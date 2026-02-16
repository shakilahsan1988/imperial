@extends('layouts.front')

@section('title', 'Membership Plan - Imperial Health Bangladesh')

@section('content')

    <!-- HERO SECTION -->
    <section class="relative h-[50vh] min-h-[350px]">
        <img src="{{ asset('assets/front/images/services/con5.jpg') }}" 
             alt="Membership Plan" 
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 to-slate-900/40"></div>
        <div class="absolute inset-0 flex items-center">
            <div class="container mx-auto px-6">
                <div class="max-w-2xl">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Membership Plans</h1>
                    <p class="text-lg text-white/90">Comprehensive healthcare solutions for you and your family</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURE CARDS -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 -mt-40 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                
                <!-- Feature 1 -->
                <div class="bg-white rounded-2xl p-10 shadow-xl border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                    <div class="flex items-start gap-6">
                        <div class="w-20 h-20 rounded-full bg-imperial-primary/10 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-user-doctor text-imperial-primary text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3 text-xl">Unlimited Doctor Visits</h3>
                            <p class="text-gray-600 text-base">Access doctors as many times as you need throughout your membership period</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl p-10 shadow-xl border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                    <div class="flex items-start gap-6">
                        <div class="w-20 h-20 rounded-full bg-imperial-primary/10 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-flask text-imperial-primary text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3 text-xl">Included Health Checks</h3>
                            <p class="text-gray-600 text-base">Comprehensive tests tailored by experienced doctors to meet your needs</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl p-10 shadow-xl border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                    <div class="flex items-start gap-6">
                        <div class="w-20 h-20 rounded-full bg-imperial-primary/10 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-percent text-imperial-primary text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3 text-xl">Discounts on Services</h3>
                            <p class="text-gray-600 text-base">Enjoy up to 25% off on additional services and procedures</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- INTRO SECTION -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Comprehensive Healthcare for Your Family</h2>
                <p class="text-lg text-gray-600 leading-relaxed mb-8">
                    Our membership plans cover healthcare needs of you and your family. The plans allow you to access doctors as many times as you need for a one-time purchase to proactively manage your health, be it yearly or for a certain period. Membership plans also cover a set of tests especially tailored by experienced doctors to meet your healthcare needs.
                </p>
                <div class="flex flex-wrap justify-center gap-6">
                    <div class="flex items-center gap-2 text-gray-700">
                        <i class="fa-solid fa-check-circle text-imperial-primary"></i>
                        <span>No Hidden Costs</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-700">
                        <i class="fa-solid fa-check-circle text-imperial-primary"></i>
                        <span>Family Coverage Available</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-700">
                        <i class="fa-solid fa-check-circle text-imperial-primary"></i>
                        <span>Flexible Duration</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Annual Membership Plans -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">Annual Membership Plans</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Gold Plan -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <div class="relative">
                        <a href="#" class="block h-48 overflow-hidden">
                            <img src="{{ asset('assets/front/images/services/con6.jpeg') }}" alt="Imperial Gold" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </a>
                        <div class="absolute top-4 right-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            Popular
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Imperial Gold Annual Plan</h3>
                        <p class="text-gray-600 text-sm mb-4">Comprehensive coverage for individuals and families</p>
                        <div class="mb-4">
                            <span class="text-3xl font-bold text-imperial-primary">৳ 12,000</span>
                            <span class="text-gray-500 text-sm">/year</span>
                        </div>
                        <ul class="text-sm text-gray-600 mb-4 space-y-2">
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-check text-green-500 text-xs"></i>
                                <span>Unlimited Doctor Visits</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-check text-green-500 text-xs"></i>
                                <span>Annual Health Checkup</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-check text-green-500 text-xs"></i>
                                <span>15% Discount on Additional Services</span>
                            </li>
                        </ul>
                        <div class="mt-auto">
                            <a href="{{ route('membership-details', ['id' => 1]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Silver Plan -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="#" class="block h-48 overflow-hidden">
                        <img src="{{ asset('assets/front/images/services/con7.jpeg') }}" alt="Imperial Silver" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Imperial Silver Annual Plan</h3>
                        <p class="text-gray-600 text-sm mb-4">Essential healthcare coverage for individuals</p>
                        <div class="mb-4">
                            <span class="text-3xl font-bold text-imperial-primary">৳ 8,400</span>
                            <span class="text-gray-500 text-sm">/year</span>
                        </div>
                        <ul class="text-sm text-gray-600 mb-4 space-y-2">
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-check text-green-500 text-xs"></i>
                                <span>Unlimited Doctor Visits</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-check text-green-500 text-xs"></i>
                                <span>Annual Health Checkup</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-check text-green-500 text-xs"></i>
                                <span>10% Discount on Additional Services</span>
                            </li>
                        </ul>
                        <div class="mt-auto">
                            <a href="{{ route('membership-details', ['id' => 2]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Platinum Plan -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <div class="relative">
                        <a href="{{ route('membership-details', ['id' => 3]) }}" class="block h-48 overflow-hidden">
                            <img src="{{ asset('assets/front/images/services/con8.jpg') }}" alt="Imperial Platinum" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </a>
                        <div class="absolute top-4 right-4 bg-purple-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            Premium
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Imperial Platinum Annual Plan</h3>
                        <p class="text-gray-600 text-sm mb-4">Ultimate healthcare protection for families</p>
                        <div class="mb-4">
                            <span class="text-3xl font-bold text-imperial-primary">৳ 21,000</span>
                            <span class="text-gray-500 text-sm">/year</span>
                        </div>
                        <ul class="text-sm text-gray-600 mb-4 space-y-2">
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-check text-green-500 text-xs"></i>
                                <span>Unlimited Doctor Visits</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-check text-green-500 text-xs"></i>
                                <span>Comprehensive Annual Health Checkup</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-check text-green-500 text-xs"></i>
                                <span>25% Discount on Additional Services</span>
                            </li>
                        </ul>
                        <div class="mt-auto">
                            <a href="{{ route('membership-details', ['id' => 10]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Special Plans -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">Special Health Plans</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Prediabetes Plan -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('membership-details', ['id' => 4]) }}" class="block h-44 overflow-hidden">
                        <img src="{{ asset('assets/front/images/services/con9.jpg') }}" alt="Prediabetes Plan" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 mb-1">Prediabetes Plan</h3>
                        <p class="text-gray-500 text-xs mb-3">12 Months</p>
                        <div class="mb-3">
                            <span class="text-xl font-bold text-imperial-primary">৳ 27,000</span>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('membership-details', ['id' => 4]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Diabetes Plan -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('membership-details', ['id' => 5]) }}" class="block h-44 overflow-hidden">
                        <img src="{{ asset('assets/front/images/services/con10.jpg') }}" alt="Diabetes Plan" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 mb-1">Diabetes Plan</h3>
                        <p class="text-gray-500 text-xs mb-3">12 Months</p>
                        <div class="mb-3">
                            <span class="text-xl font-bold text-imperial-primary">৳ 42,000</span>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('membership-details', ['id' => 5]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Cardiac & Hypertension Plan -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('membership-details', ['id' => 6]) }}" class="block h-44 overflow-hidden">
                        <img src="{{ asset('assets/front/images/services/11.jpg') }}" alt="Cardiac & Hypertension" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 mb-1">Cardiac & Hypertension</h3>
                        <p class="text-gray-500 text-xs mb-3">12 Months</p>
                        <div class="mb-3">
                            <span class="text-xl font-bold text-imperial-primary">৳ 42,000</span>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('membership-details', ['id' => 6]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Maternity Plan -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('membership-details', ['id' => 7]) }}" class="block h-44 overflow-hidden">
                        <img src="{{ asset('assets/front/images/services/con12.jpg') }}" alt="Maternity Plan" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 mb-1">Maternity Plan</h3>
                        <p class="text-gray-500 text-xs mb-3">12 Months</p>
                        <div class="mb-3">
                            <span class="text-xl font-bold text-imperial-primary">৳ 40,800</span>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('membership-details', ['id' => 7]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Maternity Plan -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="#" class="block h-44 overflow-hidden">
                        <img src="{{ asset('assets/front/images/services/con12.jpg') }}" alt="Maternity Plan" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 mb-1">Maternity Plan</h3>
                        <p class="text-gray-500 text-xs mb-3">12 Months</p>
                        <div class="mb-3">
                            <span class="text-xl font-bold text-imperial-primary">৳ 40,800</span>
                        </div>
                        <div class="mt-auto">
                            <a href="#" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Video Consultation Plans -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">Amar Jotno Plan (Video Consultation)</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- 12 Months -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('membership-details', ['id' => 8]) }}" class="block h-44 overflow-hidden">
                        <img src="{{ asset('assets/front/images/services/con13.jpg') }}" alt="12 Month Video Consultation" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded">Best Value</span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-1">12 Months Plan</h3>
                        <p class="text-gray-500 text-xs mb-3">Unlimited video consultations</p>
                        <div class="mb-3">
                            <span class="text-2xl font-bold text-imperial-primary">৳ 6,250</span>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('membership-details', ['id' => 8]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- 6 Months -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('membership-details', ['id' => 9]) }}" class="block h-44 overflow-hidden">
                        <img src="{{ asset('assets/front/images/services/con14.jpg') }}" alt="6 Month Video Consultation" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 mb-1">6 Months Plan</h3>
                        <p class="text-gray-500 text-xs mb-3">Unlimited video consultations</p>
                        <div class="mb-3">
                            <span class="text-2xl font-bold text-imperial-primary">৳ 5,050</span>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('membership-details', ['id' => 9]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- 3 Months -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('membership-details', ['id' => 10]) }}" class="block h-44 overflow-hidden">
                        <img src="{{ asset('assets/front/images/services/con16.jpg') }}" alt="3 Month Video Consultation" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 mb-1">3 Months Plan</h3>
                        <p class="text-gray-500 text-xs mb-3">Unlimited video consultations</p>
                        <div class="mb-3">
                            <span class="text-2xl font-bold text-imperial-primary">৳ 3,850</span>
                        </div>
                        <div class="mt-auto">
                            <a href="#" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6 max-w-4xl">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Frequently Asked Questions</h2>
                <p class="text-gray-600">Take a look at the most commonly asked questions. We are here to help.</p>
            </div>

            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <details class="group">
                        <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900">How can I book a membership plan?</span>
                            <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                        </summary>
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                            <p>You can book a membership plan by visiting our center, calling our hotline at 3242, or booking through our online portal.</p>
                        </div>
                    </details>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <details class="group">
                        <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900">Why should I buy a plan if I am not sick?</span>
                            <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                        </summary>
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                            <p>Preventive care is key to maintaining good health. Our plans help you monitor your health proactively, catching potential issues early before they become serious problems.</p>
                        </div>
                    </details>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <details class="group">
                        <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900">Are visiting specialists included in unlimited doctor access?</span>
                            <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                        </summary>
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                            <p>Access to specialists depends on the specific plan. Please refer to the details section of each membership card for complete information about included services.</p>
                        </div>
                    </details>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <details class="group">
                        <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900">What are excluded from the discount on additional services?</span>
                            <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                        </summary>
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                            <p>Certain specialized procedures, external medications, and packages may be excluded from the discount. Please check the specific terms and conditions of your plan.</p>
                        </div>
                    </details>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <details class="group">
                        <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900">Can I upgrade my membership plan?</span>
                            <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                        </summary>
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                            <p>Yes, you can upgrade your membership plan at any time. The price difference will be calculated based on the remaining tenure of your current plan.</p>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </section>

@endsection
