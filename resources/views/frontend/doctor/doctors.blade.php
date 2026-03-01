@extends('layouts.front')

@section('title', 'Find a Doctor - Imperial Health Bangladesh')

@section('content')

    <main class="min-h-screen bg-[#F8FAFC] font-sans">

        <!-- MODERN HERO SECTION -->
        <section class="relative py-20 md:py-32 bg-[#1E293B] overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <img src="{{ asset('assets/front/images/doctor/1.jpg') }}" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>
            
            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-3xl">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">
                        Expert Care from <span class="text-indigo-400">World-Class</span> Specialists
                    </h1>
                    <p class="text-xl text-slate-300 font-light leading-relaxed max-w-2xl mb-10">
                        Connect with highly experienced specialists dedicated to providing compassionate, personalized healthcare for you and your family.
                    </p>
                </div>
            </div>
        </section>

        <!-- FLOATING SEARCH CONSOLE -->
        <section class="relative z-20 -mt-12 px-4">
            <div class="container mx-auto">
                <div class="bg-white rounded-2xl shadow-2xl p-4 md:p-6 border border-slate-100">
                    <form action="{{ route('doctor') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        
                        <!-- Speciality -->
                        <div class="relative group">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Speciality</label>
                            <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus-within:ring-2 focus-within:ring-indigo-500 transition-all">
                                <i class="fa-solid fa-stethoscope text-indigo-500 mr-3"></i>
                                <select name="speciality" class="w-full bg-transparent border-none focus:ring-0 text-slate-700 text-sm font-medium">
                                    <option value="">All Specialities</option>
                                    <option value="1">Acupuncture</option>
                                    <option value="2">Cardiology</option>
                                    <option value="4">Dentistry</option>
                                    <option value="5">Dermatology</option>
                                    <option value="6">Diabetology</option>
                                    <option value="14">Neurology</option>
                                    <option value="19">Orthopedics</option>
                                    <option value="22">Pediatrics</option>
                                </select>
                            </div>
                        </div>

                        <!-- Doctor Name -->
                        <div class="relative group">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Doctor Name</label>
                            <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus-within:ring-2 focus-within:ring-indigo-500 transition-all">
                                <i class="fa-solid fa-user-md text-indigo-500 mr-3"></i>
                                <input type="text" name="name" placeholder="Search doctor..." class="w-full bg-transparent border-none focus:ring-0 text-slate-700 text-sm font-medium">
                            </div>
                        </div>

                        <!-- Date -->
                        <div class="relative group">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Preferred Date</label>
                            <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus-within:ring-2 focus-within:ring-indigo-500 transition-all">
                                <i class="fa-solid fa-calendar-day text-indigo-500 mr-3"></i>
                                <input type="date" name="date" class="w-full bg-transparent border-none focus:ring-0 text-slate-700 text-sm font-medium">
                            </div>
                        </div>

                        <!-- Search Action -->
                        <div class="flex items-end">
                            <button type="submit" class="w-full h-[54px] bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span>Find Specialists</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- DOCTOR LISTING -->
        <section class="container mx-auto px-4 py-16">
            
            <!-- Acupuncture Section -->
            <div class="mb-20">
                <div class="flex items-baseline gap-4 mb-8">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Acupuncture</h2>
                    <span class="h-1 flex-grow bg-slate-100 rounded-full"></span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    <!-- Modern Card -->
                    <div class="group bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 relative">
                        <div class="absolute top-4 right-4 z-10">
                            <span class="bg-emerald-50 text-emerald-600 text-[10px] font-bold px-2.5 py-1 rounded-full border border-emerald-100 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Available
                            </span>
                        </div>
                        <div class="aspect-[4/5] overflow-hidden bg-slate-100">
                            <img src="{{ asset('assets/front/images/doctor/2.jpg') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        </div>
                        <div class="p-6">
                            <div class="mb-4">
                                <h3 class="text-xl font-bold text-slate-900 mb-1 group-hover:text-indigo-600 transition-colors">Dr. Ahmed Farukh</h3>
                                <p class="text-sm text-slate-500 font-medium leading-snug">Consultant - Energetic Medicine & Acupuncture</p>
                            </div>
                            <div class="flex items-center gap-2 mb-6 text-slate-400 text-xs">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <span>MBBS, PhD (Energy Medicine)</span>
                            </div>
                            <a href="{{ route('book-doctor') }}" class="flex items-center justify-center w-full py-3 bg-slate-900 group-hover:bg-indigo-600 text-white rounded-xl font-bold text-sm tracking-wide transition-all">
                                <span>Book Appointment</span>
                                <i class="fa-solid fa-chevron-right ml-2 text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cardiology Section -->
            <div class="mb-20">
                <div class="flex items-baseline gap-4 mb-8">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Cardiology</h2>
                    <span class="h-1 flex-grow bg-slate-100 rounded-full"></span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @php
                        $cardiology = [
                            ['name' => 'Asst. Prof. DR. AZM Ahsan Ullah', 'img' => '3.jpg'],
                            ['name' => 'Dr. AHM Masud Sinha', 'img' => '4.jpg'],
                            ['name' => 'Dr. Rafique Ahmed', 'img' => '5.jpg'],
                        ];
                    @endphp
                    @foreach($cardiology as $doc)
                    <div class="group bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 relative">
                        <div class="aspect-[4/5] overflow-hidden bg-slate-100">
                            <img src="{{ asset('assets/front/images/doctor/' . $doc['img']) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        </div>
                        <div class="p-6">
                            <div class="mb-4">
                                <h3 class="text-lg font-bold text-slate-900 mb-1 group-hover:text-indigo-600 transition-colors leading-tight">{{ $doc['name'] }}</h3>
                                <p class="text-sm text-slate-500 font-medium">Senior Consultant - Cardiology</p>
                            </div>
                            <div class="flex items-center gap-2 mb-6 text-slate-400 text-xs">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>Imperial Hub, Main Block</span>
                            </div>
                            <a href="{{ route('book-doctor') }}" class="flex items-center justify-center w-full py-3 bg-slate-900 group-hover:bg-indigo-600 text-white rounded-xl font-bold text-sm tracking-wide transition-all">
                                <span>Book Appointment</span>
                                <i class="fa-solid fa-chevron-right ml-2 text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </section>
    </main>

@endsection