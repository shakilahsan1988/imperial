<!-- 
    MODERN PREMIUM HERO SLIDER
    Features: Ken Burns Effect, Staggered Text Animations, Progress Bar Navigation
-->

<style>
    #hero-slider {
        position: relative;
        width: 100%;
        height: 100vh;
        overflow: hidden;
        background-color: #0f172a;
    }

    /* --- Background & Ken Burns Effect --- */
    .slide-bg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-cover: cover;
        transform: scale(1);
        transition: transform 8s linear;
        opacity: 0;
        z-index: 1;
    }

    .slide.active .slide-bg {
        opacity: 1;
        transform: scale(1.15); /* Subtile Zoom In */
    }

    /* --- Advanced Overlay --- */
    .slide-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.4) 50%, transparent 100%);
        z-index: 2;
        opacity: 0;
        transition: opacity 1s ease;
    }

    .slide.active .slide-overlay {
        opacity: 1;
    }

    /* --- Content Animations --- */
    .slide-content {
        position: relative;
        z-index: 10;
        height: 100%;
        display: flex;
        align-items: center;
        opacity: 0;
        visibility: hidden;
    }

    .slide.active .slide-content {
        opacity: 1;
        visibility: visible;
    }

    .animate-item {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.2, 1, 0.3, 1);
    }

    .slide.active .animate-1 { transition-delay: 0.3s; opacity: 1; transform: translateY(0); }
    .slide.active .animate-2 { transition-delay: 0.5s; opacity: 1; transform: translateY(0); }
    .slide.active .animate-3 { transition-delay: 0.7s; opacity: 1; transform: translateY(0); }
    .slide.active .animate-4 { transition-delay: 0.9s; opacity: 1; transform: translateY(0); }

    /* --- Navigation: Progress Lines --- */
    .nav-container {
        position: absolute;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 20;
        display: flex;
        gap: 15px;
    }

    .progress-btn {
        width: 60px;
        height: 4px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 2px;
        position: relative;
        cursor: pointer;
        overflow: hidden;
    }

    .progress-fill {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 0%;
        background: #ffffff;
    }

    .progress-btn.active .progress-fill {
        width: 100%;
        transition: width 6s linear; /* Matches auto-play duration */
    }

    /* --- Arrows --- */
    .slider-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 30;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
    }

    .slider-arrow:hover {
        background: #007caa;
        border-color: #007caa;
        transform: translateY(-50%) scale(1.1);
    }

    .arrow-left { left: 30px; }
    .arrow-right { right: 30px; }

    @media (max-width: 768px) {
        .slider-arrow { display: none; }
        .slide-overlay {
            background: rgba(15, 23, 42, 0.7);
        }
        .slide-content { text-align: center; justify-content: center; }
    }
</style>

