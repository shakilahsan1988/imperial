@extends('layouts.front')

@section('title', 'About Us - Imperial Health Bangladesh')

@section('content')

<!-- Event Detail Article -->
<article class="w-full bg-white">
    <section class="py-16 lg:py-24">
        <div class="container mx-auto px-6">
            
            <!-- Event Header -->
            <div class="mb-8 lg:mb-12">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-imperial-text font-sans leading-tight">
                    Workplace Wellness Event at DAI
                </h1>
                <!-- Optional Divider -->
                <div class="w-24 h-1 bg-imperial-primary mt-6"></div>
            </div>

            <!-- Content Layout: Image (9 Cols) + Sidebar Text (3 Cols) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                
                <!-- Left Column: Event Image (Span 9) -->
                <div class="lg:col-span-9 order-1 lg:order-1">
                    <div class="rounded-lg overflow-hidden shadow-xl">
                        <img 
                            src="https://www.praavahealth.com/media-images/noc-iBymXT2WEt9rMT3QHm8_Cck=/420/fill-1188x670-c0/praava.jpeg" 
                            alt="Workplace Wellness Event at DAI" 
                            class="w-full h-auto object-cover block"
                            loading="lazy"
                        >
                    </div>
                </div>

                <!-- Right Column: Event Details (Span 3) -->
                <div class="lg:col-span-3 order-2 lg:order-2">
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-100 h-full">
                        <div class="text-card">
                            <div class="richtext-cont">
                                <p class="text-base text-gray-700 leading-relaxed">
                                    On Tuesday, September 25th, Praava Health facilitated a Workplace Wellness event at DAI (USAID's Agricultural Value Chains Project in Bangladesh) in Gulshan 2. Junior Physiotherapist Shimul Chanda led exercises and presented on how to utilize ergonomic principles to maximize wellness within an office environment and Marketing Manager Karina Zannat conducted a session highlighting Praava's services.
                                </p>
                                <p class="text-base text-gray-700 leading-relaxed mt-4">
                                    Following the presentation component, DAI employees participated in a mini health camp organized by Praava, where Health Coach Sadia Islam provided BMI calculation services and nurses provided pulse measurement, random glucose testing, and blood pressure measurement.
                                </p>
                                <p class="text-base text-gray-700 leading-relaxed mt-4">
                                    DAI is applying a market systems approach to agricultural value chains in Bangladesh’s Southern Delta, home to 30 million people where poverty and under-nutrition are acute and persistent, agricultural productivity is low, and farmers are not linked to markets.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
</article>
@endsection