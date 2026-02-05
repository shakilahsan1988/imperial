@extends('layouts.front')

@section('title', 'Code of Ethics - Imperial Health Bangladesh')

@section('content')

    <!-- Main Content Start -->
    <main class="font-sans text-imperial-text bg-white pb-20">
        
        <!-- HERO HEADER SECTION -->
        <section class="relative w-full h-[400px] md:h-[500px] flex items-center overflow-hidden">
            
            <!-- Background Image & Overlay -->
            <div class="absolute inset-0 z-0">
                <!-- Professional placeholder representing ethics/law/integrity -->
                <img src="https://picsum.photos/id/48/1920/1080" alt="Code of Ethics Background" class="w-full h-full object-cover">
            
                <!-- Dark Overlay using Imperial Primary color with transparency -->
                <div class="absolute inset-0 bg-imperial-primary/90"></div>
            </div>

            <!-- Content Container -->
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-white">
                
                <!-- Back Button -->
                <div class="mb-4">
                    <a href="{{ route('about') }}" class="group flex items-center gap-2 text-white/80 hover:text-white transition font-medium text-sm tracking-wide uppercase">
                        <i class="fa-solid fa-arrow-left text-xl group-hover:-translate-x-1 transition-transform"></i>
                        Back
                    </a>
                </div>

                <!-- Title -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight mb-0">
                    Code of Ethics
                </h1>
                
            </div>
        </section>

        <!-- CODE OF ETHICS CONTENT SECTION -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto">
                    
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-imperial-primary mb-4 border-l-4 border-imperial-primary pl-4">Introduction</h2>
                        <p class="text-gray-700 leading-relaxed text-lg">
                            At Imperial Health Bangladesh Limited, our reputation for integrity and excellence is our most valuable asset. This Code of Ethics outlines principles and standards that guide our conduct. It applies to all employees, management, and medical staff. We are committed to the highest standards of ethical behavior in the delivery of healthcare services.
                        </p>
                    </div>

                    <div class="prose prose-lg max-w-none">
                        
                        <!-- Principle 1 -->
                        <div class="mb-10">
                            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-heart-pulse text-imperial-primary"></i> Patient Care & Safety
                            </h2>
                            <p class="text-gray-600">
                                Our primary responsibility is to the health and safety of our patients. We are committed to providing care that is safe, effective, patient-centered, timely, efficient, and equitable. We will not compromise patient safety for profit or convenience.
                            </p>
                        </div>

                        <!-- Principle 2 -->
                        <div class="mb-10">
                            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-scale-balanced text-imperial-primary"></i> Integrity & Honesty
                            </h2>
                            <p class="text-gray-600">
                                We conduct our business with honesty and integrity. We expect all employees to adhere to high standards of moral and ethical conduct. We strictly prohibit bribery, corruption, kickbacks, and any form of unethical financial gain.
                            </p>
                        </div>

                        <!-- Principle 3 -->
                        <div class="mb-10">
                            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-user-shield text-imperial-primary"></i> Confidentiality & Privacy
                            </h2>
                            <p class="text-gray-600">
                                We respect the privacy of our patients and employees. We are committed to protecting all confidential medical and personal information in accordance with applicable laws and regulations. Unauthorized disclosure of confidential information is strictly prohibited.
                            </p>
                        </div>

                        <!-- Principle 4 -->
                        <div class="mb-10">
                            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-users-viewfinder text-imperial-primary"></i> Respect & Dignity
                            </h2>
                            <p class="text-gray-600">
                                We treat everyone with respect, dignity, and courtesy. We do not tolerate discrimination, harassment, or retaliation based on race, color, religion, gender, sexual orientation, age, disability, or any other protected characteristic.
                            </p>
                        </div>

                        <!-- Principle 5 -->
                        <div class="mb-10">
                            <h2 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-gavel text-imperial-primary"></i> Compliance with Laws
                            </h2>
                            <p class="text-gray-600">
                                We strictly comply with all applicable laws, regulations, and regulatory requirements governing the healthcare industry in Bangladesh. We maintain accurate and complete records and ensure transparent financial reporting.
                            </p>
                        </div>

                    </div>

                    <!-- Reporting Violations Box -->
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-8 mt-12">
                        <h2 class="text-xl font-bold text-imperial-primary mb-4">Reporting Unethical Conduct</h2>
                        <p class="text-gray-700 mb-4">
                            Employees and stakeholders are encouraged to report any concerns or suspected violations of this Code. We ensure confidentiality to the extent possible by law and protect whistleblowers from retaliation.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="mailto:compliance@imperialhealth.com" class="flex items-center gap-2 text-white bg-imperial-primary hover:bg-blue-700 px-6 py-3 rounded font-bold transition text-center">
                                <i class="fa-solid fa-envelope"></i> Report via Email
                            </a>
                            <a href="tel:10648" class="flex items-center gap-2 text-imperial-primary border border-imperial-primary hover:bg-imperial-light px-6 py-3 rounded font-bold transition text-center">
                                <i class="fa-solid fa-phone"></i> Hotline: 10648
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>

@endsection