@extends('layouts.front')

@section('title', 'Membership Details - Imperial Health Bangladesh')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative h-[40vh] min-h-[300px]">
        <img src="{{ asset('assets/front/images/services/con6.jpeg') }}" 
             alt="Membership Plan" 
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 to-slate-900/40"></div>
        <div class="absolute inset-0 flex items-center">
            <div class="container mx-auto px-6">
                <div class="max-w-2xl">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Imperial Gold Annual Plan</h1>
                    <p class="text-lg text-white/90">Comprehensive healthcare coverage for you and your family</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PLAN DETAILS -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                
                <!-- Plan Image -->
                <div class="relative rounded-2xl overflow-hidden shadow-xl">
                    <img src="{{ asset('assets/front/images/services/con6.jpeg') }}" 
                         alt="Imperial Gold Membership" 
                         class="w-full h-[400px] object-cover">
                    <div class="absolute top-4 right-4 bg-yellow-500 text-white px-4 py-2 rounded-full font-semibold">
                        Most Popular
                    </div>
                </div>

                <!-- Plan Info -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-3 py-1 bg-imperial-primary/10 text-imperial-primary text-sm font-medium rounded-full">
                            Annual Plan
                        </span>
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-medium rounded-full">
                            Active
                        </span>
                    </div>

                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Imperial Gold Annual Membership Plan</h2>
                    
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-imperial-primary">৳ 12,000</span>
                        <span class="text-gray-500 line-through ml-3">৳ 15,000</span>
                        <span class="ml-2 text-sm bg-red-100 text-red-600 px-2 py-1 rounded">20% OFF</span>
                    </div>

                    <p class="text-gray-600 mb-8 leading-relaxed">
                        The Imperial Gold Annual Plan provides comprehensive healthcare coverage for individuals and families. Enjoy unlimited doctor visits, annual health checkups, and discounts on additional services throughout the year.
                    </p>

                    <!-- Quick Info Cards -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-8">
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <i class="fa-solid fa-calendar text-imperial-primary text-2xl mb-2"></i>
                            <p class="text-sm text-gray-600">Duration</p>
                            <p class="font-semibold text-gray-900">12 Months</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <i class="fa-solid fa-user-doctor text-imperial-primary text-2xl mb-2"></i>
                            <p class="text-sm text-gray-600">Doctor Visits</p>
                            <p class="font-semibold text-gray-900">Unlimited</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <i class="fa-solid fa-percent text-imperial-primary text-2xl mb-2"></i>
                            <p class="text-sm text-gray-600">Discount</p>
                            <p class="font-semibold text-gray-900">15% Off</p>
                        </div>
                    </div>

                    <!-- Key Features -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Key Features</h3>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-check text-green-600 text-xs"></i>
                                </div>
                                <span class="text-gray-700">Unlimited consultations with general physicians</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-check text-green-600 text-xs"></i>
                                </div>
                                <span class="text-gray-700">Annual comprehensive health checkup</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-check text-green-600 text-xs"></i>
                                </div>
                                <span class="text-gray-700">15% discount on all additional services</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-check text-green-600 text-xs"></i>
                                </div>
                                <span class="text-gray-700">Priority appointment booking</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-check text-green-600 text-xs"></i>
                                </div>
                                <span class="text-gray-700">Dedicated customer support</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button class="flex-1 bg-imperial-primary hover:bg-imperial-dark text-white py-4 px-8 rounded-xl font-semibold transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cart-plus"></i>
                            Buy Now
                        </button>
                        <button class="flex-1 border-2 border-imperial-primary text-imperial-primary hover:bg-imperial-primary hover:text-white py-4 px-8 rounded-xl font-semibold transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-phone"></i>
                            Call 3242
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- WHAT'S INCLUDED -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">What's Included</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Included Item -->
                <div class="bg-white rounded-xl p-6 shadow-sm flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-stethoscope text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">Unlimited Doctor Visits</h4>
                        <p class="text-sm text-gray-500">Consult with general physicians as many times as needed</p>
                    </div>
                </div>

                <!-- Included Item -->
                <div class="bg-white rounded-xl p-6 shadow-sm flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-heart-pulse text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">Annual Health Checkup</h4>
                        <p class="text-sm text-gray-500">Comprehensive tests including CBC, Lipid Profile, and more</p>
                    </div>
                </div>

                <!-- Included Item -->
                <div class="bg-white rounded-xl p-6 shadow-sm flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-user-md text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">Specialist Consultations</h4>
                        <p class="text-sm text-gray-500">Access to specialist doctors when needed</p>
                    </div>
                </div>

                <!-- Included Item -->
                <div class="bg-white rounded-xl p-6 shadow-sm flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-flask text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">Lab Tests Discount</h4>
                        <p class="text-sm text-gray-500">15% off on all additional laboratory tests</p>
                    </div>
                </div>

                <!-- Included Item -->
                <div class="bg-white rounded-xl p-6 shadow-sm flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-house-medical text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">Home Service</h4>
                        <p class="text-sm text-gray-500">Free home sample collection for tests</p>
                    </div>
                </div>

                <!-- Included Item -->
                <div class="bg-white rounded-xl p-6 shadow-sm flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-headset text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">24/7 Support</h4>
                        <p class="text-sm text-gray-500">Dedicated customer support team</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TERMS & CONDITIONS -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Terms & Conditions</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- What's Not Covered -->
                <div class="bg-red-50 rounded-2xl p-8">
                    <h3 class="text-lg font-bold text-red-700 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-xmark"></i>
                        What's Not Covered
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-gray-700">
                            <i class="fa-solid fa-circle-xmark text-red-500 mt-1"></i>
                            <span>Hospitalization and surgical procedures</span>
                        </li>
                        <li class="flex items-start gap-3 text-gray-700">
                            <i class="fa-solid fa-circle-xmark text-red-500 mt-1"></i>
                            <span>Medications and prescriptions</span>
                        </li>
                        <li class="flex items-start gap-3 text-gray-700">
                            <i class="fa-solid fa-circle-xmark text-red-500 mt-1"></i>
                            <span>Dental treatments</span>
                        </li>
                        <li class="flex items-start gap-3 text-gray-700">
                            <i class="fa-solid fa-circle-xmark text-red-500 mt-1"></i>
                            <span>Cosmetic procedures</span>
                        </li>
                        <li class="flex items-start gap-3 text-gray-700">
                            <i class="fa-solid fa-circle-xmark text-red-500 mt-1"></i>
                            <span>Maternity and childbirth</span>
                        </li>
                    </ul>
                </div>

                <!-- Important Notes -->
                <div class="bg-blue-50 rounded-2xl p-8">
                    <h3 class="text-lg font-bold text-blue-700 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-info-circle"></i>
                        Important Notes
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-gray-700">
                            <i class="fa-solid fa-check text-blue-500 mt-1"></i>
                            <span>Plan is valid for 12 months from date of purchase</span>
                        </li>
                        <li class="flex items-start gap-3 text-gray-700">
                            <i class="fa-solid fa-check text-blue-500 mt-1"></i>
                            <span>Cannot be transferred to another person</span>
                        </li>
                        <li class="flex items-start gap-3 text-gray-700">
                            <i class="fa-solid fa-check text-blue-500 mt-1"></i>
                            <span>Refund available within 7 days if no services used</span>
                        </li>
                        <li class="flex items-start gap-3 text-gray-700">
                            <i class="fa-solid fa-check text-blue-500 mt-1"></i>
                            <span>Family members can be added at additional cost</span>
                        </li>
                        <li class="flex items-start gap-3 text-gray-700">
                            <i class="fa-solid fa-check text-blue-500 mt-1"></i>
                            <span>Appointment booking subject to availability</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6 max-w-4xl">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Frequently Asked Questions</h2>
            
            <div class="space-y-4">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <details class="group">
                        <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900">How do I activate my membership?</span>
                            <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                        </summary>
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                            <p>Once you purchase the plan, you will receive an activation code. Visit our center or call 3242 to activate your membership and start using the benefits immediately.</p>
                        </div>
                    </details>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <details class="group">
                        <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900">Can I add family members to my plan?</span>
                            <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                        </summary>
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                            <p>Yes, you can add family members at an additional cost. Each family member will receive their own membership card and benefits.</p>
                        </div>
                    </details>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <details class="group">
                        <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-900">What happens after 12 months?</span>
                            <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                        </summary>
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                            <p>Your membership will expire after 12 months. You can renew it at the then-current price to continue enjoying the benefits.</p>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </section>

    <!-- RELATED PLANS -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Plans</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Silver Plan -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('membership-details', ['id' => 2]) }}" class="block h-44 overflow-hidden">
                        <img src="{{ asset('assets/front/images/services/con7.jpeg') }}" alt="Silver Plan" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 mb-1">Imperial Silver Annual Plan</h3>
                        <p class="text-gray-500 text-xs mb-3">Essential coverage</p>
                        <div class="mb-3">
                            <span class="text-xl font-bold text-imperial-primary">৳ 8,400</span>
                            <span class="text-gray-500 text-sm">/year</span>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('membership-details', ['id' => 2]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Platinum Plan -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('membership-details', ['id' => 3]) }}" class="block h-44 overflow-hidden">
                        <img src="{{ asset('assets/front/images/services/con8.jpg') }}" alt="Platinum Plan" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 mb-1">Imperial Platinum Annual Plan</h3>
                        <p class="text-gray-500 text-xs mb-3">Premium coverage</p>
                        <div class="mb-3">
                            <span class="text-xl font-bold text-imperial-primary">৳ 21,000</span>
                            <span class="text-gray-500 text-sm">/year</span>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('membership-details', ['id' => 3]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Video Consultation -->
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="{{ route('membership-details', ['id' => 4]) }}" class="block h-44 overflow-hidden">
                        <img src="{{ asset('assets/front/images/services/con13.jpg') }}" alt="Video Consultation" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 mb-1">Amar Jotno Plan</h3>
                        <p class="text-gray-500 text-xs mb-3">Video consultation</p>
                        <div class="mb-3">
                            <span class="text-xl font-bold text-imperial-primary">৳ 6,250</span>
                            <span class="text-gray-500 text-sm">/year</span>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('membership-details', ['id' => 4]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection
