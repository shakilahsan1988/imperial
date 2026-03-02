@extends('layouts.front')

@section('title', ($healthCheckSettings['page_name'] ?? 'Health Check') . ' - Imperial Health Bangladesh')

@section('content')

    <main class="bg-white font-sans overflow-hidden">
        <section class="relative py-24 md:py-40 bg-[#1E293B] overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <img src="{{ asset($healthCheckSettings['hero_image']) }}" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>

            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-3xl">
                    <p class="text-xs md:text-sm text-indigo-300 uppercase tracking-[0.2em] font-black mb-4">{{ $healthCheckSettings['page_name'] }}</p>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">
                        {!! $healthCheckSettings['hero_title_html'] !!}
                    </h1>
                    <p class="text-xl text-slate-300 font-light leading-relaxed max-w-2xl">
                        {{ $healthCheckSettings['hero_description'] }}
                    </p>
                </div>
            </div>
        </section>

        <section class="relative z-20 -mt-12 px-4">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                        $features = [
                            ['title' => $healthCheckSettings['feature_1_title'], 'desc' => $healthCheckSettings['feature_1_desc'], 'icon' => 'fa-user-doctor', 'color' => 'indigo'],
                            ['title' => $healthCheckSettings['feature_2_title'], 'desc' => $healthCheckSettings['feature_2_desc'], 'icon' => 'fa-tags', 'color' => 'emerald'],
                            ['title' => $healthCheckSettings['feature_3_title'], 'desc' => $healthCheckSettings['feature_3_desc'], 'icon' => 'fa-cloud-arrow-down', 'color' => 'blue'],
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

        @forelse($categories as $index => $category)
        <section class="py-24 {{ $index % 2 === 0 ? 'bg-white' : 'bg-slate-50' }}">
            <div class="container mx-auto px-4">
                <div class="flex items-center gap-4 mb-12">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight whitespace-nowrap">{{ $category->name }}</h2>
                    <div class="h-px {{ $index % 2 === 0 ? 'bg-slate-100' : 'bg-slate-200' }} flex-grow"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse($category->packages as $package)
                    <div class="group bg-white rounded-3xl overflow-hidden border border-slate-100 hover:shadow-2xl transition-all duration-500 flex flex-col">
                        <div class="aspect-[4/3] overflow-hidden bg-slate-100">
                            <img src="{{ asset($package->image ?: 'assets/front/images/healthcheck/1.jpg') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-slate-900 mb-2 leading-tight">{{ $package->name }}</h3>
                            <p class="text-2xl font-black text-indigo-600 mb-6">{{ formated_price($package->price) }}</p>
                            <div class="mt-auto">
                                <a href="{{ route('package-details', ['slug' => $package->slug]) }}" class="block w-full py-3 bg-slate-50 group-hover:bg-indigo-600 group-hover:text-white text-slate-600 text-center rounded-xl font-bold text-xs uppercase tracking-widest transition-all">View Details</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center text-slate-400 py-10">No packages found for this category.</div>
                    @endforelse
                </div>
            </div>
        </section>
        @empty
        <section class="py-24 bg-white">
            <div class="container mx-auto px-4 text-center text-slate-500">
                Health packages are not available right now.
            </div>
        </section>
        @endforelse

        <section class="py-24">
            <div class="container mx-auto px-4 max-w-4xl">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">{{ $healthCheckSettings['faq_title'] }}</h2>
                    <p class="text-slate-500 font-medium">{{ $healthCheckSettings['faq_subtitle'] }}</p>
                </div>

                <div class="space-y-4">
                    @php
                        $faqs = [
                            ['q' => $healthCheckSettings['faq_1_question'], 'a' => $healthCheckSettings['faq_1_answer']],
                            ['q' => $healthCheckSettings['faq_2_question'], 'a' => $healthCheckSettings['faq_2_answer']],
                            ['q' => $healthCheckSettings['faq_3_question'], 'a' => $healthCheckSettings['faq_3_answer']],
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
