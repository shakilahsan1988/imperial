<section class="bg-slate-50 px-5 py-16 sm:px-6 md:py-20">
    <div class="container mx-auto overflow-hidden rounded-[2rem] bg-slate-950 shadow-2xl shadow-slate-900/15">
        <div class="grid items-stretch lg:grid-cols-2">
            <div class="group relative min-h-80 overflow-hidden lg:min-h-[34rem]">
                <img src="{{ asset($homeSettings['experience_imperial']['image']) }}" alt="{{ strip_tags($homeSettings['experience_imperial']['badge']) }}" class="absolute inset-0 h-full w-full object-cover transition duration-[1200ms] group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent lg:bg-gradient-to-r lg:from-transparent lg:to-slate-950/20"></div>
                <span class="absolute bottom-6 left-6 inline-flex items-center gap-2 rounded-full border border-white/20 bg-slate-950/60 px-4 py-2 text-xs font-bold text-white backdrop-blur">
                    <i class="fa-solid fa-location-dot text-sky-400" aria-hidden="true"></i>
                    Imperial Health
                </span>
            </div>

            <div class="flex flex-col justify-center p-8 sm:p-10 lg:p-14 xl:p-16">
                <p class="mb-3 text-xs font-black uppercase tracking-[0.18em] text-sky-400">{{ $homeSettings['experience_imperial']['badge'] }}</p>
                <h2 class="text-3xl font-black tracking-tight text-white sm:text-4xl md:text-5xl">{!! $homeSettings['experience_imperial']['title_html'] !!}</h2>
                <p class="mt-5 text-base leading-7 text-slate-300">{{ $homeSettings['experience_imperial']['description'] }}</p>
                <a href="{{ $homeSettings['experience_imperial']['button_url'] }}" class="mt-8 inline-flex w-fit items-center justify-center gap-3 rounded-xl bg-white px-6 py-3.5 text-sm font-bold text-slate-950 transition hover:-translate-y-0.5 hover:bg-sky-50 focus:outline-none focus:ring-4 focus:ring-white/20">
                    {{ $homeSettings['experience_imperial']['button_text'] }}
                    <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</section>
