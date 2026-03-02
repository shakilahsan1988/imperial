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
                                    <p class="text-xs text-slate-400 uppercase font-bold tracking-widest mb-1">Consultation Fee</p>
                                    <p class="text-3xl font-black text-slate-900 tracking-tighter">{{ formated_price($model->consultation_fee ?? 0) }}</p>
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
                            </div>

                            <div class="text-slate-500 text-sm leading-relaxed italic">{{ $model->bio ?: 'Professional consultation available.' }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 border border-slate-50">
                    <form method="POST" action="{{ route('book-doctor.submit', ['doctor' => $model->slug ?: $model->id]) }}">
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
                            <input type="text" name="patient_name" class="form-control" placeholder="Patient Name" value="{{ old('patient_name', $patient->name ?? '') }}" {{ $patient ? 'readonly' : '' }} required>
                            <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="{{ old('phone', $patient->phone ?? '') }}" {{ $patient ? 'readonly' : '' }} required>
                            <input type="email" name="email" class="form-control" placeholder="Email Address" value="{{ old('email', $patient->email ?? '') }}" {{ $patient ? 'readonly' : '' }} required>
                            <input type="date" name="dob" class="form-control" value="{{ old('dob', (!empty($patient->dob) && strtotime($patient->dob)) ? date('Y-m-d', strtotime($patient->dob)) : '') }}" {{ $patient ? 'readonly' : '' }} required>
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
                            <select name="branch_id" id="branch_id" class="form-control">
                                <option value="">Select Hub</option>
                                @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Select Appointment Date</label>
                                <input type="date" name="appointment_date" class="form-control" min="{{ date('Y-m-d') }}" value="{{ old('appointment_date') }}" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Select Time Slot</label>
                                <select name="doctor_consultation_slot_id" class="form-control" required>
                                    <option value="">Select Slot</option>
                                    @foreach($slots as $slot)
                                    <option value="{{ $slot->id }}" {{ old('doctor_consultation_slot_id') == $slot->id ? 'selected' : '' }}>{{ $slot->label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-8">
                            <textarea name="notes" class="form-control" rows="3" placeholder="Notes (optional)">{{ old('notes') }}</textarea>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-8 rounded-2xl font-black uppercase tracking-widest text-sm transition-all">
                                Confirm Appointment Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-4">
                <div class="sticky top-24 bg-indigo-900 rounded-[32px] p-8 text-white">
                    <h3 class="text-lg font-bold mb-6">Booking Summary</h3>
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between"><span>Doctor</span><span>{{ $model->name }}</span></div>
                        <div class="flex justify-between"><span>Department</span><span>{{ optional($model->department)->name ?: '-' }}</span></div>
                        <div class="flex justify-between"><span>Specialty</span><span>{{ optional($model->specialty)->name ?: '-' }}</span></div>
                        <div class="flex justify-between"><span>Fee</span><span>{{ formated_price($model->consultation_fee ?? 0) }}</span></div>
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
  const branchInput = document.getElementById('branch_id');
  function toggleBranch(){
    const selected = document.querySelector('input[name="visit_type"]:checked');
    const inHub = selected && selected.value === 'in_hub';
    if (branchWrap) branchWrap.style.display = inHub ? '' : 'none';
    if (branchInput) branchInput.required = inHub;
  }
  radios.forEach(r => r.addEventListener('change', toggleBranch));
  toggleBranch();
})();
</script>
@endpush
