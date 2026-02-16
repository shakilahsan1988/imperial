@extends('layouts.front')

@section('title', 'Health Check - Imperial Health Bangladesh')

@section('content')

    <!-- HERO SECTION -->
    <section class="relative h-[50vh] min-h-[350px]">
        <img src="{{ asset('assets/front/images/healthcheck/1.jpg') }}" 
             alt="Health Check" 
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 to-slate-900/40"></div>
        <div class="absolute inset-0 flex items-center">
            <div class="container mx-auto px-6">
                <div class="max-w-2xl">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Health Checks & Packages</h1>
                    <p class="text-lg text-white/90">Convenient, affordable, and high-quality healthcare for everyone</p>
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
                            <i class="fa-solid fa-award text-imperial-primary text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3 text-xl">Quality Assured</h3>
                            <p class="text-gray-600 text-base">Comprehensive health checks with international quality standards</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl p-10 shadow-xl border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                    <div class="flex items-start gap-6">
                        <div class="w-20 h-20 rounded-full bg-imperial-primary/10 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-tags text-imperial-primary text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3 text-xl">Affordable Pricing</h3>
                            <p class="text-gray-600 text-base">Health packages tailored to your budget and needs</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl p-10 shadow-xl border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                    <div class="flex items-start gap-6">
                        <div class="w-20 h-20 rounded-full bg-imperial-primary/10 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-house-medical text-imperial-primary text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3 text-xl">Home Service</h3>
                            <p class="text-gray-600 text-base">Sample collection from the comfort of your home</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Women Health Checks -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">Women Health Checks</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 1]) }}" class="block h-52 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/2.jpg') }}" alt="Her Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Her Health Check (Below 40 Years)</h3>
                        <p class="text-2xl font-bold text-imperial-primary mb-4">৳ 13,800</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 1]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Card 2 -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 2]) }}" class="block h-52 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/3.jpg') }}" alt="Her Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Her Health Check (40 to 65 Years)</h3>
                        <p class="text-2xl font-bold text-imperial-primary mb-4">৳ 22,200</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 2]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Card 3 -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 3]) }}" class="block h-52 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/4.jpg') }}" alt="Her Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Her Health Check (Above 65 Years)</h3>
                        <p class="text-2xl font-bold text-imperial-primary mb-4">৳ 26,400</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 3]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Card 4 -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 4]) }}" class="block h-52 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/8.jpg') }}" alt="Her Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Women's Cardiac Checkup</h3>
                        <p class="text-2xl font-bold text-imperial-primary mb-4">৳ 18,500</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 4]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Card 5 -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 5]) }}" class="block h-52 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/9.jpg') }}" alt="Her Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Women's Diabetes Check</h3>
                        <p class="text-2xl font-bold text-imperial-primary mb-4">৳ 15,000</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 5]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Card 6 -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 6]) }}" class="block h-52 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/10.jpg') }}" alt="Her Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Pregnancy Checkup Package</h3>
                        <p class="text-2xl font-bold text-imperial-primary mb-4">৳ 12,500</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 6]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Card 7 -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 7]) }}" class="block h-52 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/11.jpg') }}" alt="Her Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Women's Wellness Package</h3>
                        <p class="text-2xl font-bold text-imperial-primary mb-4">৳ 20,000</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 7]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Men Health Checks -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">Men Health Checks</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 8]) }}" class="block h-52 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/5.jpg') }}" alt="His Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">His Health Check (Below 40 Years)</h3>
                        <p class="text-2xl font-bold text-imperial-primary mb-4">৳ 13,800</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 8]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Card 2 -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 9]) }}" class="block h-52 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/6.jpg') }}" alt="His Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">His Health Check (40 to 65 Years)</h3>
                        <p class="text-2xl font-bold text-imperial-primary mb-4">৳ 22,200</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 9]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Card 3 -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 10]) }}" class="block h-52 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/7.jpg') }}" alt="His Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">His Health Check (Above 65 Years)</h3>
                        <p class="text-2xl font-bold text-imperial-primary mb-4">৳ 26,400</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 10]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Card 4 -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 11]) }}" class="block h-52 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/8.jpg') }}" alt="His Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Men's Executive Checkup</h3>
                        <p class="text-2xl font-bold text-imperial-primary mb-4">৳ 25,000</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 11]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Special Health Checks -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">Special Health Checks</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Full Body -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 12]) }}" class="block h-52 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/8.jpg') }}" alt="Full Body Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Full Body Health Check</h3>
                        <p class="text-2xl font-bold text-imperial-primary mb-4">৳ 9,900</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 12]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Home Health -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 13]) }}" class="block h-52 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/9.jpg') }}" alt="Home Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Home Health Check</h3>
                        <p class="text-2xl font-bold text-imperial-primary mb-4">৳ 8,900</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 13]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Cardiac -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 14]) }}" class="block h-52 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/9.jpg') }}" alt="Cardiac Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Comprehensive Cardiac and Hypertension</h3>
                        <p class="text-2xl font-bold text-imperial-primary mb-4">৳ 24,900</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 14]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Diabetes -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 15]) }}" class="block h-52 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/10.jpg') }}" alt="Diabetes Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Comprehensive Diabetes Health Check</h3>
                        <p class="text-2xl font-bold text-imperial-primary mb-4">৳ 25,800</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 15]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Child Health -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 16]) }}" class="block h-52 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/11.jpg') }}" alt="Child Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold mb-2 text-gray-900">Child Health Check (2 to 16 Years)</h3>
                        <p class="text-2xl font-bold text-imperial-primary mb-4">৳ 6,200</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 16]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- All Packages Table -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">All Packages</h2>
                <div class="relative w-full md:w-72">
                    <input type="text" placeholder="Search packages..." class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-imperial-primary focus:ring-1 focus:ring-imperial-primary transition">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-sm bg-white health-check-table">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="p-4 font-semibold text-gray-700 border-b border-gray-200">Name</th>
                            <th class="p-4 font-semibold text-gray-700 border-b border-gray-200 hidden md:table-cell">Category</th>
                            <th class="p-4 font-semibold text-gray-700 border-b border-gray-200">Price</th>
                            <th class="p-4 font-semibold text-gray-700 border-b border-gray-200 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4">
                                <a href="#" class="font-semibold text-gray-900 hover:text-imperial-primary">Acne Screening</a>
                            </td>
                            <td class="p-4 hidden md:table-cell text-gray-600">Packages</td>
                            <td class="p-4 font-bold text-gray-900">৳ 2,800</td>
                            <td class="p-4 text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4">
                                <a href="#" class="font-semibold text-gray-900 hover:text-imperial-primary">ActiveU</a>
                            </td>
                            <td class="p-4 hidden md:table-cell text-gray-600">Packages</td>
                            <td class="p-4 font-bold text-gray-900">৳ 3,990</td>
                            <td class="p-4 text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4">
                                <a href="#" class="font-semibold text-gray-900 hover:text-imperial-primary">Cancer Screening (Female)</a>
                            </td>
                            <td class="p-4 hidden md:table-cell text-gray-600">Packages</td>
                            <td class="p-4 font-bold text-gray-900">৳ 14,900</td>
                            <td class="p-4 text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4">
                                <a href="#" class="font-semibold text-gray-900 hover:text-imperial-primary">Cancer Screening (Male)</a>
                            </td>
                            <td class="p-4 hidden md:table-cell text-gray-600">Packages</td>
                            <td class="p-4 font-bold text-gray-900">৳ 10,600</td>
                            <td class="p-4 text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4">
                                <a href="#" class="font-semibold text-gray-900 hover:text-imperial-primary">Dengue Test Package</a>
                            </td>
                            <td class="p-4 hidden md:table-cell text-gray-600">Packages</td>
                            <td class="p-4 font-bold text-gray-900">৳ 1,800</td>
                            <td class="p-4 text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center items-center mt-8 gap-2">
                <button class="w-10 h-10 rounded-lg border border-gray-200 text-gray-400 flex items-center justify-center hover:border-imperial-primary hover:text-imperial-primary transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    <i class="fa-solid fa-chevron-left text-sm"></i>
                </button>
                <button class="w-10 h-10 rounded-lg bg-imperial-primary text-white flex items-center justify-center text-sm font-medium">1</button>
                <button class="w-10 h-10 rounded-lg border border-gray-200 text-gray-600 flex items-center justify-center text-sm font-medium hover:border-imperial-primary hover:text-imperial-primary transition-colors">2</button>
                <button class="w-10 h-10 rounded-lg border border-gray-200 text-gray-600 flex items-center justify-center hover:border-imperial-primary hover:text-imperial-primary transition-colors">
                    <i class="fa-solid fa-chevron-right text-sm"></i>
                </button>
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
                            <span class="font-semibold text-gray-900">What is a Health Check?</span>
                            <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                        </summary>
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                            <p>A health check is a comprehensive examination of your current physical condition. It involves a series of tests and screenings to detect potential health issues before they become symptoms.</p>
                        </div>
                    </details>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <details class="group">
                        <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900">How does a health check help me?</span>
                            <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                        </summary>
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                            <p>Regular health checks help in early detection of diseases, increase the chances for effective treatment, and allow you to track your health progress over time.</p>
                        </div>
                    </details>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <details class="group">
                        <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900">How will I receive my reports?</span>
                            <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                        </summary>
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                            <p>Reports are typically delivered digitally via email or through a secure patient portal within 24-48 hours of the tests being completed.</p>
                        </div>
                    </details>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <details class="group">
                        <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900">I still haven't received my reports.</span>
                            <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                        </summary>
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                            <p>If you haven't received your reports within the expected timeframe, please contact our support team immediately so we can assist you.</p>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </section>

@endsection
