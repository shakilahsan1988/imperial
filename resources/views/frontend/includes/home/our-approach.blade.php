    <!-- SECTION 1: TEXT LEFT / IMAGE RIGHT -->
    <section class="py-24 bg-slate-100 overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-20 items-center">
                <div class="lg:w-1/2 reveal-left">
                    <span class="text-indigo-600 font-black uppercase tracking-[0.2em] text-[15px] mb-4 block">{{ $homeSettings['our_approach']['badge'] }}</span>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-8 tracking-tight">{!! $homeSettings['our_approach']['title_html'] !!}</h2>
                    <p class="text-lg text-slate-600 leading-relaxed mb-6 font-medium">{{ $homeSettings['our_approach']['description_1'] }}</p>
                    <p class="text-slate-500 leading-relaxed mb-10">{{ $homeSettings['our_approach']['description_2'] }}</p>
                    <a href="{{ $homeSettings['our_approach']['button_url'] }}" class="btn-primary text-white px-10 py-4 rounded-2xl font-bold inline-flex items-center gap-3 shadow-xl shadow-indigo-200">
                        {{ $homeSettings['our_approach']['button_text'] }} <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <div class="lg:w-1/2 relative reveal-right">
                    <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-indigo-200 rounded-full blur-3xl opacity-30"></div>
                    <img src="{{ asset($homeSettings['our_approach']['image']) }}" class="rounded-[40px] shadow-2xl relative z-10 w-full hover:scale-[1.02] transition-transform duration-700">
                </div>
            </div>
        </div>
    </section>
