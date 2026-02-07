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
                            src="https://www.praavahealth.com/media-images/X9kWLiFHlhAQVG6fbJu-gY7CBCM=/527/fill-953x729-c0/Sylvana_Quader_Sinha_Blog_content_Image1.png" 
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
         SECTION 2: BLOG LIST (New Request)
    ========================================== -->
    <section class="py-16 bg-white border-t border-gray-100">
        <div class="container mx-auto px-6">
            
            <!-- Header & Search Row -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12 items-center">
                <!-- Title (Spans 7 cols) -->
                <div class="lg:col-span-7">
                    <h1 class="text-3xl md:text-4xl font-bold text-imperial-text font-sans">Blog list</h1>
                </div>
                
                <!-- Search Box (Spans 5 cols) -->
                <div class="lg:col-span-5">
                    <div class="relative w-full">
                        <input type="text" placeholder="Search" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-imperial-primary focus:border-imperial-primary transition shadow-sm text-gray-700">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Blog Grid -->
            <!-- Logic: 12-column grid. Odd items span 5, Even items span 7 to fit side-by-side (5+7=12) -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-y-8 gap-x-8">
                
                <!-- Item 1: Founder (Span 5) -->
                <div class="md:col-span-5">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/gRzABKjU7EeZpgQ5CZQK_hTyubU=/528/fill-529x352-c0%7Cformat-webp/Sylvana_Quader_Sinha_Blog_content_Image_10.5x.png" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Jul 11, 2023</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Meet Our Founder &amp; Chair of the Board</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 2: Health Checks (Span 7) -->
                <div class="md:col-span-7">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/ch3UJQUIP-TStmxQfGIRhXnEPk0=/401/fill-529x352-c0%7Cformat-webp/Artboard_6_OrJDEiF.jpg" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Jul 24, 2023</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Why Doing Regular Health Checks is Important</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 3: Vitamin D (Span 5) -->
                <div class="md:col-span-5">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/rf7XaKn3P08QQDeEuYiV__KcmIQ=/415/fill-529x352-c0%7Cformat-webp/blog-_dont_let.jpg" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Jul 24, 2023</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Don't Let Your Job Steal Your Sunshine: Vitamin D Deficiency in the Workplace</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 4: Smile Package (Span 7) -->
                <div class="md:col-span-7">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/zm95o0twteY4n-Agw2Vv2veEU-M=/416/fill-529x352-c0%7Cformat-webp/blog-_smile_.jpg" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Jul 24, 2023</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Praava Health’s Smile Package: The Complete Solution for a Healthy and Confident Smile</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 5: Weight Loss (Span 5) -->
                <div class="md:col-span-5">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/8KLJv-Ac0DphJ-q7NpV_sXOMnmk=/417/fill-529x352-c0%7Cformat-webp/weight_loss.jpg" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Jul 24, 2023</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Is Weight-loss The Key to Happiness?</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 6: Family Med (Span 7) -->
                <div class="md:col-span-7">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/qMAMQ_pzRIh8BPyPMTDBP_nAwBM=/418/fill-529x352-c0%7Cformat-webp/dr._paramita.jpg" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Jul 24, 2023</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">My Journey to Becoming a Family Medicine Doctor</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 7: Diabetes (Span 5) -->
                <div class="md:col-span-5">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/VD-lp6seDbQdsPFhMyRS1melnP8=/423/fill-529x352-c0%7Cformat-webp/diabetes-01.jpg" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Aug 22, 2023</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Type-2 Diabetes</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 8: Diabetes Details (Span 7) -->
                <div class="md:col-span-7">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/VD-lp6seDbQdsPFhMyRS1melnP8=/423/fill-529x352-c0%7Cformat-webp/diabetes-01.jpg" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Aug 22, 2023</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Type-2 Diabetes: Symptoms, Causes, Treatment</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 9: Diabetes Bangla (Span 5) -->
                <div class="md:col-span-5">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/VD-lp6seDbQdsPFhMyRS1melnP8=/423/fill-529x352-c0%7Cformat-webp/diabetes-01.jpg" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Oct 03, 2023</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">টাইপ ২ ডায়াবেটিস</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 10: Diabetes Bangla 2 (Span 7) -->
                <div class="md:col-span-7">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/VD-lp6seDbQdsPFhMyRS1melnP8=/423/fill-529x352-c0%7Cformat-webp/diabetes-01.jpg" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Oct 03, 2023</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">টাইপ ২ ডায়াবেটিস: লক্ষণ, কারণ, প্রতিকার</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 11: Common Cold (Span 5) -->
                <div class="md:col-span-5">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/s968Y04oH7UuT4OnbD0jlBklV8k=/435/fill-529x352-c0%7Cformat-webp/Common_Cold_Symptoms.jpg" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Nov 29, 2023</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Common Cold: Symptoms, Causes, Treatment</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 12: Monkeypox (Span 7) -->
                <div class="md:col-span-7">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/Jn1RHA0UGYr8caQnDTvByD7OzuQ=/469/fill-529x352-c0%7Cformat-webp/Monkey_pox.png" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Sep 01, 2024</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">What Is Monkeypox? Understanding the Virus and Its Impact</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 13: Dengue (Span 5) -->
                <div class="md:col-span-5">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/Y4yBBL5_D7TEqg_hKaYpJGW5rm0=/472/fill-529x352-c0%7Cformat-webp/Dengue.jpeg" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Sep 11, 2024</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">What is Dengue? Understanding the Virus and its Impact.</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 14: Breast Cancer (Span 7) -->
                <div class="md:col-span-7">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/1e-ukGaM87TYtqRMYp9suFOJRKc=/477/fill-529x352-c0%7Cformat-webp/Web_Image.png" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Oct 06, 2024</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Breast Cancer and the Importance of Early Detection</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 15: PCOS (Span 5) -->
                <div class="md:col-span-5">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/UuqQKc7i2OaeHvIAPzvfuWoFKQw=/531/fill-529x352-c0%7Cformat-webp/PCOS.png" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Feb 11, 2025</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Polycystic Ovary Syndrome (PCOS): Symptoms, Causes, and Treatment Plans</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 16: PCOS Bangla (Span 7) -->
                <div class="md:col-span-7">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/O_pWcYFWvLmjrwKKwMFciV5WB0g=/534/fill-529x352-c0%7Cformat-webp/PCOS_Bangla_5fBdNwr.png" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Feb 11, 2025</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">পলিসিস্টিক ওভারি সিনড্রোম (PCOS): লক্ষণ, কারণ, চিকিৎসা</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 17: Leukorrhea (Span 5) -->
                <div class="md:col-span-5">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/r6e4OkJsKvFsVV9HuU25GCGUBoY=/547/fill-529x352-c0%7Cformat-webp/Leukorrhea_Symptoms_1.jpg" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Mar 04, 2025</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Leukorrhea: Understanding Causes, Symptoms, and Treatment</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 18: Leukorrhea Bangla (Span 7) -->
                <div class="md:col-span-7">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/ASS9PWWX-XsjsI_8Ydzq2B55BUY=/541/fill-529x352-c0%7Cformat-webp/Leukorrhea_Symptoms_Bangla.png" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Mar 04, 2025</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">লিউকোরিয়া: কারণ, লক্ষণ ও চিকিৎসা সম্পর্কে জানুন</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 19: Scabies (Span 5) -->
                <div class="md:col-span-5">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/XgItClhpLgIhdXxoLpccmpO6Ekc=/553/fill-529x352-c0%7Cformat-webp/Scabies.jpg" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Apr 13, 2025</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Scabies: Understanding Causes, Symptoms, and Treatment</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Item 20: Scabies Bangla (Span 7) -->
                <div class="md:col-span-7">
                    <a href="#" class="block group">
                        <div class="grid grid-cols-6 gap-4 h-full">
                            <div class="col-span-6 md:col-span-6 h-48 overflow-hidden rounded-md bg-gray-100">
                                <img src="https://www.praavahealth.com/media-images/J223nTGBp_kH-kSaodTZavypcew=/555/fill-529x352-c0%7Cformat-webp/Scabies_1.jpg" alt="Blog" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="col-span-6 md:col-span-6 flex flex-col justify-center">
                                <h3 class="text-sm font-bold text-gray-500 mb-1">Apr 13, 2025</h3>
                                <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">স্ক্যাবিস: কারণ, লক্ষণ ও চিকিৎসা</p>
                            </div>
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