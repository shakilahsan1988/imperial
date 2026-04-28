@extends('layouts.front')

@section('title', ($pageSettings['page_name'] ?? 'Mission & Vision') . ' - Imperial Health Bangladesh')

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
                                We aspire to be your trusted partner in health, empowering you to manage your health in a manner that is aligned with your values.
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
                                We envision a world class health care system that puts Patients first.
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
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">Our Values: S.M.I.L.E.</h2>
                    <p class="text-slate-500 font-medium leading-relaxed">The core principles that guide every decision we make and every action we take.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <!-- SERVICE -->
                    <div class="group bg-white rounded-3xl p-8 border border-slate-100 hover:border-indigo-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-hand-holding-heart text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">Service</h3>
                        </div>
                        <p class="text-slate-600 mb-6 italic leading-relaxed">
                            "For me and my Patients, Imperial Health is a safe place that offers a warm welcome and personalized services."
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-check text-indigo-500 mt-1"></i>
                                <span class="text-slate-600 text-sm">I am respectful and ready to work together to create best care.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-check text-indigo-500 mt-1"></i>
                                <span class="text-slate-600 text-sm">I practice safe behaviors and always put safety first.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-check text-indigo-500 mt-1"></i>
                                <span class="text-slate-600 text-sm">I project a positive image and energy.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- MY IMPERIAL -->
                    <div class="group bg-white rounded-3xl p-8 border border-slate-100 hover:border-emerald-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-building-columns text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">My Imperial</h3>
                        </div>
                        <p class="text-slate-600 mb-6 italic leading-relaxed">
                            "I am accountable for an important part of Imperial Health, no matter how big or small."
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-check text-emerald-500 mt-1"></i>
                                <span class="text-slate-600 text-sm">I am engaged and dedicated to making Imperial Health the best it can be.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-check text-emerald-500 mt-1"></i>
                                <span class="text-slate-600 text-sm">I am constantly learning and improving.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-check text-emerald-500 mt-1"></i>
                                <span class="text-slate-600 text-sm">I always challenge myself and my team to do better.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-check text-emerald-500 mt-1"></i>
                                <span class="text-slate-600 text-sm">I speak up to ensure Imperial Health lives up to our promises.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- INTEGRITY -->
                    <div class="group bg-white rounded-3xl p-8 border border-slate-100 hover:border-amber-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-amber-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-amber-200 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-scale-balanced text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">Integrity</h3>
                        </div>
                        <p class="text-slate-600 mb-6 italic leading-relaxed">
                            "Imperial Health means quality care, that I and my Patients can trust."
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-check text-amber-500 mt-1"></i>
                                <span class="text-slate-600 text-sm">In every interaction, I am honest, trustworthy, and transparent.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-check text-amber-500 mt-1"></i>
                                <span class="text-slate-600 text-sm">I respect the privacy of my team members and Patients.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-check text-amber-500 mt-1"></i>
                                <span class="text-slate-600 text-sm">I use my time and resources wisely.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- LISTENING -->
                    <div class="group bg-white rounded-3xl p-8 border border-slate-100 hover:border-rose-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-rose-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-rose-200 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-ear-listen text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">Listening</h3>
                        </div>
                        <p class="text-slate-600 mb-6 italic leading-relaxed">
                            "Compassionate care starts with listening to Patients and to each other."
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-check text-rose-500 mt-1"></i>
                                <span class="text-slate-600 text-sm">I listen with empathy so I can act effectively.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-check text-rose-500 mt-1"></i>
                                <span class="text-slate-600 text-sm">I am courteous and respectful to all.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- EXCELLENCE -->
                    <div class="group bg-white rounded-3xl p-8 border border-slate-100 hover:border-violet-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-violet-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-violet-200 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-star text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">Excellence</h3>
                        </div>
                        <p class="text-slate-600 mb-6 italic leading-relaxed">
                            "Imperial Health is setting a whole new standard for Patient-centered care."
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-check text-violet-500 mt-1"></i>
                                <span class="text-slate-600 text-sm">I perform my role efficiently so Patients get the most out of their visits.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-check text-violet-500 mt-1"></i>
                                <span class="text-slate-600 text-sm">I go above and beyond to exceed Patients' expectations.</span>
                            </li>
                        </ul>
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
