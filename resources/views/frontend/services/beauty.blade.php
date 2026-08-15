@extends('layouts.front')

@section('title', 'Beauty Wellness - Imperial Health Bangladesh')

@section('content')
<!-- Services Section -->
<section class="py-16 px-4 bg-gray-50">
    <div class="container mx-auto max-w-7xl">
        
        <!-- Responsive Grid: 1 col mobile, 2 col tablet, 3 col desktop -->
        <!-- The original CSS used a 12-column grid with span 4, which equals 3 items per row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- Card 1: Your Skin -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-xl transition-all duration-300">
                <!-- Text Content -->
                <div class="p-8 pb-4">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-imperial-primary transition-colors">Your Skin</h2>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Whether you're looking to refresh your routine or address a persistent skin concern, our dermatology team takes time to understand your skin before recommending a plan.
                    </p>
                </div>

                <!-- Spacer/Image Area: flex-grow forces this to take remaining space -->
                <div class="flex-grow w-full overflow-hidden relative">
                    <img src="{{ asset('assets/front/images/services/dertetology.jpg') }}"
                         alt="Your Skin"
                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                </div>

                <!-- Button Area: Sticks to bottom -->
                <div class="p-8 pt-4 mt-auto">
                    <a href="{{ route('service-details') }}" class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-imperial-primary text-white font-medium rounded-full hover:bg-imperial-600 transition-colors shadow-sm">
                        Read More
                        <!-- Simple Arrow Icon (SVG) -->
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Card 2: Your Smile -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-xl transition-all duration-300">
                <div class="p-8 pb-4">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-imperial-primary transition-colors">Your Smile</h2>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        A healthy smile starts with regular care. Our dental team supports everything from routine checkups to more involved treatment, explained clearly at every step.
                    </p>
                </div>
                <div class="flex-grow w-full overflow-hidden relative">
                    <img src="{{ asset('assets/front/images/services/con9.jpg') }}"
                         alt="Your Smile"
                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8 pt-4 mt-auto">
                    <a href="{{ route('service-details') }}" class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-imperial-primary text-white font-medium rounded-full hover:bg-imperial-600 transition-colors shadow-sm">
                        Read More
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Card 3: Your Body -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-xl transition-all duration-300">
                <div class="p-8 pb-4">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-imperial-primary transition-colors">Your Body</h2>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Our nutrition and physiotherapy team works with you to set realistic goals and build a plan around your day-to-day routine, not a generic template.
                    </p>
                </div>
                <div class="flex-grow w-full overflow-hidden relative">
                    <img src="{{ asset('assets/front/images/services/phy.jpg') }}"
                         alt="Your Body"
                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8 pt-4 mt-auto">
                    <a href="{{ route('service-details') }}" class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-imperial-primary text-white font-medium rounded-full hover:bg-imperial-600 transition-colors shadow-sm">
                        Read More
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Card 4: Your Wellness -->
            <!-- Note: With 3 columns on desktop, this card will wrap to a new row. 
                 If you want it centered, you can add 'lg:col-start-2' to this div. -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-xl transition-all duration-300">
                <div class="p-8 pb-4">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-imperial-primary transition-colors">Your Wellness</h2>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Physical, mental, and emotional health are connected. Our team helps you build a routine that supports all three, at a pace that fits your life.
                    </p>
                </div>
                <div class="flex-grow w-full overflow-hidden relative">
                    <img src="{{ asset('assets/front/images/services/services-facility.jpg') }}"
                         alt="Your Wellness"
                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8 pt-4 mt-auto">
                    <a href="{{ route('service-details') }}" class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-imperial-primary text-white font-medium rounded-full hover:bg-imperial-600 transition-colors shadow-sm">
                        Read More
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection