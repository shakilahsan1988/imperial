@if(!empty($homeSettings['doctor_carousel']['enabled']) && isset($homeDoctors) && $homeDoctors->isNotEmpty())
    @once
        @push('styles')
            <style>
                .doctor-carousel-viewport {
                    overflow: hidden;
                }

                .doctor-carousel-track {
                    display: flex;
                    gap: 1.5rem;
                    transition: transform 0.6s ease;
                    will-change: transform;
                }

                .doctor-carousel-card {
                    flex: 0 0 calc((100% - 4.5rem) / 4);
                }

                @media (max-width: 1023px) {
                    .doctor-carousel-card {
                        flex-basis: calc((100% - 3rem) / 3);
                    }
                }

                @media (max-width: 767px) {
                    .doctor-carousel-card {
                        flex-basis: calc((100% - 1.5rem) / 2);
                    }
                }

                @media (max-width: 479px) {
                    .doctor-carousel-card {
                        flex-basis: 100%;
                    }
                }
            </style>
        @endpush
    @endonce

    <section class="py-24 bg-indigo-50 overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8 mb-12">
                <div class="max-w-3xl">
                    <span class="text-indigo-600 font-black uppercase tracking-[0.2em] text-[10px] mb-4 block">{{ $homeSettings['doctor_carousel']['badge'] }}</span>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">{!! $homeSettings['doctor_carousel']['title_html'] !!}</h2>
                    <p class="text-lg text-slate-600 leading-relaxed">{{ $homeSettings['doctor_carousel']['description'] }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ $homeSettings['doctor_carousel']['button_url'] }}" class="hidden sm:inline-flex btn-primary text-white px-8 py-4 rounded-2xl font-bold items-center gap-3 shadow-xl shadow-indigo-200">
                        {{ $homeSettings['doctor_carousel']['button_text'] }} <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <div class="flex items-center gap-3">
                        <button type="button" class="doctor-carousel-prev w-12 h-12 rounded-2xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-900 hover:text-white transition-all" aria-label="Previous doctors">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                        <button type="button" class="doctor-carousel-next w-12 h-12 rounded-2xl bg-indigo-600 text-white hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200" aria-label="Next doctors">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="doctor-carousel" data-carousel>
                <div class="doctor-carousel-viewport">
                    <div class="doctor-carousel-track">
                        @foreach($homeDoctors as $doctor)
                            <article class="doctor-carousel-card group bg-white rounded-[32px] overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                                <div class="aspect-[4/5] overflow-hidden bg-slate-100">
                                    <img src="{{ asset($doctor->image ?: 'assets/front/images/doctor/2.jpg') }}"
                                         alt="{{ $doctor->name }}"
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                </div>
                                <div class="p-6">
                                    <p class="text-[11px] font-black uppercase tracking-[0.2em] text-indigo-600 mb-3">
                                        {{ optional($doctor->specialty)->name ?: 'Specialist' }}
                                    </p>
                                    <h3 class="text-xl font-bold text-slate-900 mb-2 leading-tight group-hover:text-indigo-600 transition-colors">
                                        {{ $doctor->name }}
                                    </h3>
                                    <p class="text-sm text-slate-500 font-medium leading-relaxed min-h-[44px]">
                                        {{ $doctor->designation ?: 'Consultant' }}
                                    </p>
                                    <div class="flex items-center justify-between text-xs text-slate-500 mt-5 mb-6">
                                        <span>Consultation</span>
                                        <strong class="text-slate-800">{{ formated_price($doctor->consultation_fee ?? 0) }}</strong>
                                    </div>
                                    <a href="{{ route('book-doctor', ['doctor' => $doctor->slug ?: $doctor->id]) }}"
                                       class="flex items-center justify-center w-full py-3 bg-slate-900 group-hover:bg-indigo-600 text-white rounded-2xl font-bold text-sm tracking-wide transition-all">
                                        Book Appointment
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-8 sm:hidden">
                <a href="{{ $homeSettings['doctor_carousel']['button_url'] }}" class="inline-flex btn-primary text-white px-8 py-4 rounded-2xl font-bold items-center gap-3 shadow-xl shadow-indigo-200">
                    {{ $homeSettings['doctor_carousel']['button_text'] }} <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </section>

    @once
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.querySelectorAll('[data-carousel]').forEach(function (carousel) {
                        const track = carousel.querySelector('.doctor-carousel-track');
                        const cards = Array.from(carousel.querySelectorAll('.doctor-carousel-card'));
                        const prevButton = carousel.parentElement.querySelector('.doctor-carousel-prev');
                        const nextButton = carousel.parentElement.querySelector('.doctor-carousel-next');

                        if (!track || cards.length <= 1 || !prevButton || !nextButton) {
                            return;
                        }

                        let index = 0;
                        let autoplay;

                        function cardsPerView() {
                            if (window.innerWidth <= 479) return 1;
                            if (window.innerWidth <= 767) return 2;
                            if (window.innerWidth <= 1023) return 3;
                            return 4;
                        }

                        function maxIndex() {
                            return Math.max(cards.length - cardsPerView(), 0);
                        }

                        function update() {
                            const cardWidth = cards[0].offsetWidth;
                            const gap = parseFloat(window.getComputedStyle(track).gap) || 0;
                            const offset = index * (cardWidth + gap);
                            track.style.transform = 'translateX(-' + offset + 'px)';
                            prevButton.disabled = index === 0;
                            nextButton.disabled = index >= maxIndex();
                            prevButton.classList.toggle('opacity-40', index === 0);
                            nextButton.classList.toggle('opacity-40', index >= maxIndex());
                        }

                        function goTo(nextIndex) {
                            index = Math.max(0, Math.min(nextIndex, maxIndex()));
                            update();
                        }

                        function startAutoplay() {
                            stopAutoplay();
                            autoplay = window.setInterval(function () {
                                if (index >= maxIndex()) {
                                    goTo(0);
                                } else {
                                    goTo(index + 1);
                                }
                            }, 4000);
                        }

                        function stopAutoplay() {
                            if (autoplay) {
                                window.clearInterval(autoplay);
                            }
                        }

                        prevButton.addEventListener('click', function () {
                            goTo(index - 1);
                            startAutoplay();
                        });

                        nextButton.addEventListener('click', function () {
                            goTo(index + 1);
                            startAutoplay();
                        });

                        carousel.addEventListener('mouseenter', stopAutoplay);
                        carousel.addEventListener('mouseleave', startAutoplay);
                        window.addEventListener('resize', function () {
                            goTo(index);
                        });

                        update();
                        startAutoplay();
                    });
                });
            </script>
        @endpush
    @endonce
@endif
