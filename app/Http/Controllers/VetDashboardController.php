<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Pet;
use App\Models\VaccinationRecord;
use App\Models\Vet;
use App\Models\VisitRecord;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class VetDashboardController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->role !== 'vet') {
            return redirect()->route($user->dashboardRouteName());
        }

        $vet   = $this->vet($request);
        $today = Carbon::today();

        $appointments = fn (string $status) => Appointment::where(function ($q) use ($vet, $status) {
                $q->where('vet_id', $vet->id);
                // Bookings where the owner chose "any available veterinarian" go to every vet until one answers.
                if ($status === 'pending') {
                    $q->orWhereNull('vet_id');
                }
            })
            ->where('status', $status)
            ->with('pet.owner')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $requests = $appointments('pending');    // pending bookings
        $upcoming = $appointments('approved');   // confirmed appointments

        // A "patient" is a pet with an approved/completed appointment or a visit record with this vet.
        $patients = $this->patients($vet)
            ->with([
                'owner',
                'visitRecords'       => fn ($q) => $q->with('vet')->orderByDesc('visit_date'),
                'vaccinationRecords' => fn ($q) => $q->with('vet')->orderByDesc('date_given'),
                'appointments'       => fn ($q) => $q->where('vet_id', $vet->id)->orderByDesc('appointment_date'),
            ])
            ->orderBy('name')
            ->get();

        $patientIds = $patients->pluck('id');

        // Patient search (pet or owner name)
        $search = trim((string) $request->query('q', ''));
        if ($search !== '') {
            $patients = $patients->filter(fn ($p) => mb_stripos($p->name, $search) !== false
                || mb_stripos($p->owner->first_name . ' ' . $p->owner->last_name, $search) !== false)->values();
        }

        // Schedule: week (Mon-Sun) or single day
        $calendarView = $request->query('calendar_view') === 'day' ? 'day' : 'week';
        try {
            $anchor = Carbon::parse((string) $request->query('date', $today->toDateString()))->startOfDay();
        } catch (\Throwable $e) {
            $anchor = $today->copy();
        }
        $from = $calendarView === 'day' ? $anchor->copy() : $anchor->copy()->startOfWeek(Carbon::MONDAY);
        $to   = $calendarView === 'day' ? $anchor->copy() : $from->copy()->addDays(6);

        $byDate = $upcoming
            ->filter(fn ($a) => $a->appointment_date->between($from, $to))
            ->groupBy(fn ($a) => $a->appointment_date->toDateString());

        $days = [];
        for ($d = $from->copy(); $d->lte($to); $d->addDay()) {
            $days[] = ['date' => $d->copy(), 'items' => $byDate->get($d->toDateString(), collect())];
        }

        // Vaccinations due in the next 30 days
        $dueVaccines = VaccinationRecord::whereIn('pet_id', $patientIds)
            ->whereBetween('next_due_date', [$today, $today->copy()->addDays(30)])
            ->with('pet.owner')
            ->orderBy('next_due_date')
            ->get();

        $stats = [
            'today'    => $upcoming->filter(fn ($a) => $a->appointment_date->isSameDay($today))->count(),
            'pending'  => $requests->count(),
            'week'     => VisitRecord::where('vet_id', $vet->id)
                ->whereBetween('visit_date', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()])
                ->distinct()->count('pet_id'),
            'vaccines' => $dueVaccines->count(),
        ];

        $recent = Appointment::where('vet_id', $vet->id)
            ->whereIn('status', ['approved', 'declined', 'completed'])
            ->with('pet.owner')
            ->latest('updated_at')
            ->limit(8)
            ->get();


        return view('vet.dashboard', [
            'vet' => $vet,
            'todayAppointments' => $todayAppointments,
            'pendingCount' => $pendingRequests->count(),
            'patientsSeenThisWeek' => $patientsSeenThisWeek,
            'vaccinationsDueSoon' => $vaccinationsDueSoon,
            'pendingRequests' => $pendingRequests,
            'calendarAppointments' => $calendarAppointments,
            'recentAppointments' => $recentAppointments,
            'weekStart' => $weekStart,
            'weekEnd' => $weekEnd,
            'patients' => $patients,
            'selectedPatient' => $selectedPatient,
            'selectedPatientVisits' => $selectedPatientVisits,
            'selectedPatientVaccinations' => $selectedPatientVaccinations,
            'patientVaccineOptions' => self::VACCINE_OPTIONS[strtolower($selectedPatient?->pet_type ?? '')] ?? [],
            'vaccineLabels' => collect(self::VACCINE_OPTIONS)
                ->flatMap(fn (array $options) => $options)
                ->all(),
            'notifications' => $notifications,
            'weekDays' => $calendarView === 'day'
                ? collect([$calendarDate->copy()])
                : collect(range(0, 6))->map(fn (int $offset) => $weekStart->copy()->addDays($offset)),
            'calendarView' => $calendarView,
            'calendarDate' => $calendarDate,
            'search' => $request->input('search'),
        ]);
    }

    public function updateAppointment(Request $request, Appointment $appointment): RedirectResponse
    {
        $vet = $this->authenticatedVeterinarian($request);
        abort_unless($appointment->service_type !== 'Grooming', 404);

        $validated = $request->validate([
            'action' => ['required', Rule::in(['accept', 'decline', 'reschedule', 'complete'])],
            'decision_reason' => ['required_if:action,decline,reschedule', 'nullable', 'string', 'max:1000'],
            'appointment_at' => ['required_if:action,reschedule', 'nullable', 'date', 'after:now'],
        ]);
        if ($validated['action'] === 'complete') {
            abort_unless($appointment->vet_id === $vet->id && $appointment->status === 'confirmed', 404);
        } else {
            abort_unless(
                $appointment->status === 'pending'
                && ($appointment->vet_id === null || $appointment->vet_id === $vet->id),
                404
            );
        }
        if ($validated['action'] === 'accept') {
            $this->assertAvailable($vet, $appointment->appointment_at);
        }

        if ($validated['action'] === 'accept') {
            $appointment->status = 'confirmed';
            $appointment->vet_id = $vet->id;
            $appointment->decision_reason = null;
        } elseif ($validated['action'] === 'decline') {
            $appointment->status = 'cancelled';
            $appointment->vet_id = $vet->id;
            $appointment->decision_reason = $validated['decision_reason'];
        } elseif ($validated['action'] === 'reschedule') {
            $this->assertAvailable($vet, Carbon::parse($validated['appointment_at']));
            $appointment->status = 'confirmed';
            $appointment->vet_id = $vet->id;
            $appointment->appointment_at = $validated['appointment_at'];
            $appointment->decision_reason = $validated['decision_reason'];
        } else {
            abort_unless($appointment->vet_id === $vet->id && $appointment->status === 'confirmed', 404);
            $appointment->status = 'completed';
        }

        $appointment->save();

        return back()->with('status', 'Booking updated.');
    }

    public function saveAvailability(Request $request): RedirectResponse
    {
        $vet = $this->vet($request);
        $daysOff = collect($vet->days_off ?? []);

        // A single "Remove" button on a day off.
        if ($request->filled('remove_day_off')) {
            $daysOff = $daysOff->reject(fn ($d) => $d === $request->input('remove_day_off'));
            $vet->update(['days_off' => $daysOff->values()->all()]);

            return redirect()->to(route('vet.dashboard') . '#profile')->with('success', 'Day off removed.');
        }

        $data = $request->validate([
            'working_days'   => ['nullable', 'array'],
            'working_days.*' => [Rule::in(['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'])],
            'work_start'     => ['nullable', 'required_with:work_end', 'date_format:H:i'],
            'work_end'       => ['nullable', 'required_with:work_start', 'date_format:H:i', 'after:work_start'],
            'day_off'        => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        if (! empty($data['day_off'])) {
            $daysOff->push(Carbon::parse($data['day_off'])->toDateString());
        }

        $vet->update([
            'working_days' => array_values($data['working_days'] ?? []),
            'work_start'   => $data['work_start'] ?? null,
            'work_end'     => $data['work_end'] ?? null,
            'days_off'     => $daysOff->unique()->sort()->values()->all(),
        ]);

        return redirect()->to(route('vet.dashboard') . '#profile')->with('success', 'Availability saved.');
    }

    public function respond(Request $request, Appointment $appointment): RedirectResponse
    {
        $vet = $this->vet($request);

        abort_unless(
            ($appointment->vet_id === null || (int) $appointment->vet_id === (int) $vet->id)
            && $appointment->status === 'pending',
            403
        );

        $data = $request->validate([
            'decision' => ['required', Rule::in(['approved', 'declined'])],
            'vet_note' => ['nullable', 'string', 'max:500'],
        ]);

        // Whoever answers an "any vet" request becomes its veterinarian.
        $appointment->update([
            'vet_id'   => $vet->id,
            'status'   => $data['decision'],
            'vet_note' => $data['vet_note'] ?? null,
        ]);

        return redirect()->route('vet.dashboard')->with('success', 'Booking ' . $data['decision'] . '.');
    }

    public function storeVisit(Request $request, Pet $pet): RedirectResponse
    {
        $vet = $this->vet($request);
        abort_unless($this->patients($vet)->whereKey($pet->id)->exists(), 403);

        $data = $request->validate([
            'visit_date'     => ['required', 'date', 'before_or_equal:today'],
            'reason'         => ['nullable', 'string', 'max:255'],
            'diagnosis'      => ['nullable', 'string', 'max:1000'],
            'treatment'      => ['nullable', 'string', 'max:1000'],
            'notes'          => ['nullable', 'string', 'max:1000'],
            'appointment_id' => ['nullable', 'integer', Rule::exists('appointments', 'id')
                ->where('vet_id', $vet->id)->where('pet_id', $pet->id)->where('status', 'approved')],
        ]);

        VisitRecord::create($data + ['pet_id' => $pet->id, 'vet_id' => $vet->id]);

        // Saving a visit note for an approved appointment marks it completed.
        if (! empty($data['appointment_id'])) {
            Appointment::whereKey($data['appointment_id'])->update(['status' => 'completed']);
        }

        return redirect()->route('vet.dashboard')->with('success', 'Visit note saved.');
    }

    public function storeVaccination(Request $request, Pet $pet): RedirectResponse
    {
        $vet = $this->vet($request);
        abort_unless($this->patients($vet)->whereKey($pet->id)->exists(), 403);

        $data = $request->validate([
            'vaccine_name'  => ['required', 'string', 'max:100'],
            'date_given'    => ['required', 'date', 'before_or_equal:today'],
            'next_due_date' => ['nullable', 'date', 'after_or_equal:date_given'],
            'dose_number'   => ['nullable', 'integer', 'min:1', 'max:20'],
            'notes'         => ['nullable', 'string', 'max:500'],
        ]);

        VaccinationRecord::create($data + ['pet_id' => $pet->id, 'vet_id' => $vet->id]);

        return redirect()->route('vet.dashboard')->with('success', 'Vaccination recorded.');
    }

    // ── helpers ──────────────────────────────────────────────

    private function vet(Request $request): Vet
    {
        abort_unless($request->user()->role === 'vet', 403);

        return Vet::where('user_id', $request->user()->id)->firstOrFail();
    }

    private function patients(Vet $vet)
    {
        return Pet::where(function ($outer) use ($vet) {
            $outer->whereHas('appointments', fn ($q) => $q
                ->where('vet_id', $vet->id)
                ->whereIn('status', ['approved', 'completed']))
                ->orWhereHas('visitRecords', fn ($q) => $q->where('vet_id', $vet->id));
        });
    }
}
