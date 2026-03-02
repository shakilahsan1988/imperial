@extends('layouts.front')

@section('title', ($pageSettings['page_name'] ?? 'Our Doctors') . ' - Imperial Health Bangladesh')

@section('content')

<main class="min-h-screen bg-[#F8FAFC] font-sans">
    <section class="relative py-20 md:py-32 bg-[#1E293B] overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="{{ asset($pageSettings['hero_image']) }}" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl">
                <p class="text-xs md:text-sm text-indigo-300 uppercase tracking-[0.2em] font-black mb-4">{{ $pageSettings['page_name'] }}</p>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">
                    {!! $pageSettings['hero_title_html'] !!}
                </h1>
                <p class="text-xl text-slate-300 font-light leading-relaxed max-w-2xl mb-10">
                    {{ $pageSettings['hero_description'] }}
                </p>
            </div>
        </div>
    </section>

    <section class="relative z-20 -mt-12 px-4">
        <div class="container mx-auto">
            <div class="bg-white rounded-2xl shadow-2xl p-4 md:p-6 border border-slate-100">
                <form action="{{ route('doctor') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="relative group">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Specialty</label>
                        <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                            <i class="fa-solid fa-stethoscope text-indigo-500 mr-3"></i>
                            <select name="specialty_id" class="w-full bg-transparent border-none focus:ring-0 text-slate-700 text-sm font-medium">
                                <option value="">All Specialties</option>
                                @foreach($specialties as $specialty)
                                <option value="{{ $specialty->id }}" {{ request('specialty_id') == $specialty->id ? 'selected' : '' }}>{{ $specialty->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="relative group">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Department</label>
                        <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                            <i class="fa-solid fa-hospital text-indigo-500 mr-3"></i>
                            <select name="department_id" class="w-full bg-transparent border-none focus:ring-0 text-slate-700 text-sm font-medium">
                                <option value="">All Departments</option>
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="relative group">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Doctor Name</label>
                        <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                            <i class="fa-solid fa-user-md text-indigo-500 mr-3"></i>
                            <input type="text" name="name" value="{{ request('name') }}" placeholder="Search doctor..." class="w-full bg-transparent border-none focus:ring-0 text-slate-700 text-sm font-medium">
                        </div>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full h-[54px] bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 transition-all">
                            Find Specialists
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-4 py-16">
        @forelse($groupedDoctors as $departmentName => $doctorsInDept)
        <div class="mb-16">
            <div class="flex items-baseline gap-4 mb-8">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $departmentName }}</h2>
                <span class="h-1 flex-grow bg-slate-100 rounded-full"></span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($doctorsInDept as $doc)
                <div class="group bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 relative">
                    <div class="aspect-[4/5] overflow-hidden bg-slate-100">
                        <img src="{{ asset($doc->image ?: 'assets/front/images/doctor/2.jpg') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold text-slate-900 mb-1 group-hover:text-indigo-600 transition-colors">{{ $doc->name }}</h3>
                            <p class="text-sm text-slate-500 font-medium leading-snug">{{ $doc->designation ?: 'Consultant' }}</p>
                            <p class="text-xs text-indigo-600 font-bold mt-1">{{ optional($doc->specialty)->name ?: 'Specialist' }}</p>
                        </div>
                        <div class="text-xs text-slate-500 mb-6 space-y-1">
                            <div class="flex items-center justify-between">
                                <span>In-Hub Fee</span>
                                <strong class="text-slate-700">{{ formated_price($doc->consultation_fee ?? 0) }}</strong>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Video Fee</span>
                                <strong class="{{ $doc->video_consultation_available ? 'text-emerald-700' : 'text-slate-400' }}">
                                    {{ $doc->video_consultation_available ? formated_price($doc->video_consultation_fee ?? $doc->consultation_fee ?? 0) : 'N/A' }}
                                </strong>
                            </div>
                        </div>
                        <a href="{{ route('book-doctor', ['doctor' => $doc->slug ?: $doc->id]) }}" class="flex items-center justify-center w-full py-3 bg-slate-900 group-hover:bg-indigo-600 text-white rounded-xl font-bold text-sm tracking-wide transition-all">
                            Book Appointment
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="text-center py-20 text-slate-500">No doctors found for the selected filters.</div>
        @endforelse
    </section>
</main>

@endsection
