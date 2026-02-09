@extends('layouts.front')

@section('title', 'Sylvana Quader Sinha - Management Team')

@section('content')

    <!-- Main Content Start -->
    <main class="font-sans text-imperial-text bg-gray-50 py-10">

        <!-- Breadcrumbs -->
        <section class="container mx-auto px-4 sm:px-6 lg:px-8 mb-8">
            <nav class="flex text-sm text-gray-500 items-center">
                <a href="{{ route('fhome') }}" class="hover:text-imperial-primary transition">Home</a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('about') }}" class="hover:text-imperial-primary transition">About</a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('management') }}" class="hover:text-imperial-primary transition">Management Team</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-900 font-medium">Sylvana Quader Sinha</span>
            </nav>
        </section>

        <!-- Details Container -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-8">
                
                <!-- LEFT COLUMN: Details & Bio (Span 8 on large screens) -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- Member Header -->
                    <div class="text-center lg:text-left">
                        <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-2">Sylvana Quader Sinha</h1>
                        <p class="text-xl text-imperial-primary font-medium mb-8">Founder & Chair of Board</p>
                        
                        <!-- Quote -->
                        <div class="relative bg-imperial-light/30 p-6 md:p-8 rounded-lg border-l-4 border-imperial-primary">
                            <i class="fa-solid fa-quote-left text-imperial-primary text-2xl mb-4 opacity-50"></i>
                            <blockquote class="text-lg md:text-xl italic text-gray-700 font-roboto leading-relaxed">
                                "I founded Imperial Health because I saw a tremendous need for quality healthcare in Bangladesh. I believe positive, systemic change in Bangladesh's health care sector is as necessary as it is possible."
                            </blockquote>
                        </div>
                    </div>

                    <!-- Image (Embedded in Left Column) -->
                    <div class="mb-img rounded-xl overflow-hidden shadow-md mb-8 border border-gray-200">
                        <picture class="w-full h-auto block">
                            <source media="(max-width:480px)" srcset="{{ asset('assets/front/images/management/1.jpg') }}">
                            <source media="(max-width:1024px)" srcset="{{ asset('assets/front/images/management/1.jpg') }}">
                            <source media="(max-width:1024px)" srcset="{{ asset('assets/front/images/management/1.jpg') }}">
                            <source srcset="https://www.{{ asset('assets/front/images/management/1.jpg') }}">
                            <img src="{{ asset('assets/front/images/management/1.jpg') }}" 
                                 alt="Sylvana Quader Sinha" 
                                 class="w-full h-auto object-cover">
                        </picture>
                    </div>

                    <!-- Biography Content -->
                    <div class="richtext-cont text-gray-600 space-y-6 font-roboto">
                        
                        <p>
                            Ms. Sinha is Founder & Chair of Board of Imperial Health in Bangladesh. Imperial Health is a network of family health centers where patients come first. Imperial is building a better patient experience enabled by technology, offering consultations with family doctors and a full range of diagnostics services including lab and imaging. Ms. Sinha built this company from scratch, largely based on inspiration derived from conversations with public health professionals, entrepreneurs, and investors in India and Asia and beyond, learning from what had worked in other markets and what made sense for Bangladesh at this moment of its economic development.
                        </p>

                        <p>
                            Ms. Sinha is an attorney and entrepreneur with a passion for innovative, impactful approaches to governance and international development. She has over a decade of experience leading diverse, interdisciplinary teams in international law, business, development, and government relations, including at major international law firms, management consulting firms, World Bank, and think tanks in Middle East and South Asia. She has independently advised private and sovereign clients on investments, projects, and disputes in frontier markets in Middle East, Africa, and South Asia. She has advised governments in Afghanistan, Middle East, and Asia on governance and legal reform, and has counseled multinational and regional clients investing and engaged in disputes in these and other markets on political, economic, and legal risk. Ms. Sinha also served as a foreign policy advisor to 2008 Presidential campaign of then-Senator Barack Obama.
                        </p>

                        <p>
                            Ms. Sinha is a Life Member of Council on Foreign Relations and also serves as a member of National University of Singapore Medicine International Council. She is a graduate of Columbia Law School, where she earned a certificate from Parker School of Comparative and International Law. She also earned a master's degree in Public Administration / International Development from Harvard's Kennedy School and her Bachelor of Arts (with honors) in Economics and Philosophy from Wellesley College and also was a Visiting Scholar at University of Oxford studying politics, philosophy, and economics.
                        </p>
                    </div>

                    <!-- Back Button (Optional) -->
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <a href="{{ route('management') }}" class="inline-flex items-center gap-2 text-imperial-primary font-bold hover:text-imperial-dark transition">
                            <i class="fa-solid fa-arrow-left"></i>
                            Back to Management Team
                        </a>
                    </div>

                </div>

                <!-- RIGHT COLUMN: Sticky Image (Span 4 on large screens) -->
                <div class="hidden lg:block lg:col-span-4">
                    <div class="dsc-img sticky top-10">
                        <picture class="w-full h-auto block rounded-xl overflow-hidden shadow-lg border border-gray-200">
                            <source media="(max-width:480px)" srcset="{{ asset('assets/front/images/management/1.jpg') }}">
                            <source media="(max-width:480px)" srcset="{{ asset('assets/front/images/management/1.jpg') }}">
                            <source media="(max-width:1024px)" srcset="{{ asset('assets/front/images/management/1.jpg') }}">
                            <source media="(max-width:1024px)" srcset="{{ asset('assets/front/images/management/1.jpg') }}">
                            <source srcset="{{ asset('assets/front/images/management/1.jpg') }}">
                            <img src="{{ asset('assets/front/images/management/1.jpg') }}" 
                                 alt="Sylvana Quader Sinha" 
                                 class="w-full h-auto object-cover">
                        </picture>
                    </div>
                </div>

            </div>
        </div>
    </main>
    <!-- Main Content End -->

@endsection