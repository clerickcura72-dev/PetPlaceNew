<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Pet Owner Dashboard | Pet Place</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<style>
*{box-sizing:border-box;margin:0;padding:0}
:root{--bg:#f8f8fc;--card:#fff;--line:#ecebf3;--ink:#1c1a29;--mute:#76748a;--acc:#6c4fc7;--acc2:#5a3eb5;--soft:#f1eefc;--tile:#faf9fd}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--ink);min-height:100vh;line-height:1.4}
a{color:var(--acc);text-decoration:none}
.top{display:flex;justify-content:space-between;align-items:center;padding:20px max(24px,calc((100% - 1120px)/2));background:var(--card);border-bottom:1px solid var(--line)}
.brand{font-weight:800;font-size:20px;letter-spacing:-.02em}.brand span:first-child{color:var(--acc)}
.who{display:flex;align-items:center;gap:14px;font-size:14px;color:var(--mute)}
main{max-width:1120px;margin:0 auto;padding:32px 24px 70px}
h1{font-size:32px;font-weight:800;letter-spacing:-.02em}
.sub{color:var(--mute);font-size:14px;margin:6px 0 26px}
.layout{display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:24px;align-items:start}
.col{display:grid;gap:24px;min-width:0}
.side{position:sticky;top:16px}
.card{background:var(--card);border:1px solid var(--line);border-radius:18px;padding:22px;box-shadow:0 1px 4px rgba(40,30,80,.04)}
.head{display:flex;gap:12px;align-items:center;margin-bottom:16px}
.head .ico{width:34px;height:34px;border-radius:10px;background:var(--soft);color:var(--acc);display:grid;place-items:center;font-weight:700;flex:none}
.head h2{font-size:17px;font-weight:700}.head p{font-size:12px;color:var(--mute)}
.petrow{display:flex;flex-wrap:wrap;gap:18px;align-items:center;margin-bottom:18px}
.avatar{width:76px;height:76px;border-radius:18px;background:#e6f3ea;display:grid;place-items:center;font-size:40px;overflow:hidden;flex:none}
.avatar img{width:100%;height:100%;object-fit:cover}
.pname{font-size:22px;font-weight:800}.ptype{font-size:13px;color:var(--mute);text-transform:capitalize}
.grow{flex:1;min-width:140px}
.pick{display:flex;align-items:flex-end;gap:10px;margin-left:auto}
.pick label{font-size:11px;font-weight:700;color:var(--mute)}
.tiles{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.tile{background:var(--tile);border:1px solid var(--line);border-radius:12px;padding:14px 16px}
.k{font-size:10.5px;font-weight:700;letter-spacing:.07em;color:var(--mute);text-transform:uppercase;margin-bottom:6px}
.v{font-size:15px;font-weight:700}.v.none{font-weight:500;color:#a4a2b5}
.link{background:none;border:0;color:var(--acc);font:600 13px 'DM Sans',sans-serif;cursor:pointer;padding:0}
.link:hover{text-decoration:underline}
.mini{margin-top:12px;display:flex;flex-wrap:wrap;gap:14px;align-items:center}
.inline{display:flex;gap:10px;align-items:flex-end;margin-top:12px}
.inline[hidden]{display:none}
.btn{background:var(--acc);color:#fff;border:0;border-radius:10px;padding:10px 18px;font:700 14px 'DM Sans',sans-serif;cursor:pointer;display:inline-block}
.btn:hover{background:var(--acc2)}
.btn.ghost{background:#fff;color:var(--acc);border:1px solid var(--line)}
.btn.ghost:hover{background:var(--soft)}
.btn.sm{padding:8px 14px;font-size:12.5px}
.btn.block{width:100%;padding:12px}
.btn.danger{background:#d9534f}.btn.danger:hover{background:#c0403c}
.btn.warn{color:#b42323}
form.stack,dialog form{display:grid;gap:14px}
label{display:grid;gap:6px;font-size:12px;font-weight:700;color:var(--ink)}
label small{font-weight:400;color:var(--mute)}
input,select,textarea{font:400 14px 'DM Sans',sans-serif;padding:10px 12px;border:1.5px solid var(--line);border-radius:10px;background:#fff;color:var(--ink);width:100%}
input:focus,select:focus,textarea:focus{outline:none;border-color:var(--acc)}
textarea{min-height:84px;resize:vertical}
input[type=file]{padding:7px}
.two{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.actions{display:flex;justify-content:flex-end;gap:10px}
.acts{display:flex;gap:8px;flex-wrap:wrap;margin-top:14px}
.flash{border-radius:12px;padding:12px 16px;margin-bottom:18px;font-size:14px}
.ok{background:#e4f6ea;color:#1d7a3a;border:1px solid #c6ebd2}.err{background:#fde8e8;color:#b42323;border:1px solid #f6caca}.err ul{padding-left:18px}
.vaxbox{border:1px solid var(--line);border-radius:12px;padding:12px;background:var(--tile)}
.vaxbox[hidden]{display:none}
.vaxbox h4{font-size:12px;margin-bottom:2px}.vaxbox .hint{font-size:11.5px;color:var(--mute);margin-bottom:10px}
.opt{display:flex;gap:10px;align-items:flex-start;background:#fff;border:1px solid var(--line);border-radius:10px;padding:10px;margin-bottom:8px;cursor:pointer;font-weight:600}
.opt input{width:auto;margin-top:3px;accent-color:var(--acc)}
.opt span{display:block;font-size:11.5px;color:var(--mute);font-weight:400;margin-top:2px}
.appt{border-top:1px solid var(--line);padding:14px 0;display:flex;justify-content:space-between;gap:10px}
.appt:first-of-type{border-top:0;padding-top:0}
.appt h3{font-size:14px}.muted{color:var(--mute);font-size:12.5px;margin-top:2px}
.note{font-size:12.5px;background:var(--soft);border-radius:8px;padding:7px 10px;margin-top:8px;white-space:pre-line}
.chip{font-size:11px;font-weight:700;padding:4px 10px;border-radius:40px;white-space:nowrap;height:fit-content}
.pending{background:#fff4d6;color:#8a6100}.approved{background:#dff6e6;color:#1d7a3a}
.declined{background:#fde2e2;color:#b42323}.completed{background:#e3ecfb;color:#2f5aa8}.notgiven{background:#f1f0f6;color:#76748a}
.empty{color:var(--mute);font-size:13px}
.summary{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;border:1px solid var(--line);border-radius:12px;padding:14px 16px;margin-bottom:14px}
.summary strong{font-size:15px}.summary p{font-size:12.5px;color:var(--mute)}
.vrow{border:1px solid var(--line);border-radius:12px;padding:14px 16px;margin-bottom:12px}
.vtop{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:10px}
.vtop strong{font-size:14px}
.tag{font-size:10.5px;font-weight:700;background:var(--soft);color:var(--acc);padding:2px 8px;border-radius:20px;margin-left:6px}
.vgrid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px}
.vgrid .v{font-size:12.5px;font-weight:600}
.petform{display:grid;grid-template-columns:1fr 1fr;gap:14px}
dialog{border:0;border-radius:18px;padding:24px;width:min(460px,92vw);margin:auto}
dialog::backdrop{background:rgba(26,21,35,.45)}
dialog h2{font-size:18px}
@media(max-width:920px){.layout{grid-template-columns:1fr}.side{position:static}.pick{margin-left:0}}
@media(max-width:560px){.tiles,.petform,.two{grid-template-columns:1fr}.vgrid{grid-template-columns:1fr 1fr}h1{font-size:26px}}
</style>
</head>
<body>
@php
    $emoji = ['dog' => '🐶', 'cat' => '🐱', 'bird' => '🐦', 'rabbit' => '🐰', 'fish' => '🐠', 'other' => '🐾'];
    $chosenService = old('service', in_array($prefill['service'] ?? null, $services, true) ? $prefill['service'] : $services[0]);
    $chosenVaccines = old('vaccines', $prefill['vaccines'] ?? []);

<<<<<<< HEAD
    <main class="page">
        <h1>Welcome back, {{ $petOwner->first_name }}!</h1>
        <p class="intro">Keep your pet's details close and book a visit whenever they need care.</p>
=======
    $ageText = null;
    if ($selected && $selected->birth_date) {
        $ageText = $selected->birth_date->age >= 1
            ? $selected->birth_date->age . ' year' . ($selected->birth_date->age === 1 ? '' : 's') . ' old'
            : abs((int) $selected->birth_date->diffInMonths(now())) . ' month(s) old';
    }
>>>>>>> origin/main

    $nextDue = $selected
        ? $selected->vaccinationRecords->filter(fn ($r) => $r->next_due_date && ! $r->next_due_date->isPast())->sortBy('next_due_date')->first()
        : null;
@endphp

<header class="top">
  <div class="brand"><span>Pet</span> <span>Place.</span></div>
  <div class="who">
    <span>Hi, {{ $owner->first_name }}</span>
    <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn ghost sm" type="submit">Log out</button></form>
  </div>
</header>

<main>
  <h1>Welcome back, {{ $owner->first_name }}!</h1>
  <p class="sub">Keep your pet's details close and book a visit whenever they need care.</p>

  @if (session('success'))
    <div class="flash ok">{{ session('success') }}</div>
  @endif
  @if ($errors->any())
    <div class="flash err"><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
  @endif

<<<<<<< HEAD
            <div class="side-stack">
                <section class="card section-card" id="request-appointment">
                    <div class="section-heading">
                        <div class="section-icon" aria-hidden="true">＋</div>
                        <div>
                            <h2>Book appointment</h2>
                            <p>Choose a service and preferred time for {{ $pet->pet_name ?: 'your pet' }}.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('owner.appointments.store') }}">
                        @csrf
                        <input type="hidden" name="pet_id" value="{{ $pet->id }}">
                        <div class="field">
                            <label for="service_type">Service type</label>
                            <select id="service_type" name="service_type" required>
                                <option value="Check-up / Consultation" {{ old('service_type', request('service_type', 'Check-up / Consultation')) === 'Check-up / Consultation' ? 'selected' : '' }}>Check-up / Consultation</option>
                                <option value="Vaccination" {{ old('service_type', request('service_type')) === 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                                <option value="Grooming" {{ old('service_type', request('service_type')) === 'Grooming' ? 'selected' : '' }}>Grooming</option>
                            </select>
                        </div>
                        <div class="field" id="vet-field">
                            <label for="vet_id">Veterinarian</label>
                            <select id="vet_id" name="vet_id">
                                <option value="">Any available veterinarian</option>
                                @foreach ($vets as $vet)
                                    <option value="{{ $vet->id }}" {{ old('vet_id') == $vet->id ? 'selected' : '' }}>
                                        Dr. {{ $vet->first_name }} {{ $vet->last_name }}{{ $vet->specialty ? ' · '.ucfirst($vet->specialty).' specialist' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field" id="groomer-field" hidden>
                            <label for="groomer_id">Groomer</label>
                            <select id="groomer_id" name="groomer_id" disabled>
                                <option value="">Any available groomer</option>
                                @foreach ($groomers as $groomer)
                                    <option value="{{ $groomer->id }}" {{ old('groomer_id') == $groomer->id ? 'selected' : '' }}>
                                        {{ $groomer->first_name }} {{ $groomer->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <fieldset class="grooming-fields" id="grooming-fields" hidden disabled>
                            <legend>Grooming options</legend>
                            <div class="field">
                                <label>Add-ons</label>
                                <div class="grooming-addons">
                                    @foreach ([
                                        'nail_trimming' => 'Nail trimming',
                                        'ear_cleaning' => 'Ear cleaning',
                                        'teeth_brushing' => 'Teeth brushing',
                                        'anal_gland_expression' => 'Anal gland expression',
                                        'flea_tick_treatment' => 'Flea & tick treatment',
                                        'de_shedding' => 'De-shedding treatment',
                                        'medicated_shampoo' => 'Medicated or special shampoo (sensitive skin)',
                                        'perfume_bow_bandana' => 'Perfume / bow / bandana',
                                    ] as $addon => $addonLabel)
                                        <label class="grooming-addon">
                                            <input type="checkbox" name="grooming_addons[]" value="{{ $addon }}" {{ in_array($addon, old('grooming_addons', []), true) ? 'checked' : '' }}>
                                            <span>{{ $addonLabel }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
=======
  <div class="layout">
    <div class="col">
>>>>>>> origin/main

      {{-- PET CARD --}}
      @if ($selected)
      <section class="card">
        <div class="petrow">
          <div class="avatar">
            @if ($selected->photo_url)<img src="{{ $selected->photo_url }}" alt="{{ $selected->name }}">@else{{ $emoji[$selected->type] ?? '🐾' }}@endif
          </div>
          <div class="grow">
            <div class="pname">{{ $selected->name }}</div>
            <div class="ptype">{{ $selected->type }}@if ($selected->breed) · {{ $selected->breed }}@endif</div>
          </div>

<<<<<<< HEAD
                            <div class="field">
                                <label>Vaccination status from the pet's records</label>
                                <div class="grooming-vaccines">
                                    @foreach ($groomingVaccines as $vaccineName => $vaccineStatus)
                                        <div class="grooming-vaccine-status">
                                            <span>{{ ucfirst($vaccineName) }}{{ $vaccineStatus['record']?->next_due_date ? ' · due '.$vaccineStatus['record']->next_due_date->format('M j, Y') : '' }}</span>
                                            <span class="vaccination-status {{ $vaccineStatus['status'] }}">
                                                {{ ['up_to_date' => 'Up to date', 'due_soon' => 'Due soon', 'overdue' => 'Overdue', 'not_yet_given' => 'Not recorded'][$vaccineStatus['status']] }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="help">Groomers may require current rabies vaccination and, for dogs, may request Bordetella records. Please confirm their requirements.</p>
                            </div>
                        </fieldset>
                        @if ($vaccineOptions)
                            @php($selectedVaccines = old('vaccines', request()->filled('vaccine') ? [request('vaccine')] : []))
                            <fieldset class="vaccine-fieldset" id="vaccines-field" hidden disabled>
                                <legend>{{ ucfirst($pet->pet_type) }} vaccines</legend>
                                <p class="vaccine-note">Select all vaccines you'd like to discuss for your pet. Your veterinarian will confirm which are appropriate and when they are due.</p>
                                <div class="vaccine-list">
                                    @if (strtolower($pet->pet_type) === 'cat')
                                        <label class="vaccine-option" for="vaccine-cat_fvrcp">
                                            <input id="vaccine-cat_fvrcp" type="checkbox" name="vaccines[]" value="cat_fvrcp" {{ in_array('cat_fvrcp', $selectedVaccines, true) ? 'checked' : '' }}>
                                            <span class="vaccine-copy">
                                                <span class="vaccine-name">{{ $vaccineOptions['cat_fvrcp'][0] }}</span>
                                                <span class="vaccine-description">{{ $vaccineOptions['cat_fvrcp'][1] }}</span>
                                            </span>
                                        </label>
                                        <div class="vaccine-suboptions" id="fvrcp-components">
                                            @foreach (['cat_rhinotracheitis', 'cat_calicivirus', 'cat_panleukopenia'] as $vaccineId)
                                                <label class="vaccine-option" for="vaccine-{{ $vaccineId }}">
                                                    <input id="vaccine-{{ $vaccineId }}" type="checkbox" name="vaccines[]" value="{{ $vaccineId }}" {{ in_array($vaccineId, $selectedVaccines, true) ? 'checked' : '' }}>
                                                    <span class="vaccine-copy">
                                                        <span class="vaccine-name">{{ $vaccineOptions[$vaccineId][0] }}</span>
                                                        <span class="vaccine-description">{{ $vaccineOptions[$vaccineId][1] }}</span>
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                        @foreach ($vaccineOptions as $vaccineId => $vaccine)
                                            @if (! in_array($vaccineId, ['cat_fvrcp', 'cat_rhinotracheitis', 'cat_calicivirus', 'cat_panleukopenia'], true))
                                                <label class="vaccine-option" for="vaccine-{{ $vaccineId }}">
                                                    <input id="vaccine-{{ $vaccineId }}" type="checkbox" name="vaccines[]" value="{{ $vaccineId }}" {{ in_array($vaccineId, $selectedVaccines, true) ? 'checked' : '' }}>
                                                    <span class="vaccine-copy">
                                                        <span class="vaccine-name">{{ $vaccine[0] }}</span>
                                                        <span class="vaccine-description">{{ $vaccine[1] }}</span>
                                                    </span>
                                                </label>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach ($vaccineOptions as $vaccineId => $vaccine)
                                            <label class="vaccine-option" for="vaccine-{{ $vaccineId }}">
                                                <input id="vaccine-{{ $vaccineId }}" type="checkbox" name="vaccines[]" value="{{ $vaccineId }}" {{ in_array($vaccineId, $selectedVaccines, true) ? 'checked' : '' }}>
                                                <span class="vaccine-copy">
                                                    <span class="vaccine-name">{{ $vaccine[0] }}</span>
                                                    <span class="vaccine-description">{{ $vaccine[1] }}</span>
                                                </span>
                                            </label>
                                        @endforeach
                                    @endif
                                </div>
                            </fieldset>
                        @endif
                        <div class="field">
                            <label for="appointment_at">Preferred date and time</label>
                            <input id="appointment_at" name="appointment_at" type="datetime-local" min="{{ now()->addHour()->format('Y-m-d\TH:i') }}" value="{{ old('appointment_at') }}" required>
                        </div>
                        <div class="field">
                            <label for="reason">What does your pet need? <span style="font-weight:400;">(optional)</span></label>
                            <textarea id="reason" name="reason" maxlength="1000" placeholder="Anything you'd like the vet or groomer to know...">{{ old('reason') }}</textarea>
                        </div>
                        @if ($vets->isEmpty() && $groomers->isEmpty())
                            <p class="help">No staff are listed yet. You can still request service from any available staff member.</p>
                        @endif
                        <button class="btn btn-full" type="submit">Book appointment</button>
                    </form>
                </section>

                <section class="card section-card">
                    <div class="section-heading">
                        <div class="section-icon" aria-hidden="true">♡</div>
                        <div>
                            <h2>My appointments</h2>
                            <p>Keep track of your upcoming visits.</p>
                        </div>
                    </div>
                    @if ($appointments->isEmpty())
                        <p class="empty-state">You don't have any appointments yet. Use the form above to get started.</p>
                    @else
                        <div class="appointment-list">
                            @foreach ($appointments as $appointment)
                                <article class="appointment-item">
                                    <div class="appointment-row">
                                        <div class="appointment-date">{{ $appointment->appointment_at->format('M j, Y · g:i A') }}</div>
                                        <span class="badge">{{ ucfirst($appointment->status) }}</span>
                                    </div>
                                    <div class="appointment-vet">{{ $appointment->service_type }}</div>
                                    @if ($appointment->pet)
                                        <div class="appointment-vet">For {{ $appointment->pet->pet_name ?: 'your pet' }}</div>
                                    @endif
                                    <div class="appointment-vet">
                                        @if ($appointment->service_type === 'Grooming')
                                            {{ $appointment->groomer ? $appointment->groomer->first_name.' '.$appointment->groomer->last_name : 'Any available groomer' }}
                                        @else
                                            {{ $appointment->vet ? 'Dr. '.$appointment->vet->first_name.' '.$appointment->vet->last_name : 'Any available veterinarian' }}
                                        @endif
                                    </div>
                                    @if ($appointment->reason)
                                        <div class="appointment-reason">{{ $appointment->reason }}</div>
                                    @endif
                                    @if ($appointment->vaccines)
                                        <div class="appointment-reason">
                                            Vaccines requested: {{ collect($appointment->vaccines)->map(fn ($vaccine) => $vaccineLabels[$vaccine] ?? $vaccine)->join(', ') }}
                                        </div>
                                    @endif
                                    @if ($appointment->service_type === 'Grooming')
                                        @if ($appointment->grooming_addons)
                                            <div class="appointment-reason">Grooming add-ons: {{ collect($appointment->grooming_addons)->map(fn ($addon) => ucwords(str_replace('_', ' ', $addon)))->join(', ') }}</div>
                                        @endif
                                        @php($groomingPreferences = array_filter([
                                            'Haircut' => $appointment->haircut_style,
                                            'Shampoo' => $appointment->shampoo_type,
                                            'Fur matted' => is_null($appointment->fur_matted) ? null : ($appointment->fur_matted ? 'Yes' : 'No'),
                                            'Size' => $appointment->pet_size,
                                            'Coat' => $appointment->coat_type,
                                            'Temperament' => $appointment->temperament,
                                            'Allergies / skin problems' => $appointment->allergies_or_skin_problems,
                                        ]))
                                        @if ($groomingPreferences)
                                            <div class="appointment-reason">
                                                {{ collect($groomingPreferences)->map(fn ($value, $label) => $label.': '.$value)->join(' · ') }}
                                            </div>
                                        @endif
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    @endif
                </section>
            </div>
=======
          <form method="POST" action="{{ route('owner.pets.photo', $selected) }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="photo" id="photoInput" accept="image/*" hidden onchange="this.form.submit()">
            <label for="photoInput" class="btn ghost sm" style="display:inline-block;cursor:pointer">＋ {{ $selected->photo_path ? 'Change photo' : 'Add a photo' }}</label>
          </form>

          <form method="GET" action="{{ route('owner.dashboard') }}" class="pick">
            <label>Your pets
              <select name="pet_id">
                @foreach ($pets as $p)<option value="{{ $p->id }}" @selected($p->id === $selected->id)>{{ $p->name }} · {{ ucfirst($p->type) }}</option>@endforeach
              </select>
            </label>
            <button class="btn" type="submit">View pet</button>
          </form>
>>>>>>> origin/main
        </div>

        <div class="tiles">
          <div class="tile"><div class="k">Pet name</div><div class="v">{{ $selected->name }}</div></div>
          <div class="tile"><div class="k">Pet type</div><div class="v">{{ ucfirst($selected->type) }}</div></div>
          <div class="tile">
            <div class="k">Birthdate / age</div>
            @if ($selected->birth_date)
              <div class="v">{{ $selected->birth_date->format('F j, Y') }} <span style="font-weight:500;color:var(--mute);font-size:12.5px">({{ $ageText }})</span></div>
            @else
              <div class="v none">Not added yet</div>
            @endif
          </div>
        </div>

<<<<<<< HEAD
                <div class="vaccination-summary">
                    <div class="vaccination-summary-copy">
                        <strong>{{ $vaccinationSummary['coreUpToDate'] }} of {{ $vaccinationSummary['coreTotal'] }} core vaccines up to date</strong>
                        @if ($vaccinationSummary['nextDueRecord'])
                            <span>Next due: {{ $vaccineLabels[$vaccinationSummary['nextDueRecord']->vaccine_key] ?? $vaccinationSummary['nextDueRecord']->vaccine_key }} · {{ $vaccinationSummary['nextDueRecord']->next_due_date->format('M j, Y') }}</span>
                        @else
                            <span>No upcoming due date is recorded.</span>
                        @endif
                    </div>
                    @if ($vaccinationRequestKey)
                        <a class="btn" href="{{ route('owner.dashboard', ['pet_id' => $pet->id, 'service_type' => 'Vaccination', 'vaccine' => $vaccinationRequestKey]) }}#request-appointment">Book vaccination</a>
                    @endif
                </div>

                <div class="vaccination-list">
                    @foreach ($vaccinationRows as $vaccinationRow)
                        @php($record = $vaccinationRow['record'])
                        @php($vaccineKey = $vaccinationRow['vaccine_key'])
                        @php($status = $vaccinationRow['status'])
                        <article class="vaccination-item">
                            <div>
                                <div class="vaccination-item-heading">
                                    <strong>{{ $vaccineLabels[$vaccineKey] ?? $vaccineKey }}</strong>
                                    <span class="vaccination-category">{{ $vaccineCategories[$vaccineKey] ?? 'Non-core (Lifestyle)' }}</span>
                                </div>
                            </div>
                            <span class="vaccination-status {{ $status }}">
                                {{ ['up_to_date' => 'Up to date', 'due_soon' => 'Due soon', 'overdue' => 'Overdue', 'not_yet_given' => 'Not yet given'][$status] }}
                            </span>
                            <div class="vaccination-details">
                                <div class="vaccination-detail"><strong>Date given</strong>{{ $record?->date_given?->format('M j, Y') ?? 'Not recorded' }}</div>
                                <div class="vaccination-detail"><strong>Next due date</strong>{{ $record?->next_due_date?->format('M j, Y') ?? 'Not set' }}</div>
                                <div class="vaccination-detail"><strong>Veterinarian</strong>{{ $record?->veterinarian_name ?: 'Not recorded' }}</div>
                                <div class="vaccination-detail"><strong>Dose number</strong>{{ $record?->dose_number ?: 'Not recorded' }}</div>
                                @if ($record)
                                    <div class="vaccination-detail"><strong>Brand</strong>{{ $record->brand ?: 'Not recorded' }}</div>
                                    <div class="vaccination-detail"><strong>Batch / lot number</strong>{{ $record->batch_number ?: 'Not recorded' }}</div>
                                @endif
                            </div>
                            @if ($record?->notes)
                                <p class="vaccination-notes"><strong>Notes:</strong> {{ $record->notes }}</p>
                            @endif
                            @if ($status !== 'up_to_date')
                                <a class="vaccination-request-link" href="{{ route('owner.dashboard', ['pet_id' => $pet->id, 'service_type' => 'Vaccination', 'vaccine' => $vaccineKey]) }}#request-appointment">Book this vaccination</a>
                            @endif
                        </article>
                    @endforeach
                </div>
=======
        <div class="mini">
          <button type="button" class="link" onclick="document.getElementById('birthForm').hidden = !document.getElementById('birthForm').hidden">✎ {{ $selected->birth_date ? 'Edit birthdate' : 'Add birthdate' }}</button>
          <button type="button" class="link" onclick="openPet(this)"
            data-id="{{ $selected->id }}" data-name="{{ $selected->name }}" data-type="{{ $selected->type }}"
            data-breed="{{ $selected->breed }}" data-sex="{{ $selected->sex }}"
            data-birth="{{ $selected->birth_date?->toDateString() }}" data-notes="{{ $selected->notes }}">Edit pet details</button>
          <button type="button" class="link" style="color:#b42323" onclick="askDelete(this)"
            data-id="{{ $selected->id }}" data-name="{{ $selected->name }}"
            data-appts="{{ $selected->appointments_count }}" data-visits="{{ $selected->visit_records_count }}"
            data-vax="{{ $selected->vaccination_records_count }}">Delete pet</button>
        </div>

        <form id="birthForm" class="inline" hidden method="POST" action="{{ route('owner.pets.birthdate', $selected) }}">
          @csrf @method('PATCH')
          <label>Pet's birthdate
            <input type="date" name="birth_date" value="{{ $selected->birth_date?->toDateString() }}" max="{{ now()->toDateString() }}" required>
          </label>
          <button class="btn" type="submit">Save date</button>
        </form>
      </section>
>>>>>>> origin/main

      {{-- VACCINATION RECORDS --}}
      <section class="card" id="vaccinations">
        <div class="head">
          <div class="ico">＋</div>
          <div><h2>{{ $selected->name }}'s vaccination records</h2><p>Vaccination history and due dates entered by your veterinary team.</p></div>
        </div>

        <div class="summary">
          <div>
            @if ($coreTotal > 0)
              <strong>{{ $coreDone }} of {{ $coreTotal }} core vaccines up to date</strong>
            @else
              <strong>{{ $selected->vaccinationRecords->count() }} vaccination record(s)</strong>
            @endif
            <p>
              @if ($nextDue)
                Next due: {{ $nextDue->vaccine_name }} on {{ $nextDue->next_due_date->format('M d, Y') }}
              @else
                No upcoming due dates are recorded.
              @endif
            </p>
          </div>
          <a class="btn sm" href="{{ route('owner.dashboard', ['pet_id' => $selected->id, 'service_type' => 'Vaccination']) }}#book">Request vaccination</a>
        </div>

        @foreach ($vaccineRows as $row)
          @continue(! $row['core'] && ! $row['record'])
          @php $rec = $row['record']; @endphp
          <div class="vrow">
            <div class="vtop">
              <div><strong>{{ $row['name'] }}</strong>@if ($row['core'])<span class="tag">Core</span>@endif</div>
              @if (! $rec)<span class="chip notgiven">NOT YET GIVEN</span>
              @elseif ($row['overdue'])<span class="chip declined">OVERDUE</span>
              @else<span class="chip approved">UP TO DATE</span>@endif
            </div>
            <div class="vgrid">
              <div><div class="k">Date given</div><div class="v {{ $rec ? '' : 'none' }}">{{ $rec ? $rec->date_given->format('M d, Y') : 'Not recorded' }}</div></div>
              <div><div class="k">Next due date</div><div class="v {{ $rec && $rec->next_due_date ? '' : 'none' }}">{{ $rec && $rec->next_due_date ? $rec->next_due_date->format('M d, Y') : 'Not set' }}</div></div>
              <div><div class="k">Veterinarian</div><div class="v {{ $rec ? '' : 'none' }}">{{ $rec && $rec->vet ? 'Dr. ' . $rec->vet->first_name . ' ' . $rec->vet->last_name : 'Not recorded' }}</div></div>
              <div><div class="k">Dose number</div><div class="v {{ $rec && $rec->dose_number ? '' : 'none' }}">{{ $rec && $rec->dose_number ? $rec->dose_number : 'Not recorded' }}</div></div>
            </div>
            @if (! $rec || $row['overdue'])
              <p style="margin-top:10px"><a class="link" href="{{ route('owner.dashboard', ['pet_id' => $selected->id, 'service_type' => 'Vaccination', 'vaccine' => [$row['key']]]) }}#book">Request this vaccination</a></p>
            @endif
          </div>
        @endforeach

        @foreach ($otherRecords as $rec)
          <div class="vrow">
            <div class="vtop"><div><strong>{{ $rec->vaccine_name }}</strong></div><span class="chip {{ $rec->next_due_date && $rec->next_due_date->isPast() ? 'declined' : 'approved' }}">{{ $rec->next_due_date && $rec->next_due_date->isPast() ? 'OVERDUE' : 'RECORDED' }}</span></div>
            <div class="vgrid">
              <div><div class="k">Date given</div><div class="v">{{ $rec->date_given->format('M d, Y') }}</div></div>
              <div><div class="k">Next due date</div><div class="v {{ $rec->next_due_date ? '' : 'none' }}">{{ $rec->next_due_date ? $rec->next_due_date->format('M d, Y') : 'Not set' }}</div></div>
              <div><div class="k">Veterinarian</div><div class="v">{{ $rec->vet ? 'Dr. ' . $rec->vet->first_name . ' ' . $rec->vet->last_name : 'Not recorded' }}</div></div>
              <div><div class="k">Dose number</div><div class="v {{ $rec->dose_number ? '' : 'none' }}">{{ $rec->dose_number ?: 'Not recorded' }}</div></div>
            </div>
          </div>
        @endforeach

        @if (empty($catalog) && $otherRecords->isEmpty())
          <p class="empty">No vaccinations recorded yet for {{ $selected->name }}.</p>
        @endif
      </section>
      @else
      <section class="card">
        <div class="head"><div class="ico">🐾</div><div><h2>No pets yet</h2><p>Add your first pet below to get started.</p></div></div>
      </section>
      @endif

      {{-- ADD ANOTHER PET --}}
      <section class="card" id="addpet">
        <div class="head">
          <div class="ico">＋</div>
          <div style="flex:1"><h2>{{ $selected ? 'Add another pet' : 'Add your pet' }}</h2><p>Have another animal at home? Create a separate profile for their details, photo and appointments.</p></div>
          <button class="btn sm" type="button" onclick="openPet()">＋ Add additional pet</button>
        </div>
        <form class="stack" method="POST" action="{{ route('owner.pets.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="petform">
            <label>Pet name <input name="name" maxlength="100" required></label>
            <label>Pet type
              <select name="type" required>
                <option value="">Select type</option>
                @foreach ($petTypes as $t)<option value="{{ $t }}">{{ ucfirst($t) }}</option>@endforeach
              </select>
            </label>
            <label>Birthdate <small>(optional)</small> <input type="date" name="birth_date" max="{{ now()->toDateString() }}"></label>
            <label>Photo <small>(optional)</small> <input type="file" name="photo" accept="image/*"></label>
          </div>
          <div><button class="btn" type="submit">Add pet</button></div>
        </form>
      </section>
    </div>

    {{-- SIDEBAR --}}
    <aside class="col side">
      @if ($selected)
      <section class="card" id="book">
        <div class="head">
          <div class="ico">＋</div>
          <div><h2>Book appointment</h2><p>Choose a service and preferred time for {{ $selected->name }}.</p></div>
        </div>
        <form class="stack" method="POST" action="{{ route('owner.appointments.store') }}">
          @csrf
          <input type="hidden" name="pet_id" value="{{ $selected->id }}">

          <label>Service type
            <select name="service" id="serviceSelect">
              @foreach ($services as $s)<option value="{{ $s }}" @selected($chosenService === $s)>{{ $s }}</option>@endforeach
            </select>
          </label>

          @if (! empty($catalog))
          <div class="vaxbox" id="vaxBox" @if ($chosenService !== 'Vaccination') hidden @endif>
            <h4>{{ ucfirst($selected->type) }} vaccines</h4>
            <p class="hint">Select all vaccines you'd like to discuss for your pet. Your veterinarian will confirm which are appropriate and when they are due.</p>
            @foreach ($catalog as $v)
              <label class="opt">
                <input type="checkbox" name="vaccines[]" value="{{ $v['key'] }}" @checked(in_array($v['key'], (array) $chosenVaccines, true))>
                <div>{{ $v['name'] }}<span>{{ $v['info'] }}</span></div>
              </label>
            @endforeach
          </div>
          @endif

          <label>Veterinarian
            <select name="vet_id">
              <option value="">Any available veterinarian</option>
              @foreach ($vets as $vet)
                <option value="{{ $vet->id }}" @selected((string) old('vet_id') === (string) $vet->id)>Dr. {{ $vet->first_name }} {{ $vet->last_name }}@if ($vet->clinic_name) — {{ $vet->clinic_name }}@endif</option>
              @endforeach
            </select>
          </label>

          <label>Preferred date and time
            <input type="datetime-local" name="appointment_at" min="{{ now()->format('Y-m-d\TH:i') }}" value="{{ old('appointment_at') }}" required>
          </label>

          <label>What does your pet need? <small>(optional)</small>
            <textarea name="reason" maxlength="1000" placeholder="Anything you'd like the vet or groomer to know...">{{ old('reason') }}</textarea>
          </label>

          <button class="btn block" type="submit">Book appointment</button>
        </form>
      </section>

      <section class="card">
        <div class="head">
          <div class="ico">♡</div>
          <div><h2>My appointments</h2><p>Keep track of {{ $selected->name }}'s upcoming visits.</p></div>
        </div>
        @forelse ($appointments as $a)
          <article class="appt">
            <div>
              <h3>{{ $a->service }}</h3>
              <p class="muted">{{ $a->appointment_date->format('M d, Y') }} at {{ \Carbon\Carbon::parse($a->appointment_time)->format('g:i A') }}</p>
              <p class="muted">{{ $a->vet ? 'Dr. ' . $a->vet->first_name . ' ' . $a->vet->last_name : 'Any available veterinarian' }}</p>
              @if ($a->reason)<p class="note">{{ $a->reason }}</p>@endif
              @if ($a->vet_note)<p class="note">Vet's note: {{ $a->vet_note }}</p>@endif
            </div>
            <span class="chip {{ $a->status }}">{{ ucfirst($a->status) }}</span>
          </article>
        @empty
          <p class="empty">You don't have any appointments yet. Use the form above to get started.</p>
        @endforelse
      </section>
      @endif
    </aside>
  </div>
</main>

{{-- ADD / EDIT PET (one dialog for both) --}}
<dialog id="petDialog">
  <form method="POST" id="petForm" action="{{ route('owner.pets.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="PATCH" id="petMethod" disabled>
    <h2 id="petTitle">Add pet</h2>
    <label>Name <input name="name" id="p_name" maxlength="100" required></label>
    <label>Type
      <select name="type" id="p_type" required>
        @foreach ($petTypes as $t)<option value="{{ $t }}">{{ ucfirst($t) }}</option>@endforeach
      </select>
    </label>
    <label>Breed <input name="breed" id="p_breed" maxlength="100"></label>
    <div class="two">
      <label>Sex
        <select name="sex" id="p_sex"><option value="">—</option><option value="male">Male</option><option value="female">Female</option></select>
      </label>
      <label>Birth date <input type="date" name="birth_date" id="p_birth" max="{{ now()->toDateString() }}"></label>
    </div>
    <label>Photo <small>(optional)</small> <input type="file" name="photo" accept="image/*"></label>
    <label>Notes (allergies, special care) <textarea name="notes" id="p_notes" maxlength="1000"></textarea></label>
    <div class="actions">
      <button type="button" class="btn ghost" onclick="document.getElementById('petDialog').close()">Cancel</button>
      <button type="submit" class="btn">Save</button>
    </div>
  </form>
</dialog>

{{-- DELETE CONFIRMATION --}}
<dialog id="delDialog">
  <form method="POST" id="delForm">
    @csrf
    @method('DELETE')
    <h2>Are you sure you want to delete <span id="delName"></span>?</h2>
    <p class="muted" id="delWarn"></p>
    <div class="actions">
      <button type="button" class="btn ghost" onclick="document.getElementById('delDialog').close()">Cancel</button>
      <button type="submit" class="btn danger">Yes, delete</button>
    </div>
  </form>
</dialog>

<script>
const storeUrl = @json(route('owner.pets.store'));
const updateUrl = @json(route('owner.pets.update', ['pet' => '__ID__']));
const destroyUrl = @json(route('owner.pets.destroy', ['pet' => '__ID__']));
const $ = id => document.getElementById(id);

// Show the vaccine checklist only when the service is "Vaccination".
const serviceSelect = $('serviceSelect');
if (serviceSelect && $('vaxBox')) {
  serviceSelect.addEventListener('change', () => { $('vaxBox').hidden = serviceSelect.value !== 'Vaccination'; });
}

// Coming from "Request vaccination": jump to the booking card.
if (location.hash === '#book' && $('book')) { $('book').scrollIntoView({ behavior: 'smooth', block: 'start' }); }

function openPet(btn) {
  const edit = !!btn, d = edit ? btn.dataset : {};
  $('petTitle').textContent = edit ? 'Edit pet' : 'Add pet';
  $('petMethod').disabled = !edit;
  $('petForm').action = edit ? updateUrl.replace('__ID__', d.id) : storeUrl;
  $('p_name').value = d.name || '';
  $('p_type').value = d.type || 'dog';
  $('p_breed').value = d.breed || '';
  $('p_sex').value = d.sex || '';
  $('p_birth').value = d.birth || '';
  $('p_notes').value = d.notes || '';
  $('petDialog').showModal();
}

function askDelete(btn) {
  const d = btn.dataset, parts = [];
  if (+d.appts)  parts.push(d.appts + ' appointment' + (+d.appts === 1 ? '' : 's'));
  if (+d.visits) parts.push(d.visits + ' visit record' + (+d.visits === 1 ? '' : 's'));
  if (+d.vax)    parts.push(d.vax + ' vaccination record' + (+d.vax === 1 ? '' : 's'));
  $('delName').textContent = d.name;
  $('delWarn').textContent = 'This will permanently delete ' + d.name
    + (parts.length ? ' together with ' + parts.join(', ') : '') + '. This cannot be undone.';
  $('delForm').action = destroyUrl.replace('__ID__', d.id);
  $('delDialog').showModal();
}
</script>
</body>
</html>
