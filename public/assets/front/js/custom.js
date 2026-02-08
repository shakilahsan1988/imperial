        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        imperial: {
                            primary: '#007caa', /* The primary blue */
                            dark: '#000000',
                            light: '#4bb7db',/* The primary light blue */
                            text: '#282828',
                            gray: '#646464'                          
                        }
                    },
                    fontFamily: {
                        sans: ['"IBM Plex Sans"', 'sans-serif'],
                        roboto: ['"Roboto"', 'sans-serif'],
                    }
                }
            }
    }
document.addEventListener('DOMContentLoaded', () => {
      
            // 1. Filter Form Handling
            const filterForm = document.getElementById('filterForm');
            if(filterForm) {
                filterForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    
                    // Visual feedback
                    const btn = filterForm.querySelector('button[type="submit"]');
                    const originalContent = btn.innerHTML;
                    
                    // Simulate loading state
                    btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Searching...';
                    btn.disabled = true;
                    btn.classList.add('opacity-75');

                    setTimeout(() => {
                        // Restore button
                        btn.innerHTML = originalContent;
                        btn.disabled = false;
                        btn.classList.remove('opacity-75');
                        
                        // Show result alert (In a real app, you'd filter DOM or AJAX)
                        alert('Filter criteria applied! (This is a static demo)');
                    }, 800);
                });
            }

            // 2. Alphabet Navigation Active State
            const navContainer = document.querySelector('.flex.flex-wrap.items-center.justify-center.gap-2');
            
            if(navContainer) {
                const navButtons = navContainer.querySelectorAll('button');
                
                navButtons.forEach(btn => {
                    btn.addEventListener('click', function() {
                        if (this.textContent === 'All') {
                            // Reset all
                            navButtons.forEach(b => {
                                if (b.textContent !== 'All') {
                                    b.classList.remove('bg-imperial-primary', 'text-white', 'border-imperial-primary');
                                    b.classList.add('text-imperial-text', 'border-gray-300');
                                }
                            });
                        } else {
                            // Highlight selected letter
                            navButtons.forEach(b => {
                                if (b.textContent !== 'All') {
                                    b.classList.remove('bg-imperial-primary', 'text-white', 'border-imperial-primary');
                                    b.classList.add('text-imperial-text', 'border-gray-300');
                                }
                            });
                            
                            this.classList.remove('text-imperial-text', 'border-gray-300');
                            this.classList.add('bg-imperial-primary', 'text-white', 'border-imperial-primary');
                        }
                    });
                });
            }
       // --- 1. Handle Appointment Type Selection ---
            const typeRadios = document.querySelectorAll('input[name="appt_type"]');
            const summaryType = document.getElementById('summary-type');

            typeRadios.forEach(radio => {
                radio.addEventListener('change', (e) => {
                    if(summaryType) {
                        summaryType.textContent = e.target.value === 'hub' ? 'In Hub' : 'Online Consultation';
                    }
                });
            });

            // --- 2. Handle Date/Time Selection ---
            const slotCards = document.querySelectorAll('input[name="appointment_slot"]');
            const summaryDate = document.getElementById('summary-date');
            const summaryTime = document.getElementById('summary-time');

            slotCards.forEach(radio => {
                radio.addEventListener('change', (e) => {
                    // Remove active styling from all cards
                    slotCards.forEach(r => {
                        const card = r.closest('div.border'); // Find parent card
                        card.classList.remove('border-imperial-primary', 'bg-blue-50');
                        // We keep border-gray-200 because we added it to the class list
                    });

                    // Add active styling to selected card
                    const selectedCard = e.target.closest('div.border');
                    selectedCard.classList.add('border-imperial-primary', 'bg-blue-50');
                    selectedCard.classList.remove('border-gray-200');

                    // Update Summary Panel
                    const textContent = selectedCard.querySelector('.text-lg').textContent + " (" + selectedCard.querySelector('.text-xs').textContent + ")";
                    const timeText = selectedCard.querySelector('.text-imperial-primary').textContent;
                    
                    if(summaryDate) summaryDate.textContent = textContent;
                    if(summaryTime) summaryTime.textContent = timeText;
                });
            });

            // Initialize first selection visual state
            const defaultRadio = document.querySelector('input[name="appointment_slot"]:checked');
            if(defaultRadio) {
                defaultRadio.dispatchEvent(new Event('change'));
            }
      
    /* =========================================
       1. ACCOUNT DROPDOWN LOGIC
       ========================================= */
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

    /* =========================================
       2. SEARCH TRAY LOGIC
       ========================================= */
    const searchTriggers = [
        document.getElementById('search-trigger-desktop'),
        document.getElementById('search-trigger-mobile')
    ];
    const searchTray = document.getElementById('search-tray');
    const closeSearchBtn = document.getElementById('close-search-tray');
    const searchInput = searchTray ? searchTray.querySelector('input') : null;

    function openSearchTray() {
        if (!searchTray) return;
        
        // Open tray
        searchTray.classList.remove('-translate-y-[110%]');
        searchTray.classList.add('translate-y-0');
        
        // Close Mobile Menu if open
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenu && !mobileMenu.classList.contains('-translate-x-full')) {
            toggleMenu(); // Call function defined below
        }

        // Close Account Dropdown if open
        if (accountDropdown && !accountDropdown.classList.contains('hidden')) {
            accountDropdown.classList.add('hidden');
        }

        // Focus input after transition
        setTimeout(() => {
            searchInput?.focus();
        }, 300);

        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function closeSearchTray() {
        if (!searchTray) return;
        
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
        if (e.key === 'Escape' && searchTray && !searchTray.classList.contains('-translate-y-[110%]')) {
            closeSearchTray();
        }
    });

    /* =========================================
       3. MOBILE MENU LOGIC
       ========================================= */
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileOverlay = document.getElementById('mobile-overlay');
    const menuIcon = mobileMenuBtn ? mobileMenuBtn.querySelector('i') : null;

    window.toggleMenu = () => { // Make global for reuse in search tray
        if (!mobileMenu || !mobileMenuBtn) return;

        const isClosed = mobileMenu.classList.contains('-translate-x-full');
        
        if (isClosed) {
            // Open
            mobileMenu.classList.remove('-translate-x-full');
            mobileMenu.classList.add('translate-x-0');
            
            if(mobileOverlay) {
                mobileOverlay.classList.remove('hidden');
                setTimeout(() => mobileOverlay.classList.remove('opacity-0'), 10);
            }

            if(menuIcon) {
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-xmark');
            }
            document.body.style.overflow = 'hidden';
        } else {
            // Close
            mobileMenu.classList.add('-translate-x-full');
            mobileMenu.classList.remove('translate-x-0');
            
            if(mobileOverlay) {
                mobileOverlay.classList.add('opacity-0');
                setTimeout(() => mobileOverlay.classList.add('hidden'), 300);
            }

            if(menuIcon) {
                menuIcon.classList.remove('fa-xmark');
                menuIcon.classList.add('fa-bars');
            }
            document.body.style.overflow = '';
        }
    };

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', toggleMenu);
        if (mobileOverlay) mobileOverlay.addEventListener('click', toggleMenu);
    }

    /* =========================================
       4. STICKY HEADER SHADOW
       ========================================= */
    const header = document.getElementById('main-header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 10) {
            header?.classList.add('shadow-md');
        } else {
            header?.classList.remove('shadow-md');
        }
    });

    /* =========================================
       5. MODAL LOGIC (Auto Open)
       ========================================= */
    const modalBackdrop = document.querySelector('#modal-xl');
    const modalContent = modalBackdrop ? modalBackdrop.querySelector('[data-dialog="modal-xl"]') : null;
    const closeButtons = document.querySelectorAll('[data-dialog-close="true"]');
    const openButtons = document.querySelectorAll('[data-dialog-target="modal-xl"]');

    if (modalBackdrop) {
        function openModal() {
            modalBackdrop.classList.remove('pointer-events-none', 'opacity-0');
            modalBackdrop.classList.add('pointer-events-auto', 'opacity-100');
            
            if(modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }

        function closeModal() {
            modalBackdrop.classList.remove('pointer-events-auto', 'opacity-100');
            modalBackdrop.classList.add('pointer-events-none', 'opacity-0');
            
            if(modalContent) {
                modalContent.classList.remove('scale-100');
                modalContent.classList.add('scale-95');
            }
        }

        // Auto Open on Load (500ms delay)
        setTimeout(openModal, 500);

        // Attach Close Events
        closeButtons.forEach(btn => btn.addEventListener('click', closeModal));

        // Attach Open Events (if manual button exists)
        openButtons.forEach(btn => btn.addEventListener('click', openModal));
    }

    /* =========================================
       6. HERO CAROUSEL LOGIC
       ========================================= */
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.carousel-dot');
    
    if (slides.length > 0) {
        let currentSlide = 0;
        const slideInterval = 5000; // 5 seconds

        function updateSlides() {
            slides.forEach((slide, index) => {
                slide.classList.remove('active');
                if (dots[index]) {
                    dots[index].classList.remove('bg-white');
                    dots[index].classList.add('bg-white/50');
                }
                if (index === currentSlide) {
                    slide.classList.add('active');
                    if (dots[index]) {
                        dots[index].classList.remove('bg-white/50');
                        dots[index].classList.add('bg-white');
                    }
                }
            });
        }

        // Expose globally for onclick handlers
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
    }

    /* =========================================
       7. MOBILE SUBMENU LOGIC
       ========================================= */
    // Used in nav.blade.php: onclick="toggleSubmenu(this)"
    window.toggleSubmenu = (button) => {
        const submenu = button.nextElementSibling;
        const icon = button.querySelector('i');
        
        if (submenu && icon) {
            if (submenu.classList.contains('hidden')) {
                submenu.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                submenu.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    };

    /* =========================================
       8. FAQ LOGIC
       ========================================= */
    // Used in footer/content: onclick="toggleFaq(this)"
    window.toggleFaq = (button) => {
        const item = button.parentElement;
        const content = item.querySelector('.faq-content');
        
        if (item && content) {
            item.classList.toggle('active');

            if (item.classList.contains('active')) {
                content.style.maxHeight = content.scrollHeight + "px";
            } else {
                content.style.maxHeight = null;
            }
        }
    };
});

  function toggleMegaSubmenu(menuId, button) {
        const menu = document.getElementById(menuId);
        const icon = button.querySelector('i');

        // Toggle Visibility
        menu.classList.toggle('hidden');

        // Rotate Icon
        if (menu.classList.contains('hidden')) {
            icon.classList.remove('rotate-180');
        } else {
            icon.classList.add('rotate-180');
        }
    }