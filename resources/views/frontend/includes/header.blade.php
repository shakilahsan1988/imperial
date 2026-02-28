<!-- ============================================ -->
<!-- TOP BAR (Phone, Email, Cart, Account)       -->
<!-- ============================================ -->
<div class="bg-white border-b border-gray-200 hidden md:block text-sm py-2 relative z-40">
    <div class="container mx-auto px-6 flex justify-between items-center">
        <div class="flex gap-6 text-imperial-gray">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-phone text-imperial-primary"></i> 
                <a href="tel:10648" class="hover:text-imperial-primary transition">10648</a>
            </span>
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-envelope text-imperial-primary"></i> 
                <a href="mailto:imperiallistens@imperialhealth.com" class="hover:text-imperial-primary transition">imperiallistens@imperialhealth.com</a>
            </span>
        </div>
        <div class="flex gap-6 items-center text-imperial-gray">
            <a href="#" class="flex items-center gap-2 cursor-pointer hover:text-imperial-primary transition group">
                <i class="fa-solid fa-cart-shopping group-hover:scale-110 transition-transform"></i> 
                <span>Cart</span>
            </a>
            
            <!-- MY ACCOUNT -->
            <div class="relative h-full flex items-center py-2" id="account-wrapper">
                @if(auth()->guard('patient')->check())
                    <div id="account-trigger" class="flex items-center gap-2 cursor-pointer hover:text-indigo-600 transition select-none focus:outline-none">
                        <i class="fa-regular fa-user"></i> <span>{{__('My Account')}}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1"></i>
                    </div>
                    <!-- Dropdown Content -->
                    <div id="account-dropdown" class="hidden absolute top-full right-0 w-48 bg-white text-slate-700 shadow-2xl rounded-b-2xl border border-slate-100 z-[60] overflow-hidden transition-all duration-200">
                        <a href="{{ route('patient.index') }}" class="block px-6 py-3 hover:bg-indigo-50 hover:text-indigo-600 transition font-bold border-b border-slate-50">{{__('Dashboard')}}</a>
                        <form action="{{ route('patient.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left block px-6 py-3 hover:bg-red-50 hover:text-red-600 transition font-bold">{{__('Sign Out')}}</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('patient.auth.login') }}" class="flex items-center gap-2 cursor-pointer hover:text-indigo-600 transition font-bold">
                        <i class="fa-regular fa-user"></i> <span>{{__('Sign In')}}</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MAIN NAVIGATION (Include nav.blade.php)      -->
<!-- ============================================ -->
@include('frontend.includes.nav')

<!-- ============================================ -->
<!-- SEARCH TRAY (Include search-tray.blade.php)  -->
<!-- ============================================ -->
@include('frontend.includes.search-tray')

<!-- ============================================ -->
<!-- JAVASCRIPT LOGIC (Kept here for simplicity)  -->
<!-- ============================================ -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accountTrigger = document.getElementById('account-trigger');
        const accountDropdown = document.getElementById('account-dropdown');
        const accountWrapper = document.getElementById('account-wrapper');

        if (accountTrigger && accountDropdown) {
            accountTrigger.addEventListener('click', function(e) {
                e.stopPropagation();
                accountDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function(e) {
                if (!accountWrapper.contains(e.target)) {
                    accountDropdown.classList.add('hidden');
                }
            });
        }
    });
</script>
