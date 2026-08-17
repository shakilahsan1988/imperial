<section class="bg-white py-16 md:py-20">
    <div class="container mx-auto px-5 sm:px-6 lg:px-8">
        <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
            <div class="relative lg:order-1">
                <div class="overflow-hidden rounded-[2rem] bg-slate-200 shadow-xl shadow-slate-900/10">
                    <img src="{{ asset($homeSettings['lab_excellence']['image']) }}" alt="{{ strip_tags($homeSettings['lab_excellence']['badge']) }}" class="aspect-[4/3] h-full w-full object-cover transition duration-700 hover:scale-[1.025]">
                </div>
                <div class="absolute bottom-5 left-5 right-5 flex flex-wrap gap-2 rounded-2xl border border-white/60 bg-white/90 p-3 shadow-lg backdrop-blur sm:bottom-7 sm:left-7 sm:right-auto sm:p-4">
                    @foreach([$homeSettings['lab_excellence']['feature_1'], $homeSettings['lab_excellence']['feature_2']] as $feature)
                        <span class="inline-flex items-center gap-2 rounded-lg bg-sky-50 px-3 py-2 text-xs font-bold text-sky-700">
                            <i class="fa-solid fa-circle-check" aria-hidden="true"></i>{{ $feature }}
                        </span>
                    @endforeach
                </div>
            </div>

            <div class="lg:order-2">
                <p class="mb-3 text-xs font-black uppercase tracking-[0.18em] text-sky-600">{{ $homeSettings['lab_excellence']['badge'] }}</p>
                <h2 class="text-3xl font-black tracking-tight text-slate-950 sm:text-4xl md:text-5xl">{!! $homeSettings['lab_excellence']['title_html'] !!}</h2>
                <p class="mt-5 text-base leading-7 text-slate-500">{{ $homeSettings['lab_excellence']['description'] }}</p>
                <a href="{{ $homeSettings['lab_excellence']['button_url'] }}" class="mt-8 inline-flex items-center justify-center gap-3 rounded-xl bg-sky-500 px-6 py-3.5 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-sky-600 focus:outline-none focus:ring-4 focus:ring-sky-100">
                    {{ $homeSettings['lab_excellence']['button_text'] }}
                    <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</section>
