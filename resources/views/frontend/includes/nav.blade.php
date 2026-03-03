@php
    $menuSettings = menu_settings();
    $mainMenu = $menuSettings['main_menu'] ?? [];
@endphp

<header class="bg-white sticky top-0 z-[1000] shadow-lg shadow-slate-200/50" id="main-header">
    <div class="container mx-auto px-4 md:px-6 py-3 md:py-4">
        <div class="flex justify-between items-center">
            
            <!-- Logo -->
            <a href="{{ route('fhome') }}" class="flex-shrink-0 relative z-[110]">
                <img src="{{ asset('assets/front/images/logo.png') }}" alt="Imperial Health Logo" class="h-9 md:h-12 w-auto" onerror="this.src='https://placehold.co/150x50/007caa/ffffff?text=Imperial+Health'">
            </a>

            <nav class="hidden lg:flex gap-8 items-center">
                <a href="{{ route('fhome') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition-colors tracking-tight">Home</a>

                <!-- Services -->
                <div class="relative group py-2">
                    <a href="{{ route('services') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-1 tracking-tight">
                        Services <i class="fa-solid fa-chevron-down text-[8px] mt-0.5"></i>
                    </a>
                    <div class="absolute left-0 top-full mt-2 w-64 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all transform group-hover:translate-y-0 translate-y-2 duration-300 z-50 py-4">
                        <a href="{{ route('lab-test') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Diagnostics &amp; Lab</a>
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
                        <a href="{{ route('mission-vision-value') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Mission &amp; Vision</a>
                        <a href="{{ route('management') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Management</a>
                        <a href="{{ url('/career') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Careers</a>
                        <a href="{{ route('contact') }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">Contact Us</a>
                    </div>
                </div>

                <!-- Desktop CTA -->
                <div class="flex items-center gap-4 border-l border-slate-100 pl-8">
                    <a href="{{ route('book-doctor') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-full text-[11px] font-black uppercase tracking-widest shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5 active:scale-95 flex items-center gap-2">
                        <i class="fa-regular fa-calendar-check text-sm"></i>
                        <span>Book Now</span>
                    </a>
                </div>
            </nav>

            <!-- Mobile Action Row (Visible only on Mobile) -->
            <div class="flex lg:hidden items-center gap-3 relative z-[110]">
                <!-- Account/Login Link -->
                @if(auth()->guard('patient')->check())
                    <a href="{{ route('patient.index') }}" class="text-indigo-600 font-bold p-2"><i class="fa-regular fa-user-circle text-2xl"></i></a>
                @else
                    <a href="{{ route('patient.auth.login') }}" class="text-indigo-600 text-[10px] font-black uppercase tracking-widest bg-indigo-50 px-4 py-2 rounded-xl border border-indigo-100 transition-all active:scale-95">Sign In</a>
                @endif

                <!-- Hamburger Button -->
                <button id="mobile-menu-btn" class="w-11 h-11 flex items-center justify-center text-slate-600 focus:outline-none bg-slate-50 rounded-xl border border-slate-100 transition-all active:bg-slate-100">
                    <i class="fa-solid fa-bars text-xl transition-all duration-300" id="menu-icon"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- MOBILE MENU DRAWER -->
<div id="mobile-menu" class="fixed inset-y-0 left-0 w-[300px] bg-white shadow-[25px_0_60px_rgba(0,0,0,0.1)] transform -translate-x-full z-[10001] transition-transform duration-500 ease-in-out lg:hidden overflow-y-auto pt-24 px-8 flex flex-col gap-2 pointer-events-auto">
    
    <div class="mb-8">
        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Main Menu</p>
        <div class="h-1 w-10 bg-indigo-600 rounded-full"></div>
    </div>

    @foreach($mainMenu as $item)
        @php
            $url = $item['url'] ?? '#';
            $href = preg_match('/^https?:\\/\\//i', $url) ? $url : url($url);
            $children = is_array($item['children'] ?? null) ? $item['children'] : [];
        @endphp
        @if(count($children) > 0)
            <div class="py-2">
                <button type="button" class="w-full text-left text-lg font-bold text-slate-700 hover:text-indigo-600 transition-all flex items-center justify-between group" onclick="toggleSubmenu(this)">
                    <span>{{ $item['label'] ?? 'Menu' }}</span>
                    <i class="fa-solid fa-chevron-down text-[10px] opacity-40 group-hover:opacity-100 transition-opacity"></i>
                </button>
                <div class="hidden pl-4 mt-2 space-y-1">
                    <a href="{{ $href }}" class="block py-2 text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors" {{ !empty($item['new_tab']) ? 'target=_blank rel=noopener' : '' }}>All {{ $item['label'] ?? 'Menu' }}</a>
                    @foreach($children as $child)
                        @php
                            $childUrl = $child['url'] ?? '#';
                            $childHref = preg_match('/^https?:\\/\\//i', $childUrl) ? $childUrl : url($childUrl);
                        @endphp
                        <a href="{{ $childHref }}" class="block py-2 text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors" {{ !empty($child['new_tab']) ? 'target=_blank rel=noopener' : '' }}>
                            {{ $child['label'] ?? 'Sub Menu' }}
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <a href="{{ $href }}" class="text-lg font-bold text-slate-700 hover:text-indigo-600 py-3 transition-all flex items-center justify-between group" {{ !empty($item['new_tab']) ? 'target=_blank rel=noopener' : '' }}>
                <span>{{ $item['label'] ?? 'Menu' }}</span>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-20 group-hover:opacity-100 transition-opacity"></i>
            </a>
        @endif
    @endforeach

    <!-- Mobile CTA Buttons -->
    <div class="mt-12 space-y-4">
        <a href="{{ route('book-doctor') }}" class="block text-center py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-xl shadow-indigo-200 transform active:scale-95 transition-all">
            Book Appointment
        </a>
        @if(auth()->guard('patient')->check())
            <form action="{{ route('patient.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-center py-4 bg-slate-100 text-red-600 rounded-2xl font-black uppercase tracking-widest text-[10px] transition-all">Sign Out</button>
            </form>
        @endif
    </div>
</div>

<!-- Overlay -->
<div id="mobile-overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md z-[10000] hidden opacity-0 transition-opacity duration-300"></div>
