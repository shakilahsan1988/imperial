@extends('layouts.front')

@section('title', 'Management Team - Imperial Health Bangladesh')

@section('content')

    <!-- Main Content Start -->
    <main class="font-sans text-imperial-text bg-gray-50 pb-20">

        <!-- Breadcrumbs -->
        <section class="bg-white border-b border-gray-200 py-3">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex text-sm text-gray-500">
                    <a href="{{ route('fhome') }}" class="hover:text-imperial-primary transition">Home</a>
                    <span class="mx-2 text-gray-400">/</span>
                    <a href="{{ route('about') }}" class="hover:text-imperial-primary transition">About</a>
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-gray-900 font-medium">Management Team</span>
                </nav>
            </div>
        </section>

        <!-- Management Team List Section -->
        <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
            
            <!-- Title -->
            <div class="mb-12 text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Our Management Team</h1>
            </div>

            <!-- Grid Container -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Member 1: Sylvana Quader Sinha -->
                <a href="{{ route('management-details') }}" class="group block bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 text-center">
                    <div class="aspect-[3/4] overflow-hidden bg-gray-100 relative">
                        <picture class="w-full h-full block">
                            <source media="(max-width:480px)" srcset="{{ asset('assets/front/images/management/1.jpg') }}">
                            <source media="(max-width:1024px)" srcset="{{ asset('assets/front/images/management/1.jpg') }}">
                            <source media="(max-width:1024px)" srcset="{{ asset('assets/front/images/management/1.jpg') }}">
                            <img src="{{ asset('assets/front/images/management/1.jpg') }}" 
                                 alt="Sylvana Quader Sinha" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </picture>
                        <!-- Hover Overlay -->
                        <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 font-sans">Sylvana Quader Sinha</h3>
                        <p class="text-sm text-imperial-primary font-medium mb-4 font-roboto">Founder & Chair of Board</p>
                        <span class="inline-block px-4 py-2 border border-imperial-primary text-imperial-primary font-bold text-xs uppercase tracking-widest rounded hover:bg-imperial-primary hover:text-white transition-colors">
                            See Details
                        </span>
                    </div>
                </a>

                <!-- Member 2: Mohammad Abdul Matin Emon -->
                <a href="{{ route('management-details') }}" class="group block bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 text-center">
                    <div class="aspect-[3/4] overflow-hidden bg-gray-100 relative">
                        <picture class="w-full h-full block">
                            <source media="(max-width:480px)" srcset="{{ asset('assets/front/images/management/2.jpg') }}">
                            <source media="(max-width:1024px)" srcset="{{ asset('assets/front/images/management/2.jpg') }}">
                            <img src="{{ asset('assets/front/images/management/2.jpg') }}" 
                                 alt="Mohammad Abdul Matin Emon" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </picture>
                        <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 font-sans">Mohammad Abdul Matin Emon</h3>
                        <p class="text-sm text-imperial-primary font-medium mb-4 font-roboto">Chief Executive Officer</p>
                        <span class="inline-block px-4 py-2 border border-imperial-primary text-imperial-primary font-bold text-xs uppercase tracking-widest rounded hover:bg-imperial-primary hover:text-white transition-colors">
                            See Details
                        </span>
                    </div>
                </a>

                <!-- Member 3: Dr. Simeen M. Akhtar -->
                <a href="{{ route('management-details') }}" class="group block bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 text-center">
                    <div class="aspect-[3/4] overflow-hidden bg-gray-100 relative">
                        <picture class="w-full h-full block">
                            <source media="(max-width:480px)" srcset="{{ asset('assets/front/images/management/3.jpg') }}">
                            <source media="(max-width:1024px)" srcset="{{ asset('assets/front/images/management/3.jpg') }}">
                            <img src="{{ asset('assets/front/images/management/3.jpg') }}" 
                                 alt="Dr. Simeen M. Akhtar" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </picture>
                        <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 font-sans">Dr. Simeen M. Akhtar</h3>
                        <p class="text-sm text-imperial-primary font-medium mb-4 font-roboto">Chief Operating Officer (COO)</p>
                        <span class="inline-block px-4 py-2 border border-imperial-primary text-imperial-primary font-bold text-xs uppercase tracking-widest rounded hover:bg-imperial-primary hover:text-white transition-colors">
                            See Details
                        </span>
                    </div>
                </a>

                <!-- Member 4: Dr. Zaheed Husain, Ph.D. -->
                <a href="{{ route('management-details') }}" class="group block bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 text-center">
                    <div class="aspect-[3/4] overflow-hidden bg-gray-100 relative">
                        <picture class="w-full h-full block">
                            <source media="(max-width:480px)" srcset="{{ asset('assets/front/images/management/4.jpg') }}">
                            <source media="(max-width:1024px)" srcset="{{ asset('assets/front/images/management/4.jpg') }}">
                            <img src="{{ asset('assets/front/images/management/4.jpg') }}" 
                                 alt="Dr. Zaheed Husain, Ph.D." 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </picture>
                        <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 font-sans">Dr. Zaheed Husain, Ph.D.</h3>
                        <p class="text-sm text-imperial-primary font-medium mb-4 font-roboto">Senior Lab Director, Cancer Diagnostics</p>
                        <span class="inline-block px-4 py-2 border border-imperial-primary text-imperial-primary font-bold text-xs uppercase tracking-widest rounded hover:bg-imperial-primary hover:text-white transition-colors">
                            See Details
                        </span>
                    </div>
                </a>

                <!-- Member 5: Md. Mahbubur Rahman -->
                <a href="{{ route('management-details') }}" class="group block bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 text-center">
                    <div class="aspect-[3/4] overflow-hidden bg-gray-100 relative">
                        <picture class="w-full h-full block">
                            <source media="(max-width:480px)" srcset="{{ asset('assets/front/images/management/5.jpg') }}">
                            <source media="(max-width:1024px)" srcset="{{ asset('assets/front/images/management/5.jpg') }}">
                            <img src="{{ asset('assets/front/images/management/5.jpg') }}" 
                                 alt="Md. Mahbubur Rahman" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </picture>
                        <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 font-sans">Md. Mahbubur Rahman</h3>
                        <p class="text-sm text-imperial-primary font-medium mb-4 font-roboto">Laboratory Director</p>
                        <span class="inline-block px-4 py-2 border border-imperial-primary text-imperial-primary font-bold text-xs uppercase tracking-widest rounded hover:bg-imperial-primary hover:text-white transition-colors">
                            See Details
                        </span>
                    </div>
                </a>

                <!-- Member 6: Md. Rezaul Hassan Sharif -->
                <a href="{{ route('management-details') }}" class="group block bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 text-center">
                    <div class="aspect-[3/4] overflow-hidden bg-gray-100 relative">
                        <picture class="w-full h-full block">
                            <source media="(max-width:480px)" srcset="{{ asset('assets/front/images/management/6.jpg') }}">
                            <source media="(max-width:1024px)" srcset="{{ asset('assets/front/images/management/6.jpg') }}">
                            <img src="{{ asset('assets/front/images/management/6.jpg') }}" 
                                 alt="Md Rezaul Hassan Sharif" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </picture>
                        <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 font-sans">Md. Rezaul Hassan Sharif</h3>
                        <p class="text-sm text-imperial-primary font-medium mb-4 font-roboto">Head of Human Resources &amp; Admin</p>
                        <span class="inline-block px-4 py-2 border border-imperial-primary text-imperial-primary font-bold text-xs uppercase tracking-widest rounded hover:bg-imperial-primary hover:text-white transition-colors">
                            See Details
                        </span>
                    </div>
                </a>

                <!-- Member 7: Syed Shourav Kabir -->
                <a href="{{ route('management-details') }}" class="group block bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 text-center">
                    <div class="aspect-[3/4] overflow-hidden bg-gray-100 relative">
                        <picture class="w-full h-full block">
                            <source media="(max-width:480px)" srcset="{{ asset('assets/front/images/management/7.png') }}">
                            <source media="(max-width:1024px)" srcset="{{ asset('assets/front/images/management/7.png') }}">
                            <img src="{{ asset('assets/front/images/management/7.png') }}" 
                                 alt="Syed Shourav Kabir" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </picture>
                        <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 font-sans">Syed Shourav Kabir</h3>
                        <p class="text-sm text-imperial-primary font-medium mb-4 font-roboto">Head of Consumer Business</p>
                        <span class="inline-block px-4 py-2 border border-imperial-primary text-imperial-primary font-bold text-xs uppercase tracking-widest rounded hover:bg-imperial-primary hover:text-white transition-colors">
                            See Details
                        </span>
                    </div>
                </a>

            </div>
        </section>

    </main>
    <!-- Main Content End -->

@endsection