@extends('layouts.front')

@section('title', 'About Us - Imperial Health Bangladesh')

@section('content')

    <main class="bg-white font-sans overflow-hidden">
        <!-- MODERN HERO SECTION -->
        <section class="relative py-24 md:py-40 bg-[#1E293B] overflow-hidden">
            <div class="absolute inset-0 opacity-30">
                <img src="{{ asset('assets/front/images/about/1.jpg') }}" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-b from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>
            
            <div class="container mx-auto px-4 relative z-10 text-center">
                <div class="max-w-4xl mx-auto">
                    <h1 class="text-4xl md:text-7xl font-extrabold text-white mb-8 tracking-tight leading-tight">
                        Redefining the <span class="text-indigo-400">Patient Experience</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-slate-300 font-light leading-relaxed">
                        Imperial Health exists to bridge the gap between world-class technology and compassionate human care. We build healthcare where you come first.
                    </p>
                </div>
            </div>
        </section>

        <!-- CORE VALUES / DIFFERENTIATORS -->
        <section class="py-24 bg-slate-50">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                    <div class="relative">
                        <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-100 rounded-full blur-3xl opacity-50"></div>
                        <img src="{{ asset('assets/front/images/about/1.jpg') }}" class="rounded-[40px] shadow-2xl relative z-10">
                        <div class="absolute -bottom-6 -right-6 bg-white p-8 rounded-3xl shadow-xl z-20 hidden md:block">
                            <p class="text-4xl font-black text-indigo-600 mb-1">99.9%</p>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Accuracy Rate</p>
                        </div>
                    </div>

                    <div class="space-y-12">
                        <div>
                            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">What Sets Us Apart</h2>
                            <p class="text-slate-600 leading-relaxed font-medium">We don't just treat symptoms; we care for people. Our approach combines rigorous international standards with local empathy.</p>
                        </div>

                        <div class="space-y-8">
                            <!-- Quality -->
                            <div class="flex gap-6 group">
                                <div class="w-14 h-14 bg-indigo-600 text-white rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-indigo-200 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-medal text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900 mb-2 uppercase tracking-wide">Uncompromising Quality</h3>
                                    <p class="text-sm text-slate-500 leading-relaxed">Accredited by the Bangladesh Accreditation Board (BAB) and ISO 15189-2012. We participate in RIQAS, the world’s largest international quality assessment scheme.</p>
                                </div>
                            </div>

                            <!-- Affordability -->
                            <div class="flex gap-6 group">
                                <div class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-emerald-200 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-hand-holding-dollar text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900 mb-2 uppercase tracking-wide">Accessible & Affordable</h3>
                                    <p class="text-sm text-slate-500 leading-relaxed">We believe high-quality care should be available to everyone. We continuously optimize our processes to keep costs low while maintaining premium standards.</p>
                                </div>
                            </div>

                            <!-- Innovation -->
                            <div class="flex gap-6 group">
                                <div class="w-14 h-14 bg-amber-500 text-white rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-amber-200 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-microchip text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900 mb-2 uppercase tracking-wide">Technological Innovation</h3>
                                    <p class="text-sm text-slate-500 leading-relaxed">From digital health records to AI-driven diagnostics and e-pharmacy, we use the best technology to make your health journey seamless.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- MANAGEMENT TEAM -->
        <section class="py-24">
            <div class="container mx-auto px-4">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">Our Leadership</h2>
                    <p class="text-slate-500 font-medium leading-relaxed">Our diverse management team brings together decades of local and international expertise in medicine, technology, and business.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @php
                        $team = [
                            ['name' => 'Sylvana Quader Sinha', 'role' => 'Founder & Chair', 'img' => '2.jpg'],
                            ['name' => 'Mohammad Abdul Matin Emon', 'role' => 'Chief Executive Officer', 'img' => '3.jpg'],
                            ['name' => 'Dr. Simeen M. Akhtar', 'role' => 'Chief Operating Officer', 'img' => '4.jpg'],
                            ['name' => 'Dr. Zaheed Husain, Ph.D.', 'role' => 'Senior Lab Director', 'img' => '5.jpg'],
                        ];
                    @endphp
                    @foreach($team as $member)
                    <div class="group bg-white rounded-3xl overflow-hidden border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div class="aspect-[4/5] bg-slate-100 overflow-hidden">
                            <img src="{{ asset('assets/front/images/about/' . $member['img']) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="font-bold text-slate-900 mb-1 group-hover:text-indigo-600 transition-colors">{{ $member['name'] }}</h3>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">{{ $member['role'] }}</p>
                            <a href="{{ route('management-details') }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase text-indigo-600 group-hover:gap-3 transition-all">
                                Profile <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- CORPORATE PARTNERS -->
        <section class="py-24 bg-slate-900">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-white text-2xl font-bold mb-2">Trusted by Industry Leaders</h2>
                    <p class="text-slate-500 text-sm font-medium uppercase tracking-[0.3em]">Corporate Health Partners</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach(range(1, 12) as $i)
                    <div class="h-24 bg-white/5 rounded-2xl flex items-center justify-center p-6 grayscale opacity-40 hover:grayscale-0 hover:opacity-100 hover:bg-white/10 transition-all duration-500">
                        <img src="{{ asset('assets/front/images/client/'.(($i > 8) ? 1 : $i).'.webp') }}" class="max-w-full max-h-full object-contain">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

@endsection