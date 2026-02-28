@extends('layouts.front')

@section('title', 'Package Details - Imperial Health Bangladesh')

@section('content')

    <main class="bg-white font-sans overflow-hidden">
        <!-- MODERN HERO SECTION -->
        <section class="relative py-20 md:py-32 bg-[#1E293B] overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <img src="{{ asset('assets/front/images/healthcheck/1.jpg') }}" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>
            
            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-3xl">
                    <span class="inline-block px-4 py-1.5 bg-indigo-500/20 text-indigo-300 text-[10px] font-black uppercase tracking-widest rounded-full mb-6">Comprehensive Screening</span>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">
                        Package <span class="text-indigo-400">Details</span>
                    </h1>
                    <p class="text-xl text-slate-300 font-light leading-relaxed max-w-2xl">
                        Deep dive into our specialized health packages designed to give you a complete picture of your wellness.
                    </p>
                </div>
            </div>
        </section>

        <!-- PACKAGE OVERVIEW -->
        <section class="py-24">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                    
                    <!-- Left: Visual -->
                    <div class="lg:col-span-5 relative">
                        <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-100 rounded-full blur-3xl opacity-50"></div>
                        <img src="{{ asset('assets/front/images/healthcheck/2.jpg') }}" class="rounded-[40px] shadow-2xl relative z-10 w-full object-cover aspect-[4/5]">
                        <div class="absolute top-8 right-8 z-20">
                            <span class="bg-white/90 backdrop-blur-md text-indigo-600 text-[10px] font-black px-4 py-2 rounded-2xl shadow-xl uppercase tracking-widest border border-white">Recommended</span>
                        </div>
                    </div>

                    <!-- Right: Info -->
                    <div class="lg:col-span-7 space-y-8">
                        <div>
                            <div class="flex items-center gap-3 mb-6">
                                <span class="bg-indigo-50 text-indigo-600 text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-tighter">Women's Health</span>
                                <span class="bg-emerald-50 text-emerald-600 text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-tighter">Immediate Availability</span>
                            </div>
                            <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">Her Health Check <span class="text-indigo-600 block">(Under 40 Years)</span></h2>
                            
                            <div class="flex items-baseline gap-4 mb-8">
                                <span class="text-5xl font-black text-slate-900 tracking-tighter">৳ 13,800</span>
                                <span class="text-xl text-slate-400 line-through">৳ 18,000</span>
                                <span class="bg-rose-50 text-rose-600 text-[10px] font-black px-3 py-1.5 rounded-lg uppercase">Save 23%</span>
                            </div>

                            <p class="text-lg text-slate-600 leading-relaxed font-medium mb-10">
                                A clinical-grade screening protocol meticulously designed for women in their prime. This package covers essential cardiovascular, metabolic, and hormonal markers to ensure early detection and proactive health management.
                            </p>
                        </div>

                        <!-- Highlights Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-12">
                            <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 flex flex-col items-center text-center group hover:bg-white hover:shadow-xl transition-all">
                                <i class="fa-solid fa-clock-rotate-left text-indigo-500 text-xl mb-3"></i>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Duration</p>
                                <p class="text-sm font-bold text-slate-900">4-6 Hours</p>
                            </div>
                            <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 flex flex-col items-center text-center group hover:bg-white hover:shadow-xl transition-all">
                                <i class="fa-solid fa-file-shield text-indigo-500 text-xl mb-3"></i>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Turnaround</p>
                                <p class="text-sm font-bold text-slate-900">24-48 Hours</p>
                            </div>
                            <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 flex flex-col items-center text-center group hover:bg-white hover:shadow-xl transition-all">
                                <i class="fa-solid fa-mug-hot text-indigo-500 text-xl mb-3"></i>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Fasting</p>
                                <p class="text-sm font-bold text-slate-900">10-12 Hours</p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('book-doctor') }}" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-5 rounded-2xl font-black uppercase tracking-widest text-xs shadow-xl shadow-indigo-200 transition-all transform active:scale-95 text-center">Book This Package</a>
                            <a href="tel:10648" class="flex-1 border-2 border-slate-200 hover:border-indigo-600 text-slate-900 hover:text-indigo-600 py-5 rounded-2xl font-black uppercase tracking-widest text-xs transition-all text-center">Inquire via Hotline</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TESTS INCLUDED -->
        <section class="py-24 bg-slate-50">
            <div class="container mx-auto px-4">
                <div class="flex items-center gap-4 mb-16">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight whitespace-nowrap">What's Included</h2>
                    <div class="h-px bg-slate-200 flex-grow"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        $inclusions = [
                            ['name' => 'Complete Blood Count (CBC)', 'type' => 'Blood Panel'],
                            ['name' => 'Lipid Profile', 'type' => 'Cholesterol'],
                            ['name' => 'Liver Function Test (LFT)', 'type' => 'Metabolic'],
                            ['name' => 'Kidney Function Test (KFT)', 'type' => 'Metabolic'],
                            ['name' => 'Blood Glucose (Fasting)', 'type' => 'Diabetes'],
                            ['name' => 'Thyroid Profile (T3, T4, TSH)', 'type' => 'Hormonal'],
                            ['name' => 'Urine Routine Examination', 'type' => 'Excretory'],
                            ['name' => 'ECG (Resting)', 'type' => 'Cardiac'],
                            ['name' => 'Ultrasound (Whole Abdomen)', 'type' => 'Imaging'],
                            ['name' => 'Pap Smear (Cytology)', 'type' => 'Screening'],
                            ['name' => 'Physical Consultation', 'type' => 'Clinical'],
                        ];
                    @endphp
                    @foreach($inclusions as $item)
                    <div class="bg-white p-6 rounded-[24px] border border-slate-100 flex items-center gap-5 shadow-sm group hover:border-indigo-200 transition-all">
                        <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-check text-sm"></i></div>
                        <div>
                            <p class="font-bold text-slate-900 leading-none mb-1 group-hover:text-indigo-600 transition-colors">{{$item['name']}}</p>
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">{{$item['type']}}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- PREP & FAQ -->
        <section class="py-24">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20">
                    
                    <div>
                        <h3 class="text-3xl font-extrabold text-slate-900 mb-10 tracking-tight">How to Prepare</h3>
                        <div class="space-y-6">
                            <div class="flex gap-6">
                                <span class="w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center font-black flex-shrink-0">1</span>
                                <p class="text-slate-600 font-medium leading-relaxed pt-2">Complete fasting for 10-12 hours is mandatory. You may only consume plain water.</p>
                            </div>
                            <div class="flex gap-6">
                                <span class="w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center font-black flex-shrink-0">2</span>
                                <p class="text-slate-600 font-medium leading-relaxed pt-2">Refrain from smoking or consuming alcohol for at least 24 hours prior to the tests.</p>
                            </div>
                            <div class="flex gap-6">
                                <span class="w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center font-black flex-shrink-0">3</span>
                                <p class="text-slate-600 font-medium leading-relaxed pt-2">Please carry all your previous medical records, prescriptions, and existing test reports.</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-3xl font-extrabold text-slate-900 mb-10 tracking-tight">Common Questions</h3>
                        <div class="group bg-slate-50 rounded-3xl border border-slate-100 overflow-hidden">
                            <details class="peer">
                                <summary class="flex justify-between items-center p-6 cursor-pointer list-none font-bold text-slate-700">
                                    Do I need to book in advance?
                                    <i class="fa-solid fa-plus text-indigo-500 transition-transform peer-open:rotate-45"></i>
                                </summary>
                                <div class="px-6 pb-6 text-slate-500 text-sm leading-relaxed">
                                    Highly recommended. Booking in advance ensures a dedicated slot and faster transition between different diagnostic areas.
                                </div>
                            </details>
                        </div>
                        <div class="group bg-slate-50 rounded-3xl border border-slate-100 overflow-hidden">
                            <details class="peer">
                                <summary class="flex justify-between items-center p-6 cursor-pointer list-none font-bold text-slate-700">
                                    When will I receive my reports?
                                    <i class="fa-solid fa-plus text-indigo-500 transition-transform peer-open:rotate-45"></i>
                                </summary>
                                <div class="px-6 pb-6 text-slate-500 text-sm leading-relaxed">
                                    Digital reports are usually uploaded to our secure portal within 24-48 hours. Hard copies can be collected from the main desk.
                                </div>
                            </details>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

@endsection
