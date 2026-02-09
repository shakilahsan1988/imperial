@extends('layouts.front')

@section('title', 'About Us - Imperial Health Bangladesh')

@section('content')

<main class="w-full bg-white">

    <!-- ==========================================
         SECTION 1: FOUNDER (From Previous Request)
    ========================================== -->
    <section class="py-16 lg:py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Text Content (5 Cols) -->
                <div class="lg:col-span-5 order-2 lg:order-1">
                    <div class="blog-card">
                        <div class="mb-4">
                            <span class="text-imperial-primary font-bold tracking-wider uppercase text-xs">Our Story</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-imperial-text mb-6 font-sans leading-tight">
                            Meet Our Founder &amp; Chair of the Board
                        </h1>
                        <p class="text-gray-600 text-lg leading-relaxed mb-8">
                            Six years ago, my mother was hospitalized at one of Bangladesh’s top hospitals for a basic operation. We expected that the routine procedure would go smoothly, yet she suffered such dramatic complications that we nearly lost her. The most harrowing part of the experience was the doctor’s cavalier attitude. On my mother’s worst day, my sister and I desperately needed to understand why our mother was vomiting bile, but the doctor ignored our queries and walked out of the room. I distinctly remember chasing him up two flights of stairs to demand answers to our simple questions.
                        </p>
                        <div class="press-btn mt-4">
                            <a href="#" rel="noopener noreferrer" class="inline-flex items-center text-imperial-primary font-bold text-lg group hover:text-imperial-dark transition duration-300">
                                See Details 
                                <i class="fa-solid fa-arrow-right ml-3 transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Image Content (7 Cols) -->
                <div class="lg:col-span-7 order-1 lg:order-2">
                    <div class="blog-imgwrap relative h-[400px] md:h-[500px] lg:h-[550px] w-full rounded-lg overflow-hidden shadow-xl">
                        <img 
                            src="{{ asset('assets/front/images/management/1.jpg') }}" 
                            alt="Sylvana Quader Sinha" 
                            class="w-full h-full object-cover object-center"
                            loading="lazy"
                        >
                    </div>
                </div>
            </div>
        </div>
    </section>

         <!-- ==========================================
         SECTION 2: BLOG LIST (4 Columns + Fixed Height)
    ========================================== -->
    <section class="py-16 bg-white border-t border-gray-100">
        <div class="container mx-auto px-6">
            
            <!-- Header & Search Row -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12 items-center">
                <!-- Title -->
                <div class="lg:col-span-7">
                    <h1 class="text-3xl md:text-4xl font-bold text-imperial-text font-sans">Blog list</h1>
                </div>
                
                <!-- Search Box -->
                <div class="lg:col-span-5">
                    <div class="relative w-full">
                        <input type="text" placeholder="Search" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-imperial-primary focus:border-imperial-primary transition shadow-sm text-gray-700">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Blog Grid: 4 Boxes Per Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <!-- Item 1 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <!-- Fixed Height Container (h-56) + Object Contain (Shows full image) -->
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/2.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Jul 11, 2023</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Meet Our Founder &amp; Chair of the Board</p>
                        </div>
                    </a>
                </div>

                <!-- Item 2 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/2.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Jul 24, 2023</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Why Doing Regular Health Checks is Important</p>
                        </div>
                    </a>
                </div>

                <!-- Item 3 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/2.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Jul 24, 2023</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Don't Let Your Job Steal Your Sunshine: Vitamin D Deficiency</p>
                        </div>
                    </a>
                </div>

                <!-- Item 4 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/3.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Jul 24, 2023</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Praava Health’s Smile Package</p>
                        </div>
                    </a>
                </div>

                <!-- Item 5 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/4.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Jul 24, 2023</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Is Weight-loss The Key to Happiness?</p>
                        </div>
                    </a>
                </div>

                <!-- Item 6 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/5.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Jul 24, 2023</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">My Journey to Becoming a Family Medicine Doctor</p>
                        </div>
                    </a>
                </div>

                <!-- Item 7 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/6.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Aug 22, 2023</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Type-2 Diabetes</p>
                        </div>
                    </a>
                </div>

                <!-- Item 8 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/1.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Aug 22, 2023</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Type-2 Diabetes: Symptoms, Causes, Treatment</p>
                        </div>
                    </a>
                </div>

                <!-- Item 9 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/1.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Oct 03, 2023</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">টাইপ ২ ডায়াবেটিস</p>
                        </div>
                    </a>
                </div>

                <!-- Item 10 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/2.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Oct 03, 2023</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">টাইপ ২ ডায়াবেটিস: লক্ষণ, কারণ, প্রতিকার</p>
                        </div>
                    </a>
                </div>

                <!-- Item 11 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/3.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Nov 29, 2023</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Common Cold: Symptoms, Causes, Treatment</p>
                        </div>
                    </a>
                </div>

                <!-- Item 12 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/4.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Sep 01, 2024</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">What Is Monkeypox? Understanding the Virus</p>
                        </div>
                    </a>
                </div>

                <!-- Item 13 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/5.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Sep 11, 2024</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">What is Dengue? Understanding the Virus</p>
                        </div>
                    </a>
                </div>

                <!-- Item 14 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/6.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Oct 06, 2024</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Breast Cancer and Early Detection</p>
                        </div>
                    </a>
                </div>

                <!-- Item 15 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/6.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Feb 11, 2025</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">PCOS: Symptoms, Causes, and Treatment</p>
                        </div>
                    </a>
                </div>

                <!-- Item 16 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/1.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Feb 11, 2025</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">পলিসিস্টিক ওভারি সিনড্রোম (PCOS)</p>
                        </div>
                    </a>
                </div>

                <!-- Item 17 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/3.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Mar 04, 2025</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Leukorrhea: Causes, Symptoms, and Treatment</p>
                        </div>
                    </a>
                </div>

                <!-- Item 18 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/4.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Mar 04, 2025</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">লিউকোরিয়া: কারণ, লক্ষণ ও চিকিৎসা</p>
                        </div>
                    </a>
                </div>

                <!-- Item 19 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/5.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Apr 13, 2025</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Scabies: Causes, Symptoms, and Treatment</p>
                        </div>
                    </a>
                </div>

                <!-- Item 20 -->
                <div class="flex flex-col h-full">
                    <a href="#" class="group block h-full">
                        <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/management/6.jpg') }}" alt="Blog" class="w-full h-full object-contain transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 mb-1">Apr 13, 2025</h3>
                            <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">স্ক্যাবিস: কারণ, লক্ষণ ও চিকিৎসা</p>
                        </div>
                    </a>
                </div>

            </div>

            <!-- Load More Button -->
            <div class="flex justify-center mt-12">
                <button class="bg-imperial-primary hover:bg-imperial-dark text-white font-bold py-3 px-8 rounded shadow transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-imperial-primary">
                    Load More
                </button>
            </div>

        </div>
    </section>

</main>

@endsection