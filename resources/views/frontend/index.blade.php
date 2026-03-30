@extends('layouts.front')

@section('title', 'Imperial Health - World Class Healthcare in Bangladesh')

@section('content')
    
    @include('frontend.includes.slider')

    <!-- STATS SECTION -->
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-50 rounded-full blur-3xl opacity-50 -mr-48 -mt-48"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row gap-20 items-center">
                <div class="lg:w-5/12 reveal">
                    <span class="text-indigo-600 font-black uppercase tracking-[0.2em] text-[10px] mb-4 block">{{ $homeSettings['about']['badge'] }}</span>
                    <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">{!! $homeSettings['about']['title_html'] !!}</h2>
                    <p class="text-lg text-slate-500 leading-relaxed font-medium">{{ $homeSettings['about']['description'] }}</p>
                </div>
                
                <div class="lg:w-7/12 grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                        $stats = [
                            ['count' => $homeSettings['stats']['specialities_count'], 'label' => $homeSettings['stats']['specialities_label'], 'icon' => 'fa-stethoscope'],
                            ['count' => $homeSettings['stats']['doctors_count'], 'label' => $homeSettings['stats']['doctors_label'], 'icon' => 'fa-user-md'],
                            ['count' => $homeSettings['stats']['patients_count'], 'label' => $homeSettings['stats']['patients_label'], 'icon' => 'fa-users'],
                        ];
                    @endphp
                    @foreach($stats as $s)
                    <div class="bg-slate-50 p-8 rounded-[32px] border border-slate-100 hover:bg-white hover:shadow-2xl hover:border-indigo-100 transition-all duration-500 group reveal">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-6 group-hover:scale-110 transition-transform">
                            <i class="fa-solid {{$s['icon']}} text-indigo-600"></i>
                        </div>
                        <h3 class="text-4xl font-black text-slate-900 mb-1 tracking-tighter">{{$s['count']}}</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{$s['label']}}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- CEO'S MESSAGE SECTION -->
    @if(!empty($homeSettings['ceo_message']['enabled']))
    <section class="py-24 bg-indigo-50 overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-16 lg:gap-20 items-center">
                <!-- Left: CEO Image -->
                <div class="lg:w-5/12 relative reveal-left">
                    <div class="relative">
                        <img src="{{ asset($homeSettings['ceo_message']['image']) }}" 
                             alt="{{ $homeSettings['ceo_message']['name'] }}" 
                             class="w-full max-w-md mx-auto lg:mx-0 rounded-[40px] shadow-2xl object-cover aspect-[4/5]">
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-indigo-100 rounded-full -z-10"></div>
                        <div class="absolute -top-6 -left-6 w-24 h-24 bg-indigo-50 rounded-full -z-10"></div>
                    </div>
                </div>
                
                <!-- Right: CEO Message -->
                <div class="lg:w-7/12 reveal-right">
                    <span class="text-indigo-600 font-black uppercase tracking-[0.2em] text-[10px] mb-4 block">{{ $homeSettings['ceo_message']['badge'] }}</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-8 tracking-tight leading-tight">{!! $homeSettings['ceo_message']['title_html'] !!}</h2>
                    <p class="text-lg text-slate-600 leading-relaxed mb-8">{{ $homeSettings['ceo_message']['message'] }}</p>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-indigo-600 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-quote-left text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-900">{{ $homeSettings['ceo_message']['name'] }}</h4>
                            <p class="text-sm text-indigo-600 font-medium">{{ $homeSettings['ceo_message']['designation'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- SECTION 1: TEXT LEFT / IMAGE RIGHT -->
    <section class="py-24 bg-slate-100 overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-20 items-center">
                <div class="lg:w-1/2 reveal-left">
                    <span class="text-indigo-600 font-black uppercase tracking-[0.2em] text-[10px] mb-4 block">{{ $homeSettings['our_approach']['badge'] }}</span>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-8 tracking-tight">{!! $homeSettings['our_approach']['title_html'] !!}</h2>
                    <p class="text-lg text-slate-600 leading-relaxed mb-6 font-medium">{{ $homeSettings['our_approach']['description_1'] }}</p>
                    <p class="text-slate-500 leading-relaxed mb-10">{{ $homeSettings['our_approach']['description_2'] }}</p>
                    <a href="{{ $homeSettings['our_approach']['button_url'] }}" class="btn-primary text-white px-10 py-4 rounded-2xl font-bold inline-flex items-center gap-3 shadow-xl shadow-indigo-200">
                        {{ $homeSettings['our_approach']['button_text'] }} <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <div class="lg:w-1/2 relative reveal-right">
                    <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-indigo-200 rounded-full blur-3xl opacity-30"></div>
                    <img src="{{ asset($homeSettings['our_approach']['image']) }}" class="rounded-[40px] shadow-2xl relative z-10 w-full hover:scale-[1.02] transition-transform duration-700">
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: IMAGE LEFT / TEXT RIGHT -->
    <section class="py-24 bg-white overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row-reverse gap-20 items-center">
                <div class="lg:w-1/2 reveal-right">
                    <span class="text-emerald-600 font-black uppercase tracking-[0.2em] text-[10px] mb-4 block">{{ $homeSettings['lab_excellence']['badge'] }}</span>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-8 tracking-tight">{!! $homeSettings['lab_excellence']['title_html'] !!}</h2>
                    <p class="text-lg text-slate-600 leading-relaxed mb-8 font-medium">{{ $homeSettings['lab_excellence']['description'] }}</p>
                    
                    <div class="grid grid-cols-2 gap-6 mb-10">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-emerald-500"></i>
                            <span class="text-sm font-bold text-slate-700 uppercase tracking-tight">{{ $homeSettings['lab_excellence']['feature_1'] }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-emerald-500"></i>
                            <span class="text-sm font-bold text-slate-700 uppercase tracking-tight">{{ $homeSettings['lab_excellence']['feature_2'] }}</span>
                        </div>
                    </div>

                    <a href="{{ $homeSettings['lab_excellence']['button_url'] }}" class="text-indigo-600 font-black uppercase tracking-widest text-xs flex items-center gap-3 group">
                        {{ $homeSettings['lab_excellence']['button_text'] }} <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                    </a>
                </div>
                <div class="lg:w-1/2 relative reveal-left">
                    <img src="{{ asset($homeSettings['lab_excellence']['image']) }}" class="rounded-[40px] shadow-2xl relative z-10 w-full hover:scale-[1.02] transition-transform duration-700">
                </div>
            </div>
        </div>
    </section>

    <!-- FACILITY TOUR -->
    <section class="py-24 px-6">
        <div class="container mx-auto bg-slate-900 rounded-[48px] overflow-hidden shadow-2xl relative group">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 h-[400px] lg:h-[600px] overflow-hidden">
                    <img src="{{ asset($homeSettings['experience_imperial']['image']) }}" class="w-full h-full object-cover transition-transform duration-[10s] group-hover:scale-110">
                </div>
                <div class="lg:w-1/2 p-12 lg:p-20">
                    <span class="text-indigo-400 font-black uppercase tracking-[0.2em] text-[10px] mb-4 block">{{ $homeSettings['experience_imperial']['badge'] }}</span>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-8 tracking-tight">{!! $homeSettings['experience_imperial']['title_html'] !!}</h2>
                    <p class="text-lg text-slate-400 leading-relaxed mb-12">{{ $homeSettings['experience_imperial']['description'] }}</p>
                    <a href="{{ $homeSettings['experience_imperial']['button_url'] }}" class="inline-block bg-white text-slate-900 px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-indigo-50 transition-all transform active:scale-95 shadow-xl">{{ $homeSettings['experience_imperial']['button_text'] }}</a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA: MEMBERSHIP & VIDEO CONSULTATION -->
    <section class="py-24 bg-slate-50 overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                
                <!-- Membership Plan -->
                <div class="relative group reveal-left">
                    <div class="bg-white p-10 md:p-16 rounded-[48px] shadow-xl border border-slate-100 h-full flex flex-col justify-between hover:shadow-2xl transition-all duration-500 overflow-hidden">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-50 rounded-full blur-3xl group-hover:bg-indigo-100 transition-colors"></div>
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-8 shadow-sm">
                                <i class="fa-solid fa-id-card-clip text-2xl"></i>
                            </div>
                            <h3 class="text-3xl font-extrabold text-slate-900 mb-6 tracking-tight">{!! $homeSettings['continuous_care']['title_html'] !!}</h3>
                            <p class="text-slate-500 leading-relaxed mb-10 font-medium text-lg">{{ $homeSettings['continuous_care']['description'] }}</p>
                        </div>
                        <a href="{{ $homeSettings['continuous_care']['button_url'] }}" class="btn-primary text-white px-10 py-4 rounded-2xl font-bold inline-flex items-center justify-center gap-3 shadow-xl shadow-indigo-200 w-fit">
                            {{ $homeSettings['continuous_care']['button_text'] }} <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Video Consultation -->
                <div class="relative group reveal-right">
                    <div class="bg-[#1E293B] p-10 md:p-16 rounded-[48px] shadow-xl h-full flex flex-col justify-between hover:shadow-2xl transition-all duration-500 overflow-hidden">
                        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/5 rounded-full blur-3xl group-hover:bg-white/10 transition-colors"></div>
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-white/10 text-indigo-400 rounded-2xl flex items-center justify-center mb-8 shadow-sm">
                                <i class="fa-solid fa-video text-2xl"></i>
                            </div>
                            <h3 class="text-3xl font-extrabold text-white mb-6 tracking-tight">{!! $homeSettings['expert_advice']['title_html'] !!}</h3>
                            <p class="text-slate-400 leading-relaxed mb-10 font-medium text-lg">{{ $homeSettings['expert_advice']['description'] }}</p>
                        </div>
                        <a href="{{ $homeSettings['expert_advice']['button_url'] }}" class="bg-white text-slate-900 hover:bg-indigo-50 px-10 py-4 rounded-2xl font-bold inline-flex items-center justify-center gap-3 shadow-xl w-fit transition-all transform active:scale-95">
                            {{ $homeSettings['expert_advice']['button_text'] }} <i class="fa-solid fa-video text-xs"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
