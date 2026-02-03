document.addEventListener('DOMContentLoaded', () => {


    /* --- Carousel Logic --- */
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.carousel-dot');
    const totalSlides = slides.length;
    let slideInterval;

    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('bg-white'));
        
        slides[index].classList.add('active');
        dots[index].classList.add('bg-white');
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    // Exposed to window for onclick attributes
    window.changeSlide = function(direction) {
        currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
        showSlide(currentSlide);
        resetInterval();
    }

    window.goToSlide = function(index) {
        currentSlide = index;
        showSlide(currentSlide);
        resetInterval();
    }

    function resetInterval() {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 5000); // 5 seconds per slide
    }

    // Initialize Carousel
    if(slides.length > 0) {
        showSlide(0);
        resetInterval();
    }

    /* --- Mobile Menu Logic --- */
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const overlay = document.getElementById('mobile-overlay');

    function toggleMenu() {
        const isClosed = mobileMenu.classList.contains('-translate-x-full');
        if (isClosed) {
            mobileMenu.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            mobileMenu.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    }

    if(menuBtn) {
        menuBtn.addEventListener('click', toggleMenu);
        if(overlay) overlay.addEventListener('click', toggleMenu);
    }

    // Exposed Submenu Toggle
    window.toggleSubmenu = function(btn) {
        const submenu = btn.nextElementSibling;
        if(submenu) {
            submenu.classList.toggle('hidden');
        }
    }

    /* --- FAQ Accordion Logic --- */
    window.toggleFaq = function(button) {
        const item = button.parentElement;
        const content = item.querySelector('.faq-content');
        const isOpen = item.classList.contains('active');

        // Close all others
        document.querySelectorAll('.faq-item').forEach(i => {
            i.classList.remove('active');
            const iContent = i.querySelector('.faq-content');
            if(iContent) {
                iContent.classList.remove('open');
                iContent.style.maxHeight = null;
            }
        });

        // Toggle clicked one
        if (!isOpen && content) {
            item.classList.add('active');
            content.classList.add('open');
            content.style.maxHeight = content.scrollHeight + "px";
        }
    }
});
