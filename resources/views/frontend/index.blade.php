@extends('layouts.front')

@section('title', 'Home - Imperial Health Bangladesh')

@section('content')
    
    @include('frontend.includes.slider')

    <!-- ========================================== -->
    <!-- STATS SECTION                              -->
    <!-- ========================================== -->
    <section class="py-16 md:py-24 bg-white section-divider">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 items-center">
                <!-- Text Left -->
                <div class="w-full md:w-5/12 text-center md:text-left reveal">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">About <span class="text-gradient">imperial</span></h2>
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed">imperial exists to provide a better patient experience. We are a one-stop-shop for your health, offering caring doctors, world-class diagnostics, in-house pharmacy, and much more.</p>
                </div>
                
                <!-- Stats Right -->
                <div class="w-full md:w-7/12 grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="stat-card p-6 rounded-xl card-shadow reveal" style="transition-delay: 0ms;">
                        <div class="text-4xl md:text-5xl font-bold text-gradient mb-2 counter" data-target="27">0</div>
                        <h3 class="text-lg sm:text-xl font-medium text-gray-700">Departments</h3>
                    </div>
                    <div class="stat-card p-6 rounded-xl card-shadow reveal" style="transition-delay: 100ms;">
                        <div class="text-4xl md:text-5xl font-bold text-gradient mb-2 counter" data-target="84">0</div>
                        <h3 class="text-lg sm:text-xl font-medium text-gray-700">Doctors</h3>
                    </div>
                    <div class="stat-card p-6 rounded-xl card-shadow reveal" style="transition-delay: 200ms;">
                        <div class="text-4xl md:text-5xl font-bold text-gradient mb-2"><span class="counter" data-target="914">0</span>K</div>
                        <h3 class="text-lg sm:text-xl font-medium text-gray-700">Patients Served</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 1: TEXT LEFT / IMAGE RIGHT         -->
    <!-- Mobile: Image Top / Desktop: Text Left     -->
    <!-- ========================================== -->
    <section class="bg-gray-50 section-bg-pattern">
        <div class="container mx-auto px-4 sm:px-6 py-16 md:py-24">
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 items-center">
                
                <!-- Text Content (Order 2 on mobile, 1 on desktop) -->
                <div class="w-full md:w-5/12 order-2 md:order-1 reveal-left">
                    <h4 class="text-xs md:text-sm font-semibold tracking-wider uppercase mb-3 text-imperial-primary">Why imperial</h4>
                    <h2 class="text-2xl md:text-4xl font-bold mb-5 leading-tight text-gray-900">Doctors Who Listen</h2>
                    <p class="text-base md:text-lg leading-relaxed mb-4 text-gray-600">Our doctors spend time to get to know you and your health. They treat you with the respect and empathy you deserve.</p>
                    <p class="text-base md:text-lg leading-relaxed text-gray-600">Years of local and international experience to give you advice you can rely on.</p>
                </div>

                <!-- Image (Order 1 on mobile, 2 on desktop) -->
                <div class="w-full md:w-7/12 order-1 md:order-2 reveal-right">
                    <div class="img-zoom-container rounded-2xl shadow-2xl">
                        <img src="{{ asset('assets/front/images/index/why-imperial.jpg') }}" 
                             onerror="this.src='https://picsum.photos/seed/doclist/800/600'"
                             alt="Doctors Listening" 
                             class="w-full h-auto rounded-2xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 2: IMAGE LEFT / TEXT RIGHT          -->
    <!-- ========================================== -->
    <section class="py-16 md:py-24 bg-white section-bg-pattern">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 items-center">
                
                <!-- Image Left (First in DOM, so Top on Mobile) -->
                <div class="w-full md:w-1/2 reveal-left">
                    <div class="img-zoom-container rounded-2xl shadow-2xl">
                        <img src="{{ asset('assets/front/images/index/diagnosis.jpeg') }}" 
                             onerror="this.src='https://picsum.photos/seed/lab/800/600'"
                             alt="Diagnosis Lab" 
                             class="w-full h-auto rounded-2xl">
                    </div>
                </div>

                <!-- Text Right -->
                <div class="w-full md:w-1/2 reveal-right">
                    <h4 class="text-xs md:text-sm font-semibold text-imperial-primary tracking-wider uppercase mb-3">Why imperial</h4>
                    <h2 class="text-2xl md:text-4xl font-bold mb-5 text-gray-900 leading-tight">Diagnosis You Can Trust</h2>
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed mb-6">You can depend on the quality of our diagnosis and test results. Our laboratories are set up according to international standards and protocols.</p>
                    
                    <a href="#" class="link-arrow text-imperial-primary font-bold flex items-center gap-2 group text-base md:text-lg focus-ring px-2 py-1 rounded">
                        Our services 
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform text-sm"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 3: TEXT LEFT / IMAGE RIGHT          -->
    <!-- ========================================== -->
    <section class="py-16 md:py-24 bg-gray-50 section-bg-pattern">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 items-center">
                
                <!-- Text Left -->
                <div class="w-full md:w-5/12 order-2 md:order-1 reveal-left">
                    <h4 class="text-xs md:text-sm font-semibold tracking-wider uppercase mb-3 text-imperial-primary">Why imperial</h4>
                    <h2 class="text-2xl md:text-4xl font-bold mb-5 leading-tight text-gray-900">Healthcare Anytime, Anywhere</h2>
                    <p class="text-base md:text-lg leading-relaxed text-gray-600">We use technology to make healthcare accessible to you no matter where you are. Access your health data, book appointments, and view records anywhere.</p>
                </div>

                <!-- Image Right -->
                <div class="w-full md:w-7/12 order-1 md:order-2 reveal-right">
                    <div class="img-zoom-container rounded-2xl shadow-2xl">
                        <img src="{{ asset('assets/front/images/index/health-care-anytime.jpg') }}" 
                             onerror="this.src='https://picsum.photos/seed/tech/800/600'"
                             alt="Digital Health" 
                             class="w-full h-auto rounded-2xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 4: FLOATING LAYOUT                  -->
    <!-- ========================================== -->
    <section class="py-16 md:py-24 text-white relative overflow-hidden min-h-[400px] flex items-center">
        <div class="container mx-auto px-4 sm:px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                
                <!-- Text Card -->
                <div class="md:col-span-7 bg-white text-slate-900 p-8 md:p-12 rounded-2xl shadow-2xl relative z-20 w-full mx-auto md:mx-0 reveal-left">
                    <h4 class="text-xs md:text-sm font-semibold text-imperial-primary tracking-wider uppercase mb-3">Why imperial</h4>
                    <h2 class="text-2xl md:text-4xl font-bold mb-5 leading-tight">Take A Tour Of Our Facility</h2>
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed mb-6">Visit us at our flagship facility in Banani, Dhaka, and find out what makes us different.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#" class="btn-primary text-white px-8 py-3.5 rounded-lg font-bold hover:opacity-90 transition text-center inline-block">Book a guided tour</a>
                    </div>
                </div>

                <!-- Spacer (Desktop Only) -->
                <div class="hidden md:block md:col-span-5"></div>
            </div>

            <!-- Background Image (Desktop Only) -->
            <div class="absolute right-0 top-0 h-full w-1/2 z-0 hidden md:block">
                <div class="img-zoom-container h-full float-animation">
                    <img src="{{ asset('assets/front/images/index/tour.jpg') }}" 
                         onerror="this.src='https://picsum.photos/seed/facility/800/600'"
                         alt="Facility Tour" 
                         class="w-full h-full object-cover rounded-l-2xl">
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 5: IMAGE LEFT / TEXT RIGHT          -->
    <!-- ========================================== -->
    <section class="py-16 md:py-24 bg-white section-bg-pattern">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 items-center">
                
                <!-- Image Left -->
                <div class="w-full md:w-1/2 reveal-left">
                    <div class="img-zoom-container rounded-2xl shadow-2xl">
                        <!-- Applied Responsive Picture Logic Here -->
                        <picture>
                            <!-- Mobile Image (Max 480px) -->
                            <source media="(max-width:480px)" 
                                    srcset="{{ asset('assets/front/images/index/family-care.jpg') }}" 
                                    type="image/webp">
                            <source media="(max-width:480px)" 
                                    srcset="{{ asset('assets/front/images/index/family-care.jpg') }}">
                            
                            <!-- Tablet/Desktop Image (Max 1024px) -->
                            <source media="(max-width:1024px)" 
                                    srcset="{{ asset('assets/front/images/index/family-care.jpg') }}" 
                                    type="image/webp">
                            <source media="(max-width:1024px)" 
                                    srcset="{{ asset('assets/front/images/index/family-care.jpg') }}">
                            
                            <!-- Default Source -->
                            <source srcset="{{ asset('assets/front/images/index/family-care.jpg') }}">
                            
                            <!-- Fallback Image -->
                            <img src="{{ asset('assets/front/images/index/family-care.jpg') }}" 
                                 alt="We Care For You Like Family" 
                                 loading="lazy"
                                 class="w-full h-auto rounded-2xl">
                        </picture>
                    </div>
                </div>

                <!-- Text Right -->
                <div class="w-full md:w-1/2 reveal-right">
                    <h4 class="text-xs md:text-sm font-semibold text-imperial-primary tracking-wider uppercase mb-3">Why imperial</h4>
                    <h2 class="text-2xl md:text-4xl font-bold mb-5 text-gray-900 leading-tight">We Care For You Like Family</h2>
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed mb-6">Open every day from 8AM - 10PM. Our dedicated team ensures you feel at home while receiving the best medical attention.</p>
                    
                    <a href="#" class="btn-outline border-2 border-imperial-primary text-imperial-primary px-8 py-3 rounded-lg font-bold hover:text-white transition text-center inline-block">Book Appointment</a>
                </div>
            </div>
        </div>
    </section>

@endsection