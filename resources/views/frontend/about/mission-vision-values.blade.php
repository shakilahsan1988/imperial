@extends('layouts.front')

@section('title', ($pageSettings['page_name'] ?? 'Mission & Vision') . ' - Imperial Health Bangladesh')
@section('meta_description', $pageSettings['hero_description'] ?? null)

@section('content')

    <main class="bg-white font-sans overflow-hidden">
        <!-- HERO SECTION -->
        <section class="relative py-24 md:py-40 bg-[#1E293B] overflow-hidden">
            <div class="absolute inset-0 opacity-30">
                <img src="{{ asset($pageSettings['hero_image']) }}" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-b from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>
            
            <div class="container mx-auto px-4 relative z-10 text-center">
                <div class="max-w-4xl mx-auto">
                    <p class="text-xs md:text-sm text-indigo-300 uppercase tracking-[0.2em] font-black mb-4">{{ $pageSettings['page_name'] }}</p>
                    <h1 class="text-4xl md:text-7xl font-extrabold text-white mb-6 tracking-tight leading-tight">
                        {!! $pageSettings['hero_title_html'] !!}
                    </h1>
                    <p class="text-xl md:text-2xl text-slate-300 font-light leading-relaxed">
                        {{ $pageSettings['hero_description'] }}
                    </p>
                </div>
            </div>
        </section>

        @include('frontend.includes.ceo-message')

        <!-- MISSION & VISION SECTION -->
        <section class="py-24 bg-slate-50">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    
                    <!-- Mission Card -->
                    <div class="group bg-white rounded-[40px] p-8 md:p-12 shadow-xl hover:shadow-2xl transition-all duration-500 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-100 rounded-full blur-3xl opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <div class="relative z-10">
                            <div class="w-20 h-20 bg-indigo-600 rounded-3xl flex items-center justify-center mb-8 shadow-lg shadow-indigo-200 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-bullseye text-3xl text-white"></i>
                            </div>
                            
                            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Our Mission</h2>
                            <p class="text-lg text-slate-600 font-medium leading-relaxed">
                                To make quality healthcare in Bangladesh easier to access, easier to understand, and centered on the patient in front of us.
                            </p>
                        </div>
                    </div>

                    <!-- Vision Card -->
                    <div class="group bg-white rounded-[40px] p-8 md:p-12 shadow-xl hover:shadow-2xl transition-all duration-500 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-amber-100 rounded-full blur-3xl opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <div class="relative z-10">
                            <div class="w-20 h-20 bg-amber-500 rounded-3xl flex items-center justify-center mb-8 shadow-lg shadow-amber-200 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-lightbulb text-3xl text-white"></i>
                            </div>
                            
                            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Our Vision</h2>
                            <p class="text-lg text-slate-600 font-medium leading-relaxed">
                                A healthcare experience where every patient leaves better informed than when they arrived.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- VALUES SECTION -->
        <section class="py-24">
            <div class="container mx-auto px-4">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">The Imperial Standard</h2>
                    <p class="text-slate-500 font-medium leading-relaxed">Four commitments we hold ourselves to, at every visit.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- SHOW UP PREPARED -->
                    <div class="group bg-white rounded-3xl p-8 border border-slate-100 hover:border-indigo-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-clipboard-list text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">Show Up Prepared</h3>
                        </div>
                        <p class="text-slate-600 leading-relaxed">
                            Your care team reviews your history before you walk in, so your visit isn't spent repeating yourself.
                        </p>
                    </div>

                    <!-- EXPLAIN CLEARLY -->
                    <div class="group bg-white rounded-3xl p-8 border border-slate-100 hover:border-emerald-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-comments text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">Explain Clearly</h3>
                        </div>
                        <p class="text-slate-600 leading-relaxed">
                            Every diagnosis, test, and next step is explained in plain language before you leave.
                        </p>
                    </div>

                    <!-- RESPECT YOUR TIME -->
                    <div class="group bg-white rounded-3xl p-8 border border-slate-100 hover:border-amber-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-amber-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-amber-200 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-clock text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">Respect Your Time</h3>
                        </div>
                        <p class="text-slate-600 leading-relaxed">
                            Scheduling, testing, and follow-up are coordinated to minimize back-and-forth visits.
                        </p>
                    </div>

                    <!-- FOLLOW THROUGH -->
                    <div class="group bg-white rounded-3xl p-8 border border-slate-100 hover:border-rose-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-rose-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-rose-200 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-arrow-rotate-right text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">Follow Through</h3>
                        </div>
                        <p class="text-slate-600 leading-relaxed">
                            Your results and care plan don't end at the appointment; we follow up on next steps.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- CTA SECTION -->
        <section class="py-20 bg-slate-900">
            <div class="container mx-auto px-4 text-center">
                <div class="max-w-3xl mx-auto">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-6 tracking-tight">Experience Healthcare the Right Way</h2>
                    <p class="text-slate-400 text-lg mb-10 leading-relaxed">Schedule an appointment today and see how our mission, vision, and values translate into exceptional patient care.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('book-doctor') }}" class="inline-flex items-center justify-center px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-500 transition-colors shadow-lg shadow-indigo-600/30">
                            <i class="fa-solid fa-calendar-check mr-3"></i>
                            Book Appointment
                        </a>
                        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white/10 text-white font-bold rounded-2xl hover:bg-white/20 transition-colors border border-white/20">
                            <i class="fa-solid fa-phone mr-3"></i>
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

@endsection
