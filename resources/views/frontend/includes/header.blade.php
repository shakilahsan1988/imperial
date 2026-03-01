<!-- ============================================ -->
<!-- TOP BAR (Desktop Only)                      -->
<!-- ============================================ -->
<div class="bg-white border-b border-slate-100 hidden lg:block text-[11px] py-2.5 relative z-[60]">
    <div class="container mx-auto px-6 flex justify-between items-center">
        <div class="flex gap-8 text-slate-500 font-bold uppercase tracking-widest">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-phone text-indigo-600"></i> 
                <a href="tel:10648" class="hover:text-indigo-600 transition">Hotline: 10648</a>
            </span>
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-envelope text-indigo-600"></i> 
                <a href="mailto:imperiallistens@imperialhealth.com" class="hover:text-indigo-600 transition">Support Center</a>
            </span>
        </div>
        <div class="flex gap-8 items-center">
            <a href="#" class="flex items-center gap-2 cursor-pointer text-slate-500 hover:text-indigo-600 transition group font-bold uppercase tracking-widest">
                <i class="fa-solid fa-cart-shopping group-hover:scale-110 transition-transform"></i> 
                <span>Cart</span>
            </a>
            
            <!-- MY ACCOUNT (Desktop) -->
            <div class="relative h-full flex items-center" id="account-wrapper">
                @if(auth()->guard('patient')->check())
                    <div id="account-trigger" class="flex items-center gap-2 cursor-pointer text-slate-500 hover:text-indigo-600 transition select-none focus:outline-none font-bold uppercase tracking-widest">
                        <i class="fa-regular fa-user"></i> <span>{{__('My Account')}}</span>
                        <i class="fa-solid fa-chevron-down text-[8px] ml-1"></i>
                    </div>
                    <!-- Dropdown -->
                    <div id="account-dropdown" class="hidden absolute top-full right-0 mt-2 w-48 bg-white text-slate-700 shadow-2xl rounded-2xl border border-slate-100 z-[100] overflow-hidden transition-all duration-200">
                        <a href="{{ route('patient.index') }}" class="block px-6 py-3 hover:bg-indigo-50 hover:text-indigo-600 transition font-bold border-b border-slate-50">{{__('Dashboard')}}</a>
                        <form action="{{ route('patient.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left block px-6 py-3 hover:bg-red-50 hover:text-red-600 transition font-bold">{{__('Sign Out')}}</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('patient.auth.login') }}" class="flex items-center gap-2 cursor-pointer text-slate-500 hover:text-indigo-600 transition font-bold uppercase tracking-widest">
                        <i class="fa-regular fa-user text-sm"></i> <span>{{__('Sign In')}}</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MAIN NAVIGATION                              -->
<!-- ============================================ -->
@include('frontend.includes.nav')

<!-- ============================================ -->
<!-- SEARCH TRAY                                  -->
<!-- ============================================ -->
@include('frontend.includes.search-tray')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Desktop Account Dropdown
        const accountTrigger = document.getElementById('account-trigger');
        const accountDropdown = document.getElementById('account-dropdown');
        const accountWrapper = document.getElementById('account-wrapper');

        if (accountTrigger && accountDropdown) {
            accountTrigger.addEventListener('click', function(e) {
                e.stopPropagation();
                accountDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function(e) {
                if (accountWrapper && !accountWrapper.contains(e.target)) {
                    accountDropdown.classList.add('hidden');
                }
            });
        }
    });
</script>
