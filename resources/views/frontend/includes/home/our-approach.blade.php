<section class="border-y border-slate-100 bg-slate-50 py-16 md:py-20">
    <div class="container mx-auto px-5 sm:px-6 lg:px-8">
        <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
            <div>
                <p class="mb-3 text-xs font-black uppercase tracking-[0.18em] text-sky-600">{{ $homeSettings['our_approach']['badge'] }}</p>
                <h2 class="text-3xl font-black tracking-tight text-slate-950 sm:text-4xl md:text-5xl">{!! $homeSettings['our_approach']['title_html'] !!}</h2>
                <p class="mt-5 text-base font-medium leading-7 text-slate-600">{{ $homeSettings['our_approach']['description_1'] }}</p>
                <p class="mt-3 text-sm leading-7 text-slate-500">{{ $homeSettings['our_approach']['description_2'] }}</p>
                <a href="{{ $homeSettings['our_approach']['button_url'] }}" class="mt-8 inline-flex items-center justify-center gap-3 rounded-xl bg-slate-950 px-6 py-3.5 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-sky-600 focus:outline-none focus:ring-4 focus:ring-sky-100">
                    {{ $homeSettings['our_approach']['button_text'] }}
                    <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                </a>
            </div>

            <div class="relative">
                <div class="absolute -left-5 -top-5 h-24 w-24 rounded-[2rem] bg-sky-100"></div>
                <div class="absolute -bottom-5 -right-5 h-28 w-28 rounded-full bg-white"></div>
                <div class="relative overflow-hidden rounded-[2rem] border border-white bg-slate-200 shadow-xl shadow-slate-900/10">
                    <img src="{{ asset($homeSettings['our_approach']['image']) }}" alt="{{ strip_tags($homeSettings['our_approach']['badge']) }}" class="aspect-[4/3] h-full w-full object-cover transition duration-700 hover:scale-[1.025]">
                </div>
            </div>
        </div>
    </div>
</section>
