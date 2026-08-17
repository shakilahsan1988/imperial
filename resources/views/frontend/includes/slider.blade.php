@php
    $slides = $homeSettings['hero']['slides'] ?? [];
@endphp

@if(count($slides))
<style>
    #hero-slider {
        position: relative;
        isolation: isolate;
        height: clamp(620px, calc(100svh - 120px), 780px);
        min-height: 620px;
        overflow: hidden;
        background: #020617;
    }
    #hero-slider .home-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        visibility: hidden;
        transition: opacity .8s ease, visibility .8s ease;
    }
    #hero-slider .home-slide.active { opacity: 1; visibility: visible; }
    #hero-slider .home-slide-image {
        position: absolute;
        inset: 0;
        height: 100%;
        width: 100%;
        object-fit: cover;
        object-position: center;
        transform: scale(1.02);
        transition: transform 7s ease-out;
    }
    #hero-slider .home-slide.active .home-slide-image { transform: scale(1.075); }
    #hero-slider .home-slide-overlay {
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 15% 25%, rgba(14, 165, 233, .18), transparent 28%),
            linear-gradient(90deg, rgba(2, 6, 23, .96) 0%, rgba(2, 6, 23, .84) 38%, rgba(2, 6, 23, .28) 72%, rgba(2, 6, 23, .14) 100%);
    }
    #hero-slider .home-slide-content { opacity: 0; transform: translateY(24px); transition: opacity .65s ease .2s, transform .65s ease .2s; }
    #hero-slider .home-slide.active .home-slide-content { opacity: 1; transform: translateY(0); }
    #hero-slider .home-progress-fill { width: 0; transition: none; }
    #hero-slider .home-progress.active .home-progress-fill { width: 100%; transition: width 6s linear; }
    @media (max-width: 767px) {
        #hero-slider { height: 680px; min-height: 620px; }
        #hero-slider .home-slide-overlay {
            background: linear-gradient(180deg, rgba(2, 6, 23, .34) 0%, rgba(2, 6, 23, .88) 58%, rgba(2, 6, 23, .98) 100%);
        }
        #hero-slider .home-slide-image { object-position: 62% center; }
    }
    @media (prefers-reduced-motion: reduce) {
        #hero-slider .home-slide-image,
        #hero-slider .home-slide-content,
        #hero-slider .home-progress-fill { transition: none !important; transform: none !important; }
    }
</style>

<section id="hero-slider" aria-label="Imperial Health highlights">
    @foreach($slides as $index => $slide)
        <article class="home-slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}" aria-hidden="{{ $index === 0 ? 'false' : 'true' }}">
            <img
                src="{{ asset($slide['image'] ?? 'assets/front/images/index/tour.jpg') }}"
                onerror="this.onerror=null;this.src='{{ asset('assets/front/images/index/tour.jpg') }}';"
                alt="{{ strip_tags($slide['badge'] ?? 'Imperial Health') }}"
                class="home-slide-image"
            >
            <div class="home-slide-overlay"></div>
            <div class="container relative z-10 mx-auto flex h-full items-center px-5 pb-24 pt-16 sm:px-6 md:px-8 md:pb-28">
                <div class="home-slide-content max-w-3xl">
                    @if(!empty($slide['badge']))
                        <p class="mb-5 text-xs font-black uppercase tracking-[0.22em] text-sky-300 sm:text-sm">{{ $slide['badge'] }}</p>
                    @endif
                    <h1 class="max-w-3xl text-4xl font-black leading-[1.06] tracking-tight text-white sm:text-5xl md:text-6xl lg:text-7xl">
                        {!! $slide['title_html'] ?? '' !!}
                    </h1>
                    @if(!empty($slide['description']))
                        <p class="mt-6 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg sm:leading-8">{{ $slide['description'] }}</p>
                    @endif
                    @if(!empty($slide['button_text']))
                        <a href="{{ $slide['button_url'] ?? '#' }}" class="mt-9 inline-flex items-center justify-center gap-3 rounded-xl bg-sky-500 px-6 py-3.5 text-sm font-bold text-white shadow-xl shadow-slate-950/30 transition hover:-translate-y-0.5 hover:bg-sky-400 focus:outline-none focus:ring-4 focus:ring-sky-400/30">
                            {{ $slide['button_text'] }}
                            <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                        </a>
                    @endif
                </div>
            </div>
        </article>
    @endforeach

    <div class="absolute inset-x-0 bottom-7 z-30">
        <div class="container mx-auto flex items-center justify-between gap-6 px-5 sm:px-6 md:px-8">
            <div class="flex items-center gap-2" aria-label="Choose a hero slide">
                @foreach($slides as $index => $slide)
                    <button type="button" class="home-progress {{ $index === 0 ? 'active' : '' }} relative h-1 w-10 overflow-hidden rounded-full bg-white/20 sm:w-14" onclick="jumpToSlide({{ $index }})" aria-label="Show slide {{ $index + 1 }}">
                        <span class="home-progress-fill absolute inset-y-0 left-0 rounded-full bg-sky-400"></span>
                    </button>
                @endforeach
            </div>
            @if(count($slides) > 1)
                <div class="hidden items-center gap-2 sm:flex">
                    <button type="button" onclick="moveSlide(-1)" class="flex h-11 w-11 items-center justify-center rounded-xl border border-white/15 bg-white/10 text-white backdrop-blur transition hover:border-sky-400 hover:bg-sky-500" aria-label="Previous slide">
                        <i class="fa-solid fa-chevron-left text-xs" aria-hidden="true"></i>
                    </button>
                    <button type="button" onclick="moveSlide(1)" class="flex h-11 w-11 items-center justify-center rounded-xl border border-white/15 bg-white/10 text-white backdrop-blur transition hover:border-sky-400 hover:bg-sky-500" aria-label="Next slide">
                        <i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>
</section>

<script>
    let currentSlideIndex = 0;
    const allSlides = document.querySelectorAll('#hero-slider .home-slide');
    const allProgressBtns = document.querySelectorAll('#hero-slider .home-progress');
    const slideCount = allSlides.length;
    let slideTimer;

    function showSlide(index) {
        if (!slideCount) return;

        allSlides.forEach(slide => {
            slide.classList.remove('active');
            slide.setAttribute('aria-hidden', 'true');
        });
        allProgressBtns.forEach(button => button.classList.remove('active'));

        if (index >= slideCount) currentSlideIndex = 0;
        else if (index < 0) currentSlideIndex = slideCount - 1;
        else currentSlideIndex = index;

        allSlides[currentSlideIndex].classList.add('active');
        allSlides[currentSlideIndex].setAttribute('aria-hidden', 'false');
        allProgressBtns[currentSlideIndex]?.classList.add('active');

        window.clearTimeout(slideTimer);
        if (slideCount > 1 && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            slideTimer = window.setTimeout(() => showSlide(currentSlideIndex + 1), 6000);
        }
    }

    function moveSlide(step) { showSlide(currentSlideIndex + step); }
    function jumpToSlide(index) { showSlide(index); }

    document.addEventListener('DOMContentLoaded', () => showSlide(0));
</script>
@endif
