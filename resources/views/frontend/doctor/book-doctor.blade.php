@extends('layouts.front')

@section('title', 'Book Appointment - ' . ($model->name ?? 'Doctor'))

@section('content')
@php
    $fallbacks = [
        'assets/front/images/doctor/1.jpg',
        'assets/front/images/doctor/2.jpg',
        'assets/front/images/doctor/3.jpg',
        'assets/front/images/doctor/4.jpg',
        'assets/front/images/doctor/5.jpg',
        'assets/front/images/doctor/6.jpg',
        'assets/front/images/doctor/7.jpg',
        'assets/front/images/doctor/8.jpg',
    ];
    $fallbackImage = $fallbacks[$model->id % count($fallbacks)];
    $doctorImage = !empty($model->image)
        ? (\Illuminate\Support\Str::startsWith($model->image, ['http://', 'https://']) ? $model->image : asset($model->image))
        : asset($fallbackImage);
    $branchSchedules = $model->branchSchedules->mapWithKeys(function ($schedule) {
        $branchName = optional($schedule->branch)->title ?: optional($schedule->branch)->name ?: 'Branch';
        return [
            $schedule->branch_id => [
                'branch_name' => $branchName,
                'consultant' => $schedule->consultant,
                'schedule_days' => $schedule->schedule_days,
                'schedule_time' => $schedule->schedule_time,
            ],
        ];
    });
    $defaultBranchId = old('branch_id') ?: optional($model->branchSchedules->first())->branch_id;
    $defaultSchedule = $defaultBranchId ? ($branchSchedules[$defaultBranchId] ?? null) : null;
