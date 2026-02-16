@extends('layouts.front')

@section('title', 'Package Details - Imperial Health Bangladesh')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative h-[40vh] min-h-[300px]">
        <img src="{{ asset('assets/front/images/healthcheck/1.jpg') }}" 
             alt="Package Details" 
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 to-slate-900/40"></div>
        <div class="absolute inset-0 flex items-center">
            <div class="container mx-auto px-6">
                <div class="max-w-2xl">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Package Details</h1>
                    <p class="text-lg text-white/90">Comprehensive health packages tailored to your needs</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PACKAGE DETAILS -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                
                <!-- Package Image -->
                <div class="relative rounded-2xl overflow-hidden shadow-xl">
                    <img src="{{ asset('assets/front/images/healthcheck/2.jpg') }}" 
                         alt="Health Package" 
                         class="w-full h-[400px] object-cover">
                    <div class="absolute top-4 right-4 bg-imperial-primary text-white px-4 py-2 rounded-full font-semibold">
                        Recommended
                    </div>
                </div>

                <!-- Package Info -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-3 py-1 bg-imperial-primary/10 text-imperial-primary text-sm font-medium rounded-full">
                            Women Health
                        </span>
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-medium rounded-full">
                            Available
                        </span>
                    </div>

                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Her Health Check (Below 40 Years)</h2>
                    
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-imperial-primary">৳ 13,800</span>
                        <span class="text-gray-500 line-through ml-3">৳ 18,000</span>
                        <span class="ml-2 text-sm bg-red-100 text-red-600 px-2 py-1 rounded">23% OFF</span>
                    </div>

                    <p class="text-gray-600 mb-8 leading-relaxed">
                        A comprehensive health checkup designed for women under 40 years of age. This package includes all essential tests to assess your overall health status and detect any potential issues early.
                    </p>

                    <!-- Quick Info Cards -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-8">
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <i class="fa-solid fa-clock text-imperial-primary text-2xl mb-2"></i>
                            <p class="text-sm text-gray-600">Duration</p>
                            <p class="font-semibold text-gray-900">4-6 Hours</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <i class="fa-solid fa-file-medical text-imperial-primary text-2xl mb-2"></i>
                            <p class="text-sm text-gray-600">Reports</p>
                            <p class="font-semibold text-gray-900">24-48 Hours</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <i class="fa-solid fa-user-doctor text-imperial-primary text-2xl mb-2"></i>
                            <p class="text-sm text-gray-600">Fasting</p>
                            <p class="font-semibold text-gray-900">10-12 Hours</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button class="flex-1 bg-imperial-primary hover:bg-imperial-dark text-white py-4 px-8 rounded-xl font-semibold transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-calendar-check"></i>
                            Book Now
                        </button>
                        <button class="flex-1 border-2 border-imperial-primary text-imperial-primary hover:bg-imperial-primary hover:text-white py-4 px-8 rounded-xl font-semibold transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-phone"></i>
                            Call 3242
                        </button>
                    </div>

                    <!-- Home Service Badge -->
                    <div class="mt-6 flex items-center gap-2 text-gray-600">
                        <i class="fa-solid fa-house-medical text-imperial-primary"></i>
                        <span>Home sample collection available</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTS INCLUDED -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Tests Included</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Test Item -->
                <div class="bg-white rounded-xl p-4 flex items-center gap-3 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Complete Blood Count (CBC)</h4>
                        <p class="text-sm text-gray-500">Blood</p>
                    </div>
                </div>

                <!-- Test Item -->
                <div class="bg-white rounded-xl p-4 flex items-center gap-3 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Lipid Profile</h4>
                        <p class="text-sm text-gray-500">Blood</p>
                    </div>
                </div>

                <!-- Test Item -->
                <div class="bg-white rounded-xl p-4 flex items-center gap-3 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Liver Function Test</h4>
                        <p class="text-sm text-gray-500">Blood</p>
                    </div>
                </div>

                <!-- Test Item -->
                <div class="bg-white rounded-xl p-4 flex items-center gap-3 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Kidney Function Test</h4>
                        <p class="text-sm text-gray-500">Blood</p>
                    </div>
                </div>

                <!-- Test Item -->
                <div class="bg-white rounded-xl p-4 flex items-center gap-3 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Blood Glucose (Fasting)</h4>
                        <p class="text-sm text-gray-500">Blood</p>
                    </div>
                </div>

                <!-- Test Item -->
                <div class="bg-white rounded-xl p-4 flex items-center gap-3 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Thyroid Profile</h4>
                        <p class="text-sm text-gray-500">Blood</p>
                    </div>
                </div>

                <!-- Test Item -->
                <div class="bg-white rounded-xl p-4 flex items-center gap-3 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Urine Routine</h4>
                        <p class="text-sm text-gray-500">Urine</p>
                    </div>
                </div>

                <!-- Test Item -->
                <div class="bg-white rounded-xl p-4 flex items-center gap-3 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">ECG</h4>
                        <p class="text-sm text-gray-500">Heart</p>
                    </div>
                </div>

                <!-- Test Item -->
                <div class="bg-white rounded-xl p-4 flex items-center gap-3 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Chest X-Ray</h4>
                        <p class="text-sm text-gray-500">Imaging</p>
                    </div>
                </div>

                <!-- Test Item -->
                <div class="bg-white rounded-xl p-4 flex items-center gap-3 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Ultrasound (Whole Abdomen)</h4>
                        <p class="text-sm text-gray-500">Imaging</p>
                    </div>
                </div>

                <!-- Test Item -->
                <div class="bg-white rounded-xl p-4 flex items-center gap-3 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Pap Smear</h4>
                        <p class="text-sm text-gray-500">Cytology</p>
                    </div>
                </div>

                <!-- Test Item -->
                <div class="bg-white rounded-xl p-4 flex items-center gap-3 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Consultation</h4>
                        <p class="text-sm text-gray-500">General Physician</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PREPARATION & FAQ -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- Preparation -->
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-6">How to Prepare</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-imperial-primary text-white flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fa-solid fa-1 text-xs"></i>
                            </div>
                            <p class="text-gray-600">Fast for 10-12 hours before the test. Only water is allowed.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-imperial-primary text-white flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fa-solid fa-2 text-xs"></i>
                            </div>
                            <p class="text-gray-600">Avoid smoking and alcohol 24 hours before the test.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-imperial-primary text-white flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fa-solid fa-3 text-xs"></i>
                            </div>
                            <p class="text-gray-600">Bring all previous medical reports if any.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-imperial-primary text-white flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fa-solid fa-4 text-xs"></i>
                            </div>
                            <p class="text-gray-600">Wear comfortable loose-fitting clothes.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ -->
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h3>
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-xl p-5">
                            <h4 class="font-semibold text-gray-900 mb-2">Do I need to book an appointment?</h4>
                            <p class="text-gray-600 text-sm">Yes, we recommend booking an appointment for smoother service. You can book online or call 3242.</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5">
                            <h4 class="font-semibold text-gray-900 mb-2">How long does the whole process take?</h4>
                            <p class="text-gray-600 text-sm">The entire process takes approximately 4-6 hours depending on the tests included.</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5">
                            <h4 class="font-semibold text-gray-900 mb-2">When will I receive my reports?</h4>
                            <p class="text-gray-600 text-sm">Reports are typically ready within 24-48 hours. You can collect them from our center or receive them via email.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- RELATED PACKAGES -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Packages</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Package 1 -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 2]) }}" class="block h-48 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/3.jpg') }}" alt="Her Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 mb-2">Her Health Check (40 to 65 Years)</h3>
                        <p class="text-xl font-bold text-imperial-primary mb-3">৳ 22,200</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 2]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Package 2 -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 3]) }}" class="block h-48 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/4.jpg') }}" alt="Her Health Check" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 mb-2">Her Health Check (Above 65 Years)</h3>
                        <p class="text-xl font-bold text-imperial-primary mb-3">৳ 26,400</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 3]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Package 3 -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('package-details', ['id' => 4]) }}" class="block h-48 overflow-hidden">
                        <img src="{{ asset('assets/front/images/healthcheck/8.jpg') }}" alt="Women's Cardiac Checkup" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 mb-2">Women's Cardiac Checkup</h3>
                        <p class="text-xl font-bold text-imperial-primary mb-3">৳ 18,500</p>
                        <div class="mt-auto">
                            <a href="{{ route('package-details', ['id' => 4]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection
