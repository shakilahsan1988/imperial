@extends('layouts.front')

@section('title', $member->name . ' - Management Team')

@section('content')

    <!-- Main Content Start -->
    <main class="font-sans text-imperial-text bg-gray-50 py-10">

        <!-- Breadcrumbs -->
        <section class="container mx-auto px-4 sm:px-6 lg:px-8 mb-8">
            <nav class="flex text-sm text-gray-500 items-center flex-wrap">
                <a href="{{ route('fhome') }}" class="hover:text-imperial-primary transition">Home</a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('about') }}" class="hover:text-imperial-primary transition">About</a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('management') }}" class="hover:text-imperial-primary transition">Management Team</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-900 font-medium">{{ $member->name }}</span>
            </nav>
        </section>

        <!-- Details Container -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-8">
                
                <!-- LEFT COLUMN: Details & Bio (Span 8 on large screens) -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- Member Header -->
                    <div class="text-center lg:text-left">
                        <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-2">{{ $member->name }}</h1>
                        <p class="text-xl text-imperial-primary font-medium mb-8">{{ $member->designation }}</p>
                        
                        @if($member->bio)
                        <!-- Bio Content -->
                        <div class="richtext-cont text-gray-600 font-roboto">
                            {!! $member->bio !!}
                        </div>
                        @endif
                    </div>

                    <!-- Back Button -->
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <a href="{{ route('management') }}" class="inline-flex items-center gap-2 text-imperial-primary font-bold hover:text-imperial-dark transition">
                            <i class="fa-solid fa-arrow-left"></i>
                            Back to Management Team
                        </a>
                    </div>

                </div>

                <!-- RIGHT COLUMN: Sticky Image (Span 4 on large screens) -->
                @if($member->image)
                <div class="hidden lg:block lg:col-span-4">
                    <div class="dsc-img sticky top-10">
                        <picture class="w-full h-auto block rounded-xl overflow-hidden shadow-lg border border-gray-200">
                            <img src="{{ asset($member->image) }}" 
                                 alt="{{ $member->name }}" 
                                 class="w-full h-auto object-cover">
                        </picture>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </main>
    <!-- Main Content End -->

@endsection
