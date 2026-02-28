@extends('layouts.front')

@section('title', 'Health Checks & Packages - Imperial Health Bangladesh')

@section('content')

    <main class="bg-white font-sans overflow-hidden">
        <!-- MODERN HERO SECTION -->
        <section class="relative py-24 md:py-40 bg-[#1E293B] overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <img src="{{ asset('assets/front/images/healthcheck/1.jpg') }}" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>
            
            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-3xl">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">
                        Invest in Your <span class="text-indigo-400">Future Health</span> Today
                    </h1>
                    <p class="text-xl text-slate-300 font-light leading-relaxed max-w-2xl">
                        Comprehensive health screenings designed to detect risks early and provide you with a roadmap to long-term wellness.
                    </p>
                </div>
            </div>
        </section>

        <!-- FEATURE HIGHLIGHTS -->
        <section class="relative z-20 -mt-12 px-4">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                        $features = [
                            ['title' => 'Expert Analysis', 'desc' => 'Consultations with top clinical specialists.', 'icon' => 'fa-user-doctor', 'color' => 'indigo'],
                            ['title' => 'Affordable Care', 'desc' => 'Best-in-class tests at transparent prices.', 'icon' => 'fa-tags', 'color' => 'emerald'],
                            ['title' => 'Instant Digital Reports', 'desc' => 'Access your data anytime via our portal.', 'icon' => 'fa-cloud-arrow-down', 'color' => 'blue'],
                        ];
                    @endphp
                    @foreach($features as $f)
                    <div class="bg-white rounded-2xl shadow-xl p-8 border border-slate-50 flex items-center gap-6 group hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 bg-{{$f['color']}}-50 text-{{$f['color']}}-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fa-solid {{$f['icon']}} text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 mb-1 tracking-tight">{{$f['title']}}</h3>
                            <p class="text-slate-500 text-xs leading-relaxed">{{$f['desc']}}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- WOMEN'S HEALTH -->
        <section class="py-24 bg-white">
            <div class="container mx-auto px-4">
                <div class="flex items-center gap-4 mb-12">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight whitespace-nowrap">Women's Health</h2>
                    <div class="h-px bg-slate-100 flex-grow"></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @php
                        $women_packages = [
                            ['name' => 'Her Health (Under 40)', 'price' => '13,800', 'img' => '2.jpg'],
                            ['name' => 'Her Health (40 - 65)', 'price' => '22,200', 'img' => '3.jpg'],
                            ['name' => 'Her Health (Above 65)', 'price' => '26,400', 'img' => '4.jpg'],
                            ['name' => 'Women\'s Cardiac Check', 'price' => '18,500', 'img' => '8.jpg'],
                        ];
                    @endphp
                    @foreach($women_packages as $p)
                    <div class="group bg-white rounded-3xl overflow-hidden border border-slate-100 hover:shadow-2xl transition-all duration-500 flex flex-col">
                        <div class="aspect-[4/3] overflow-hidden bg-slate-100">
                            <img src="{{ asset('assets/front/images/healthcheck/' . $p['img']) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-slate-900 mb-2 leading-tight">{{ $p['name'] }}</h3>
                            <p class="text-2xl font-black text-indigo-600 mb-6">৳ {{ $p['price'] }}</p>
                            <div class="mt-auto">
                                <a href="{{ route('package-details', ['id' => 1]) }}" class="block w-full py-3 bg-slate-50 group-hover:bg-indigo-600 group-hover:text-white text-slate-600 text-center rounded-xl font-bold text-xs uppercase tracking-widest transition-all">View Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- MEN'S HEALTH -->
        <section class="py-24 bg-slate-50">
            <div class="container mx-auto px-4">
                <div class="flex items-center gap-4 mb-12">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight whitespace-nowrap">Men's Health</h2>
                    <div class="h-px bg-slate-200 flex-grow"></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @php
                        $men_packages = [
                            ['name' => 'His Health (Under 40)', 'price' => '13,800', 'img' => '5.jpg'],
                            ['name' => 'His Health (40 - 65)', 'price' => '22,200', 'img' => '6.jpg'],
                            ['name' => 'His Health (Above 65)', 'price' => '26,400', 'img' => '7.jpg'],
                            ['name' => 'Men\'s Executive Check', 'price' => '25,000', 'img' => '8.jpg'],
                        ];
                    @endphp
                    @foreach($men_packages as $p)
                    <div class="group bg-white rounded-3xl overflow-hidden border border-slate-100 hover:shadow-2xl transition-all duration-500 flex flex-col">
                        <div class="aspect-[4/3] overflow-hidden bg-slate-100">
                            <img src="{{ asset('assets/front/images/healthcheck/' . $p['img']) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-slate-900 mb-2 leading-tight">{{ $p['name'] }}</h3>
                            <p class="text-2xl font-black text-indigo-600 mb-6">৳ {{ $p['price'] }}</p>
                            <div class="mt-auto">
                                <a href="{{ route('package-details', ['id' => 8]) }}" class="block w-full py-3 bg-slate-50 group-hover:bg-indigo-600 group-hover:text-white text-slate-600 text-center rounded-xl font-bold text-xs uppercase tracking-widest transition-all">View Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- FAQ SECTION -->
        <section class="py-24">
            <div class="container mx-auto px-4 max-w-4xl">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">Common Questions</h2>
                    <p class="text-slate-500 font-medium">Everything you need to know about our health checks.</p>
                </div>

                <div class="space-y-4">
                    @php
                        $faqs = [
                            ['q' => 'What is a Health Check?', 'a' => 'A health check is a comprehensive examination of your current physical condition. It involves a series of tests and screenings to detect potential health issues before they become symptoms.'],
                            ['q' => 'How does a health check help me?', 'a' => 'Regular health checks help in early detection of diseases, increase the chances for effective treatment, and allow you to track your health progress over time.'],
                            ['q' => 'How will I receive my reports?', 'a' => 'Reports are typically delivered digitally via email or through a secure patient portal within 24-48 hours of the tests being completed.'],
                        ];
                    @endphp
                    @foreach($faqs as $faq)
                    <div class="group bg-white rounded-2xl border border-slate-100 hover:border-indigo-200 transition-all overflow-hidden shadow-sm hover:shadow-md">
                        <details class="peer">
                            <summary class="flex justify-between items-center p-6 cursor-pointer list-none font-bold text-slate-700">
                                {{ $faq['q'] }}
                                <i class="fa-solid fa-plus text-indigo-500 transition-transform peer-open:rotate-45"></i>
                            </summary>
                            <div class="px-6 pb-6 text-slate-500 text-sm leading-relaxed">
                                {{ $faq['a'] }}
                            </div>
                        </details>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

@endsection
