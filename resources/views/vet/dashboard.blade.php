<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Veterinarian Dashboard | PetPlace</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<style>
*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
:root{--bg:#eef4fd;--card:#fff;--line:#d9e5f5;--ink:#10243b;--mute:#52688a;--acc:#4f86c6;--acc2:#3d75b5;--soft:#e4eefb}
body{font-family:'DM Sans',sans-serif;color:var(--ink);min-height:100vh;line-height:1.4;
  background:radial-gradient(1200px 600px at 20% -10%,#dbe9fb 0,transparent 60%),radial-gradient(900px 500px at 100% 0,#e6effc 0,transparent 55%),var(--bg)}
.shell{display:grid;grid-template-columns:190px minmax(0,1fr);max-width:1240px;margin:0 auto}
.side{position:sticky;top:0;align-self:start;height:100vh;padding:26px 16px;display:flex;flex-direction:column;gap:4px}
.logo{font-weight:800;font-size:18px;color:var(--acc);margin:0 10px 18px}.logo span{color:var(--mute);font-weight:600}
.side a{display:block;padding:9px 12px;border-radius:10px;color:var(--ink);text-decoration:none;font-size:14px;font-weight:500}
.side a:hover{background:rgba(79,134,198,.1)}
.side a.on{background:var(--soft);color:var(--acc2);font-weight:700}
.signed{margin:auto 10px 0;font-size:11px;color:var(--mute)}.signed b{display:block;color:var(--ink);font-size:12px}
main{padding:34px 28px 70px;min-width:0}
.hello{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;margin-bottom:22px}
h1{font-size:30px;font-weight:800;letter-spacing:-.02em}
.sub{color:var(--mute);font-size:13px;margin-top:4px}
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px}
.stat{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:16px 18px}
.stat b{display:block;font-size:26px;font-weight:700;color:var(--acc2)}
.stat span{font-size:12.5px;color:var(--mute)}
.card{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:22px;margin-bottom:20px;scroll-margin-top:16px}
.card h2{font-size:18px;font-weight:700;margin-bottom:4px}
.card .desc{font-size:13px;color:var(--mute);margin-bottom:14px}
.cols{display:grid;grid-template-columns:minmax(0,1.5fr) minmax(0,1fr);gap:20px;align-items:start}
h3{font-size:15px;margin-bottom:4px}.sec{margin:18px 0 6px}
.muted{color:var(--mute);font-size:13px;margin-bottom:3px}
.note{font-size:13px;background:var(--soft);border-radius:8px;padding:7px 10px;margin:8px 0;white-space:pre-line}
.empty{color:var(--mute);font-size:13.5px}
.btn{background:var(--acc);color:#fff;border:0;border-radius:8px;padding:9px 16px;font:700 13.5px 'DM Sans',sans-serif;cursor:pointer;text-decoration:none;display:inline-block}
.btn:hover{background:var(--acc2)}.btn.danger{background:#d9534f}.btn.danger:hover{background:#c0403c}
.btn.ghost{background:#fff;color:var(--acc2);border:1px solid var(--line)}
.btn.sm{padding:6px 12px;font-size:12px}.btn.tog{background:var(--soft);color:var(--acc2);padding:6px 12px;font-size:12px}
.btn.tog.on{background:var(--acc);color:#fff}
.req{border-top:1px solid var(--line);padding:16px 0}.req:first-of-type{border-top:0;padding-top:0}
.appt{display:flex;justify-content:space-between;gap:14px;align-items:flex-start}
.respond{display:flex;gap:8px;flex-wrap:wrap;margin-top:12px}.respond input{flex:1;min-width:180px}
.chip{font-size:11.5px;font-weight:700;padding:4px 10px;border-radius:40px;white-space:nowrap;height:fit-content}
.pending{background:#fff4d6;color:#8a6100}.approved{background:#dff6e6;color:#1d7a3a}.declined{background:#fde2e2;color:#b42323}.completed{background:#e3ecfb;color:#2f5aa8}
.flash{border-radius:12px;padding:12px 16px;margin-bottom:18px;font-size:14px}
.ok{background:#dff6e6;color:#1d7a3a}.err{background:#fde2e2;color:#b42323}.err ul{padding-left:18px}
.form{display:grid;gap:12px;margin-top:10px}
label{display:grid;gap:6px;font-size:11.5px;font-weight:700;color:var(--mute)}
input,select,textarea{font:400 14px 'DM Sans',sans-serif;padding:9px 11px;border:1.5px solid var(--line);border-radius:8px;background:#fff;color:var(--ink);width:100%}
input:focus,select:focus,textarea:focus{outline:none;border-color:var(--acc)}
textarea{min-height:60px;resize:vertical}
.two{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.days{display:flex;flex-wrap:wrap;gap:6px 12px;font-size:12px}
.days label{display:flex;align-items:center;gap:5px;font-weight:500;color:var(--ink)}.days input{width:auto}
.dayrow{border-top:1px solid var(--line);padding:11px 0}.dayrow:first-of-type{border-top:0}
.dayrow h4{font-size:13.5px;font-weight:700;margin-bottom:3px}
.cal-head{display:flex;justify-content:space-between;align-items:flex-start;gap:10px;flex-wrap:wrap;margin-bottom:12px}
.cal-ctl{display:flex;gap:8px;align-items:center;flex-wrap:wrap}.cal-ctl input{width:auto}
.dayoff{display:flex;gap:8px;align-items:center;flex-wrap:wrap;margin-top:12px;font-size:12px;color:var(--mute)}
.dayoff form{display:inline}
.dayoff button{background:#fff;border:1px solid var(--line);border-radius:20px;padding:3px 10px;font:600 12px 'DM Sans',sans-serif;color:#b42323;cursor:pointer}
.psearch{display:flex;gap:8px;align-items:center}.psearch input{width:200px}
.prow{display:flex;justify-content:space-between;align-items:center;gap:12px;border-top:1px solid var(--line);padding:12px 0}
.prow:first-of-type{border-top:0}
.pet-icon{font-size:26px;margin-right:10px}
.vax,.vrow{display:flex;flex-wrap:wrap;gap:4px 12px;align-items:center;padding:8px 0;border-top:1px solid var(--line)}
.vax .note{flex-basis:100%;margin:2px 0}
.row{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px}.row h2{margin:0}
details{margin-top:12px;border:1px solid var(--line);border-radius:12px;padding:10px 14px}
summary{cursor:pointer;font-weight:700;color:var(--acc2)}
dialog{border:0;border-radius:18px;padding:24px;width:min(620px,94vw);max-height:90vh;overflow:auto;margin:auto}
dialog::backdrop{background:rgba(15,33,55,.45)}
@media(max-width:960px){.shell{grid-template-columns:1fr}.side{position:static;height:auto;flex-direction:row;flex-wrap:wrap;padding:14px 16px}.logo{width:100%;margin-bottom:6px}.signed{display:none}.cols{grid-template-columns:1fr}.stats{grid-template-columns:1fr 1fr}}
</style>
</head>
<body>
@php
    $emoji = ['dog' => '🐶', 'cat' => '🐱', 'bird' => '🐦', 'rabbit' => '🐰', 'fish' => '🐠', 'other' => '🐾'];
    $dayKeys = ['mon' => 'Mon', 'tue' => 'Tue', 'wed' => 'Wed', 'thu' => 'Thu', 'fri' => 'Fri', 'sat' => 'Sat', 'sun' => 'Sun'];
    $savedDays = old('working_days', $vet->working_days ?? []);
    $startVal = old('work_start', $vet->work_start ? substr($vet->work_start, 0, 5) : '');
    $endVal   = old('work_end', $vet->work_end ? substr($vet->work_end, 0, 5) : '');
    $futureDaysOff = collect($vet->days_off ?? [])->filter(fn ($d) => $d >= now()->toDateString())->values();
    $soon = $upcoming->filter(fn ($a) => $a->appointment_date->between(now()->startOfDay(), now()->addDays(2)->startOfDay()));
@endphp

<div class="shell">
  <nav class="side">
    <div class="logo">PetPlace <span>| Vet</span></div>
    <a href="#overview" class="on">Dashboard</a>
    <a href="#requests">Appointments</a>
    <a href="#schedule">Schedule</a>
    <a href="#patients">Patients</a>
    <a href="#vaccinations">Vaccinations</a>
    <a href="#profile">Profile</a>
    <div class="signed">Signed in as<b>Dr. {{ $vet->first_name }} {{ $vet->last_name }}</b>@if ($vet->clinic_name){{ $vet->clinic_name }}@endif</div>
  </nav>

  <main id="overview">
    <div class="hello">
      <div>
        <h1>Good day, Dr. {{ $vet->first_name }}</h1>
        <p class="sub">{{ now()->format('l, F j, Y') }} · Veterinarian dashboard</p>
      </div>
      <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn ghost" type="submit">Log out</button></form>
    </div>

    @if (session('success'))<div class="flash ok">{{ session('success') }}</div>@endif
    @if ($errors->any())
      <div class="flash err"><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    <div class="stats">
      <div class="stat"><b>{{ $stats['today'] }}</b><span>Appointments today</span></div>
      <div class="stat"><b>{{ $stats['pending'] }}</b><span>Pending bookings</span></div>
      <div class="stat"><b>{{ $stats['week'] }}</b><span>Patients seen this week</span></div>
      <div class="stat"><b>{{ $stats['vaccines'] }}</b><span>Vaccinations due in 30 days</span></div>
    </div>

    {{-- PENDING BOOKINGS --}}
    <section class="card" id="requests">
      <h2>Pending bookings</h2>
      <p class="desc">Bookings assigned to you or awaiting a veterinarian.</p>
      @forelse ($requests as $r)
        <article class="req">
          <div class="appt">
            <div>
              <h3>{{ $emoji[$r->pet->type] ?? '🐾' }} {{ $r->pet->name }} · {{ $r->service }}</h3>
              <p class="muted">{{ $r->appointment_date->format('M d, Y') }} at {{ \Carbon\Carbon::parse($r->appointment_time)->format('g:i A') }}</p>
              <p class="muted">Owner: {{ $r->pet->owner->first_name }} {{ $r->pet->owner->last_name }}@if ($r->pet->owner->phone) · {{ $r->pet->owner->phone }}@endif</p>
              @if (! $r->vet_id)<p class="muted">Requested: any available veterinarian</p>@endif
              @if ($r->reason)<p class="note">{{ $r->reason }}</p>@endif
            </div>
            <span class="chip pending">Pending</span>
          </div>
          <form method="POST" action="{{ route('vet.appointments.respond', $r) }}" class="respond">
            @csrf @method('PATCH')
            <input name="vet_note" maxlength="500" placeholder="Note to the owner (optional)">
            <button class="btn" type="submit" name="decision" value="approved">Approve</button>
            <button class="btn danger" type="submit" name="decision" value="declined">Decline</button>
          </form>
        </article>
      @empty
        <p class="empty">There are no pending bookings.</p>
      @endforelse
    </section>

    <div class="cols">
      {{-- SCHEDULE --}}
      <section class="card" id="schedule">
        <div class="cal-head">
          <div>
            <h2>Schedule</h2>
            <p class="desc" style="margin:0">{{ $from->format('M j, Y') }}@if (! $from->isSameDay($to)) – {{ $to->format('M j, Y') }}@endif</p>
          </div>
          <div class="cal-ctl">
            <a class="btn tog {{ $calendarView === 'week' ? 'on' : '' }}" href="{{ route('vet.dashboard', ['calendar_view' => 'week', 'date' => $anchor->toDateString()]) }}#schedule">Week</a>
            <a class="btn tog {{ $calendarView === 'day' && $anchor->isToday() ? 'on' : '' }}" href="{{ route('vet.dashboard', ['calendar_view' => 'day', 'date' => now()->toDateString()]) }}#schedule">Today</a>
            <form method="GET" action="{{ route('vet.dashboard') }}#schedule" class="cal-ctl">
              <input type="hidden" name="calendar_view" value="{{ $calendarView }}">
              <input type="date" name="date" value="{{ $anchor->toDateString() }}">
              <button class="btn tog" type="submit">Go</button>
            </form>

        </header>

        @if (session('status'))
            <div class="notice">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="notice" style="background:#fff0f0;color:#8f2929">
                <strong>Please check the form:</strong>
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <section class="cards" aria-label="Today's overview">
            <div class="metric"><strong>{{ $todayAppointments }}</strong><span>Appointments today</span></div>
            <div class="metric"><strong>{{ $pendingCount }}</strong><span>Pending bookings</span></div>
            <div class="metric"><strong>{{ $patientsSeenThisWeek }}</strong><span>Patients seen this week</span></div>
            <div class="metric"><strong>{{ $vaccinationsDueSoon }}</strong><span>Vaccinations due in 30 days</span></div>
        </section>

        <section class="panel" id="requests">
            <div class="section-head">
                <div><h2>Pending bookings</h2><p class="muted">Bookings assigned to you or awaiting a veterinarian.</p></div>
            </div>
            @forelse ($pendingRequests as $appointment)
                <article class="request-card">
                    <div>
                        <h3>{{ $appointment->pet?->pet_name ?? 'Pet' }} <span class="pill pending">Pending</span></h3>
                        <p>{{ ucfirst($appointment->pet?->pet_type ?? 'Pet') }} · {{ $appointment->service_type }}</p>
                        <p class="muted">Owner: {{ $appointment->petOwner?->first_name }} {{ $appointment->petOwner?->last_name }}
                            @if ($appointment->petOwner?->phone) · {{ $appointment->petOwner->phone }} @endif</p>
                        <p><strong>Requested:</strong> {{ $appointment->appointment_at?->format('M j, Y g:i A') }}</p>
                        @if ($appointment->reason)<p><strong>Client notes:</strong> {{ $appointment->reason }}</p>@endif
                        @if ($appointment->vet_id === null)<p class="muted">Not assigned to a veterinarian yet.</p>@endif
                    </div>
                    <div>
                        <form method="POST" action="{{ route('vet.appointments.update', $appointment) }}" class="no-print">
                            @csrf @method('PATCH')
                            <div class="actions">
                                <button class="btn small" name="action" value="accept">Accept</button>
                                <button class="btn danger small" name="action" value="decline" onclick="return confirm('Decline this request? Add a reason first.')">Decline</button>
                            </div>
                            <div class="field" style="margin-top:10px">
                                <label for="reason-{{ $appointment->id }}">Reason if declining or rescheduling</label>
                                <input id="reason-{{ $appointment->id }}" name="decision_reason" maxlength="1000" placeholder="Required for decline or reschedule">
                            </div>
                            <div class="actions">
                                <label for="reschedule-{{ $appointment->id }}">New date/time</label>
                                <input id="reschedule-{{ $appointment->id }}" type="datetime-local" name="appointment_at">
                                <button class="btn secondary small" name="action" value="reschedule">Reschedule</button>
                            </div>
                        </form>
                    </div>
                </article>
            @empty
                <p class="muted">There are no pending bookings.</p>
            @endforelse
        </section>

        <div class="split">
            <section class="panel" id="schedule">
                <div class="section-head">
                    <div><h2>Schedule</h2><p class="muted">{{ $calendarDate->format('M j, Y') }} @if($calendarView === 'week') – {{ $weekEnd->format('M j, Y') }} @endif</p></div>
                    <div class="actions no-print">
                        <a class="btn small {{ $calendarView === 'day' ? '' : 'secondary' }}" href="{{ route('vet.dashboard', ['calendar_view' => 'week', 'week' => $calendarDate->toDateString()]) }}">Week</a>
                        <a class="btn small {{ $calendarView === 'day' ? 'secondary' : '' }}" href="{{ route('vet.dashboard', ['calendar_view' => 'day', 'week' => today()->toDateString()]) }}">Today</a>
                        <form method="GET" action="{{ route('vet.dashboard') }}" class="actions">
                            <input type="hidden" name="calendar_view" value="{{ $calendarView }}">
                            <input type="date" name="week" value="{{ $calendarDate->toDateString() }}" aria-label="Choose calendar date">
                            <button class="btn secondary small" type="submit">Go</button>
                        </form>
                    </div>
                </div>
                @forelse ($weekDays as $day)
                    <div class="calendar-day">
                        <strong>{{ $day->format('l, M j') }}</strong>
                        @php($dayAppointments = $calendarAppointments->filter(fn ($item) => $item->appointment_at?->isSameDay($day)))
                        @forelse ($dayAppointments as $appointment)
                            <div class="event">
                                <strong>{{ $appointment->appointment_at->format('g:i A') }} · {{ $appointment->pet?->pet_name }}</strong>
                                <div>{{ $appointment->service_type }} · {{ $appointment->petOwner?->first_name }} {{ $appointment->petOwner?->last_name }}</div>
                                <form method="POST" action="{{ route('vet.appointments.update', $appointment) }}" class="actions no-print">
                                    @csrf @method('PATCH')
                                    <button class="btn secondary small" name="action" value="complete">Mark completed</button>
                                </form>
                            </div>
                        @empty
                            <p class="muted">No confirmed appointments.</p>
                        @endforelse
                    </div>
                @empty
                    <p class="muted">No schedule found.</p>
                @endforelse
            </section>

            <section class="panel" id="profile">
                <h2>Availability</h2>
                <p class="muted">Set the days and hours you accept appointments. Day-off dates are excluded.</p>
                <form method="POST" action="{{ route('vet.availability.update') }}">
                    @csrf @method('PUT')
                    <div class="field">
                        <label>Working days</label>
                        <div class="check-grid">
                            @foreach (['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                                <label><input type="checkbox" name="working_days[]" value="{{ $day }}" @checked(in_array($day, old('working_days', $vet->working_days ?? []), true))>{{ substr($day, 0, 3) }}</label>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="field"><label for="start-time">Start</label><input id="start-time" type="time" name="working_hours_start" value="{{ old('working_hours_start', $vet->working_hours_start) }}"></div>
                        <div class="field"><label for="end-time">End</label><input id="end-time" type="time" name="working_hours_end" value="{{ old('working_hours_end', $vet->working_hours_end) }}"></div>
                        <div class="field full"><label for="day-off">Add a day off</label><input id="day-off" type="date" name="days_off[]" min="{{ today()->toDateString() }}"></div>
                    </div>
                    @if ($vet->days_off)
                        <p class="muted">Saved days off: {{ collect($vet->days_off)->join(', ') }}</p>
                        @foreach ($vet->days_off as $dayOff)<input type="hidden" name="days_off[]" value="{{ $dayOff }}">@endforeach
                    @endif
                    <button class="btn" type="submit">Save availability</button>
                </form>
            </section>
          </div>

        </div>
        @foreach ($days as $day)
          <div class="dayrow">
            <h4>{{ $day['date']->format('l, M j') }}</h4>
            @forelse ($day['items'] as $u)
              <div class="appt" style="margin-top:6px">
                <div>
                  <p style="font-size:13.5px;font-weight:600">{{ \Carbon\Carbon::parse($u->appointment_time)->format('g:i A') }} · {{ $emoji[$u->pet->type] ?? '🐾' }} {{ $u->pet->name }} — {{ $u->service }}</p>
                  <p class="muted">Owner: {{ $u->pet->owner->first_name }} {{ $u->pet->owner->last_name }}</p>
                </div>
                <span class="chip approved">Approved</span>
              </div>
            @empty
              <p class="empty">No confirmed appointments.</p>
            @endforelse
          </div>
        @endforeach
      </section>

      {{-- AVAILABILITY --}}
      <section class="card" id="profile">
        <h2>Availability</h2>
        <p class="desc">Set the days and hours you accept appointments. Day-off dates are excluded.</p>
        <form class="form" method="POST" action="{{ route('vet.availability.update') }}">
          @csrf @method('PATCH')
          <div>
            <label>Working days</label>
            <div class="days" style="margin-top:6px">
              @foreach ($dayKeys as $key => $label)
                <label><input type="checkbox" name="working_days[]" value="{{ $key }}" @checked(in_array($key, (array) $savedDays, true))> {{ $label }}</label>
              @endforeach
            </div>
          </div>
          <div class="two">
            <label>Start <input type="time" name="work_start" value="{{ $startVal }}"></label>
            <label>End <input type="time" name="work_end" value="{{ $endVal }}"></label>
          </div>
          <label>Add a day off <input type="date" name="day_off" min="{{ now()->toDateString() }}"></label>
          <div><button class="btn" type="submit">Save availability</button></div>
        </form>

        @if ($futureDaysOff->isNotEmpty())
          <div class="dayoff">
            <span>Days off:</span>
            @foreach ($futureDaysOff as $d)
              <form method="POST" action="{{ route('vet.availability.update') }}">
                @csrf @method('PATCH')
                <input type="hidden" name="remove_day_off" value="{{ $d }}">
                <button type="submit" title="Remove this day off">{{ \Carbon\Carbon::parse($d)->format('M j, Y') }} ✕</button>
              </form>
            @endforeach
          </div>
        @endif
      </section>
    </div>

    {{-- RECENT ACTIVITY --}}
    <section class="card">
      <h2>Recent appointment activity</h2>
      @forelse ($recent as $a)
        <div class="prow">
          <div>
            <h3 style="font-size:14px">{{ $emoji[$a->pet->type] ?? '🐾' }} {{ $a->pet->name }} · {{ $a->service }}</h3>
            <p class="muted">{{ $a->appointment_date->format('M d, Y') }} at {{ \Carbon\Carbon::parse($a->appointment_time)->format('g:i A') }} · Owner: {{ $a->pet->owner->first_name }} {{ $a->pet->owner->last_name }}</p>
          </div>
          <span class="chip {{ $a->status }}">{{ ucfirst($a->status) }}</span>
        </div>
      @empty
        <p class="empty">No appointment history yet.</p>
      @endforelse
    </section>

    {{-- PATIENT RECORDS --}}
    <section class="card" id="patients">
      <div class="cal-head">
        <div>
          <h2>Patient records</h2>
          <p class="desc" style="margin:0">Patients with an appointment or visit record connected to your account.</p>
        </div>
        <form method="GET" action="{{ route('vet.dashboard') }}#patients" class="psearch">
          <input type="text" name="q" value="{{ $search }}" placeholder="Pet or owner name">
          <button class="btn" type="submit">Search</button>
        </form>
      </div>
      @forelse ($patients as $p)
        <div class="prow">
          <div style="display:flex;align-items:center">
            <span class="pet-icon">{{ $emoji[$p->type] ?? '🐾' }}</span>
            <div>
              <h3 style="font-size:14.5px">{{ $p->name }}</h3>
              <p class="muted">{{ ucfirst($p->type) }}@if ($p->breed) · {{ $p->breed }}@endif · Owner: {{ $p->owner->first_name }} {{ $p->owner->last_name }} · {{ $p->visitRecords->count() }} visits · {{ $p->vaccinationRecords->count() }} vaccines</p>
            </div>
          </div>
          <button class="btn ghost sm" type="button" onclick="document.getElementById('pt-{{ $p->id }}').showModal()">Open record</button>
        </div>
      @empty
        <p class="empty">{{ $search !== '' ? 'No patients match your search.' : 'No patients found for your appointments yet.' }}</p>
      @endforelse
    </section>

    {{-- VACCINATIONS DUE --}}
    <section class="card" id="vaccinations">
      <h2>Vaccinations due</h2>
      <p class="desc">Next doses due in the next 30 days for your patients.</p>
      @forelse ($dueVaccines as $dv)
        <div class="prow">
          <div>
            <h3 style="font-size:14px">{{ $dv->vaccine_name }} · {{ $dv->pet->name }}</h3>
            <p class="muted">Owner: {{ $dv->pet->owner->first_name }} {{ $dv->pet->owner->last_name }}</p>
          </div>
          <span class="chip approved">Due {{ $dv->next_due_date->format('M d, Y') }}</span>
        </div>
      @empty
        <p class="empty">No vaccinations are due in the next 30 days.</p>
      @endforelse
    </section>


                    <h3 style="margin-top:24px">Record a visit</h3>
                    <form method="POST" action="{{ route('vet.visits.store') }}" class="no-print">
                        @csrf
                        <input type="hidden" name="pet_id" value="{{ $selectedPatient->id }}">
                        <div class="form-grid">
                            <div class="field"><label for="visit-date">Visit date</label><input id="visit-date" type="date" name="visit_date" max="{{ today()->toDateString() }}" value="{{ old('visit_date', today()->toDateString()) }}" required></div>
                            <div class="field"><label for="appointment-id">Appointment (optional)</label>
                                <select id="appointment-id" name="appointment_id"><option value="">Not linked</option>
                                    @foreach ($selectedPatient->appointments()->where('vet_id', $vet->id)->orderByDesc('appointment_at')->limit(20)->get() as $patientAppointment)
                                        <option value="{{ $patientAppointment->id }}">{{ $patientAppointment->appointment_at->format('M j, Y') }} · {{ $patientAppointment->status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field full"><label for="visit-reason">Reason for visit</label><textarea id="visit-reason" name="reason">{{ old('reason') }}</textarea></div>
                            <div class="field full"><label for="diagnosis">Diagnosis</label><textarea id="diagnosis" name="diagnosis">{{ old('diagnosis') }}</textarea></div>
                            <div class="field full"><label for="treatment">Treatment and notes</label><textarea id="treatment" name="treatment">{{ old('treatment') }}</textarea></div>
                            <div class="field"><label for="follow-up">Follow-up date</label><input id="follow-up" type="date" name="follow_up_date" min="{{ today()->toDateString() }}"></div>
                            <div class="field"><label for="medicine">Prescription medicine</label><input id="medicine" name="prescription_medicine"></div>
                            <div class="field"><label for="dosage">Dosage</label><input id="dosage" name="prescription_dosage"></div>
                            <div class="field"><label for="duration">Duration</label><input id="duration" name="prescription_duration"></div>
                            <div class="field full"><label for="instructions">Prescription instructions</label><textarea id="instructions" name="prescription_instructions"></textarea></div>
                        </div>
                        <button class="btn" type="submit">Save visit record</button>
                    </form>
                    <h3 style="margin-top:24px">Visit history</h3>
                    @forelse ($selectedPatientVisits as $visit)
                        <div class="record">
                            <strong>{{ $visit->visit_date->format('M j, Y') }}</strong>
                            @if($visit->reason)<p><strong>Reason:</strong> {{ $visit->reason }}</p>@endif
                            @if($visit->diagnosis)<p><strong>Diagnosis:</strong> {{ $visit->diagnosis }}</p>@endif
                            @if($visit->treatment)<p><strong>Treatment:</strong> {{ $visit->treatment }}</p>@endif
                            @if($visit->follow_up_date)<p><strong>Follow-up:</strong> {{ $visit->follow_up_date->format('M j, Y') }}</p>@endif
                            @if($visit->prescriptions)<p><strong>Prescription:</strong> {{ collect($visit->prescriptions)->filter()->join(' · ') }}</p>@endif
                        </div>
                    @empty
                        <p class="muted">No visit records yet.</p>
                    @endforelse
                </div>

                <div class="record" id="vaccinations">
                    <h3>Vaccination history</h3>
                    @forelse ($selectedPatientVaccinations as $record)
                        <div class="record">
                            <strong>{{ $vaccineLabels[$record->vaccine_key] ?? $record->vaccine_key }}</strong>
                            <span class="pill">{{ $record->category }}</span>
                            @if (!$record->next_due_date)
                                <span class="pill">Not yet due</span>
                            @elseif ($record->next_due_date->isBefore(today()))
                                <span class="pill cancelled">Overdue</span>
                            @elseif ($record->next_due_date->lessThanOrEqualTo(today()->addDays(30)))
                                <span class="pill pending">Due soon</span>
                            @else
                                <span class="pill confirmed">Up to date</span>
                            @endif
                            <p>Given {{ $record->date_given?->format('M j, Y') }} · Next due {{ $record->next_due_date?->format('M j, Y') ?: 'Not set' }}
                                @if($record->dose_number) · Dose {{ $record->dose_number }} @endif</p>
                            @if($record->brand || $record->batch_number)<p class="muted">{{ $record->brand }} @if($record->batch_number) · Lot {{ $record->batch_number }} @endif</p>@endif
                            @if($record->notes)<p>{{ $record->notes }}</p>@endif
                            @if($record->vet_id === $vet->id)
                                <a class="btn secondary small no-print" href="{{ route('vet.vaccinations.certificate', $record) }}" target="_blank" rel="noopener">View certificate</a>
                            @endif
                        </div>
                    @empty
                        <p class="muted">No vaccinations recorded.</p>
                    @endforelse

                    <h3 style="margin-top:22px">Log a vaccination</h3>
                    <form method="POST" action="{{ route('vet.vaccinations.store') }}" class="no-print">
                        @csrf
                        <input type="hidden" name="pet_id" value="{{ $selectedPatient->id }}">
                        <div class="form-grid">
                            <div class="field full"><label for="vaccine-key">Vaccine</label>
                                @if ($patientVaccineOptions)
                                    <select id="vaccine-key" name="vaccine_key" required>
                                        <option value="">Choose vaccine</option>
                                        @foreach($patientVaccineOptions as $key => $name)<option value="{{ $key }}">{{ $name }}</option>@endforeach
                                        <option value="other">Other / custom vaccine</option>
                                    </select>
                                    <input id="custom-vaccine-name" name="vaccine_name" maxlength="100" placeholder="Enter vaccine name" style="display:none;margin-top:8px">
                                @else
                                    <input id="vaccine-key" name="vaccine_key" maxlength="100" placeholder="Enter vaccine name" required>
                                @endif
                            </div>
                            <div class="field"><label for="vaccine-category">Category</label><select id="vaccine-category" name="category" required><option>Core</option><option>Non-core (Lifestyle)</option></select></div>
                            <div class="field"><label for="dose-number">Dose number</label><input id="dose-number" name="dose_number" placeholder="1st, 2nd, booster"></div>
                            <div class="field"><label for="date-given">Date given</label><input id="date-given" type="date" name="date_given" max="{{ today()->toDateString() }}" required></div>
                            <div class="field"><label for="next-due">Next due date</label><input id="next-due" type="date" name="next_due_date" required></div>
                            <div class="field"><label for="brand">Brand</label><input id="brand" name="brand"></div>
                            <div class="field"><label for="batch-number">Batch / lot number</label><input id="batch-number" name="batch_number"></div>
                            <div class="field full"><label for="vaccine-notes">Notes</label><textarea id="vaccine-notes" name="notes"></textarea></div>
                        </div>
                        <button class="btn" type="submit">Save vaccination record</button>
                    </form>
                </div>
            @endif
        </section>

        <section class="panel" aria-label="Notifications">
            <h2>Notifications</h2>
            @forelse ($notifications as $notification)
                <div class="record">
                    <strong>{{ $notification->status === 'pending' ? 'New booking' : ($notification->status === 'cancelled' ? 'Appointment cancelled or declined' : 'Upcoming appointment') }}</strong>
                    <p>{{ $notification->pet?->pet_name }} · {{ $notification->appointment_at?->format('M j, Y g:i A') }} · {{ $notification->service_type }}</p>
                </div>
            @empty
                <p class="muted">No new bookings or appointments coming up.</p>
            @endforelse
        </section>
    </main>

    {{-- NOTIFICATIONS --}}
    <section class="card">
      <h2>Notifications</h2>
      @if ($requests->isEmpty() && $soon->isEmpty())
        <p class="empty">No new bookings or appointments coming up.</p>
      @else
        @if ($requests->isNotEmpty())
          <p class="muted" style="font-size:13.5px">You have {{ $requests->count() }} pending {{ \Illuminate\Support\Str::plural('booking', $requests->count()) }} waiting for your reply.</p>
        @endif
        @foreach ($soon as $s)
          <p class="muted" style="font-size:13.5px">Coming up: {{ $s->pet->name }} · {{ $s->service }} on {{ $s->appointment_date->format('M j') }} at {{ \Carbon\Carbon::parse($s->appointment_time)->format('g:i A') }}</p>
        @endforeach
      @endif
    </section>
  </main>

</div>

{{-- ONE RECORD DIALOG PER PATIENT: full history + add forms --}}
@foreach ($patients as $p)
  <dialog id="pt-{{ $p->id }}">
    <div class="row">
      <h2>{{ $emoji[$p->type] ?? '🐾' }} {{ $p->name }}</h2>
      <button class="btn ghost sm" style="margin:0" type="button" onclick="this.closest('dialog').close()">Close</button>
    </div>
    @php
        $info = array_filter([
            ucfirst($p->type),
            $p->breed,
            $p->sex ? ucfirst($p->sex) : null,
            $p->birth_date ? 'born ' . $p->birth_date->format('M d, Y') : null,
        ]);
    @endphp
    <p class="muted">{{ implode(' · ', $info) }}</p>
    <p class="muted">Owner: {{ $p->owner->first_name }} {{ $p->owner->last_name }}@if ($p->owner->phone) · {{ $p->owner->phone }}@endif</p>
    @if ($p->notes)<p class="note">Owner's notes: {{ $p->notes }}</p>@endif

    <h3 class="sec">Visit history</h3>
    @forelse ($p->visitRecords as $v)
      <div class="vax">
        <strong>{{ $v->visit_date->format('M d, Y') }}</strong>
        <span class="muted">Dr. {{ $v->vet->first_name }} {{ $v->vet->last_name }}@if ($v->reason) · {{ $v->reason }}@endif</span>
        @if ($v->diagnosis)<p class="note"><b>Diagnosis:</b> {{ $v->diagnosis }}</p>@endif
        @if ($v->treatment)<p class="note"><b>Treatment:</b> {{ $v->treatment }}</p>@endif
        @if ($v->notes)<p class="note"><b>Notes:</b> {{ $v->notes }}</p>@endif
      </div>
    @empty
      <p class="muted">No visits recorded yet.</p>
    @endforelse

    <h3 class="sec">Vaccinations</h3>
    @forelse ($p->vaccinationRecords as $vc)
      <div class="vax">
        <strong>{{ $vc->vaccine_name }}</strong>
        <span class="muted">{{ $vc->date_given->format('M d, Y') }} · Dr. {{ $vc->vet->first_name }} {{ $vc->vet->last_name }}</span>
        @if ($vc->dose_number)<span class="muted">Dose {{ $vc->dose_number }}</span>@endif
        @if ($vc->next_due_date)<span class="chip {{ $vc->next_due_date->isPast() ? 'declined' : 'approved' }}">Next due {{ $vc->next_due_date->format('M d, Y') }}</span>@endif
      </div>
    @empty
      <p class="muted">No vaccinations recorded yet.</p>
    @endforelse

    <details>
      <summary>＋ Add visit note</summary>
      <form class="form" method="POST" action="{{ route('vet.visits.store', $p) }}">
        @csrf
        <label>Appointment (optional — marks it completed)
          <select name="appointment_id">
            <option value="">— none —</option>
            @foreach ($p->appointments->where('status', 'approved') as $ap)
              <option value="{{ $ap->id }}">{{ $ap->appointment_date->format('M d') }} · {{ $ap->service }}</option>
            @endforeach
          </select>
        </label>
        <div class="two">
          <label>Visit date <input type="date" name="visit_date" value="{{ now()->toDateString() }}" max="{{ now()->toDateString() }}" required></label>
          <label>Reason <input name="reason" maxlength="255"></label>
        </div>
        <label>Diagnosis <textarea name="diagnosis" maxlength="1000"></textarea></label>
        <label>Treatment <textarea name="treatment" maxlength="1000"></textarea></label>
        <label>Notes <textarea name="notes" maxlength="1000"></textarea></label>
        <button class="btn" type="submit">Save visit note</button>
      </form>
    </details>

    <details>
      <summary>＋ Add vaccination</summary>
      <form class="form" method="POST" action="{{ route('vet.vaccinations.store', $p) }}">
        @csrf
        <label>Vaccine <input name="vaccine_name" list="vaccine-names" maxlength="100" placeholder="e.g. Anti-rabies" required></label>
        <div class="two">
          <label>Date given <input type="date" name="date_given" value="{{ now()->toDateString() }}" max="{{ now()->toDateString() }}" required></label>
          <label>Next due <input type="date" name="next_due_date"></label>
        </div>
        <label>Dose number (optional) <input type="number" name="dose_number" min="1" max="20"></label>
        <label>Notes <textarea name="notes" maxlength="500"></textarea></label>
        <button class="btn" type="submit">Save vaccination</button>
      </form>
    </details>
  </dialog>
@endforeach

<script>
// Highlight the sidebar link for the section being viewed.
const links = [...document.querySelectorAll('.side a[href^="#"]')];
function markActive() {
  let current = links[0];
  links.forEach(a => {
    const el = document.querySelector(a.getAttribute('href'));
    if (el && el.getBoundingClientRect().top <= 140) current = a;
  });
  links.forEach(a => a.classList.toggle('on', a === current));
}
window.addEventListener('scroll', markActive, { passive: true });
markActive();
</script>
<datalist id="vaccine-names">
@foreach (\App\Support\VaccineCatalog::allNames() as $vn)<option value="{{ $vn }}">@endforeach
</datalist>
</body>
</html>
