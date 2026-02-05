@extends('layouts.front')

@section('title', 'Contact - Imperial Health Bangladesh')

@section('content')
<!-- Main Content Start -->
<main class="font-sans text-imperial-text bg-white">
    
    <!-- 
       HERO SECTION 
       Converted from <div class="contact-header ...">
       Full-width background with overlay, title, and 2x2 contact info grid.
    -->
    <section class="relative w-full min-h-[600px] flex items-center overflow-hidden">
        
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <!-- Using a placeholder image representing doctor/patient interaction -->
            <img src="https://picsum.photos/id/4/1920/1080" alt="Imperial Health Doctor" class="w-full h-full object-cover">
            
            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-imperial-primary/90"></div>
        </div>

        <!-- Content Container -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-white py-12">
            
            <!-- Title & Description -->
            <div class="max-w-3xl mb-12">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 tracking-tight">
                    Get in touch with us
                </h1>
                <p class="text-lg md:text-xl font-roboto text-blue-50 leading-relaxed">
                    Our doctors spend time to get to know you and your health. They treat you with the respect and empathy you deserve, and have years of local and international experience to give you advice that you can rely on.
                </p>
            </div>

            <!-- Contact Info Grid (2x2) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl">
                
                <!-- Email -->
                <div class="bg-white text-gray-900 rounded-lg p-6 shadow-lg flex flex-col justify-center hover:shadow-xl transition-shadow">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-imperial-primary">
                            <i class="fa-solid fa-envelope text-lg"></i>
                        </div>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500">Email</h3>
                    </div>
                    <a href="mailto:imperiallistens@imperialhealth.com" class="text-lg font-bold hover:text-imperial-primary transition">
                        imperiallistens@imperialhealth.com
                    </a>
                </div>

                <!-- Phone Number -->
                <div class="bg-white text-gray-900 rounded-lg p-6 shadow-lg flex flex-col justify-center hover:shadow-xl transition-shadow">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-imperial-primary">
                            <i class="fa-solid fa-phone text-lg"></i>
                        </div>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500">Phone Number</h3>
                    </div>
                    <a href="tel:10648" class="text-lg font-bold hover:text-imperial-primary transition">
                        10648
                    </a>
                </div>

                <!-- WhatsApp -->
                <div class="bg-white text-gray-900 rounded-lg p-6 shadow-lg flex flex-col justify-center hover:shadow-xl transition-shadow">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                            <i class="fa-brands fa-whatsapp text-xl"></i>
                        </div>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500">WhatsApp</h3>
                    </div>
                    <a href="https://wa.me/+8801844508402" target="_blank" class="text-lg font-bold hover:text-green-600 transition">
                        +8801844508402
                    </a>
                </div>

                <!-- Address -->
                <div class="bg-white text-gray-900 rounded-lg p-6 shadow-lg flex flex-col justify-center hover:shadow-xl transition-shadow">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-imperial-primary">
                            <i class="fa-solid fa-location-dot text-lg"></i>
                        </div>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500">Address</h3>
                    </div>
                    <p class="text-base font-medium">
                        Plot 9, Road 17, Block C, Banani, Dhaka 1213, Bangladesh
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- MAP SECTION -->
    <!-- Full width map below the hero -->
    <section class="w-full h-[400px] md:h-[500px] bg-gray-200">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3648.389736832745!2d90.3983!3d23.7954!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c8c16e0e643b%3A0x6a466d658b8a5e0!2sBanani%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1620000000000!5m2!1sen!2sbd" 
            width="100%" 
            height="100%" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy">
        </iframe>
    </section>

    <!-- CONTACT FORM SECTION -->
    <section class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                <!-- Form Side (Span 8) -->
                <div class="lg:col-span-8">
                    <div class="bg-gray-50 p-8 md:p-10 rounded-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a message</h2>
                        
                        <form action="#" method="POST" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-imperial-primary focus:border-imperial-primary outline-none transition">
                                </div>
                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-imperial-primary focus:border-imperial-primary outline-none transition">
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-imperial-primary focus:border-imperial-primary outline-none transition">
                            </div>

                            <!-- Subject -->
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                                <select id="subject" name="subject" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-imperial-primary focus:border-imperial-primary outline-none transition bg-white">
                                    <option>General Inquiry</option>
                                    <option>Appointments</option>
                                    <option>Feedback</option>
                                    <option>Corporate Partnerships</option>
                                    <option>Careers</option>
                                </select>
                            </div>

                            <!-- Message -->
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                                <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-imperial-primary focus:border-imperial-primary outline-none transition"></textarea>
                            </div>

                            <!-- Button -->
                            <button type="submit" class="w-full bg-imperial-primary hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg shadow transition duration-300">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Info Side (Span 4) -->
                <div class="lg:col-span-4 space-y-8">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Operating Hours</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex justify-between border-b border-gray-100 pb-2">
                                <span>Saturday - Thursday</span>
                                <span class="font-bold text-gray-900">8:00 AM - 10:00 PM</span>
                            </li>
                            <li class="flex justify-between border-b border-gray-100 pb-2">
                                <span>Friday</span>
                                <span class="font-bold text-gray-900">3:00 PM - 10:00 PM</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Emergency?</h3>
                        <p class="text-gray-600 mb-4">If you have a medical emergency, please call our emergency hotline immediately.</p>
                        <a href="tel:10648" class="inline-flex items-center gap-2 text-2xl font-bold text-red-600 hover:text-red-700 transition">
                            <i class="fa-solid fa-phone-volume"></i> 10648
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>
@endsection