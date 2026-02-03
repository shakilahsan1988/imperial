
    <!-- Footer: Background Gray -->
    <footer class="bg-gray-200 pt-16 pb-8">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <!-- Brand & Newsletter -->
                <div>
                    <img src="../assets/logo.jpg" alt="Imperial Health" class="h-8 w-auto mb-6 " onerror="this.src='https://placehold.co/150x50/ffffff/333333?text=imperial+Health'">
                    <h4 class="text-lg font-bold mb-4">Keep up with imperial</h4>
                    <p class="text-gray-600 text-sm mb-4">Subscribe to our newsletter for health tips and updates.</p>
                    <form class="flex gap-2" onsubmit="event.preventDefault(); alert('Thank you for subscribing!');">
                        <input type="email" placeholder="Email Address" class="border border-imperial-primary rounded px-4 py-2 w-full focus:ring-1 focus:ring-imperial-primary text-sm">
                        <button type="submit" class="bg-imperial-primary text-white px-4 py-2 rounded hover:bg-imperial-dark transition">Subscribe</button>
                    </form>
                    <div class="flex gap-4 mt-6">
                        <a href="#" class="text-gray-600 hover:text-white"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-600 hover:text-white"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" class="text-gray-600 hover:text-white"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#" class="text-gray-600 hover:text-white"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="text-lg font-bold mb-4 text-dark">Services</h4>
                    <ul class="space-y-2 text-gray-600 text-sm">
                        <li><a href="#" class="hover:text-imperial-primary transition">Tests & Procedures</a></li>
                        <li><a href="#" class="hover:text-imperial-primary transition">Health Checks & Packages</a></li>
                        <li><a href="#" class="hover:text-imperial-primary transition">Membership Plans</a></li>
                        <li><a href="#" class="hover:text-imperial-primary transition">Diagnostics</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h4 class="text-lg font-bold mb-4 text-dark">Resources</h4>
                    <ul class="space-y-2 text-gray-600 text-sm">
                        <li><a href="#" class="hover:text-imperial-primary transition">Our Doctors</a></li>
                        <li><a href="#" class="hover:text-imperial-primary transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-imperial-primary transition">Blog</a></li>
                        <li><a href="#" class="hover:text-imperial-primary transition">Careers</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-bold mb-4 text-dark">Get in touch</h4>
                    <ul class="space-y-3 text-gray-600 text-sm">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot mt-1 text-imperial-primary"></i>
                            <span>Banani, Dhaka<br>Bangladesh</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-imperial-primary"></i>
                            <a href="tel:10648" class="hover:text-white">10648</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-imperial-primary"></i>
                            <a href="mailto:imperiallistens@imperialhealth.com" class="hover:text-white">imperiallistens@imperialhealth.com</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
                <div class="flex gap-6 mb-4 md:mb-0">
                    <a href="#" class="hover:text-white">Privacy Notice</a>
                    <a href="#" class="hover:text-white">Code of Ethics</a>
                    <a href="#" class="hover:text-white">Patient Bill of Rights</a>
                </div>
                <div>
                    <p>&copy; 2019-2025 Imperial Health Bangladesh Limited.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Book Appointment Button (Mobile Friendly) -->
    <div class="fixed bottom-6 right-6 z-40 md:hidden">
        <a href="#" class="fab-pulse flex items-center justify-center bg-imperial-primary text-white w-14 h-14 rounded-full shadow-lg">
            <i class="fa-solid fa-calendar-check text-xl"></i>
        </a>
    </div>

   

    <!-- ================= JAVASCRIPT ================= -->
    <script>

        document.addEventListener('DOMContentLoaded', () => {
            
            // --- 1. ACCOUNT DROPDOWN CLICK LOGIC ---
            const accountTrigger = document.getElementById('account-trigger');
            const accountDropdown = document.getElementById('account-dropdown');
            const accountWrapper = document.getElementById('account-wrapper');

            if (accountTrigger && accountDropdown) {
                // Toggle on Click
                accountTrigger.addEventListener('click', (e) => {
                    e.stopPropagation(); // Prevent document click from firing immediately
                    accountDropdown.classList.toggle('hidden');
                });

                // Close when clicking outside
                document.addEventListener('click', (e) => {
                    if (!accountWrapper.contains(e.target)) {
                        accountDropdown.classList.add('hidden');
                    }
                });
            }


            // --- 2. MODAL LOGIC (Open on Load & Close) ---
            const modalBackdrop = document.querySelector('#modal-xl');
            const modalContent = modalBackdrop ? modalBackdrop.querySelector('[data-dialog="modal-xl"]') : null;
            const closeButtons = document.querySelectorAll('[data-dialog-close="true"]');
            const openButtons = document.querySelectorAll('[data-dialog-target="modal-xl"]');

            function openModal() {
                if (modalBackdrop) {
                    modalBackdrop.classList.remove('pointer-events-none', 'opacity-0');
                    modalBackdrop.classList.add('pointer-events-auto', 'opacity-100');
                    
                    if(modalContent) {
                        modalContent.classList.remove('scale-95');
                        modalContent.classList.add('scale-100');
                    }
                }
            }

            function closeModal() {
                if (modalBackdrop) {
                    modalBackdrop.classList.remove('pointer-events-auto', 'opacity-100');
                    modalBackdrop.classList.add('pointer-events-none', 'opacity-0');
                    
                    if(modalContent) {
                        modalContent.classList.remove('scale-100');
                        modalContent.classList.add('scale-95');
                    }
                }
            }

            // Auto Open on Load (500ms delay)
            setTimeout(openModal, 500);

            // Attach Close Events (X button and Cancel link)
            closeButtons.forEach(btn => {
                btn.addEventListener('click', closeModal);
            });

            // Attach Open Events (if manual button exists)
            openButtons.forEach(btn => {
                btn.addEventListener('click', openModal);
            });


            // --- 3. HERO CAROUSEL LOGIC ---
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.carousel-dot');
            let currentSlide = 0;
            const slideInterval = 5000; // 5 seconds

            function updateSlides() {
                slides.forEach((slide, index) => {
                    slide.classList.remove('active');
                    dots[index].classList.remove('bg-white');
                    dots[index].classList.add('bg-white/50');
                    if (index === currentSlide) {
                        slide.classList.add('active');
                        dots[index].classList.remove('bg-white/50');
                        dots[index].classList.add('bg-white');
                    }
                });
            }

            window.goToSlide = (index) => {
                currentSlide = index;
                updateSlides();
                resetTimer();
            };

            window.changeSlide = (direction) => {
                currentSlide = (currentSlide + direction + slides.length) % slides.length;
                updateSlides();
                resetTimer();
            };

            let autoPlayTimer = setInterval(() => {
                currentSlide = (currentSlide + 1) % slides.length;
                updateSlides();
            }, slideInterval);

            function resetTimer() {
                clearInterval(autoPlayTimer);
                autoPlayTimer = setInterval(() => {
                    currentSlide = (currentSlide + 1) % slides.length;
                    updateSlides();
                }, slideInterval);
            }


            // --- 4. MOBILE MENU LOGIC ---
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileOverlay = document.getElementById('mobile-overlay');
            const menuIcon = mobileMenuBtn.querySelector('i');

            function toggleMenu() {
                const isClosed = mobileMenu.classList.contains('-translate-x-full');
                
                if (isClosed) {
                    mobileMenu.classList.remove('-translate-x-full');
                    mobileOverlay.classList.remove('hidden');
                    setTimeout(() => mobileOverlay.classList.remove('opacity-0'), 10);
                    menuIcon.classList.remove('fa-bars');
                    menuIcon.classList.add('fa-xmark');
                    document.body.style.overflow = 'hidden';
                } else {
                    mobileMenu.classList.add('-translate-x-full');
                    mobileOverlay.classList.add('opacity-0');
                    setTimeout(() => mobileOverlay.classList.add('hidden'), 300);
                    menuIcon.classList.remove('fa-xmark');
                    menuIcon.classList.add('fa-bars');
                    document.body.style.overflow = '';
                }
            }

            mobileMenuBtn.addEventListener('click', toggleMenu);
            mobileOverlay.addEventListener('click', toggleMenu);

            window.toggleSubmenu = (button) => {
                const submenu = button.nextElementSibling;
                const icon = button.querySelector('i');
                
                if (submenu.classList.contains('hidden')) {
                    submenu.classList.remove('hidden');
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    submenu.classList.add('hidden');
                    icon.style.transform = 'rotate(0deg)';
                }
            };


            // --- 5. FAQ LOGIC ---
            window.toggleFaq = (button) => {
                const item = button.parentElement;
                const content = item.querySelector('.faq-content');
                
                item.classList.toggle('active');

                if (item.classList.contains('active')) {
                    content.style.maxHeight = content.scrollHeight + "px";
                } else {
                    content.style.maxHeight = null;
                }
            };


            // --- 6. STICKY HEADER SHADOW ---
            const header = document.getElementById('main-header');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 10) {
                    header.classList.add('shadow-md');
                } else {
                    header.classList.remove('shadow-md');
                }
            });


            // --- 7. SEARCH TRAY LOGIC (NEW) ---
            const searchTriggers = [
                document.getElementById('search-trigger-desktop'),
                document.getElementById('search-trigger-mobile')
            ];
            const searchTray = document.getElementById('search-tray');
            const closeSearchBtn = document.getElementById('close-search-tray');
            const searchInput = searchTray.querySelector('input');

            function openSearchTray() {
                // Open tray
                searchTray.classList.remove('-translate-y-[110%]');
                searchTray.classList.add('translate-y-0');
                
                // Close Mobile Menu if open
                if (!mobileMenu.classList.contains('-translate-x-full')) {
                    toggleMenu();
                }

                // Close Account Dropdown if open
                if (accountDropdown && !accountDropdown.classList.contains('hidden')) {
                    accountDropdown.classList.add('hidden');
                }

                // Focus input after animation
                setTimeout(() => {
                    searchInput.focus();
                }, 300);

                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }

            function closeSearchTray() {
                searchTray.classList.remove('translate-y-0');
                searchTray.classList.add('-translate-y-[110%]');
                document.body.style.overflow = ''; // Restore scrolling
            }

            // Attach open events to both search icons
            searchTriggers.forEach(btn => {
                if(btn) {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        openSearchTray();
                    });
                }
            });

            // Close on X button
            if(closeSearchBtn) {
                closeSearchBtn.addEventListener('click', closeSearchTray);
            }

            // Close on Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !searchTray.classList.contains('-translate-y-[110%]')) {
                    closeSearchTray();
                }
            });

        });
    </script>
</body>
</html>