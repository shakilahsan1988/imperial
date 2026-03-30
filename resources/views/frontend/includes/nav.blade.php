@php
    $menuSettings = menu_settings();
    $mainMenu = $menuSettings['main_menu'] ?? [];
    $infoSettings = setting('info') ?? [];
    $logoSrc = !empty($infoSettings['logo']) ? asset('img/' . $infoSettings['logo']) : asset('assets/front/images/logo.png');
@endphp

<header class="bg-white sticky top-0 z-[1000] shadow-lg shadow-slate-200/50" id="main-header">
    <div class="container mx-auto px-4 md:px-6 py-3 md:py-4">
        <div class="flex justify-between items-center">
            
            <!-- Logo -->
            <a href="{{ route('fhome') }}" class="flex-shrink-0 relative z-[110]">
                <img src="{{ $logoSrc }}" alt="Imperial Health Logo" class="h-9 md:h-12 w-auto" onerror="this.src='https://placehold.co/150x50/007caa/ffffff?text=Imperial+Health'">
            </a>

            <nav class="hidden lg:flex gap-8 items-center">
                @foreach($mainMenu as $item)
                    @php
                        $url = $item['url'] ?? '#';
                        $href = preg_match('/^https?:\\/\\//i', $url) ? $url : url($url);
                        $children = is_array($item['children'] ?? null) ? $item['children'] : [];
                    @endphp
                    @if(count($children) > 0)
                        <div class="relative group py-2">
                            <a href="{{ $href }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-1 tracking-tight" {{ !empty($item['new_tab']) ? 'target=_blank rel=noopener' : '' }}>
                                {{ $item['label'] ?? 'Menu' }} <i class="fa-solid fa-chevron-down text-[8px] mt-0.5"></i>
                            </a>
                            <div class="absolute left-0 top-full mt-2 w-64 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all transform group-hover:translate-y-0 translate-y-2 duration-300 z-50 py-4">
                                @foreach($children as $child)
                                    @php
                                        $childUrl = $child['url'] ?? '#';
                                        $childHref = preg_match('/^https?:\\/\\//i', $childUrl) ? $childUrl : url($childUrl);
                                    @endphp
                                    <a href="{{ $childHref }}" class="block px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all" {{ !empty($child['new_tab']) ? 'target=_blank rel=noopener' : '' }}>
                                        {{ $child['label'] ?? 'Sub Menu' }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $href }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition-colors tracking-tight" {{ !empty($item['new_tab']) ? 'target=_blank rel=noopener' : '' }}>
                            {{ $item['label'] ?? 'Menu' }}
                        </a>
                    @endif
                @endforeach

                <!-- Desktop CTA -->
                <div class="flex items-center gap-4 border-l border-slate-100 pl-8">
                    <a href="{{ route('cart.index') }}" class="flex items-center gap-2 cursor-pointer text-slate-500 hover:text-indigo-600 transition group font-bold uppercase tracking-widest relative">
                        <i class="fa-solid fa-cart-shopping group-hover:scale-110 transition-transform"></i> 
                        <span>Cart</span>
                        <span id="cart-count-badge" class="absolute -top-2 -right-3 bg-indigo-600 text-white text-[9px] w-4 h-4 rounded-full flex items-center justify-center border border-white {{ session()->get('cart') ? '' : 'hidden' }}">
                            {{ session()->get('cart') ? count(session()->get('cart')) : 0 }}
                        </span>
                    </a>
                    <a href="{{ route('book-doctor') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-full text-[11px] font-black uppercase tracking-widest shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5 active:scale-95 flex items-center gap-2">
                        <i class="fa-regular fa-calendar-check text-sm"></i>
                        <span>Book Now</span>
                    </a>
                </div>
            </nav>

            <!-- Mobile Action Row (Visible only on Mobile) -->
            <div class="flex lg:hidden items-center gap-2 relative z-[110]">
                <!-- Mobile Cart Link -->
                <a href="{{ route('cart.index') }}" class="relative p-2 text-slate-500 hover:text-indigo-600 transition">
                    <i class="fa-solid fa-cart-shopping text-lg"></i>
                    <span id="cart-count-badge-mobile" class="absolute -top-0 -right-0.5 bg-indigo-600 text-white text-[8px] w-4 h-4 rounded-full flex items-center justify-center border border-white {{ session()->get('cart') ? '' : 'hidden' }}">
                        {{ session()->get('cart') ? count(session()->get('cart')) : 0 }}
                    </span>
                </a>
                
                <!-- Account/Login Link -->
                @if(auth()->guard('patient')->check())
                    <a href="{{ route('patient.index') }}" class="text-indigo-600 font-bold p-2"><i class="fa-regular fa-user-circle text-xl"></i></a>
                @else
                    <a href="{{ route('patient.auth.login') }}" class="text-indigo-600 text-[10px] font-black uppercase tracking-widest bg-indigo-50 px-3 py-2 rounded-xl border border-indigo-100 transition-all active:scale-95">Sign In</a>
                @endif

                <!-- Hamburger Button -->
                <button id="mobile-menu-btn" class="w-10 h-10 flex items-center justify-center text-slate-600 focus:outline-none bg-slate-50 rounded-xl border border-slate-100 transition-all active:bg-slate-100">
                    <i class="fa-solid fa-bars text-lg transition-all duration-300" id="menu-icon"></i>
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
