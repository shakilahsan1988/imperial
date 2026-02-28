@extends('layouts.front')

@section('title', 'Our Services - Imperial Health Bangladesh')

@section('content')

    <main class="bg-white font-sans">
        <!-- MODERN HERO SECTION -->
        <section class="relative py-20 md:py-32 bg-[#1E293B] overflow-hidden">
            <div class="absolute inset-0 opacity-30">
                <img src="{{ asset('assets/front/images/services/services.jpg') }}" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>
            
            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-3xl">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">
                        Comprehensive <span class="text-indigo-400">Healthcare</span> Solutions
                    </h1>
                    <p class="text-xl text-slate-300 font-light leading-relaxed max-w-2xl">
                        From primary consultations to advanced diagnostics, we provide all your outpatient needs under one professional roof.
                    </p>
                </div>
            </div>
        </section>

        <!-- SERVICES OVERVIEW -->
        <section class="container mx-auto px-4 py-24">
            
            <!-- Service Block 1: Consultations -->
            <div class="flex flex-col md:flex-row items-center gap-16 mb-24 reveal">
                <div class="md:w-1/2">
                    <div class="inline-block px-4 py-1.5 bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase tracking-widest rounded-full mb-6">Expert Guidance</div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Personalized Consultations</h2>
                    <p class="text-lg text-slate-600 leading-relaxed mb-8">
                        Our caring doctors take the time to listen and understand your needs. All consultations, in-person or virtual, last for at least 15 minutes, ensuring you get the respect and empathy you deserve.
                    </p>
                    <a href="{{ route('service-details') }}" class="inline-flex items-center gap-3 text-indigo-600 font-bold group">
                        Explore Specialities
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                    </a>
                </div>
                <div class="md:w-1/2">
                    <img src="https://picsum.photos/seed/doc1/800/600" class="rounded-3xl shadow-2xl">
                </div>
            </div>

            <!-- Service Block 2: Diagnostics (Alternating) -->
            <div class="flex flex-col md:flex-row-reverse items-center gap-16 mb-24 reveal">
                <div class="md:w-1/2">
                    <div class="inline-block px-4 py-1.5 bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-widest rounded-full mb-6">World Class Tech</div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Advanced Diagnostics</h2>
                    <p class="text-lg text-slate-600 leading-relaxed mb-8">
                        With seven state-of-the-art laboratories and ISO international accreditation, we offer the highest accuracy in Bangladesh. Our average monthly accuracy score is a remarkable 99.9%.
                    </p>
                    <a href="{{ route('lab-test') }}" class="btn-primary text-white px-8 py-4 rounded-2xl font-bold inline-block shadow-xl shadow-indigo-200">View Lab Tests</a>
                </div>
                <div class="md:w-1/2">
                    <img src="https://picsum.photos/seed/lab1/800/600" class="rounded-3xl shadow-2xl">
                </div>
            </div>

            <!-- Grid Services -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @php
                    $services = [
                        ['title' => 'E-Pharmacy', 'desc' => 'Medicines sourced directly from manufacturers, delivered to your doorstep.', 'icon' => 'fa-pills', 'color' => 'indigo'],
                        ['title' => 'Health Packages', 'desc' => 'Designed specifically for your age, gender, and unique healthcare needs.', 'icon' => 'fa-heart-pulse', 'color' => 'rose'],
                        ['title' => 'Membership Plans', 'desc' => 'Ongoing care for your family with unlimited consultations and discounts.', 'icon' => 'fa-id-card', 'color' => 'amber'],
                        ['title' => 'Vaccination', 'desc' => 'Approved center for EPI and international child/adult vaccinations.', 'icon' => 'fa-syringe', 'color' => 'blue'],
                        ['title' => 'Home Health', 'desc' => 'Nurses and physiotherapists available for visits in the comfort of your home.', 'icon' => 'fa-house-medical', 'color' => 'emerald'],
                        ['title' => 'Beauty Wellness', 'desc' => 'Skin, hair, and dental treatments using modern laser and energy technology.', 'icon' => 'fa-spa', 'color' => 'fuchsia'],
                    ];
                @endphp

                @foreach($services as $s)
                <div class="p-8 bg-slate-50 rounded-3xl border border-slate-100 hover:bg-white hover:shadow-2xl hover:border-indigo-100 transition-all duration-500 group">
                    <div class="w-14 h-14 bg-{{$s['color']}}-100 text-{{$s['color']}}-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid {{$s['icon']}} text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">{{$s['title']}}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">{{$s['desc']}}</p>
                    <a href="{{ route('service-details') }}" class="text-xs font-bold uppercase tracking-widest text-indigo-600 flex items-center gap-2">
                        Read Details <i class="fa-solid fa-chevron-right text-[8px]"></i>
                    </a>
                </div>
                @endforeach
            </div>

        </section>
    </main>

@endsection