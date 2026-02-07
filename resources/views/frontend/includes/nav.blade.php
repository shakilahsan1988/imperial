<!-- ======================================================= -->
<!-- MAIN NAVIGATION (nav.blade.php)                        -->
<!-- ======================================================= -->
<header class="bg-white sticky top-0 z-10 shadow-sm transition-all duration-300  z-50" id="main-header">
    <div class="container mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            
            <!-- Logo -->
            <a href="{{ route('fhome') }}" class="flex-shrink-0 z-50">
                <img src="{{ asset('assets/front/images/logo.jpg') }}" alt="Imperial Health Logo" class="h-10 w-auto md:h-10" onerror="this.src='https://placehold.co/150x50/8A2061/ffffff?text=Imperial+Health'">
            </a>

            <!-- Desktop Menu -->
            <nav class="hidden lg:flex gap-8 items-center">
                
                <!-- Home -->
                <a href="{{ route('fhome') }}" class="text-imperial-text font-medium hover:text-imperial-primary transition">Home</a>
                
                <!-- SERVICES MEGA MENU CONTAINER -->
                <div class="relative group py-4"> 
                    <a href="{{ route('services') }}" class="text-imperial-text font-medium hover:text-imperial-primary transition flex items-center gap-1">
                        Services <i class="fa-solid fa-chevron-down text-xs"></i>
                    </a>
                    
                    <!-- Mega Menu Dropdown -->
                    <div class="absolute left-1/2 -translate-x-1/2 top-full mt-0 w-[75vw] max-w-[1200px] bg-white shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border-b border-gray-100 rounded-lg">
                        <div class="container mx-auto px-6 py-10">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                
                                <!-- Column 4: Banner Image & CTA -->
                                <div class="relative h-full min-h-[250px] flex flex-col justify-end bg-gray-50 rounded-lg overflow-hidden group/img">
                                    <img src="https://www.imperialhealth.com/media-images/gqo4Gk4YrQ2fJ2QYFkUjjPuHr-4=/173/fill-1280x432-c0/Healthcare_Anywhere_1.png" 
                                         onerror="this.src='https://picsum.photos/seed/doc/400/300'"
                                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-105" 
                                         alt="Healthcare Anywhere">
                                    
                                </div>
                                <!-- Column 1: Consultations & Health Checks -->
                                <div>
                                    <h5 class="text-imperial-primary font-bold mb-4 uppercase text-sm tracking-wider">Services</h5>

                                    <ul class="space-y-2 mb-6">
                                         <li class="border-b"><a href="{{ route('services') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Test & Procedures</a></li>
                                        <li>
                                             <button  onclick="toggleMegaSubmenu('consultations', this)" 
                                                    class="w-full border-b flex justify-between items-center text-left text-gray-700 hover:text-imperial-primary font-medium py-1 transition-colors focus:outline-none">
                                                <span>Consultations</span>
                                                <i class="fa-solid fa-chevron-down text-xs ml-2 transform transition-transform duration-300"></i>
                                            </button>
                                            <div id="consultations" class="hidden pl-4 mt-2 border-l-2 border-gray-100 space-y-1">
                                               <a href="{{ route('services') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Consultations</a>
                                               <a href="{{ route('video-consultation') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Video Consultation</a>
                                            </div>
                                        </li>
                                        <li>
                                             <button  onclick="toggleMegaSubmenu('diagnostics', this)" 
                                                    class="w-full border-b flex justify-between items-center text-left text-gray-700 hover:text-imperial-primary font-medium py-1 transition-colors focus:outline-none">
                                                <span>Diagnostics</span>
                                                <i class="fa-solid fa-chevron-down text-xs ml-2 transform transition-transform duration-300"></i>
                                            </button>
                                            <div id="diagnostics" class="hidden pl-4 mt-2 border-l-2 border-gray-100 space-y-1">
                                               <a href="{{ route('service-details') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Diagnostics</a>
                                               <a href="{{ route('service-details') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Molecular Cancer Diagnostics</a>
                                            </div>
                                        </li>
                                         <li class="border-b">
                                            <a href="{{ route('membership') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Health Checks and Packages</a>
                                         </li>
                                         <li class="border-b">
                                            <a href="{{ route('membership') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Membership Plan</a>
                                         </li>
                                         <li>
                                             <button  onclick="toggleMegaSubmenu('beauty', this)" 
                                                    class="w-full flex border-b justify-between items-center text-left text-gray-700 hover:text-imperial-primary font-medium py-1 transition-colors focus:outline-none">
                                                <span>Beauty Wellness</span>
                                                <i class="fa-solid fa-chevron-down text-xs ml-2 transform transition-transform duration-300"></i>
                                            </button>
                                            <div id="beauty" class="hidden pl-4 mt-2 border-l-2 border-gray-100 space-y-1">

                                               <a href="{{ route('service-details') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Beauty Wellness</a>

                                               <a href="{{ route('service-details') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Your Skin</a>

                                               <a href="{{ route('service-details') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Your Smile</a>

                                                <a href="{{ route('service-details') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Your Body</a>

                                                 <a href="{{ route('service-details') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Your Wellness</a>

                                            </div>
                                        </li>
                                    </ul>
                                   
                                </div>

                              

                                <!-- Column 3: Wellness -->
                                <div>
                                    <h5 class="text-imperial-primary font-bold mb-4 uppercase text-sm tracking-wider"></h5>
                                    <ul class="space-y-2">
                                        <!-- Note: No specific pharmacy route found, mapping to membership or generic -->
                                        
                                        <li><a href="{{ route('lab-test') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Vaccines</a></li>
                                        <li><a href="{{ route('service-details') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Covid 19</a></li>
                                        <li><a href="{{ route('service-details') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Hub</a></li>
                                            <li><a href="{{ route('service-details') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Home Health Service</a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Our Doctors -->
                <a href="{{ route('doctor') }}" class="text-imperial-text font-medium hover:text-imperial-primary transition">Our Doctors</a>
                
                <!-- imperialMD (Route not found in list, linking to doctor temporarily or #) -->
                <a href="{{ route('doctor') }}" class="text-imperial-text font-medium hover:text-imperial-primary transition">imperialMD</a>
                
                <!-- ABOUT MEGA MENU CONTAINER -->
                <div class="relative  z-50 group py-4"> 
                    <a href="{{ route('about') }}" class="text-imperial-text font-medium hover:text-imperial-primary transition">About <i class="fa-solid fa-chevron-down text-xs"></i></a>
                    
                    <!-- About Mega Menu Dropdown -->
                    <div class="absolute left-1/2 -translate-x-1/2 top-full mt-0 w-[55vw] max-w-[1200px] bg-white shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[9999999] border-b border-gray-100 rounded-lg">
                        <div class="container mx-auto px-6 py-10">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                
                                <!-- Column 4: Banner Image & CTA -->
                                <div class="relative h-full min-h-[250px] flex flex-col justify-end bg-gray-50 rounded-lg overflow-hidden group/img">
                                    <img src="https://picsum.photos/seed/hospital/400/300" 
                                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-105" 
                                         alt="About Imperial">
                                   
                                </div>
                                <!-- Column 1: Company -->
                                <div>
                                  <h3 class="text-imperial-primary font-bold mb-4 uppercase text-sm tracking-wider">About Us</h5>
                                    <ul class="space-y-2 mb-6">
                                      
                                         <li class="border-b">
                                            <a href="{{ route('mission-vision-value') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Mission & Vision</a>
                                        </li>
                                        <li class="border-b">
                                            <a href="{{ route('management') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Management </a>
                                        </li>
                                         <li class="border-b">
                                            <a href="{{ route('client') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Corporate Clients</a>
                                        </li>
                                          <li class="border-b">
                                            <a href="{{ route('career') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Careers</a>
                                        </li>
                                         <li class="border-b">
                                            <a href="{{ route('bill-of-right') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1"> Bill of Rights</a>
                                        </li>
                                         <li class="border-b">
                                            <a href="{{ route('career') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Careers</a>
                                        </li>
                                         <li class="border-b">
                                            <a href="{{ route('privacy-notice') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1"> Privacy Notice</a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Column 2: Quality -->
                                <div>
                                  <br/>
                                    <ul class="space-y-2">
                                 
                                         <li class="border-b">
                                            <a href="{{ route('code-of-ethics') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Code of Ethics</a>
                                        </li>
                                        <li class="border-b">
                                            <a href="{{ route('contact') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Contact</a>
                                        </li>
                                       
                                    </ul>
                                </div>

                    

                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative group py-4"> 
                <!-- Community (Route not found in list) -->
                     <a href="#" class="text-imperial-text font-medium hover:text-imperial-primary transition">Community <i class="fa-solid fa-chevron-down text-xs"></i></a>

                    <!-- About Mega Menu Dropdown -->
                    <div class="absolute left-1/2 -translate-x-1/2 top-full mt-0 w-[55vw] max-w-[1200px] bg-white shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[9999999] border-b border-gray-100 rounded-lg">
                        <div class="container mx-auto px-6 py-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                
                                <!-- Column 4: Banner Image & CTA -->
                                <div class="relative h-full min-h-[250px] flex flex-col justify-end bg-gray-50 rounded-lg overflow-hidden group/img">
                                    <img src="https://picsum.photos/seed/hospital/400/300" 
                                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-105" 
                                         alt="About Imperial">
                                   
                                </div>
                                <!-- Column 1: Company -->
                                <div>
                                  <h3 class="text-imperial-primary font-bold mb-4 uppercase text-sm tracking-wider">Community</h5>
                                    <ul class="space-y-2 mb-6">
                                      
                                         <li class="border-b">
                                            <a href="{{ route('blog') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Blog</a>
                                        </li>
                                        <li class="border-b">
                                            <a href="{{ route('event') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Event </a>
                                        </li>
                                         <li class="border-b">
                                            <a href="{{ route('press') }}" class="text-gray-700 hover:text-imperial-primary font-medium block py-1">Press</a>
                                        </li>
                                        
                                    </ul>
                                </div>

                            

                    

                            </div>
                        </div>
                    </div>
                </div>               
                <div class="flex items-center gap-4 ml-4">
                    <!-- Desktop Search Icon Trigger -->
                    <button id="search-trigger-desktop" class="text-imperial-text hover:text-imperial-primary transition"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <!-- Book Appointment -->
                    <a href="{{ route('book-doctor') }}" class="bg-imperial-primary text-white px-6 py-2.5 rounded-sm font-medium hover:bg-imperial-dark transition">Book Appointment</a>
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
        <a href="{{ route('fhome') }}" class="text-lg font-medium text-imperial-primary border-b pb-2">Home</a>
        
        <!-- Mobile Submenu: Services -->
        <div class="border-b pb-2">
            <button class="text-lg font-medium text-imperial-text w-full flex justify-between items-center" onclick="toggleSubmenu(this)">
                Services <i class="fa-solid fa-chevron-down text-sm transition-transform duration-300"></i>
            </button>
            <div class="hidden pl-4 mt-2 flex flex-col gap-2 bg-gray-50 p-2 rounded transition-all duration-300">
                <a href="{{ route('health-check') }}" class="text-imperial-gray hover:text-imperial-primary py-1">Health Checks</a>
                <a href="{{ route('doctor') }}" class="text-imperial-gray hover:text-imperial-primary py-1">Doctors</a>
                <a href="{{ route('lab-test') }}" class="text-imperial-gray hover:text-imperial-primary py-1">Lab Tests</a>
                <a href="{{ route('membership') }}" class="text-imperial-gray hover:text-imperial-primary py-1">Membership</a>
            </div>
        </div>

        <a href="{{ route('doctor') }}" class="text-lg font-medium text-imperial-text border-b pb-2">Our Doctors</a>
        <a href="{{ route('about') }}" class="text-lg font-medium text-imperial-text border-b pb-2">About</a>
        <a href="{{ route('book-doctor') }}" class="bg-imperial-primary text-white text-center py-3 rounded mt-4 font-medium">Book Appointment</a>
    </div>
    
    <!-- Overlay for mobile menu -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden opacity-0 transition-opacity duration-300"></div>
</header>