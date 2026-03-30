@extends('layouts.front')

@section('title', ($pageSettings['page_name'] ?? 'Management') . ' - Imperial Health Bangladesh')

@section('content')

    <!-- Main Content Start -->
    <main class="font-sans text-imperial-text bg-gray-50 pb-20">
        <section class="relative py-24 md:py-40 bg-[#1E293B] overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <img src="{{ asset($pageSettings['hero_image']) }}" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl">
                    <p class="text-xs md:text-sm text-indigo-300 uppercase tracking-[0.2em] font-black mb-4">{{ $pageSettings['page_name'] }}</p>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">{!! $pageSettings['hero_title_html'] !!}</h1>
                    <p class="text-xl text-slate-300 font-light leading-relaxed max-w-2xl">{{ $pageSettings['hero_description'] }}</p>
                </div>
            </div>
        </section>

        <!-- Management Team List Section -->
        <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
            
            <!-- Title -->
            <div class="mb-12 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $pageSettings['page_name'] }}</h2>
            </div>

            <!-- Grid Container -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($teamMembers as $member)
                    <a href="{{ route('management-details', $member->slug) }}" class="group block bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 text-center">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-100 relative">
                            @if($member->image)
                                <img src="{{ asset($member->image) }}" 
                                     alt="{{ $member->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <i class="fa-solid fa-user text-6xl text-gray-400"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 font-sans">{{ $member->name }}</h3>
                            <p class="text-sm text-imperial-primary font-medium mb-4 font-roboto">{{ $member->designation }}</p>
                            <span class="inline-block px-4 py-2 border border-imperial-primary text-imperial-primary font-bold text-xs uppercase tracking-widest rounded hover:bg-imperial-primary hover:text-white transition-colors">
                                See Details
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 text-center py-12 text-gray-500">
                        <p>No team members found.</p>
                    </div>
                @endforelse
            </div>
        </section>

    </main>
    <!-- Main Content End -->

@endsection
