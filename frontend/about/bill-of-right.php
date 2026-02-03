<?php require_once '../includes/header.php'; ?>

<!-- Main Content Start -->
<main class="font-sans text-imperial-text bg-white pb-20">
    
 
    <!-- HERO SECTION -->
    <section class="relative h-[50vh] md:h-[60vh] w-full overflow-hidden">
        <img src="https://www.praavahealth.com/media-images/z5jPhyJJMyxSGlROQ1ve7B_z04k=/316/fill-1920x634-c0/About_Us.jpg" 
             alt="About Us" 
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/40"></div>
        
        <div class="container mx-auto px-4 h-full flex items-center relative z-10">
            <div class="max-w-2xl text-white">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Patient Bill of Rights</h1>
                <p class="text-lg md:text-xl opacity-90 font-roboto leading-relaxed">
                    We want you, as a Patient at Imperial Health, to speak openly with your healthcare team, take part in your treatment choices, and promote your own safety by being well informed and involved in your care. We exist to empower you to take control of your health, and we want you to think of us as your partners in managing your health.
                </p>
            </div>
        </div>
    </section>

    <!-- 
       RIGHTS GRID SECTION 
       Added content to flesh out the page
    -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 border-l-4 border-imperial-primary pl-4">Your Rights</h2>
                <p class="text-gray-600">As a patient of Imperial Health, you have the right to:</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Right 1 -->
                <div class="flex gap-4 p-6 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 text-imperial-primary rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">Respect and Dignity</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">Receive care that respects your personal values, beliefs, and cultural background in a safe environment.</p>
                    </div>
                </div>

                <!-- Right 2 -->
                <div class="flex gap-4 p-6 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 text-imperial-primary rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">Information about Care</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">Receive complete, understandable information about your diagnosis, treatment, and prognosis in terms you can understand.</p>
                    </div>
                </div>

                <!-- Right 3 -->
                <div class="flex gap-4 p-6 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 text-imperial-primary rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-file-signature"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">Informed Consent</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">Participate in decisions regarding your healthcare, including the right to refuse treatment to the extent permitted by law.</p>
                    </div>
                </div>

                <!-- Right 4 -->
                <div class="flex gap-4 p-6 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 text-imperial-primary rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">Privacy and Confidentiality</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">Expect that all communications and records concerning your care will be treated as confidential.</p>
                    </div>
                </div>

                <!-- Right 5 -->
                <div class="flex gap-4 p-6 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 text-imperial-primary rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">Communication</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">Communicate with healthcare providers in a language you understand, including access to interpreters if necessary.</p>
                    </div>
                </div>

                <!-- Right 6 -->
                <div class="flex gap-4 p-6 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 text-imperial-primary rounded-full flex items-center justify-center text-xl">
                        <i class="fa-solid fa-file-pen"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">Review Records</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">Request and receive a copy of your medical records and have the information explained to you.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 
       RESPONSIBILITIES SECTION 
    -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Patient Responsibilities</h2>
                    <p class="text-gray-600 mb-6">Being a partner in your health also means taking responsibility for your actions.</p>
                    
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-check text-green-500 mt-1"></i>
                            <span class="text-gray-700">Provide accurate information about your health, including past illnesses, hospitalizations, medications, and other matters related to your health.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-check text-green-500 mt-1"></i>
                            <span class="text-gray-700">Report unexpected changes in your condition to the responsible practitioner.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-check text-green-500 mt-1"></i>
                            <span class="text-gray-700">Ask questions when you do not understand what you have been told about your care or what you are expected to do.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-check text-green-500 mt-1"></i>
                            <span class="text-gray-700">Inform your provider if you anticipate problems in following prescribed treatment.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-check text-green-500 mt-1"></i>
                            <span class="text-gray-700">Recognize the effect of lifestyle on your personal health and act to reduce health risks.</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-imperial-primary text-white rounded-full flex items-center justify-center text-xl">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Have a Concern?</h3>
                    </div>
                    <p class="text-gray-600 mb-6">
                        If you feel your rights have been violated or you have a complaint regarding the service received, please reach out to our Patient Relations team.
                    </p>
                    <a href="mailto:imperiallistens@imperialhealth.com" class="inline-flex items-center gap-2 text-imperial-primary font-bold hover:underline">
                        <i class="fa-solid fa-envelope"></i> imperiallistens@imperialhealth.com
                    </a>
                </div>

            </div>
        </div>
    </section>

</main>

<?php require_once '../includes/footer.php'; ?>