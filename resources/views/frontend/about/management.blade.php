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
                            <source media="(max-width:480px)" srcset="https://www.praavahealth.com/media-images/DsdlsUYtSCFtpLjqrEp5LB1llDA=/525/fill-168x226-c0/Sylvana_Quader_Sinha_1.png">
                            <source media="(max-width:1024px)" srcset="https://www.praavahealth.com/media-images/ON4KfIwBrFct6SPXzrCDL_aJGXs=/525/fill-268x358-c0/Sylvana_Quader_Sinha_1.png">
                            <source media="(max-width:1024px)" srcset="https://www.praavahealth.com/media-images/vDPuZvnQTAN0BamqaqepI-y3ZgU=/525/fill-268x358-c0/Sylvana_Quader_Sinha_1.png">
                            <img src="https://www.praavahealth.com/media-images/ON4KfIwBrFct6SPXzrCDL_aJGXs=/525/fill-268x358-c0/Sylvana_Quader_Sinha_1.png" 
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
                            <source media="(max-width:480px)" srcset="https://www.praavahealth.com/media-images/qFESppC1ecXv6L18ophJa-ykoA0=/546/fill-168x226-c0/Mohammad_Abdul_Matin_Emon_9.jpg">
                            <source media="(max-width:1024px)" srcset="https://www.praavahealth.com/media-images/B4A3cAJknolYU3kS-ZESncz1mQs=/546/fill-268x358-c0/Mohammad_Abdul_Matin_Emon_9.jpg">
                            <img src="https://www.praavahealth.com/media-images/B4A3cAJknolYU3kS-ZESncz1mQs=/546/fill-268x358-c0/Mohammad_Abdul_Matin_Emon_9.jpg" 
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
                            <source media="(max-width:480px)" srcset="https://www.praavahealth.com/media-images/lZ63EcFMK8IOgjRJ6TrpTmIWQkA=/362/fill-168x226-c0/Dr._Simeen_Majid_Akhtar_hfVv4Mu.jpg">
                            <source media="(max-width:1024px)" srcset="https://www.praavahealth.com/media-images/V18ACOxSxN3fJDK-nKgBNFuzDdY=/362/fill-268x358-c0/Dr._Simeen_Majid_Akhtar_hfVv4Mu.jpg">
                            <img src="https://www.praavahealth.com/media-images/V18ACOxSxN3fJDK-nKgBNFuzDdY=/362/fill-268x358-c0/Dr._Simeen_Majid_Akhtar_hfVv4Mu.jpg" 
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
                            <source media="(max-width:480px)" srcset="https://www.praavahealth.com/media-images/pLP0lQPx1f0vCk4E9lSh3YJH87I=/355/fill-168x226-c0/Dr._Zaheed_Husain_Ph.D_LVLIYCq.jpg">
                            <source media="(max-width:1024px)" srcset="https://www.praavahealth.com/media-images/8UgtZ3GY46c8IHeJWmRi0pJq4l8=/355/fill-268x358-c0/Dr._Zaheed_Husain_Ph.D_LVLIYCq.jpg">
                            <img src="https://www.praavahealth.com/media-images/8UgtZ3GY46c8IHeJWmRi0pJq4l8=/355/fill-268x358-c0/Dr._Zaheed_Husain_Ph.D_LVLIYCq.jpg" 
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
                            <source media="(max-width:480px)" srcset="https://www.praavahealth.com/media-images/WiPYJTRVJqsvCZNOkOd-MeEjZC0=/358/fill-168x226-c0/Md._Mahbubur_Rahman_OWC3wzV.jpg">
                            <source media="(max-width:1024px)" srcset="https://www.praavahealth.com/media-images/m2h3P08GS4PAr9pwk9gHIaF1RiQ=/358/fill-268x358-c0/Md._Mahbubur_Rahman_OWC3wzV.jpg">
                            <img src="https://www.praavahealth.com/media-images/m2h3P08GS4PAr9pwk9gHIaF1RiQ=/358/fill-268x358-c0/Md._Mahbubur_Rahman_OWC3wzV.jpg" 
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
                            <source media="(max-width:480px)" srcset="https://www.praavahealth.com/media-images/-6iUl_ynfQM9OLn2jEma9s4ZLjk=/552/fill-168x226-c0/Md_Rezaul_Hassan_Sharif.jpg">
                            <source media="(max-width:1024px)" srcset="https://www.praavahealth.com/media-images/-nSyvhYD7TaQCm8AHIy8CWq0vlo=/552/fill-268x358-c0/Md_Rezaul_Hassan_Sharif.jpg">
                            <img src="https://www.praavahealth.com/media-images/-nSyvhYD7TaQCm8AHIy8CWq0vlo=/552/fill-268x358-c0/Md_Rezaul_Hassan_Sharif.jpg" 
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
                            <source media="(max-width:480px)" srcset="https://www.praavahealth.com/media-images/GuIy7FaCfjxp0jot9ip94nMqchs=/550/fill-168x226-c0/Syed_Shourav_Kabir.jpg">
                            <source media="(max-width:1024px)" srcset="https://www.praavahealth.com/media-images/0l_10jnMv7cnbtIlAI4FGy6YMB4=/550/fill-268x358-c0/Syed_Shourav_Kabir.jpg">
                            <img src="https://www.praavahealth.com/media-images/0l_10jnMv7cnbtIlAI4FGy6YMB4=/550/fill-268x358-c0/Syed_Shourav_Kabir.jpg" 
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