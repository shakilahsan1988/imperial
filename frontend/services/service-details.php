<?php require_once '../includes/header.php'; ?>

    <main>
        <!-- PAGE HEADER -->
        <section class="bg-white border-b border-gray-200 pt-16 pb-12">
            <div class="container mx-auto px-6">
                <h1 class="text-3xl md:text-5xl font-bold text-imperial-text">Consultations</h1>
                <p class="text-lg text-gray-600 mt-4 max-w-3xl">
                    Connect with our expert doctors for personalized care and treatment plans across a wide range of specialties.
                </p>
            </div>
        </section>

        <div class="container mx-auto px-6 py-12">
            
            <!-- SECTION: Consultations -->
            <section class="mb-24">
                
                <!-- Header for this group -->
                <div class="text-center max-w-2xl mx-auto mb-20">
                    <h2 class="text-2xl font-bold text-imperial-text">Expert Doctors Across Specialties</h2>
                    <p class="text-gray-600 mt-2">Our team of experienced doctors provides compassionate care across various medical fields.</p>
                </div>

                <!-- Specialty 1: Cardiology -->
                <div class="flex flex-col md:flex-row items-start gap-12 mb-24">
                    <div class="flex-1">
                        <!-- Independent Number with Left Border -->
                        <div class="mb-6">
                            <div class="border-l-4 border-imperial-primary pl-4 mb-2">
                                <span class="text-sm font-bold text-imperial-primary">01</span>
                            </div>
                            <h3 class="text-3xl font-bold text-imperial-primary">Cardiology</h3>
                        </div>
                        
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Comprehensive heart care including ECG, Echocardiogram, and specialized cardiac consultations. Our cardiologists are dedicated to diagnosing and treating heart conditions with precision and care. We specialize in managing hypertension, heart failure, arrhythmias, and congenital heart defects using state-of-the-art technology to ensure your heart stays healthy.
                        </p>
                        
                        <!-- Thin Border Button, Normal Font -->
                        <a href="#" class="inline-block border border-imperial-primary text-imperial-primary px-8 py-3 font-medium hover:bg-imperial-primary hover:text-white transition">
                            Book an Appointment
                        </a>
                        
                        <!-- Call Link -->
                        <div class="mt-4">
                            <a href="tel:3242" class="text-gray-600 hover:text-imperial-primary flex items-center gap-2 text-sm font-medium">
                                <i class="fa-solid fa-phone"></i> Call at 3242
                            </a>
                        </div>
                    </div>
                    <div class="flex-1 w-full">
                        <!-- Big Image, No Rounded Corners -->
                        <img src="https://img.freepik.com/free-photo/beautiful-young-female-doctor-looking-camera-office_1301-7807.jpg" alt="Cardiology" class="shadow-2xl w-full h-[400px] md:h-[600px] object-cover">
                    </div>
                </div>

                <!-- Specialty 2: Dermatology -->
                <div class="flex flex-col md:flex-row-reverse items-start gap-12 mb-24">
                    <div class="flex-1">
                        <div class="mb-6">
                            <div class="border-l-4 border-imperial-primary pl-4 mb-2">
                                <span class="text-sm font-bold text-imperial-primary">02</span>
                            </div>
                            <h3 class="text-3xl font-bold text-imperial-primary">Dermatology</h3>
                       </div>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Comprehensive skin care, hair treatment, and cosmetic procedures. We help you achieve healthy skin through advanced treatments for acne, eczema, aging, and more. Our specialists offer expert solutions for hair fall, psoriasis, and cosmetic enhancements including chemical peels and laser therapy, tailored to your unique skin type.
                        </p>
                        <a href="#" class="inline-block border border-imperial-primary text-imperial-primary px-8 py-3 font-medium hover:bg-imperial-primary hover:text-white transition">
                            Book an Appointment
                        </a>
                        <div class="mt-4">
                            <a href="tel:3242" class="text-gray-600 hover:text-imperial-primary flex items-center gap-2 text-sm font-medium">
                                <i class="fa-solid fa-phone"></i> Call at 3242
                            </a>
                        </div>
                    </div>
                    <div class="flex-1 w-full">
                        <img src="https://img.freepik.com/free-photo/portrait-professional-medical-worker-posing-picture-with-arms-folded_1098-19293.jpg" alt="Dermatology" class="shadow-2xl w-full h-[400px] md:h-[600px] object-cover">
                    </div>
                </div>

                <!-- Specialty 3: Pediatrics -->
                <div class="flex flex-col md:flex-row items-start gap-12 mb-24">
                    <div class="flex-1">
                        <div class="mb-6">
                            <div class="border-l-4 border-imperial-primary pl-4 mb-2">
                                <span class="text-sm font-bold text-imperial-primary">03</span>
                            </div>
                            <h3 class="text-3xl font-bold text-imperial-primary">Pediatrics</h3>
                       </div>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Compassionate care for infants, children, and adolescents. Our pediatricians create a friendly environment to ensure your child's health and development are on right track. From newborn care and essential immunizations to treating childhood illnesses and monitoring adolescent growth, we are here to support your family at every step.
                        </p>
                        <a href="#" class="inline-block border border-imperial-primary text-imperial-primary px-8 py-3 font-medium hover:bg-imperial-primary hover:text-white transition">
                            Book an Appointment
                        </a>
                        <div class="mt-4">
                            <a href="tel:3242" class="text-gray-600 hover:text-imperial-primary flex items-center gap-2 text-sm font-medium">
                                <i class="fa-solid fa-phone"></i> Call at 3242
                            </a>
                        </div>
                    </div>
                    <div class="flex-1 w-full">
                        <img src="https://img.freepik.com/premium-photo/smiling-doctor-with-arms-crossed_13339-167390.jpg" alt="Pediatrics" class="shadow-2xl w-full h-[400px] md:h-[600px] object-cover">
                    </div>
                </div>

                <!-- Specialty 4: Orthopedics -->
                <div class="flex flex-col md:flex-row-reverse items-start gap-12 mb-24">
                    <div class="flex-1">
                        <div class="mb-6">
                            <div class="border-l-4 border-imperial-primary pl-4 mb-2">
                                <span class="text-sm font-bold text-imperial-primary">04</span>
                            </div>
                            <h3 class="text-3xl font-bold text-imperial-primary">Orthopedics</h3>
                       </div>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Bone and joint care, physiotherapy, and sports injury management. Get back to your active life with our expert orthopedic treatments and rehabilitation plans. We specialize in treating arthritis, sports injuries, spine disorders, and performing joint replacement surgeries to help you regain mobility and improve your quality of life.
                        </p>
                        <a href="#" class="inline-block border border-imperial-primary text-imperial-primary px-8 py-3 font-medium hover:bg-imperial-primary hover:text-white transition">
                            Book an Appointment
                        </a>
                        <div class="mt-4">
                            <a href="tel:3242" class="text-gray-600 hover:text-imperial-primary flex items-center gap-2 text-sm font-medium">
                                <i class="fa-solid fa-phone"></i> Call at 3242
                            </a>
                        </div>
                    </div>
                    <div class="flex-1 w-full">
                        <img src="https://img.freepik.com/premium-photo/male-doctor-light-surface_392895-24691.jpg" alt="Orthopedics" class="shadow-2xl w-full h-[400px] md:h-[600px] object-cover">
                    </div>
                </div>

                <!-- Specialty 5: Gynecology -->
                <div class="flex flex-col md:flex-row items-start gap-12 mb-24">
                    <div class="flex-1">
                        <div class="mb-6">
                            <div class="border-l-4 border-imperial-primary pl-4 mb-2">
                                <span class="text-sm font-bold text-imperial-primary">05</span>
                            </div>
                            <h3 class="text-3xl font-bold text-imperial-primary">Gynecology</h3>
                       </div>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Women's health services, prenatal care, and maternity support. We provide a safe and supportive environment for all stages of a woman's life. Services include antenatal care, fertility consultation, management of PCOS/PCOD, and menopause support, provided with utmost confidentiality and compassion by our specialized team.
                        </p>
                        <a href="#" class="inline-block border border-imperial-primary text-imperial-primary px-8 py-3 font-medium hover:bg-imperial-primary hover:text-white transition">
                            Book an Appointment
                        </a>
                        <div class="mt-4">
                            <a href="tel:3242" class="text-gray-600 hover:text-imperial-primary flex items-center gap-2 text-sm font-medium">
                                <i class="fa-solid fa-phone"></i> Call at 3242
                            </a>
                        </div>
                    </div>
                    <div class="flex-1 w-full">
                        <img src="https://img.freepik.com/premium-photo/studio-shot-young-handsome-indian-man-doctor-against-gray_251136-12611.jpg" alt="Gynecology" class="shadow-2xl w-full h-[400px] md:h-[600px] object-cover">
                    </div>
                </div>

                <!-- Specialty 6: General Physician -->
                <div class="flex flex-col md:flex-row-reverse items-start gap-12 mb-12">
                    <div class="flex-1">
                        <div class="mb-6">
                            <div class="border-l-4 border-imperial-primary pl-4 mb-2">
                                <span class="text-sm font-bold text-imperial-primary">06</span>
                            </div>
                            <h3 class="text-3xl font-bold text-imperial-primary">General Physician</h3>
                       </div>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Primary care for common illnesses, routine check-ups, and chronic disease management. Your first point of contact for comprehensive health assessments. Our GPs serve as your primary care coordinators, managing ongoing health issues, providing expert advice on lifestyle modifications, and coordinating specialist referrals when necessary.
                        </p>
                        <a href="#" class="inline-block border border-imperial-primary text-imperial-primary px-8 py-3 font-medium hover:bg-imperial-primary hover:text-white transition">
                            Book an Appointment
                        </a>
                        <div class="mt-4">
                            <a href="tel:3242" class="text-gray-600 hover:text-imperial-primary flex items-center gap-2 text-sm font-medium">
                                <i class="fa-solid fa-phone"></i> Call at 3242
                            </a>
                        </div>
                    </div>
                    <div class="flex-1 w-full">
                        <img src="https://img.freepik.com/free-photo/doctor-holding-clipboard-looking-camera_23-2148285743.jpg" alt="General Physician" class="shadow-2xl w-full h-[400px] md:h-[600px] object-cover">
                    </div>
                </div>

            </section>

        </div>
    </main>
<?php require_once '../includes/footer.php'; ?>