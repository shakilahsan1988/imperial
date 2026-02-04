<!-- 
  HERO CAROUSEL (VERIFIED - All Slides have Text and Buttons)
-->

<!-- 1. Tailwind Configuration -->
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    imperial: {
                        primary: '#0e7490', 
                        dark: '#155e75',     
                    }
                }
            }
        }
    }
</script>

<!-- 2. CSS -->
<style>
    /* SLIDE POSITIONING */
    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.8s ease-in-out;
    }

    .slide.active {
        opacity: 1;
        visibility: visible;
    }

    /* DOT NAVIGATION */
    .carousel-dot.active {
        background-color: white;
        transform: scale(1.2);
    }
</style>

<!-- 3. HERO SECTION -->
<section class="relative w-full min-h-[100vh] h-[100vh] md:h-[100vh] overflow-hidden bg-gray-900" id="heroCarousel">

    <!-- ==========================================
         SLIDE 1 
         Contains: H1, Paragraph, Button
    ========================================== -->
    <div class="slide active" data-index="0">
        <!-- Background Image -->
        <img src="https://images.pexels.com/photos/6129653/pexels-photo-6129653.jpeg" 
             onerror="this.src='https://picsum.photos/seed/health1/1920/1080'"
             class="w-full h-full object-cover absolute top-0 left-0">
        
        <!-- Dark Overlay (for contrast) -->
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- CONTENT CONTAINER (Text & Button) -->
        <div class="absolute inset-0 flex items-center justify-center text-center px-4 z-10">
            <div class="max-w-4xl text-white">
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight drop-shadow-lg">Healthcare Anytime, Anywhere</h1>
                <p class="text-lg md:text-xl mb-8 opacity-90 drop-shadow-md">Let us take care of your health with world-class facilities.</p>
                
                <!-- BUTTON -->
                <a href="#" class="inline-block bg-imperial-primary text-white px-8 py-3 rounded-full font-medium hover:bg-imperial-dark transition shadow-lg">Explore our services</a>
            </div>
        </div>
    </div>

    <!-- ==========================================
         SLIDE 2 
         Contains: H1, Paragraph, Button
    ========================================== -->
    <div class="slide" data-index="1">
        <!-- Background Image -->
        <img src="https://images.pexels.com/photos/6129502/pexels-photo-6129502.jpeg" 
             onerror="this.src='https://picsum.photos/seed/health2/1920/1080'"
             class="w-full h-full object-cover absolute top-0 left-0">

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- CONTENT CONTAINER (Text & Button) -->
        <div class="absolute inset-0 flex items-center justify-center text-center px-4 z-10">
            <div class="max-w-4xl text-white">
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight drop-shadow-lg">Affordable Health Checks & Packages</h1>
                <p class="text-lg md:text-xl mb-8 opacity-90 drop-shadow-md">Imperial has designed health checks and packages tailored to your needs, based on age and gender, that fit within your budget.</p>
                
                <!-- BUTTON -->
                <a href="#" class="inline-block bg-imperial-primary text-white px-8 py-3 rounded-full font-medium hover:bg-imperial-dark transition shadow-lg">Explore your options</a>
            </div>
        </div>
    </div>

    <!-- ==========================================
         SLIDE 3 
         Contains: H1, Paragraph, Button
    ========================================== -->
    <div class="slide" data-index="2">
        <!-- Background Image -->
        <img src="https://images.pexels.com/photos/6129644/pexels-photo-6129644.jpeg" 
             onerror="this.src='https://picsum.photos/seed/health3/1920/1080'"
             class="w-full h-full object-cover absolute top-0 left-0">

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- CONTENT CONTAINER (Text & Button) -->
        <div class="absolute inset-0 flex items-center justify-center text-center px-4 z-10">
            <div class="max-w-4xl text-white">
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight drop-shadow-lg">Hassle-Free Lab Tests</h1>
                <p class="text-lg md:text-xl mb-8 opacity-90 drop-shadow-md">We offer lab tests at home, especially during busy schedules, harsh weather and heavy traffic.</p>
                
                <!-- BUTTON -->
                <a href="#" class="inline-block bg-imperial-primary text-white px-8 py-3 rounded-full font-medium hover:bg-imperial-dark transition shadow-lg">Book a test</a>
            </div>
        </div>
    </div>

    <!-- CONTROLS (Bottom Dots) -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex gap-3 z-20">
        <button class="carousel-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition active" onclick="goToSlide(0)"></button>
        <button class="carousel-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition" onclick="goToSlide(1)"></button>
        <button class="carousel-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition" onclick="goToSlide(2)"></button>
    </div>
    
    <!-- CONTROLS (Arrows) -->
    <button class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white p-3 rounded-full z-20" onclick="changeSlide(-1)">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white p-3 rounded-full z-20" onclick="changeSlide(1)">
        <i class="fa-solid fa-chevron-right"></i>
    </button>
</section>

<!-- 4. JAVASCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.carousel-dot');
        let currentIndex = 0;
        const totalSlides = slides.length;

        function updateSlideClasses() {
            slides.forEach((slide, index) => {
                if(index === currentIndex) slide.classList.add('active');
                else slide.classList.remove('active');
            });
            dots.forEach((dot, index) => {
                if(index === currentIndex) dot.classList.add('active');
                else dot.classList.remove('active');
            });
        }

        window.goToSlide = function(index) {
            currentIndex = index;
            updateSlideClasses();
        };

        window.changeSlide = function(direction) {
            currentIndex += direction;
            if (currentIndex >= totalSlides) currentIndex = 0;
            if (currentIndex < 0) currentIndex = totalSlides - 1;
            updateSlideClasses();
        };

        // Simple Auto-play
        setInterval(() => {
            changeSlide(1);
        }, 5000);
    });
</script>