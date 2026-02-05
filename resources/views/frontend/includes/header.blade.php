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
            
            <!-- MY ACCOUNT DROPDOWN -->
            <div class="relative h-full flex items-center py-2" id="account-wrapper">
                <div id="account-trigger" class="flex items-center gap-2 cursor-pointer hover:text-imperial-primary transition select-none focus:outline-none">
                    <i class="fa-regular fa-user"></i> <span>My Account</span>
                    <i class="fa-solid fa-chevron-down text-[10px] ml-1"></i>
                </div>
                <!-- Dropdown Content -->
                <div id="account-dropdown" class="hidden absolute top-full right-0 w-48 bg-white text-gray-800 shadow-xl rounded-b-lg border border-gray-100 z-[60] overflow-hidden transition-all duration-200">
                    <a href="signin.php" class="block px-4 py-3 hover:bg-imperial-light hover:text-white transition font-medium border-b border-gray-50">Sign In</a>
                    <a href="signup.php" class="block px-4 py-3 hover:bg-imperial-light hover:text-white transition font-medium">Sign Up</a>
                </div>
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
