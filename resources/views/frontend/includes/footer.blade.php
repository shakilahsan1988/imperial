<!-- ======================================================= -->
<!-- FOOTER SECTION                                          -->
<!-- ======================================================= -->
<footer class="bg-gray-100 border-t border-gray-200 pt-16 pb-8">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
            
            <!-- Brand & Newsletter -->
            <div>
                <!-- Using Laravel asset() helper for images -->
                <img src="{{ asset('assets/front/images/logo.png') }}" alt="Imperial Health" class="footer-logo w-auto mb-6" onerror="this.src='https://placehold.co/150x50/ffffff/333333?text=Imperial+Health'">
                
                <h4 class="text-lg font-bold mb-4 text-imperial-text">Keep up with imperial</h4>
                <p class="text-gray-600 text-sm mb-4">Subscribe to our newsletter for health tips and updates.</p>
                
                <form class="flex gap-2" onsubmit="event.preventDefault(); alert('Thank you for subscribing!');">
                    <input type="email" placeholder="Email Address" class="border border-gray-300 rounded-l px-4 py-2 w-full focus:ring-1 focus:ring-imperial-primary focus:border-imperial-primary text-sm outline-none">
                    <button type="submit" class="bg-imperial-primary text-white px-4 py-2 rounded-r hover:bg-imperial-dark transition">Subscribe</button>
                </form>
                
                <div class="flex gap-4 mt-6">
                    <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 text-imperial-gray hover:bg-imperial-primary hover:text-white transition">
                        <i class="fa-brands fa-facebook-f text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 text-imperial-gray hover:bg-imperial-primary hover:text-white transition">
                        <i class="fa-brands fa-linkedin-in text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 text-imperial-gray hover:bg-imperial-primary hover:text-white transition">
                        <i class="fa-brands fa-youtube text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 text-imperial-gray hover:bg-imperial-primary hover:text-white transition">
                        <i class="fa-brands fa-instagram text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- Services -->
            <div>
                <h4 class="text-lg font-bold mb-4 text-imperial-dark">Services</h4>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li><a href="#" class="hover:text-imperial-primary transition">Tests & Procedures</a></li>
                    <li><a href="#" class="hover:text-imperial-primary transition">Health Checks & Packages</a></li>
                    <li><a href="#" class="hover:text-imperial-primary transition">Membership Plans</a></li>
                    <li><a href="#" class="hover:text-imperial-primary transition">Diagnostics</a></li>
                </ul>
            </div>

            <!-- Resources -->
            <div>
                <h4 class="text-lg font-bold mb-4 text-imperial-dark">Resources</h4>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li><a href="#" class="hover:text-imperial-primary transition">Our Doctors</a></li>
                    <li><a href="#" class="hover:text-imperial-primary transition">FAQ</a></li>
                    <li><a href="#" class="hover:text-imperial-primary transition">Blog</a></li>
                    <li><a href="#" class="hover:text-imperial-primary transition">Careers</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-bold mb-4 text-imperial-dark">Get in touch</h4>
                <ul class="space-y-3 text-gray-600 text-sm">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot mt-1 text-imperial-primary"></i>
                        <span>Banani, Dhaka<br>Bangladesh</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-phone text-imperial-primary"></i>
                        <a href="tel:10648" class="hover:text-imperial-primary">10648</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-envelope text-imperial-primary"></i>
                        <a href="mailto:imperiallistens@imperialhealth.com" class="hover:text-imperial-primary">imperiallistens@imperialhealth.com</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="border-t border-gray-300 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
            <div class="flex gap-6 mb-4 md:mb-0">
                <a href="#" class="hover:text-imperial-primary transition">Privacy Notice</a>
                <a href="#" class="hover:text-imperial-primary transition">Code of Ethics</a>
                <a href="#" class="hover:text-imperial-primary transition">Patient Bill of Rights</a>
            </div>
            <div>
                <p>&copy; {{ date('Y') }} Imperial Health Bangladesh Limited.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Floating Book Appointment Button (Mobile Friendly) -->
<div class="fixed bottom-6 right-6 z-40 md:hidden">
    <a href="#" class="fab-pulse flex items-center justify-center bg-imperial-primary text-white w-14 h-14 rounded-full shadow-lg hover:bg-imperial-dark transition">
        <i class="fa-solid fa-calendar-check text-xl"></i>
    </a>
</div>

<!-- ======================================================= -->
<!-- PAGE SPECIFIC JAVASCRIPT                                -->
<!-- NOTE: Header logic (Dropdown, Search, Mobile Menu)      -->
<!-- is handled in header.blade.php to avoid duplication.    -->
<!-- ======================================================= -->
<script>
  
</script>