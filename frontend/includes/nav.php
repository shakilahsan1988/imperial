    <!-- Main Navigation -->
<?PHP	require_once 'config.php'; ?>
    <header class="bg-white sticky top-0 z-10 shadow-sm transition-all duration-300" id="main-header">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="<?php echo HOME ;?>" class="flex-shrink-0 z-50">
                    <img src="../assets/logo.jpg" alt="Imperial Health Logo" class="h-10 w-auto md:h-10" onerror="this.src='https://placehold.co/150x50/8A2061/ffffff?text=imperial+Health'">
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden lg:flex gap-8 items-center">
                    <a href="<?php echo HOME ;?>" class="text-imperial-text font-medium hover:text-imperial-primary transition">Home</a>
                    
                    <!-- MEGA MENU CONTAINER -->
                    <div class="relative group py-4"> 
                        <a href="<?php echo SERVICES ;?>" class="text-imperial-text font-medium hover:text-imperial-primary transition flex items-center gap-1">
                            Services <i class="fa-solid fa-chevron-down text-xs"></i>
                        </a>
                        
                        <!-- Mega Menu Dropdown -->
                        <div class="absolute left-1/2 -translate-x-1/2 top-full mt-0 w-[75vw] max-w-[1200px] bg-white shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border-b border-gray-100 rounded-lg">
                            <div class="container mx-auto px-6 py-10">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                                    
                                    <!-- Column 1: Consultations & Health Checks -->
                                    <div>
                                        <h5 class="text-imperial-primary font-bold mb-4 uppercase text-sm tracking-wider">Consultations</h5>
                                        <ul class="space-y-2 mb-6">
                                            <li><a href="<?php echo SERVICES ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Consultations</a></li>
                                            <li><a href="<?php echo VIDEO_CONSULTATIONS ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Video Consultation</a></li>
                                        </ul>
                                        <h5 class="text-imperial-primary font-bold mb-4 uppercase text-sm tracking-wider">Health Checks</h5>
                                        <ul class="space-y-2">
                                            <li><a href="<?php echo HEALTH_CHECK ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Health Checks</a></li>
                                            <li><a href="<?php echo HEALTH_CHECK ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Men's Health Packages</a></li>
                                            <li><a href="<?php echo HEALTH_CHECK ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Senior Citizen Checks</a></li>
                                        </ul>
                                    </div>

                                    <!-- Column 2: Diagnostics -->
                                    <div>
                                        <h5 class="text-imperial-primary font-bold mb-4 uppercase text-sm tracking-wider">Diagnostics</h5>
                                        <ul class="space-y-2">
                                               <li><a href="<?php echo LAB_TEST ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Diagnostics</a></li>
                                            <li><a href="<?php echo LAB_TEST ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Lab Tests & Procedures</a></li>
                                            <li><a href="<?php echo LAB_TEST ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Imaging & X-Ray</a></li>
                                            <li><a href="<?php echo LAB_TEST ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Molecular Cancer Diagnostics</a></li>
                                            <li><a href="<?php echo LAB_TEST ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Home Sample Collection</a></li>
                                            <li><a href="<?php echo LAB_TEST ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Banani Hub</a></li>
                                        </ul>
                                    </div>

                                    <!-- Column 3: Wellness -->
                                    <div>
                                        <h5 class="text-imperial-primary font-bold mb-4 uppercase text-sm tracking-wider">Wellness & Pharmacy</h5>
                                        <ul class="space-y-2">
                                            <li><a href="<?php echo MEMBERSHIP ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Pharmacy</a></li>
                                            <li><a href="<?php echo MEMBERSHIP ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Vaccines</a></li>
                                            <li><a href="<?php echo MEMBERSHIP ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Membership Plans</a></li>
                                            <li><a href="<?php echo MEMBERSHIP ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">COVID-19 Services</a></li>
                                        </ul>
                                    </div>

                                    <!-- Column 4: Banner Image & CTA -->
                                    <div class="relative h-full min-h-[250px] flex flex-col justify-end bg-gray-50 rounded-lg overflow-hidden group/img">
                                        <img src="https://www.imperialhealth.com/media-images/gqo4Gk4YrQ2fJ2QYFkUjjPuHr-4=/173/fill-1280x432-c0/Healthcare_Anywhere_1.png" 
                                             onerror="this.src='https://picsum.photos/seed/doc/400/300'"
                                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-105" 
                                             alt="Healthcare Anywhere">
                                        <div class="relative z-10 bg-white/95 backdrop-blur-sm p-6 rounded-lg shadow-lg border border-gray-100">
                                            <h4 class="text-imperial-text font-bold mb-2 text-lg">Need Help Booking?</h4>
                                            <p class="text-sm text-gray-600 mb-4">Our team is available to assist you with finding right service.</p>
                                            <div class="flex gap-3">
                                                <a href="tel:10648" class="flex-1 bg-imperial-primary text-white text-sm font-bold px-4 py-3 rounded hover:bg-imperial-dark transition text-center">
                                                    <i class="fa-solid fa-phone mr-2"></i> 10648
                                                </a>
                                                <a href="#" class="flex-1 bg-white text-imperial-primary border border-imperial-primary text-sm font-bold px-4 py-3 rounded hover:bg-gray-50 transition text-center">
                                                    Chat Now
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="<?php echo DOCTOR ;?>" class="text-imperial-text font-medium hover:text-imperial-primary transition">Our Doctors</a>
                    <a href="<?php echo DOCTOR ;?>" class="text-imperial-text font-medium hover:text-imperial-primary transition">imperialMD</a>
                   <div class="relative group py-4"> 
						<a href="<?php echo ABOUT ;?>" class="text-imperial-text font-medium hover:text-imperial-primary transition">About</a>
						   <!-- Mega Menu Dropdown -->
                        <div class="absolute left-1/2 -translate-x-1/2 top-full mt-0 w-[75vw] max-w-[1200px] bg-white shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border-b border-gray-100 rounded-lg">
                            <div class="container mx-auto px-6 py-10">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                                    
                                    <!-- Column 1: Consultations & Health Checks -->
                                    <div>
                                        <h5 class="text-imperial-primary font-bold mb-4 uppercase text-sm tracking-wider">Consultations</h5>
                                        <ul class="space-y-2 mb-6">
                                            <li><a href="<?php echo SERVICES ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Consultations</a></li>
                                            <li><a href="<?php echo VIDEO_CONSULTATIONS ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Video Consultation</a></li>
                                        </ul>
                                        <h5 class="text-imperial-primary font-bold mb-4 uppercase text-sm tracking-wider">Health Checks</h5>
                                        <ul class="space-y-2">
                                            <li><a href="<?php echo HEALTH_CHECK ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Health Checks</a></li>
                                            <li><a href="<?php echo HEALTH_CHECK ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Men's Health Packages</a></li>
                                            <li><a href="<?php echo HEALTH_CHECK ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Senior Citizen Checks</a></li>
                                        </ul>
                                    </div>

                                    <!-- Column 2: Diagnostics -->
                                    <div>
                                        <h5 class="text-imperial-primary font-bold mb-4 uppercase text-sm tracking-wider">Diagnostics</h5>
                                        <ul class="space-y-2">
                                               <li><a href="<?php echo LAB_TEST ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Diagnostics</a></li>
                                            <li><a href="<?php echo LAB_TEST ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Lab Tests & Procedures</a></li>
                                            <li><a href="<?php echo LAB_TEST ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Imaging & X-Ray</a></li>
                                            <li><a href="<?php echo LAB_TEST ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Molecular Cancer Diagnostics</a></li>
                                            <li><a href="<?php echo LAB_TEST ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Home Sample Collection</a></li>
                                            <li><a href="<?php echo LAB_TEST ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Banani Hub</a></li>
                                        </ul>
                                    </div>

                                    <!-- Column 3: Wellness -->
                                    <div>
                                        <h5 class="text-imperial-primary font-bold mb-4 uppercase text-sm tracking-wider">Wellness & Pharmacy</h5>
                                        <ul class="space-y-2">
                                            <li><a href="<?php echo MEMBERSHIP ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Pharmacy</a></li>
                                            <li><a href="<?php echo MEMBERSHIP ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Vaccines</a></li>
                                            <li><a href="<?php echo MEMBERSHIP ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Membership Plans</a></li>
                                            <li><a href="<?php echo MEMBERSHIP ;?>" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">COVID-19 Services</a></li>
                                        </ul>
                                    </div>

                                    <!-- Column 4: Banner Image & CTA -->
                                    <div class="relative h-full min-h-[250px] flex flex-col justify-end bg-gray-50 rounded-lg overflow-hidden group/img">
                                        <img src="https://www.imperialhealth.com/media-images/gqo4Gk4YrQ2fJ2QYFkUjjPuHr-4=/173/fill-1280x432-c0/Healthcare_Anywhere_1.png" 
                                             onerror="this.src='https://picsum.photos/seed/doc/400/300'"
                                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-105" 
                                             alt="Healthcare Anywhere">
                                        <div class="relative z-10 bg-white/95 backdrop-blur-sm p-6 rounded-lg shadow-lg border border-gray-100">
                                            <h4 class="text-imperial-text font-bold mb-2 text-lg">Need Help Booking?</h4>
                                            <p class="text-sm text-gray-600 mb-4">Our team is available to assist you with finding right service.</p>
                                            <div class="flex gap-3">
                                                <a href="tel:10648" class="flex-1 bg-imperial-primary text-white text-sm font-bold px-4 py-3 rounded hover:bg-imperial-dark transition text-center">
                                                    <i class="fa-solid fa-phone mr-2"></i> 10648
                                                </a>
                                                <a href="#" class="flex-1 bg-white text-imperial-primary border border-imperial-primary text-sm font-bold px-4 py-3 rounded hover:bg-gray-50 transition text-center">
                                                    Chat Now
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                  </div>
				  <a href="#" class="text-imperial-text font-medium hover:text-imperial-primary transition">Community</a>
                    
                    <div class="flex items-center gap-4 ml-4">
                        <!-- Desktop Search Icon Trigger -->
                        <button id="search-trigger-desktop" class="text-imperial-text hover:text-imperial-primary transition"><i class="fa-solid fa-magnifying-glass"></i></button>
                        <a href="#" class="bg-imperial-primary text-white px-6 py-2.5 rounded-sm font-medium hover:bg-imperial-dark transition">Book Appointment</a>
                    </div>
                </nav>

                <!-- Mobile Hamburger & Search -->
                <div class="lg:hidden flex items-center gap-4 z-50 relative">
                    <!-- Mobile Search Icon Trigger -->
                    <button id="search-trigger-mobile" class="text-imperial-text"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <button id="mobile-menu-btn" class="text-imperial-text focus:outline-none">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Drawer -->
        <div id="mobile-menu" class="fixed inset-y-0 left-0 w-3/4 max-w-sm bg-white shadow-2xl transform -translate-x-full z-50 pt-20 px-6 flex flex-col gap-4 lg:hidden transition-transform duration-300 ease-in-out">
            <a href="#" class="text-lg font-medium text-imperial-primary border-b pb-2">Home</a>
            
            <!-- Mobile Submenu -->
            <div class="border-b pb-2">
                <button class="text-lg font-medium text-imperial-text w-full flex justify-between items-center" onclick="toggleSubmenu(this)">
                    Services <i class="fa-solid fa-chevron-down text-sm transition-transform duration-300"></i>
                </button>
                <div class="hidden pl-4 mt-2 flex flex-col gap-2 bg-gray-50 p-2 rounded transition-all duration-300">
                    <a href="#" class="text-imperial-gray hover:text-imperial-primary py-1">Health Checks</a>
                    <a href="#" class="text-imperial-gray hover:text-imperial-primary py-1">Doctors</a>
                    <a href="#" class="text-imperial-gray hover:text-imperial-primary py-1">Diagnostics</a>
                    <a href="#" class="text-imperial-gray hover:text-imperial-primary py-1">Pharmacy</a>
                </div>
            </div>

            <a href="#" class="text-lg font-medium text-imperial-text border-b pb-2">Our Doctors</a>
            <a href="#" class="text-lg font-medium text-imperial-text border-b pb-2">About</a>
            <a href="#" class="bg-imperial-primary text-white text-center py-3 rounded mt-4 font-medium">Book Appointment</a>
        </div>
        <!-- Overlay for mobile menu -->
        <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden opacity-0 transition-opacity duration-300"></div>
    </header>