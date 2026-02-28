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
                    <span class="text-indigo-600 font-black uppercase tracking-[0.2em] text-[10px] mb-4 block">About Imperial</span>
                    <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">Redefining the <span class="text-indigo-600">Patient Experience</span></h2>
                    <p class="text-lg text-slate-500 leading-relaxed font-medium">Imperial exists to provide a better patient experience. We are a one-stop-shop for your health, offering caring doctors, world-class diagnostics, and accessible healthcare for everyone.</p>
                </div>
                
                <div class="lg:w-7/12 grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                        $stats = [
                            ['count' => '27', 'label' => 'Specialities', 'icon' => 'fa-stethoscope'],
                            ['count' => '84', 'label' => 'Expert Doctors', 'icon' => 'fa-user-md'],
                            ['count' => '914K', 'label' => 'Patients Served', 'icon' => 'fa-users'],
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

    <!-- SECTION 1: TEXT LEFT / IMAGE RIGHT -->
    <section class="py-24 bg-slate-50 overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-20 items-center">
                <div class="lg:w-1/2 reveal-left">
                    <span class="text-indigo-600 font-black uppercase tracking-[0.2em] text-[10px] mb-4 block">Our Approach</span>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-8 tracking-tight">Doctors Who <span class="text-indigo-600">Actually</span> Listen</h2>
                    <p class="text-lg text-slate-600 leading-relaxed mb-6 font-medium">Our specialists dedicate time to truly understand your health history. We believe in respect, empathy, and personalized advice based on international clinical protocols.</p>
                    <p class="text-slate-500 leading-relaxed mb-10">With years of local and international experience, our team provides healthcare you can trust blindly.</p>
                    <a href="{{ route('doctor') }}" class="btn-primary text-white px-10 py-4 rounded-2xl font-bold inline-flex items-center gap-3 shadow-xl shadow-indigo-200">
                        Find a Specialist <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <div class="lg:w-1/2 relative reveal-right">
                    <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-indigo-200 rounded-full blur-3xl opacity-30"></div>
                    <img src="{{ asset('assets/front/images/index/why-imperial.jpg') }}" class="rounded-[40px] shadow-2xl relative z-10 w-full hover:scale-[1.02] transition-transform duration-700">
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: IMAGE LEFT / TEXT RIGHT -->
    <section class="py-24 bg-white overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row-reverse gap-20 items-center">
                <div class="lg:w-1/2 reveal-right">
                    <span class="text-emerald-600 font-black uppercase tracking-[0.2em] text-[10px] mb-4 block">Lab Excellence</span>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-8 tracking-tight">Diagnostics You Can <span class="text-emerald-600">Trust</span></h2>
                    <p class="text-lg text-slate-600 leading-relaxed mb-8 font-medium">Accuracy is our top priority. Our laboratories follow ISO 15189-2012 international standards to ensure you get precise results every single time.</p>
                    
                    <div class="grid grid-cols-2 gap-6 mb-10">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-emerald-500"></i>
                            <span class="text-sm font-bold text-slate-700 uppercase tracking-tight">ISO Certified</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-emerald-500"></i>
                            <span class="text-sm font-bold text-slate-700 uppercase tracking-tight">Accredited Lab</span>
                        </div>
                    </div>

                    <a href="{{ route('lab-test') }}" class="text-indigo-600 font-black uppercase tracking-widest text-xs flex items-center gap-3 group">
                        Explore Our Services <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                    </a>
                </div>
                <div class="lg:w-1/2 relative reveal-left">
                    <img src="{{ asset('assets/front/images/index/diagnosis.jpeg') }}" class="rounded-[40px] shadow-2xl relative z-10 w-full hover:scale-[1.02] transition-transform duration-700">
                </div>
            </div>
        </div>
    </section>

    <!-- FACILITY TOUR -->
    <section class="py-24 px-6">
        <div class="container mx-auto bg-slate-900 rounded-[48px] overflow-hidden shadow-2xl relative group">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 h-[400px] lg:h-[600px] overflow-hidden">
                    <img src="{{ asset('assets/front/images/index/tour.jpg') }}" class="w-full h-full object-cover transition-transform duration-[10s] group-hover:scale-110">
                </div>
                <div class="lg:w-1/2 p-12 lg:p-20">
                    <span class="text-indigo-400 font-black uppercase tracking-[0.2em] text-[10px] mb-4 block">Experience Imperial</span>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-8 tracking-tight">Take a Virtual Tour of Our Facility</h2>
                    <p class="text-lg text-slate-400 leading-relaxed mb-12">Step inside our world-class medical center. From our luxury waiting areas to state-of-the-art diagnostic labs, experience the Imperial difference.</p>
                    <a href="#" class="inline-block bg-white text-slate-900 px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-indigo-50 transition-all transform active:scale-95 shadow-xl">Start The Tour</a>
                </div>
            </div>
        </div>
    </section>

@endsection