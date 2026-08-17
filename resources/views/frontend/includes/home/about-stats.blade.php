@php
    $stats = collect([
        ['count' => $homeSettings['stats']['specialities_count'], 'label' => $homeSettings['stats']['specialities_label'], 'icon' => 'fa-stethoscope'],
        ['count' => $homeSettings['stats']['doctors_count'], 'label' => $homeSettings['stats']['doctors_label'], 'icon' => 'fa-user-doctor'],
        ['count' => $homeSettings['stats']['patients_count'] ?? '', 'label' => $homeSettings['stats']['patients_label'], 'icon' => 'fa-users'],
    ])->filter(fn ($stat) => trim((string) $stat['count']) !== '');
@endphp

<section class="relative overflow-hidden bg-white py-16 md:py-20">
    <div class="absolute -right-32 -top-32 h-80 w-80 rounded-full bg-sky-50 blur-3xl"></div>
    <div class="container relative z-10 mx-auto px-5 sm:px-6 lg:px-8">
        <div class="grid items-center gap-10 lg:grid-cols-12 lg:gap-14">
            <div class="lg:col-span-5">
                <p class="mb-3 text-xs font-black uppercase tracking-[0.18em] text-sky-600">{{ $homeSettings['about']['badge'] }}</p>
                <h2 class="text-3xl font-black tracking-tight text-slate-950 sm:text-4xl md:text-5xl">{!! $homeSettings['about']['title_html'] !!}</h2>
                <p class="mt-5 text-sm leading-7 text-slate-500 sm:text-base">{{ $homeSettings['about']['description'] }}</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:col-span-7 lg:grid-cols-{{ max(1, $stats->count()) }}">
                @foreach($stats as $stat)
                    <article class="group rounded-2xl border border-slate-200/80 bg-slate-50 p-6 transition hover:-translate-y-0.5 hover:border-sky-200 hover:bg-white hover:shadow-xl hover:shadow-slate-900/5 sm:p-7">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-sky-600 shadow-sm transition group-hover:bg-sky-600 group-hover:text-white">
                            <i class="fa-solid {{ $stat['icon'] }}" aria-hidden="true"></i>
                        </span>
                        <strong class="mt-6 block text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">{{ $stat['count'] }}</strong>
                        <span class="mt-1 block text-xs font-black uppercase tracking-[0.12em] text-slate-500">{{ $stat['label'] }}</span>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
