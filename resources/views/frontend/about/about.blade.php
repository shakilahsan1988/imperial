@extends('layouts.front')

@section('title', 'About Us - Imperial Health Bangladesh')

@section('content')

    <!-- Main Content Start -->
    <main class="font-sans text-imperial-text bg-white">

        <!-- HERO SECTION -->
        <section class="relative h-[50vh] md:h-[60vh] w-full overflow-hidden">
            <img src="https://www.praavahealth.com/media-images/z5jPhyJJMyxSGlROQ1ve7B_z04k=/316/fill-1920x634-c0/About_Us.jpg" 
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
                        <img src="https://www.praavahealth.com/media-images/7pO_S_1kC8aZAqJPI1fLdEOOG7w=/317/fill-909x681-c0/What_Sets_Us_Apart.jpg" 
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
                            <img src="https://www.praavahealth.com/media-images/ON4KfIwBrFct6SPXzrCDL_aJGXs=/525/fill-268x358-c0/Sylvana_Quader_Sinha_1.png" 
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
                            <img src="https://www.praavahealth.com/media-images/B4A3cAJknolYU3kS-ZESncz1mQs=/546/fill-268x358-c0/Mohammad_Abdul_Matin_Emon_9.jpg" 
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
                            <img src="https://www.praavahealth.com/media-images/V18ACOxSxN3fJDK-nKgBNFuzDdY=/362/fill-268x358-c0/Dr._Simeen_Majid_Akhtar_hfVv4Mu.jpg" 
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
                            <img src="https://www.praavahealth.com/media-images/8UgtZ3GY46c8IHeJWmRi0pJq4l8=/355/fill-268x358-c0/Dr._Zaheed_Husain_Ph.D_LVLIYCq.jpg" 
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
                            <img src="https://www.praavahealth.com/media-images/7hpe-O0NdwhO31s6sUgqiyvFKZI=/358/fill-268x358-c0/Md._Mahbubur_Rahman_OWC3wzV.jpg" 
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
                            <img src="https://www.praavahealth.com/media-images/cLk0PpZsuYip6dwI5e7xOXMHbhI=/552/fill-268x358-c0/Md_Rezaul_Hassan_Sharif.jpg" 
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
                            <img src="https://www.praavahealth.com/media-images/5--L0i9D-2QZ6VjI5IQgK9fy1KA=/550/fill-268x358-c0/Syed_Shourav_Kabir.jpg" 
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
                        <img src="https://www.praavahealth.com/media-images/liMAazUu7oKcAqcQgQxOliS3Vz8=/158/fill-540x292-c0/1.png" alt="Client 1" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="https://www.praavahealth.com/media-images/cvUBnLpLRyTOhZyk0BDHomw2P_Y=/159/fill-540x292-c0/2.png" alt="Client 2" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="https://www.praavahealth.com/media-images/D6-Q4t7x9d54nsjxsMYXJuuVQDo=/160/fill-540x292-c0/3.png" alt="Client 3" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="https://www.praavahealth.com/media-images/j4aW5VCXWXG6NZExpzKcMLPBeVk=/161/fill-540x292-c0/4.png" alt="Client 4" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="https://www.praavahealth.com/media-images/FRraavxzXy9luaHQh8ehwpK9h8U=/162/fill-540x292-c0/5.png" alt="Client 5" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="https://www.praavahealth.com/media-images/WyrxDaMULjxrXq3o7ZuLg2Dgjjc=/163/fill-540x292-c0/6.png" alt="Client 6" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="https://www.praavahealth.com/media-images/5GWamPArp6lMMrqLjBdrqTZaVH4=/237/fill-540x292-c0/7.png" alt="Client 7" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="https://www.praavahealth.com/media-images/RubKYZDRxh0r2mxah-uuz9hr0aw=/238/fill-540x292-c0/8.png" alt="Client 8" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="https://www.praavahealth.com/media-images/rY4gA9BjZa8W6hP7UKXasi72IWE=/239/fill-540x292-c0/9.png" alt="Client 9" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="https://www.praavahealth.com/media-images/FR9_CpzLn4ke4Q1pBrwG0iXS6G0=/240/fill-540x292-c0/10.png" alt="Client 10" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="https://www.praavahealth.com/media-images/5eHtA1jogNNRV-qDxZhO1OzuOS4=/241/fill-540x292-c0/11.png" alt="Client 11" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center justify-center h-32 hover:shadow-md transition-shadow">
                        <img src="https://www.praavahealth.com/media-images/UmE8BkGSshEqoTk9vEDspgTg0GY=/242/fill-540x292-c0/12.png" alt="Client 12" class="max-w-full max-h-full object-contain">
                    </div>

                </div>
            </div>
        </section>

    </main>
    <!-- Main Content End -->

@endsection