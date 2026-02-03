
<?php require_once '../includes/header.php'; ?>

<!-- Main Content Start -->
<main class="font-sans text-imperial-text bg-white pb-20">
    
    <!-- 
       HERO HEADER SECTION 
       Converted from <div class="service-header service-header-bg ...">
       This uses a full-width background image with an overlay and white text.
    -->
    <section class="relative w-full h-[400px] md:h-[500px] flex items-center overflow-hidden">
        
        <!-- Background Image & Overlay -->
        <div class="absolute inset-0 z-0">
            <!-- Using a professional placeholder image suitable for Privacy/Legal pages -->
            <img src="https://picsum.photos/id/532/1920/1080" alt="Privacy Notice Background" class="w-full h-full object-cover">
            
            <!-- Dark Overlay using Imperial Primary color with transparency -->
            <div class="absolute inset-0 bg-imperial-primary/90"></div>
        </div>

        <!-- Content Container -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-white">
            
            <!-- Back Button -->
            <div class="mb-4">
                <button onclick="history.back()" class="group flex items-center gap-2 text-white/80 hover:text-white transition font-medium text-sm tracking-wide uppercase">
                    <i class="fa-solid fa-arrow-left text-xl group-hover:-translate-x-1 transition-transform"></i>
                    Back
                </button>
            </div>

            <!-- Title -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight mb-0">
                Privacy Notice
            </h1>
            
        </div>
    </section>

    <!-- 
       PRIVACY CONTENT SECTION
    -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                
                <p class="text-lg text-gray-600 mb-10 leading-relaxed">
                    Effective Date: January 1, 2025<br>
                    At Imperial Health Bangladesh Limited, we are committed to protecting your personal information and your right to privacy. This Privacy Notice explains how we collect, use, disclose, and safeguard your information when you visit our website or use our healthcare services.
                </p>

                <div class="prose prose-lg prose-blue max-w-none">
                    
                    <!-- 1. Information We Collect -->
                    <div class="mb-10">
                        <h2 class="text-2xl font-bold text-imperial-primary mb-4 border-b pb-2">1. Information We Collect</h2>
                        <p class="text-gray-700 mb-3">We collect personal information that you voluntarily provide to us when you register on the website, express an interest in obtaining information about us or our products and services, when you participate in activities on the website, or otherwise when you contact us.</p>
                        <ul class="list-disc list-outside ml-6 space-y-2 text-gray-600">
                            <li><strong class="text-gray-900">Personal Identification Information:</strong> Name, email address, phone number, date of birth, National ID, and passport details.</li>
                            <li><strong class="text-gray-900">Health Information:</strong> Medical history, symptoms, lab results, prescriptions, and insurance details.</li>
                            <li><strong class="text-gray-900">Technical Data:</strong> IP address, browser type, device information, and pages visited.</li>
                        </ul>
                    </div>

                    <!-- 2. How We Use Your Information -->
                    <div class="mb-10">
                        <h2 class="text-2xl font-bold text-imperial-primary mb-4 border-b pb-2">2. How We Use Your Information</h2>
                        <p class="text-gray-700 mb-3">We use the information we collect to provide, maintain, and improve our services, and to process transactions. Specifically, we may use your information to:</p>
                        <ul class="list-disc list-outside ml-6 space-y-2 text-gray-600">
                            <li>Facilitate your access to and use of the website and services.</li>
                            <li>Process and manage appointments, prescriptions, and medical records.</li>
                            <li>Send you technical notices, updates, security alerts, and support messages.</li>
                            <li>Respond to your comments, questions, and customer service requests.</li>
                        </ul>
                    </div>

                    <!-- 3. Sharing Your Information -->
                    <div class="mb-10">
                        <h2 class="text-2xl font-bold text-imperial-primary mb-4 border-b pb-2">3. Sharing Your Information</h2>
                        <p class="text-gray-700 mb-3">We may process or share your data that we hold in the following situations:</p>
                        <ul class="list-disc list-outside ml-6 space-y-2 text-gray-600">
                            <li><strong class="text-gray-900">Service Providers:</strong> We may share your information with third-party vendors (e.g., labs, insurance partners, payment processors) to perform services on our behalf.</li>
                            <li><strong class="text-gray-900">Business Transfers:</strong> We may share or transfer your information in connection with a merger, sale of company assets, financing, or acquisition of all or a portion of our business.</li>
                            <li><strong class="text-gray-900">Legal Requirements:</strong> We may disclose information where we believe it is necessary to investigate, prevent, or take action regarding illegal activities, fraud, or potential threats to the physical safety of any person.</li>
                        </ul>
                    </div>

                    <!-- 4. Data Security -->
                    <div class="mb-10">
                        <h2 class="text-2xl font-bold text-imperial-primary mb-4 border-b pb-2">4. Data Security</h2>
                        <p class="text-gray-700">We have implemented appropriate technical and organizational security measures designed to protect the security of any personal information we process. However, no method of transmission over the Internet or method of electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your personal information, we cannot guarantee its absolute security.</p>
                    </div>

                    <!-- 5. Your Rights -->
                    <div class="mb-10">
                        <h2 class="text-2xl font-bold text-imperial-primary mb-4 border-b pb-2">5. Your Privacy Rights</h2>
                        <p class="text-gray-700 mb-3">Depending on your location, you may have certain rights regarding your personal information:</p>
                        <ul class="list-disc list-outside ml-6 space-y-2 text-gray-600">
                            <li>The right to access, update, or delete the information we have on you.</li>
                            <li>The right to rectification if the information is inaccurate or incomplete.</li>
                            <li>The right to object to our processing of your personal data.</li>
                        </ul>
                    </div>

                    <!-- 6. Contact Us -->
                    <div class="bg-gray-50 p-8 rounded-xl border border-gray-200 mt-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Contact Us</h2>
                        <p class="text-gray-600 mb-4">
                            If you have questions or comments about this Privacy Notice, please contact us at:
                        </p>
                        <p class="text-gray-900 font-medium mb-1">
                            <i class="fa-solid fa-envelope text-imperial-primary mr-2"></i>
                            <a href="mailto:privacy@imperialhealth.com" class="hover:text-imperial-primary">privacy@imperialhealth.com</a>
                        </p>
                        <p class="text-gray-900 font-medium">
                            <i class="fa-solid fa-phone text-imperial-primary mr-2"></i>
                            <a href="tel:10648" class="hover:text-imperial-primary">10648</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>

</main>

<?php require_once '../includes/footer.php'; ?>