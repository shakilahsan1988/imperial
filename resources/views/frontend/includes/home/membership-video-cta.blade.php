<section class="overflow-hidden bg-white py-16 md:py-20">
    <div class="container mx-auto px-5 sm:px-6 lg:px-8">
        <div class="grid gap-5 lg:grid-cols-2">
            <article class="group relative flex min-h-[25rem] flex-col justify-between overflow-hidden rounded-[2rem] border border-slate-200 bg-slate-50 p-8 transition hover:-translate-y-1 hover:border-sky-200 hover:shadow-2xl hover:shadow-slate-900/10 sm:p-10">
                <div class="absolute -right-20 -top-20 h-60 w-60 rounded-full bg-sky-100/70 blur-3xl"></div>
                <div class="relative z-10">
                    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-xl text-sky-600 shadow-sm">
                        <i class="fa-solid fa-id-card-clip" aria-hidden="true"></i>
                    </span>
                    <h3 class="mt-8 text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">{!! $homeSettings['continuous_care']['title_html'] !!}</h3>
                    <p class="mt-4 max-w-xl text-base leading-7 text-slate-500">{{ $homeSettings['continuous_care']['description'] }}</p>
                </div>
                <a href="{{ $homeSettings['continuous_care']['button_url'] }}" class="relative z-10 mt-8 inline-flex w-fit items-center justify-center gap-3 rounded-xl bg-sky-500 px-6 py-3.5 text-sm font-bold text-white transition hover:bg-sky-600 focus:outline-none focus:ring-4 focus:ring-sky-100">
                    {{ $homeSettings['continuous_care']['button_text'] }}
                    <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                </a>
            </article>

            <article class="group relative flex min-h-[25rem] flex-col justify-between overflow-hidden rounded-[2rem] bg-slate-950 p-8 transition hover:-translate-y-1 hover:shadow-2xl hover:shadow-slate-900/20 sm:p-10">
                <div class="absolute -bottom-24 -left-16 h-72 w-72 rounded-full bg-sky-500/15 blur-3xl"></div>
                <div class="relative z-10">
                    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 text-xl text-sky-400">
                        <i class="fa-solid fa-video" aria-hidden="true"></i>
                    </span>
                    <h3 class="mt-8 text-3xl font-black tracking-tight text-white sm:text-4xl">{!! $homeSettings['expert_advice']['title_html'] !!}</h3>
                    <p class="mt-4 max-w-xl text-base leading-7 text-slate-300">{{ $homeSettings['expert_advice']['description'] }}</p>
                </div>
                <a href="{{ $homeSettings['expert_advice']['button_url'] }}" class="relative z-10 mt-8 inline-flex w-fit items-center justify-center gap-3 rounded-xl bg-white px-6 py-3.5 text-sm font-bold text-slate-950 transition hover:bg-sky-50 focus:outline-none focus:ring-4 focus:ring-white/20">
                    {{ $homeSettings['expert_advice']['button_text'] }}
                    <i class="fa-solid fa-video text-xs" aria-hidden="true"></i>
                </a>
            </article>
        </div>
    </div>
</section>
