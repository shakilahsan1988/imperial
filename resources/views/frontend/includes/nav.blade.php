<header class="bg-white sticky top-0 z-50 shadow-lg shadow-slate-200/50 transition-all duration-300" id="main-header">
    <div class="container mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            
            <!-- Logo -->
            <a href="{{ route('fhome') }}" class="flex-shrink-0 relative z-50">
                <img src="{{ asset('assets/front/images/logo.png') }}" alt="Imperial Health Logo" class="h-10 md:h-12 w-auto" onerror="this.src='https://placehold.co/150x50/4f46e5/ffffff?text=Imperial+Health'">
            </a>

            <!-- Desktop Menu -->
            <nav class="hidden lg:flex gap-10 items-center">
                
                <!-- Links -->
                <a href="{{ route('fhome') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition-colors tracking-tight">Home</a>
                
                <!-- Services -->
                <div class="relative group py-2"> 
                    <a href="{{ route('services') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-1 tracking-tight">
                        Services <i class="fa-solid fa-chevron-down text-[8px] mt-0.5"></i>
                    </a>
                    <!-- Standard Dropdown (Simplified for modernization) -->
                    <div class="absolute left-0 top-full mt-2 w-64 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all transform group-hover:translate-y-0 translate-y-2 duration-300 z-50 py-4">
                        <a href="{{ route('lab-test') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Diagnostics & Lab</a>
                        <a href="{{ route('health-check') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Health Checks</a>
                        <a href="{{ route('membership') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Membership Plan</a>
                        <a href="{{ route('video-consultation') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Video Consultation</a>
                    </div>
                </div>

                <a href="{{ route('doctor') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition-colors tracking-tight">Our Doctors</a>
                
                <!-- Community -->
                <div class="relative group py-2"> 
                    <a href="#" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-1 tracking-tight">
                        Community <i class="fa-solid fa-chevron-down text-[8px] mt-0.5"></i>
                    </a>
                    <div class="absolute left-0 top-full mt-2 w-64 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all transform group-hover:translate-y-0 translate-y-2 duration-300 z-50 py-4">
                        <a href="{{ route('blog') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Blog</a>
                        <a href="{{ route('gallery') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Gallery</a>
                    </div>
                </div>

                <!-- About -->
                <div class="relative group py-2"> 
                    <a href="{{ route('about') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-1 tracking-tight">
                        About <i class="fa-solid fa-chevron-down text-[8px] mt-0.5"></i>
                    </a>
                    <div class="absolute left-0 top-full mt-2 w-64 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all transform group-hover:translate-y-0 translate-y-2 duration-300 z-50 py-4">
                        <a href="{{ route('mission-vision-value') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Mission & Vision</a>
                        <a href="{{ route('management') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Management</a>
                        <a href="{{ route('career') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Careers</a>
                        <a href="{{ route('contact') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Contact Us</a>
                    </div>
                </div>

                <!-- Action Group -->
                <div class="flex items-center gap-6 border-l border-slate-100 pl-10">
                    <button class="text-slate-400 hover:text-indigo-600 transition-colors"><i class="fa-solid fa-magnifying-glass"></i></button>
                    
                    <!-- My Account Dropdown -->
                    <div class="relative group py-2">
                        <a href="#" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-2 tracking-tight">
                            <i class="fa-regular fa-user"></i> <span>My Account</span>
                            <i class="fa-solid fa-chevron-down text-[8px] mt-0.5"></i>
                        </a>
                        <div class="absolute right-0 top-full mt-2 w-48 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all transform group-hover:translate-y-0 translate-y-2 duration-300 z-50 py-4">
                            @if(auth()->guard('patient')->check())
                                <a href="{{ route('patient.index') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Dashboard</a>
                                <form action="{{ route('patient.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-red-50 hover:text-red-600 transition-all">Sign Out</button>
                                </form>
                            @else
                                <a href="{{ route('patient.auth.login') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Sign In</a>
                                <a href="{{ route('patient.auth.register') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Sign Up</a>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('book-doctor') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl text-sm font-black tracking-tight shadow-lg shadow-indigo-200 transition-all transform active:scale-95">
                        Book Appointment
                    </a>
                </div>
            </nav>

            <!-- Mobile Toggle -->
            <button id="mobile-menu-btn" class="lg:hidden w-10 h-10 flex items-center justify-center text-slate-600 focus:outline-none">
                <i class="fa-solid fa-bars-staggered text-xl"></i>
            </button>
        </div>
    </div>
</header>