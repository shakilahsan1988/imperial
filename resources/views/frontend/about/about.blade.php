@extends('layouts.front')

@section('title', 'About Us - Imperial Health Bangladesh')

@section('content')

    <!-- Main Content Start -->
    <main class="font-sans text-imperial-text bg-white">

        <!-- HERO SECTION -->
        <section class="relative h-[50vh] md:h-[60vh] w-full overflow-hidden">
            <img src="{{ asset('assets/front/images/about/1.jpg') }}" 
                 alt="About Us" 
                 class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/40"></div>
            
            <div class="container mx-auto px-4 h-full flex items-center relative z-10">
                <div class="max-w-2xl text-white">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Your Partner in Health</h1>
                    <p class="text-lg md:text-xl opacity-90 font-roboto leading-relaxed">
                        Praava exists to provide a better patient experience and we have built a healthcare system where you come first.
                    </p>
                </div>
            </div>
        </section>

        <!-- WHAT SETS US APART SECTION -->
        <section class="py-16 md:py-24 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-12 text-center md:text-left">
                    <h2 class="text-3xl font-bold text-gray-900">What Sets Us Apart</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Image -->
                    <div class="order-2 lg:order-1 rounded-2xl overflow-hidden shadow-lg">
                        <img src="{{ asset('assets/front/images/about/1.jpg') }}" 
                             alt="What Sets Us Apart" 
                             class="w-full h-auto object-cover">
                    </div>

                    <!-- List Items -->
                    <div class="order-1 lg:order-2 space-y-10">
                        <!-- Quality -->
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-imperial-light text-imperial-primary flex items-center justify-center">
                                    <i class="fa-solid fa-star text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">QUALITY</h3>
                                <p class="text-gray-600 font-roboto leading-relaxed">
                                    Our state-of-the-art facility hosts a wide range of lab and imaging services. Praava has received Bangladesh Accreditation Board (BAB) accreditation and ISO 15189-2012 international accreditation in March 2022. For external validation, Praava also participates in RIQAS, world’s largest international external quality assessment scheme, and we receive a 99.9% average monthly accuracy score.
                                </p>
                            </div>
                        </div>

                        <!-- Affordability -->
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-imperial-light text-imperial-primary flex items-center justify-center">
                                    <i class="fa-solid fa-tags text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">AFFORDABILITY</h3>
                                <p class="text-gray-600 font-roboto leading-relaxed">
                                    We believe that everyone should have access to convenient, affordable, and high-quality care. We provide best-in-class care at a price you can afford and we continuously working to reduce our cost, so more Bangladeshis can have access to great care.
                                </p>
                            </div>
                        </div>

                        <!-- Innovation -->
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-imperial-light text-imperial-primary flex items-center justify-center">
                                    <i class="fa-solid fa-laptop-medical text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">INNOVATION</h3>
                                <p class="text-gray-600 font-roboto leading-relaxed">
                                    We use technology to make healthcare accessible to you no matter where you are. You can book consultations and lab and imaging services online, talk to a doctor through video consultation, and also order your medications from our online pharmacy.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- MANAGEMENT TEAM SECTION -->
        <section class="py-16 md:py-24">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Our Management Team</h2>
                    <div class="w-16 h-1 bg-imperial-primary mx-auto mt-4"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    
                    <!-- Card 1 -->
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-100">
                            <img src="{{ asset('assets/front/images/about/2.jpg') }}" 
                                 alt="Sylvana Quader Sinha" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Sylvana Quader Sinha</h3>
                            <p class="text-sm text-imperial-primary font-medium mb-4">Founder & Chair of Board</p>
                            <a href="{{ route('management-details') }}" class="text-sm font-bold text-gray-500 hover:text-imperial-primary uppercase tracking-wide">See Details &rarr;</a>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-100">
                            <img src="{{ asset('assets/front/images/about/3.jpg') }}" 
                                 alt="Mohammad Abdul Matin Emon" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Mohammad Abdul Matin Emon</h3>
                            <p class="text-sm text-imperial-primary font-medium mb-4">Chief Executive Officer</p>
                            <a href="{{ route('management-details') }}" class="text-sm font-bold text-gray-500 hover:text-imperial-primary uppercase tracking-wide">See Details &rarr;</a>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-100">
                            <img src="{{ asset('assets/front/images/about/4.jpg') }}" 
                                 alt="Dr. Simeen M. Akhtar" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Dr. Simeen M. Akhtar</h3>
                            <p class="text-sm text-imperial-primary font-medium mb-4">Chief Operating Officer (COO)</p>
                            <a href="{{ route('management-details') }}" class="text-sm font-bold text-gray-500 hover:text-imperial-primary uppercase tracking-wide">See Details &rarr;</a>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-100">
                            <img src="{{ asset('assets/front/images/about/5.jpg') }}" 
                                 alt="Dr. Zaheed Husain, Ph.D." 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Dr. Zaheed Husain, Ph.D.</h3>
                            <p class="text-sm text-imperial-primary font-medium mb-4">Senior Lab Director, Cancer Diagnostics</p>
                            <a href="{{ route('management-details') }}" class="text-sm font-bold text-gray-500 hover:text-imperial-primary uppercase tracking-wide">See Details &rarr;</a>
                        </div>
                    </div>

                    <!-- Card 5 -->
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-100">
                            <img src="{{ asset('assets/front/images/about/6.jpg') }}" 
                                 alt="Md. Mahbubur Rahman" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Md. Mahbubur Rahman</h3>
                            <p class="text-sm text-imperial-primary font-medium mb-4">Laboratory Director</p>
                            <a href="{{ route('management-details') }}" class="text-sm font-bold text-gray-500 hover:text-imperial-primary uppercase tracking-wide">See Details &rarr;</a>
                        </div>
                    </div>

                    <!-- Card 6 -->
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-100">
                            <img src="{{ asset('assets/front/images/about/7.jpg') }}" 
                                 alt="Md. Rezaul Hassan Sharif" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Md. Rezaul Hassan Sharif</h3>
                            <p class="text-sm text-imperial-primary font-medium mb-4">Head of Human Resources & Admin</p>
                            <a href="{{ route('management-details') }}" class="text-sm font-bold text-gray-500 hover:text-imperial-primary uppercase tracking-wide">See Details &rarr;</a>
                        </div>
                    </div>

                     <!-- Card 7 -->
                     <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-100">
                            <img src="{{ asset('assets/front/images/about/8.jpg') }}" 
                                 alt="Syed Shourav Kabir" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Syed Shourav Kabir</h3>
                            <p class="text-sm text-imperial-primary font-medium mb-4">Head of Consumer Business</p>
                            <a href="{{ route('management-details') }}" class="text-sm font-bold text-gray-500 hover:text-imperial-primary uppercase tracking-wide">See Details &rarr;</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- CORPORATE CLIENTS SECTION -->
        <section class="py-16 md:py-24 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Our Corporate Clients</h2>
                    <p class="text-imperial-gray mt-2 uppercase tracking-widest text-sm font-bold">We Provide Best Healthcare to Best of Bangladesh</p>
                </div>

                <!-- Logo Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8">
                    
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="{{ asset('assets/front/images/client/1.webp') }}" alt="Client 1" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="{{ asset('assets/front/images/client/2.webp') }}" alt="Client 2" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="{{ asset('assets/front/images/client/3.webp') }}" alt="Client 3" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="{{ asset('assets/front/images/client/5.webp') }}" alt="Client 4" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="{{ asset('assets/front/images/client/6.webp') }}" alt="Client 5" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="{{ asset('assets/front/images/client/7.webp') }}" alt="Client 6" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="{{ asset('assets/front/images/client/8.webp') }}" alt="Client 7" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="{{ asset('assets/front/images/client/1.webp') }}" alt="Client 8" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="{{ asset('assets/front/images/client/2.webp') }}" alt="Client 9" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="{{ asset('assets/front/images/client/3.webp') }}" alt="Client 10" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="{{ asset('assets/front/images/client/4.webp') }}" alt="Client 11" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="{{ asset('assets/front/images/client/5.webp') }}" alt="Client 12" class="max-w-full max-h-full object-contain">
                    </div>

                </div>
            </div>
        </section>

    </main>
    <!-- Main Content End -->

@endsection