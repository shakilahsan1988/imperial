@extends('layouts.front')

@section('title', 'Home - Imperial Health Bangladesh')

@section('content')
    
    @include('frontend.includes.slider')

    <!-- ========================================== -->
    <!-- STATS SECTION                              -->
    <!-- ========================================== -->
    <section class="py-12 md:py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row gap-8 md:gap-12 items-center">
                <!-- Text Left -->
                <div class="w-full md:w-5/12 text-center md:text-left">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">About <span class="text-imperial-primary">imperial</span></h2>
                    <p class="text-base md:text-lg text-imperial-gray leading-relaxed">imperial exists to provide a better patient experience. We are a one-stop-shop for your health, offering caring doctors, world-class diagnostics, in-house pharmacy, and much more.</p>
                </div>
                
                <!-- Stats Right -->
                <div class="w-full md:w-7/12 grid grid-cols-1 sm:grid-cols-3 gap-6 sm:gap-8">
                    <div class="text-center sm:text-left">
                        <div class="text-3xl sm:text-4xl font-bold text-imperial-primary mb-2">27</div>
                        <h3 class="text-lg sm:text-xl font-medium text-imperial-text">Departments</h3>
                    </div>
                    <div class="text-center sm:text-left">
                        <div class="text-3xl sm:text-4xl font-bold text-imperial-primary mb-2">84</div>
                        <h3 class="text-lg sm:text-xl font-medium text-imperial-text">Doctors</h3>
                    </div>
                    <div class="text-center sm:text-left">
                        <div class="text-3xl sm:text-4xl font-bold text-imperial-primary mb-2">914K</div>
                        <h3 class="text-lg sm:text-xl font-medium text-imperial-text">Patients Served</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 1: TEXT LEFT / IMAGE RIGHT          -->
    <!-- Mobile: Image Top / Desktop: Text Left      -->
    <!-- ========================================== -->
    <section class="bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 py-12 md:py-20">
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 items-center">
                
                <!-- Text Content (Order 2 on mobile, 1 on desktop) -->
                <div class="w-full md:w-5/12 order-2 md:order-1">
                    <h4 class="text-xs md:text-sm font-semibold tracking-wider uppercase mb-2 opacity-90">Why imperial</h4>
                    <h2 class="text-2xl md:text-4xl font-bold mb-4 leading-tight">Doctors Who Listen</h2>
                    <p class="text-base md:text-lg leading-relaxed mb-4">Our doctors spend time to get to know you and your health. They treat you with the respect and empathy you deserve.</p>
                    <p class="text-base md:text-lg leading-relaxed">Years of local and international experience to give you advice you can rely on.</p>
                </div>

                <!-- Image (Order 1 on mobile, 2 on desktop) -->
                <div class="w-full md:w-7/12 order-1 md:order-2">
                    <!-- Removed 'rounded-lg' here -->
                    <img src="{{ asset('assets/front/images/index/why-imperial.jpg') }}" 
                         onerror="this.src='https://picsum.photos/seed/doclist/800/600'"
                         alt="Doctors Listening" 
                         class="w-full h-auto shadow-xl object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 2: IMAGE LEFT / TEXT RIGHT          -->
    <!-- ========================================== -->
    <section class="py-12 md:py-24 bg-white">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 items-center">
                
                <!-- Image Left (First in DOM, so Top on Mobile) -->
                <div class="w-full md:w-1/2">
                    <!-- Removed 'rounded-lg' here -->
                    <img src="{{ asset('assets/front/images/index/diagnosis.jpeg') }}" 
                         onerror="this.src='https://picsum.photos/seed/lab/800/600'"
                         alt="Diagnosis Lab" 
                         class="w-full h-auto shadow-lg object-cover">
                </div>

                <!-- Text Right -->
                <div class="w-full md:w-1/2">
                    <h4 class="text-xs md:text-sm font-semibold text-imperial-primary tracking-wider uppercase mb-2">Why imperial</h4>
                    <h2 class="text-2xl md:text-4xl font-bold mb-4 text-imperial-text leading-tight">Diagnosis You Can Trust</h2>
                    <p class="text-base md:text-lg text-imperial-gray leading-relaxed mb-6">You can depend on the quality of our diagnosis and test results. Our laboratories are set up according to international standards and protocols.</p>
                    
                    <a href="#" class="text-imperial-primary font-bold hover:underline flex items-center gap-2 group text-base md:text-lg">
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
    <section class="py-12 md:py-24 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 items-center">
                
                <!-- Text Left -->
                <div class="w-full md:w-5/12 order-2 md:order-1">
                    <h4 class="text-xs md:text-sm font-semibold tracking-wider uppercase mb-2 opacity-90">Why imperial</h4>
                    <h2 class="text-2xl md:text-4xl font-bold mb-4 leading-tight">Healthcare Anytime, Anywhere</h2>
                    <p class="text-base md:text-lg leading-relaxed">We use technology to make healthcare accessible to you no matter where you are. Access your health data, book appointments, and view records anywhere.</p>
                </div>

                <!-- Image Right -->
                <div class="w-full md:w-7/12 order-1 md:order-2">
                    <!-- Removed 'rounded-lg' here -->
                    <img src="{{ asset('assets/front/images/index/health-care-anytime.jpg') }}" 
                         onerror="this.src='https://picsum.photos/seed/tech/800/600'"
                         alt="Digital Health" 
                         class="w-full h-auto shadow-xl object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 4: FLOATING LAYOUT                  -->
    <!-- ========================================== -->
    <section class="py-12 md:py-24 text-white relative overflow-hidden min-h-[400px] flex items-center">
        <div class="container mx-auto px-4 sm:px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                
                <!-- Text Card -->
                <div class="md:col-span-7 bg-white text-slate-900 p-6 md:p-12 shadow-2xl relative z-20 w-full mx-auto md:mx-0">
                    <h4 class="text-xs md:text-sm font-semibold text-imperial-primary tracking-wider uppercase mb-2">Why imperial</h4>
                    <h2 class="text-2xl md:text-4xl font-bold mb-4 leading-tight">Take A Tour Of Our Facility</h2>
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed mb-6">Visit us at our flagship facility in Banani, Dhaka, and find out what makes us different.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#" class="bg-imperial-primary text-white px-6 py-3 rounded font-bold hover:bg-opacity-90 transition text-center shadow-lg">Book a guided tour</a>
                    </div>
                </div>

                <!-- Spacer (Desktop Only) -->
                <div class="hidden md:block md:col-span-5"></div>
            </div>

            <!-- Background Image (Desktop Only) -->
            <div class="absolute right-0 top-0 h-full w-1/2 z-0 hidden md:block">
                <img src="{{ asset('assets/front/images/index/tour.jpg') }}" 
                     onerror="this.src='https://picsum.photos/seed/facility/800/600'"
                     alt="Facility Tour" 
                     class="w-full h-full object-cover ">
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 5: IMAGE LEFT / TEXT RIGHT          -->
    <!-- ========================================== -->
    <section class="py-12 md:py-24 bg-white">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 items-center">
                
                <!-- Image Left -->
                <div class="w-full md:w-1/2">
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
                             class="w-full h-auto shadow-lg object-cover">
                    </picture>
                </div>

                <!-- Text Right -->
                <div class="w-full md:w-1/2">
                    <h4 class="text-xs md:text-sm font-semibold text-imperial-primary tracking-wider uppercase mb-2">Why imperial</h4>
                    <h2 class="text-2xl md:text-4xl font-bold mb-4 text-imperial-text leading-tight">We Care For You Like Family</h2>
                    <p class="text-base md:text-lg text-imperial-gray leading-relaxed mb-6">Open every day from 8AM - 10PM. Our dedicated team ensures you feel at home while receiving the best medical attention.</p>
                    
                    <a href="#" class="inline-block border-2 border-imperial-primary text-imperial-primary px-8 py-3 rounded font-bold hover:bg-imperial-primary hover:text-white transition text-center">Book Appointment</a>
                </div>
            </div>
        </div>
    </section>

@endsection