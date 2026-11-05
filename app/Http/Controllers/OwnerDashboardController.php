<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Pet;
use App\Models\PetOwner;
use App\Models\Vet;
use App\Support\VaccineCatalog;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OwnerDashboardController extends Controller
{
    private const PET_TYPES = ['dog', 'cat', 'bird', 'rabbit', 'fish', 'other'];

    private const SERVICES = ['Check-up / Consultation', 'Vaccination', 'Illness / Injury', 'Dental', 'Grooming', 'Other'];

    public function show(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        // Only pet owners belong here; everyone else goes to their own dashboard.
        if ($user->role !== 'owner') {
            return redirect()->route($user->dashboardRouteName());
        }

        $owner = $this->owner($request);
        $this->copyRegistrationPet($owner);

        $pets = Pet::where('pet_owner_id', $owner->id)
            ->with(['vaccinationRecords' => fn ($query) => $query->with('vet')->orderByDesc('date_given')])
            ->withCount(['appointments', 'visitRecords', 'vaccinationRecords'])
            ->orderBy('name')
            ->get();

        // The pet being viewed (?pet_id=...), or the first pet.
        $selected = $pets->firstWhere('id', (int) $request->query('pet_id')) ?? $pets->first();

        $appointments = $selected
            ? Appointment::where('pet_id', $selected->id)
                ->with(['pet', 'vet'])
                ->orderByDesc('appointment_date')
                ->orderByDesc('appointment_time')
                ->get()
            : collect();

        $vets = Vet::where('approval_status', 'approved')
            ->orderBy('first_name')
            ->get();

        [$vaccineRows, $otherRecords, $coreDone, $coreTotal] = $this->vaccineStatus($selected);

        return view('owner.dashboard', [
            'owner'        => $owner,
            'pets'         => $pets,
            'selected'     => $selected,
            'appointments' => $appointments,
            'vets'         => $vets,
            'petTypes'     => self::PET_TYPES,
            'services'     => self::SERVICES,
            'catalog'      => $selected ? VaccineCatalog::for($selected->type) : [],
            'vaccineRows'  => $vaccineRows,
            'otherRecords' => $otherRecords,
            'coreDone'     => $coreDone,
            'coreTotal'    => $coreTotal,
            'prefill'      => [
                'service'  => $request->query('service_type'),
                'vaccines' => array_filter((array) $request->query('vaccine')),
            ],
        ]);
    }

    public function storePet(Request $request): RedirectResponse
    {
        $owner = $this->owner($request);

        $data = $this->validatedPet($request);
        $data = $this->withPhoto($request, $data);

        $pet = Pet::create($data + ['pet_owner_id' => $owner->id]);

        return redirect()->route('owner.dashboard', ['pet_id' => $pet->id])->with('success', 'Pet added.');
    }

    public function updatePet(Request $request, Pet $pet): RedirectResponse
    {
        $owner = $this->owner($request);

        // An owner may only edit their own pets.
        abort_unless((int) $pet->pet_owner_id === (int) $owner->id, 403);

        $data = $this->validatedPet($request);
        $data = $this->withPhoto($request, $data, $pet);

        $pet->update($data);

        return redirect()->route('owner.dashboard', ['pet_id' => $pet->id])->with('success', 'Pet updated.');
    }

    public function updateBirthdate(Request $request, Pet $pet): RedirectResponse
    {
        $owner = $this->owner($request);
        abort_unless((int) $pet->pet_owner_id === (int) $owner->id, 403);

        $data = $request->validate([
            'birth_date' => ['required', 'date', 'before_or_equal:today'],
        ]);

        $pet->update($data);

        return redirect()->route('owner.dashboard', ['pet_id' => $pet->id])->with('success', 'Pet profile updated.');
    }

    public function updatePhoto(Request $request, Pet $pet): RedirectResponse
    {
        $owner = $this->owner($request);
        abort_unless((int) $pet->pet_owner_id === (int) $owner->id, 403);

        $request->validate([
            'photo' => ['required', 'image', 'max:2048'],
        ]);

        $data = $this->withPhoto($request, [], $pet);
        $pet->update($data);

        return redirect()->route('owner.dashboard', ['pet_id' => $pet->id])->with('success', 'Photo updated.');
    }

    public function destroyPet(Request $request, Pet $pet): RedirectResponse
    {
        $owner = $this->owner($request);

        // An owner may only delete their own pets.
        abort_unless((int) $pet->pet_owner_id === (int) $owner->id, 403);

        $name = $pet->name;

        if ($pet->photo_path) {
            Storage::disk('public')->delete($pet->photo_path);
        }

        // Appointments, visit records and vaccination records are removed with the pet (cascade).
        $pet->delete();

        // Clear the registration pet so it isn't copied back in on the next dashboard load.
        $owner->update(['pet_name' => null, 'pet_type' => null]);

        return redirect()->route('owner.dashboard')->with('success', $name . ' was deleted.');
    }

    public function bookAppointment(Request $request): RedirectResponse
    {
        $owner = $this->owner($request);

        $data = $request->validate([
            'pet_id'         => ['required', 'integer', Rule::exists('pets', 'id')->where('pet_owner_id', $owner->id)],
            'vet_id'         => ['nullable', 'integer', Rule::exists('vets', 'id')->where('approval_status', 'approved')],
            'service'        => ['required', Rule::in(self::SERVICES)],
            'appointment_at' => ['required', 'date', 'after:now'],
            'reason'         => ['nullable', 'string', 'max:1000'],
            'vaccines'       => ['nullable', 'array'],
            'vaccines.*'     => ['string', 'max:40'],
        ]);

        $pet = Pet::findOrFail($data['pet_id']);
        $reason = trim((string) ($data['reason'] ?? ''));

        // Vaccination bookings list the vaccines the owner picked.
        if ($data['service'] === 'Vaccination') {
            $names = collect(VaccineCatalog::for($pet->type))->pluck('name', 'key');
            $picked = collect($data['vaccines'] ?? [])->map(fn ($key) => $names[$key] ?? null)->filter()->values();

            if ($names->isNotEmpty() && $picked->isEmpty()) {
                return back()->withInput()->withErrors(['vaccines' => 'Please select at least one vaccine.']);
            }

            if ($picked->isNotEmpty()) {
                $reason = trim('Vaccines requested: ' . $picked->implode(', ') . ".\n" . $reason);
            }
        }

        $when = Carbon::parse($data['appointment_at']);

        // If a specific vet was chosen, respect the days, hours and days off they set.
        if (! empty($data['vet_id'])) {
            $vet = Vet::find($data['vet_id']);
            $problem = $this->availabilityProblem($vet, $when);
            if ($problem) {
                return back()->withInput()->withErrors(['appointment_at' => $problem]);
            }
        }

        Appointment::create([
            'pet_id'           => $pet->id,
            'vet_id'           => $data['vet_id'] ?? null,   // null = any available veterinarian
            'service'          => $data['service'],
            'appointment_date' => $when->toDateString(),
            'appointment_time' => $when->format('H:i'),
            'reason'           => $reason !== '' ? $reason : null,
            'status'           => 'pending',
        ]);

<<<<<<< HEAD
        return back()->with('status', 'Your appointment has been booked.');
=======

        return back()->with('status', 'Your appointment has been booked.');

        return redirect()->route('owner.dashboard', ['pet_id' => $pet->id])
            ->with('success', 'Appointment booked. A veterinarian will review it.');

>>>>>>> da3af7c19f7ce3e38eb8d73f4da80ae1801d7df5
    }

    // ── helpers ──────────────────────────────────────────────

    /** Returns a message if the vet can't take a booking at this time, otherwise null. */
    private function availabilityProblem(?Vet $vet, Carbon $when): ?string
    {
        if (! $vet) {
            return null;
        }

        $name = 'Dr. ' . $vet->last_name;

        if (in_array($when->toDateString(), $vet->days_off ?? [], true)) {
            return $name . ' is off on ' . $when->format('M j, Y') . '. Please pick another date.';
        }

        $days = $vet->working_days ?? [];
        if ($days && ! in_array(strtolower($when->format('D')), $days, true)) {
            return $name . ' does not accept appointments on ' . $when->format('l') . 's. Please pick another day.';
        }

        if ($vet->work_start && $vet->work_end) {
            $time = $when->format('H:i');
            if ($time < substr($vet->work_start, 0, 5) || $time > substr($vet->work_end, 0, 5)) {
                return $name . ' accepts appointments between ' . Carbon::parse($vet->work_start)->format('g:i A')
                    . ' and ' . Carbon::parse($vet->work_end)->format('g:i A') . '.';
            }
        }

        return null;
    }

    private function owner(Request $request): PetOwner
    {
        abort_unless($request->user()->role === 'owner', 403);

        return PetOwner::where('user_id', $request->user()->id)->firstOrFail();
    }

    private function validatedPet(Request $request): array
    {
        return $request->validate([
            'name'       => ['required', 'string', 'max:100'],
            'type'       => ['required', Rule::in(self::PET_TYPES)],
            'breed'      => ['nullable', 'string', 'max:100'],
            'sex'        => ['nullable', Rule::in(['male', 'female'])],
            'birth_date' => ['nullable', 'date', 'before_or_equal:today'],
            'notes'      => ['nullable', 'string', 'max:1000'],
            'photo'      => ['nullable', 'image', 'max:2048'],
        ]);
    }

    /** Saves an uploaded photo (if any) and returns the data with photo_path set. */
    private function withPhoto(Request $request, array $data, ?Pet $pet = null): array
    {
        unset($data['photo']);

        if ($request->hasFile('photo')) {
            if ($pet?->photo_path) {
                Storage::disk('public')->delete($pet->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('pet-photos', 'public');
        }

        return $data;
    }

    /**
     * Matches the pet's vaccination records against the standard vaccine list.
     * Returns [rows, otherRecords, coreUpToDate, coreTotal].
     */
    private function vaccineStatus(?Pet $pet): array
    {
        if (! $pet) {
            return [[], collect(), 0, 0];
        }

        $records = $pet->vaccinationRecords;   // newest first
        $usedIds = [];
        $rows = [];
        $coreDone = 0;
        $coreTotal = 0;

        foreach (VaccineCatalog::for($pet->type) as $item) {
            $name = mb_strtolower($item['name']);
            $key  = mb_strtolower($item['key']);

            $record = $records->first(function ($r) use ($name, $key) {
                $given = mb_strtolower($r->vaccine_name);
                return $given === $name || str_contains($given, $key);
            });

            if ($record) {
                $usedIds[] = $record->id;
            }

            $overdue  = $record && $record->next_due_date && $record->next_due_date->isPast();
            $upToDate = $record && ! $overdue;

            if ($item['core']) {
                $coreTotal++;
                $coreDone += $upToDate ? 1 : 0;
            }

            $rows[] = $item + ['record' => $record, 'overdue' => (bool) $overdue];
        }

        $other = $records->reject(fn ($r) => in_array($r->id, $usedIds, true))->values();

        return [$rows, $other, $coreDone, $coreTotal];
    }

    /**
     * The registration form collects one pet. The first time the owner opens
     * the dashboard, copy it into the pets table so it shows up as a real pet.
     */
    private function copyRegistrationPet(PetOwner $owner): void
    {
        if ($owner->pet_name && ! Pet::where('pet_owner_id', $owner->id)->exists()) {
            Pet::create([
                'pet_owner_id' => $owner->id,
                'name'         => $owner->pet_name,
                'type'         => $owner->pet_type ?: 'other',
            ]);
        }
    }
}