<section id="hero-slider">
    
    <!-- Slide 1 -->
    <div class="slide active h-full w-full absolute inset-0" data-index="0">
        <img src="{{ asset('assets/front/images/index/slide-1.jpeg') }}" onerror="this.src='https://picsum.photos/seed/h1/1920/1080'" class="slide-bg">
        <div class="slide-overlay"></div>
        <div class="container mx-auto px-6 slide-content">
            <div class="max-w-2xl">
                <span class="animate-item animate-1 inline-block text-indigo-400 font-black uppercase tracking-[0.3em] text-[10px] mb-4">Precision & Care</span>
                <h1 class="animate-item animate-2 text-4xl md:text-7xl font-extrabold text-white mb-6 tracking-tight leading-tight">Healthcare <br>Anytime, <span class="text-indigo-400 italic">Anywhere</span></h1>
                <p class="animate-item animate-3 text-lg md:text-xl text-slate-300 font-medium leading-relaxed mb-10">Experience the future of healthcare with our world-class medical facilities and home diagnostics.</p>
                <div class="animate-item animate-4">
                    <a href="{{ route('services') }}" class="bg-white text-slate-900 px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-indigo-50 transition-all shadow-xl active:scale-95 inline-block">Explore Services</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 2 -->
    <div class="slide h-full w-full absolute inset-0" data-index="1">
        <img src="{{ asset('assets/front/images/index/slide-2.jpeg') }}" onerror="this.src='https://picsum.photos/seed/h2/1920/1080'" class="slide-bg">
        <div class="slide-overlay"></div>
        <div class="container mx-auto px-6 slide-content">
            <div class="max-w-2xl">
                <span class="animate-item animate-1 inline-block text-indigo-400 font-black uppercase tracking-[0.3em] text-[10px] mb-4">Wellness Packages</span>
                <h1 class="animate-item animate-2 text-4xl md:text-7xl font-extrabold text-white mb-6 tracking-tight leading-tight">Affordable <br>Health <span class="text-indigo-400 italic">Checks</span></h1>
                <p class="animate-item animate-3 text-lg md:text-xl text-slate-300 font-medium leading-relaxed mb-10">Tailored packages designed for every age and gender, fitting perfectly within your family budget.</p>
                <div class="animate-item animate-4">
                    <a href="{{ route('health-check') }}" class="bg-white text-slate-900 px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-indigo-50 transition-all shadow-xl active:scale-95 inline-block">View Packages</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 3 -->
    <div class="slide h-full w-full absolute inset-0" data-index="2">
        <img src="{{ asset('assets/front/images/index/slide-3.jpeg') }}" onerror="this.src='https://picsum.photos/seed/h3/1920/1080'" class="slide-bg">
        <div class="slide-overlay"></div>
        <div class="container mx-auto px-6 slide-content">
            <div class="max-w-2xl">
                <span class="animate-item animate-1 inline-block text-indigo-400 font-black uppercase tracking-[0.3em] text-[10px] mb-4">Lab at Doorstep</span>
                <h1 class="animate-item animate-2 text-4xl md:text-7xl font-extrabold text-white mb-6 tracking-tight leading-tight">Hassle-Free <br>Diagnostic <span class="text-indigo-400 italic">Tests</span></h1>
                <p class="animate-item animate-3 text-lg md:text-xl text-slate-300 font-medium leading-relaxed mb-10">Avoid the traffic and wait. Our experts come to you for sample collection in the comfort of your home.</p>
                <div class="animate-item animate-4">
                    <a href="{{ route('lab-test') }}" class="bg-white text-slate-900 px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-indigo-50 transition-all shadow-xl active:scale-95 inline-block">Book Home Test</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Nav -->
    <div class="nav-container">
        <div class="progress-btn active" onclick="jumpToSlide(0)"><div class="progress-fill"></div></div>
        <div class="progress-btn" onclick="jumpToSlide(1)"><div class="progress-fill"></div></div>
        <div class="progress-btn" onclick="jumpToSlide(2)"><div class="progress-fill"></div></div>
    </div>

    <!-- Arrow Controls -->
    <div class="slider-arrow arrow-left" onclick="moveSlide(-1)">
        <i class="fa-solid fa-chevron-left"></i>
    </div>
    <div class="slider-arrow arrow-right" onclick="moveSlide(1)">
        <i class="fa-solid fa-chevron-right"></i>
    </div>

</section>

<script>
    let currentSlideIndex = 0;
    const allSlides = document.querySelectorAll('.slide');
    const allProgressBtns = document.querySelectorAll('.progress-btn');
    const slideCount = allSlides.length;
    let slideTimer;

    function showSlide(index) {
        // Reset
        allSlides.forEach(s => s.classList.remove('active'));
        allProgressBtns.forEach(b => b.classList.remove('active'));
        
        // Update Index
        if (index >= slideCount) currentSlideIndex = 0;
        else if (index < 0) currentSlideIndex = slideCount - 1;
        else currentSlideIndex = index;

        // Activate
        allSlides[currentSlideIndex].classList.add('active');
        allProgressBtns[currentSlideIndex].classList.add('active');

        // Restart Auto-play timer
        clearTimeout(slideTimer);
        slideTimer = setTimeout(() => showSlide(currentSlideIndex + 1), 6000);
    }

    function moveSlide(step) {
        showSlide(currentSlideIndex + step);
    }

    function jumpToSlide(index) {
        showSlide(index);
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        showSlide(0);
    });
</script>
