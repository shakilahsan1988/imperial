@extends('layouts.front')

@section('title', 'Consultations - Imperial Health Bangladesh')

@section('content')
    <main>
        <!-- PAGE HEADER -->
        <section class="bg-white border-b border-gray-200 pt-20 pb-16">
            <div class="container mx-auto px-6">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900">Consultations</h1>
                <p class="text-lg text-gray-600 mt-6 max-w-3xl leading-relaxed">
                    Connect with our expert doctors for personalized care and treatment plans across a wide range of specialties.
                </p>
            </div>
        </section>

        <div class="container mx-auto px-6 py-12 lg:py-20">
            
            <!-- SECTION: Consultations -->
            <section class="mb-20">
                
                <!-- Header for this group -->
                <div class="text-center max-w-2xl mx-auto mb-24">
                    <h2 class="text-2xl font-bold text-gray-900">Expert Doctors Across Specialties</h2>
                    <p class="text-gray-600 mt-2">Our team of experienced doctors provides compassionate care across various medical fields.</p>
                </div>

                <!-- Specialty 1: Cardiology (Text Left, Image Right) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-0 items-center mb-24 lg:mb-28">
                    
                    <!-- Text Column: Span 5 -->
                    <div class="order-2 lg:order-1 lg:col-span-5 flex flex-col justify-center">
                        <div class="mb-6">
                            <div class="border-l-4 border-imperial-primary pl-4 mb-2">
                                <span class="text-sm font-bold text-imperial-primary">01</span>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-900">Cardiology</h3>
                        </div>
                        
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Comprehensive heart care including ECG, Echocardiogram, and specialized cardiac consultations. Our cardiologists are dedicated to diagnosing and treating heart conditions with precision and care. We specialize in managing hypertension, heart failure, arrhythmias, and congenital heart defects using state-of-the-art technology to ensure your heart stays healthy.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('book-doctor') }}" class="inline-block border border-imperial-primary text-imperial-primary px-8 py-3 font-medium hover:bg-imperial-primary hover:text-white transition text-center whitespace-nowrap">
                                Book an Appointment
                            </a>
                            
                            <a href="tel:3242" class="text-gray-600 hover:text-imperial-primary flex items-center gap-2 text-sm font-medium px-2 py-3">
                                <i class="fa-solid fa-phone"></i> Call at 3242
                            </a>
                        </div>
                    </div>

                    <!-- Image Column: Span 6, Start at Column 7 -->
                    <div class="order-1 lg:order-2 lg:col-span-6 lg:col-start-7 w-full h-full">
                        <!-- Added flex centering to position image perfectly, object-contain to show full image -->
                        <div class="relative shadow-xl h-[350px] lg:h-[450px] w-full overflow-hidden bg-gray-50 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/services/cardiology.jpg') }}" alt="Cardiology" class="max-w-full max-h-full object-contain">
                        </div>
                    </div>
                </div>

                <!-- Specialty 2: Dermatology (Image Left, Text Right) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-0 items-center mb-24 lg:mb-28">
                    
                    <!-- Image Column: Span 6 -->
                    <div class="order-1 lg:col-span-6 w-full h-full">
                        <div class="relative shadow-xl h-[350px] lg:h-[450px] w-full overflow-hidden bg-gray-50 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/services/dertetology.jpg') }}" alt="Dermatology" class="max-w-full max-h-full object-contain">
                        </div>
                    </div>

                    <!-- Text Column: Span 5, Start at Column 8 -->
                    <div class="order-2 lg:col-span-5 lg:col-start-8 flex flex-col justify-center">
                        <div class="mb-6">
                            <div class="border-l-4 border-imperial-primary pl-4 mb-2">
                                <span class="text-sm font-bold text-imperial-primary">02</span>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-900">Dermatology</h3>
                        </div>
                        
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Comprehensive skin care, hair treatment, and cosmetic procedures. We help you achieve healthy skin through advanced treatments for acne, eczema, aging, and more. Our specialists offer expert solutions for hair fall, psoriasis, and cosmetic enhancements including chemical peels and laser therapy, tailored to your unique skin type.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('book-doctor') }}" class="inline-block border border-imperial-primary text-imperial-primary px-8 py-3 font-medium hover:bg-imperial-primary hover:text-white transition text-center whitespace-nowrap">
                                Book an Appointment
                            </a>
                            <a href="tel:3242" class="text-gray-600 hover:text-imperial-primary flex items-center gap-2 text-sm font-medium px-2 py-3">
                                <i class="fa-solid fa-phone"></i> Call at 3242
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Specialty 3: Pediatrics (Text Left, Image Right) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-0 items-center mb-24 lg:mb-28">
                    
                    <div class="order-2 lg:order-1 lg:col-span-5 flex flex-col justify-center">
                        <div class="mb-6">
                            <div class="border-l-4 border-imperial-primary pl-4 mb-2">
                                <span class="text-sm font-bold text-imperial-primary">03</span>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-900">Pediatrics</h3>
                        </div>
                        
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Compassionate care for infants, children, and adolescents. Our pediatricians create a friendly environment to ensure your child's health and development are on right track. From newborn care and essential immunizations to treating childhood illnesses and monitoring adolescent growth, we are here to support your family at every step.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('book-doctor') }}" class="inline-block border border-imperial-primary text-imperial-primary px-8 py-3 font-medium hover:bg-imperial-primary hover:text-white transition text-center whitespace-nowrap">
                                Book an Appointment
                            </a>
                            <a href="tel:3242" class="text-gray-600 hover:text-imperial-primary flex items-center gap-2 text-sm font-medium px-2 py-3">
                                <i class="fa-solid fa-phone"></i> Call at 3242
                            </a>
                        </div>
                    </div>

                    <div class="order-1 lg:order-2 lg:col-span-6 lg:col-start-7 w-full h-full">
                        <div class="relative shadow-xl h-[350px] lg:h-[450px] w-full overflow-hidden bg-gray-50 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/services/pediatrics.jpg') }}" alt="Pediatrics" class="max-w-full max-h-full object-contain">
                        </div>
                    </div>
                </div>

                <!-- Specialty 4: Orthopedics (Image Left, Text Right) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-0 items-center mb-24 lg:mb-28">
                    
                    <div class="order-1 lg:col-span-6 w-full h-full">
                        <div class="relative shadow-xl h-[350px] lg:h-[450px] w-full overflow-hidden bg-gray-50 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/services/orthopedics.jpg') }}" alt="Orthopedics" class="max-w-full max-h-full object-contain">
                        </div>
                    </div>

                    <div class="order-2 lg:col-span-5 lg:col-start-8 flex flex-col justify-center">
                        <div class="mb-6">
                            <div class="border-l-4 border-imperial-primary pl-4 mb-2">
                                <span class="text-sm font-bold text-imperial-primary">04</span>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-900">Orthopedics</h3>
                        </div>
                        
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Bone and joint care, physiotherapy, and sports injury management. Get back to your active life with our expert orthopedic treatments and rehabilitation plans. We specialize in treating arthritis, sports injuries, spine disorders, and performing joint replacement surgeries to help you regain mobility and improve your quality of life.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('book-doctor') }}" class="inline-block border border-imperial-primary text-imperial-primary px-8 py-3 font-medium hover:bg-imperial-primary hover:text-white transition text-center whitespace-nowrap">
                                Book an Appointment
                            </a>
                            <a href="tel:3242" class="text-gray-600 hover:text-imperial-primary flex items-center gap-2 text-sm font-medium px-2 py-3">
                                <i class="fa-solid fa-phone"></i> Call at 3242
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Specialty 5: Gynecology (Text Left, Image Right) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-0 items-center mb-24 lg:mb-28">
                    
                    <div class="order-2 lg:order-1 lg:col-span-5 flex flex-col justify-center">
                        <div class="mb-6">
                            <div class="border-l-4 border-imperial-primary pl-4 mb-2">
                                <span class="text-sm font-bold text-imperial-primary">05</span>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-900">Gynecology</h3>
                        </div>
                        
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Women's health services, prenatal care, and maternity support. We provide a safe and supportive environment for all stages of a woman's life. Services include antenatal care, fertility consultation, management of PCOS/PCOD, and menopause support, provided with utmost confidentiality and compassion by our specialized team.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('book-doctor') }}" class="inline-block border border-imperial-primary text-imperial-primary px-8 py-3 font-medium hover:bg-imperial-primary hover:text-white transition text-center whitespace-nowrap">
                                Book an Appointment
                            </a>
                            <a href="tel:3242" class="text-gray-600 hover:text-imperial-primary flex items-center gap-2 text-sm font-medium px-2 py-3">
                                <i class="fa-solid fa-phone"></i> Call at 3242
                            </a>
                        </div>
                    </div>

                    <div class="order-1 lg:order-2 lg:col-span-6 lg:col-start-7 w-full h-full">
                        <div class="relative shadow-xl h-[350px] lg:h-[450px] w-full overflow-hidden bg-gray-50 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/services/gyno.jpg') }}" alt="Gynecology" class="max-w-full max-h-full object-contain">
                        </div>
                    </div>
                </div>

                <!-- Specialty 6: General Physician (Image Left, Text Right) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-0 items-center mb-12">
                    
                    <div class="order-1 lg:col-span-6 w-full h-full">
                        <div class="relative shadow-xl h-[350px] lg:h-[450px] w-full overflow-hidden bg-gray-50 flex items-center justify-center">
                            <img src="{{ asset('assets/front/images/services/phy.jpg') }}" alt="General Physician" class="max-w-full max-h-full object-contain">
                        </div>
                    </div>

                    <div class="order-2 lg:col-span-5 lg:col-start-8 flex flex-col justify-center">
                        <div class="mb-6">
                            <div class="border-l-4 border-imperial-primary pl-4 mb-2">
                                <span class="text-sm font-bold text-imperial-primary">06</span>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-900">General Physician</h3>
                        </div>
                        
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Primary care for common illnesses, routine check-ups, and chronic disease management. Your first point of contact for comprehensive health assessments. Our GPs serve as your primary care coordinators, managing ongoing health issues, providing expert advice on lifestyle modifications, and coordinating specialist referrals when necessary.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('book-doctor') }}" class="inline-block border border-imperial-primary text-imperial-primary px-8 py-3 font-medium hover:bg-imperial-primary hover:text-white transition text-center whitespace-nowrap">
                                Book an Appointment
                            </a>
                            <a href="tel:3242" class="text-gray-600 hover:text-imperial-primary flex items-center gap-2 text-sm font-medium px-2 py-3">
                                <i class="fa-solid fa-phone"></i> Call at 3242
                            </a>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>
@endsection