@endphp
<main class="min-h-screen bg-[#F8FAFC] font-sans pb-20">
    <nav class="bg-white border-b border-slate-100 py-4 mb-8">
        <div class="container mx-auto px-4">
            <ol class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                <li><a href="{{ route('fhome') }}" class="hover:text-indigo-600 transition">Home</a></li>
                <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
                <li><a href="{{ route('doctor') }}" class="hover:text-indigo-600 transition">Doctors</a></li>
                <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
                <li class="text-indigo-600">Book Appointment</li>
            </ol>
        </div>
    </nav>

    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <div class="lg:col-span-8 space-y-8">
                <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-50">
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-64 bg-slate-100 aspect-square md:aspect-auto overflow-hidden">
                            <img src="{{ $doctorImage }}" alt="{{ $model->name }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-8 flex-1">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="bg-indigo-50 text-indigo-600 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest mb-2 inline-block">{{ optional($model->specialty)->name ?: 'Specialist' }}</span>
                                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-1">{{ $model->name }}</h1>
                                    <p class="text-indigo-600 font-bold text-sm">{{ $model->designation ?: 'Consultant' }}</p>
                                </div>
                                <div class="text-right hidden md:block">
                                    <p id="hero-fee-label" class="text-xs text-slate-400 uppercase font-bold tracking-widest mb-1">Consultation Fee (In-Hub)</p>
                                    <p id="hero-fee-value" class="text-3xl font-black text-slate-900 tracking-tighter">{{ formated_price($model->consultation_fee ?? 0) }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6 py-6 border-y border-slate-50 mb-6">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Qualification</p>
                                    <p class="text-sm font-bold text-slate-700">{{ $model->qualification ?: '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Experience</p>
                                    <p class="text-sm font-bold text-slate-700">{{ $model->experience_years ? $model->experience_years . '+ Years' : '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Schedule Days</p>
                                    <p id="doctor-schedule-days" class="text-sm font-bold text-slate-700">{{ $defaultSchedule['schedule_days'] ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Schedule Time</p>
                                    <p id="doctor-schedule-time" class="text-sm font-bold text-slate-700">{{ $defaultSchedule['schedule_time'] ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="text-slate-500 text-sm leading-relaxed italic">{{ $model->bio ?: 'Professional consultation available.' }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 border border-slate-50">
                    <form id="doctor-booking-form" method="POST" action="{{ route('book-doctor.submit', ['doctor' => $model->slug ?: $model->id]) }}">
                        @csrf
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-bold">1</div>
                            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Select Preferred Schedule</h2>
                        </div>

                        @php($patient = auth()->guard('patient')->user())

                        @if ($errors->any())
                            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-3 text-sm text-green-700">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Patient Name</label>
                                <input type="text" name="patient_name" class="w-full h-[52px] rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition" placeholder="Patient Name" value="{{ old('patient_name', $patient->name ?? '') }}" {{ $patient ? 'readonly' : '' }} required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Phone Number</label>
                                <input type="text" name="phone" class="w-full h-[52px] rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition" placeholder="Phone Number" value="{{ old('phone', $patient->phone ?? '') }}" {{ $patient ? 'readonly' : '' }} required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Email Address</label>
                                <input type="email" name="email" class="w-full h-[52px] rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition" placeholder="Email Address" value="{{ old('email', $patient->email ?? '') }}" {{ $patient ? 'readonly' : '' }} required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Date Of Birth</label>
                                <input type="date" name="dob" class="w-full h-[52px] rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition" value="{{ old('dob', (!empty($patient->dob) && strtotime($patient->dob)) ? date('Y-m-d', strtotime($patient->dob)) : '') }}" {{ $patient ? 'readonly' : '' }} required>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-4 mb-6">
                            <label class="cursor-pointer relative flex-1 min-w-[150px]">
                                <input type="radio" name="visit_type" value="in_hub" class="peer sr-only" {{ old('visit_type', 'in_hub') === 'in_hub' ? 'checked' : '' }}>
                                <div class="p-4 border-2 border-slate-100 rounded-2xl peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all flex items-center gap-3">
                                    <i class="fa-solid fa-hospital text-indigo-600"></i>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">In-Hub Visit</p>
                                        <p class="text-[10px] text-slate-500">Visit our facility</p>
                                    </div>
                                </div>
                            </label>
                            <label class="cursor-pointer relative flex-1 min-w-[150px]">
                                <input type="radio" name="visit_type" value="video" class="peer sr-only" {{ old('visit_type') === 'video' ? 'checked' : '' }} {{ $model->video_consultation_available ? '' : 'disabled' }}>
                                <div class="p-4 border-2 border-slate-100 rounded-2xl peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all flex items-center gap-3 {{ $model->video_consultation_available ? '' : 'opacity-60' }}">
                                    <i class="fa-solid fa-video text-indigo-600"></i>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Video Consult</p>
                                        <p class="text-[10px] text-slate-500">
                                            {{ $model->video_consultation_available ? 'Online consultation' : 'Not available for this doctor' }}
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="mb-6" id="branch-wrap">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Select Hub</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($branches as $branch)
                                @php($schedule = $branchSchedules[$branch->id] ?? null)
                                <label class="cursor-pointer">
                                    <input
                                        type="radio"
                                        name="branch_id"
                                        value="{{ $branch->id }}"
                                        class="peer sr-only branch-radio"
                                        data-branch-name="{{ e($schedule['branch_name'] ?? ($branch->title ?: $branch->name)) }}"
                                        data-schedule-days="{{ e($schedule['schedule_days'] ?? '') }}"
                                        data-schedule-time="{{ e($schedule['schedule_time'] ?? '') }}"
                                        data-consultant="{{ e($schedule['consultant'] ?? '') }}"
                                        {{ old('branch_id', $defaultBranchId) == $branch->id ? 'checked' : '' }}
                                    >
                                    <div class="p-4 border-2 border-slate-100 rounded-2xl peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                                        <p class="text-sm font-bold text-slate-900">{{ $branch->name }}</p>
                                        @if($schedule && ($schedule['schedule_days'] || $schedule['schedule_time']))
                                        <p class="text-[11px] text-indigo-600 mt-1">
                                            {{ $schedule['schedule_days'] ?: 'On request' }}@if($schedule['schedule_time']), {{ $schedule['schedule_time'] }}@endif
                                        </p>
                                        @endif
                                        @if(!empty($branch->address))
                                        <p class="text-[11px] text-slate-500 mt-1">{{ $branch->address }}</p>
                                        @endif
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Select Appointment Date</label>
                                <input type="date" id="appointment_date" name="appointment_date" class="w-full h-[52px] rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition" min="{{ date('Y-m-d') }}" value="{{ old('appointment_date') }}" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Select Time Slot</label>
                                <div class="grid grid-cols-2 gap-2 max-h-[180px] overflow-auto pr-1">
                                    @foreach($slots as $slot)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="doctor_consultation_slot_id" value="{{ $slot->id }}" class="peer sr-only" {{ old('doctor_consultation_slot_id') == $slot->id ? 'checked' : '' }} required>
                                        <span class="block text-center p-3 rounded-xl border-2 border-slate-100 text-xs font-semibold text-slate-700 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">{{ $slot->label }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Notes (Optional)</label>
                            <textarea name="notes" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition" rows="4" placeholder="Notes (optional)">{{ old('notes') }}</textarea>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-4">
                <div class="sticky top-24 space-y-4">
                <div class="bg-indigo-900 rounded-[32px] p-8 text-white">
                    <h3 class="text-lg font-bold mb-6">Booking Summary</h3>
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between"><span>Doctor</span><span>{{ $model->name }}</span></div>
                        <div class="flex justify-between"><span>Department</span><span>{{ optional($model->department)->name ?: '-' }}</span></div>
                        <div class="flex justify-between"><span>Specialty</span><span>{{ optional($model->specialty)->name ?: '-' }}</span></div>
                        <div class="flex justify-between"><span>Branch</span><span id="summary-branch">{{ $defaultSchedule['branch_name'] ?? '-' }}</span></div>
                        <div class="flex justify-between"><span>Schedule</span><span id="summary-schedule">{{ $defaultSchedule['schedule_days'] ?? '-' }}</span></div>
                        <div class="flex justify-between"><span>Time</span><span id="summary-time">{{ $defaultSchedule['schedule_time'] ?? '-' }}</span></div>
                        <div class="flex justify-between"><span>In-Hub Fee</span><span>{{ formated_price($model->consultation_fee ?? 0) }}</span></div>
                        <div class="flex justify-between"><span>Video Fee</span><span>{{ $model->video_consultation_available ? formated_price($model->video_consultation_fee ?? $model->consultation_fee ?? 0) : 'N/A' }}</span></div>
                        <div class="flex justify-between pt-2 border-t border-indigo-700">
                            <span id="summary-fee-label">Selected Fee</span>
                            <span id="summary-fee-value">{{ formated_price($model->consultation_fee ?? 0) }}</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-lg shadow-slate-200/40">
                    <button type="submit" form="doctor-booking-form" class="w-full inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-6 rounded-xl font-black uppercase tracking-widest text-xs transition-all">
                        Confirm Appointment Request
                    </button>
                </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
(function(){
  const radios = document.querySelectorAll('input[name="visit_type"]');
  const branchWrap = document.getElementById('branch-wrap');
  const branchInputs = document.querySelectorAll('.branch-radio');
  const appointmentDate = document.getElementById('appointment_date');
  const bookingForm = document.getElementById('doctor-booking-form');
  const summaryFeeLabel = document.getElementById('summary-fee-label');
  const summaryFeeValue = document.getElementById('summary-fee-value');
  const heroFeeLabel = document.getElementById('hero-fee-label');
  const heroFeeValue = document.getElementById('hero-fee-value');
  const summaryBranch = document.getElementById('summary-branch');
  const summarySchedule = document.getElementById('summary-schedule');
  const summaryTime = document.getElementById('summary-time');
  const doctorScheduleDays = document.getElementById('doctor-schedule-days');
  const doctorScheduleTime = document.getElementById('doctor-schedule-time');
  const inHubFee = @json(formated_price($model->consultation_fee ?? 0));
  const videoFee = @json($model->video_consultation_available ? formated_price($model->video_consultation_fee ?? $model->consultation_fee ?? 0) : 'N/A');
  function updateBranchSchedule() {
    const selectedBranch = document.querySelector('.branch-radio:checked');
    const branchName = selectedBranch ? selectedBranch.dataset.branchName : '-';
    const scheduleDays = selectedBranch ? (selectedBranch.dataset.scheduleDays || '-') : '-';
    const scheduleTime = selectedBranch ? (selectedBranch.dataset.scheduleTime || '-') : '-';
    if (summaryBranch) summaryBranch.textContent = branchName;
    if (summarySchedule) summarySchedule.textContent = scheduleDays;
    if (summaryTime) summaryTime.textContent = scheduleTime;
    if (doctorScheduleDays) doctorScheduleDays.textContent = scheduleDays;
    if (doctorScheduleTime) doctorScheduleTime.textContent = scheduleTime;
  }
  function toggleBranch(){
    const selected = document.querySelector('input[name="visit_type"]:checked');
    const inHub = selected && selected.value === 'in_hub';
    if (branchWrap) branchWrap.style.display = inHub ? '' : 'none';
    branchInputs.forEach((input, index) => {
      input.disabled = !inHub;
      input.required = inHub && document.querySelectorAll('.branch-radio').length > 0 && index === 0;
    });
    if (summaryFeeLabel && summaryFeeValue) {
      if (inHub) {
        summaryFeeLabel.textContent = 'Selected Fee (In-Hub)';
        summaryFeeValue.textContent = inHubFee;
      } else {
        summaryFeeLabel.textContent = 'Selected Fee (Video)';
        summaryFeeValue.textContent = videoFee;
      }
    }
    if (heroFeeLabel && heroFeeValue) {
      if (inHub) {
        heroFeeLabel.textContent = 'Consultation Fee (In-Hub)';
        heroFeeValue.textContent = inHubFee;
      } else {
        heroFeeLabel.textContent = 'Consultation Fee (Video)';
        heroFeeValue.textContent = videoFee;
      }
    }
    updateBranchSchedule();
  }
  radios.forEach(r => r.addEventListener('change', toggleBranch));
  branchInputs.forEach((input) => input.addEventListener('change', updateBranchSchedule));
  toggleBranch();

  if (appointmentDate) {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const today = year + '-' + month + '-' + day;
    appointmentDate.min = today;
  }

  if (bookingForm && appointmentDate) {
    bookingForm.addEventListener('submit', function(e) {
      if (!appointmentDate.value) return;
      const selected = new Date(appointmentDate.value + 'T00:00:00');
      const current = new Date();
      current.setHours(0, 0, 0, 0);
      if (selected < current) {
        e.preventDefault();
        alert('Past dates are not allowed for appointment booking.');
        appointmentDate.focus();
      }
    });
  }
})();
</script>
@endpush
