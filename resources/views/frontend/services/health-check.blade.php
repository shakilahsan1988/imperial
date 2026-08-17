@extends('layouts.front')

@section('title', ($healthCheckSettings['page_name'] ?? 'Health Check') . ' - Imperial Health Bangladesh')
@section('meta_description', $healthCheckSettings['hero_description'] ?? null)

@push('schema')
{!! \App\Support\SchemaBuilder::script(\App\Support\SchemaBuilder::faqPage([
    ['question' => $healthCheckSettings['faq_1_question'] ?? null, 'answer' => $healthCheckSettings['faq_1_answer'] ?? null],
    ['question' => $healthCheckSettings['faq_2_question'] ?? null, 'answer' => $healthCheckSettings['faq_2_answer'] ?? null],
    ['question' => $healthCheckSettings['faq_3_question'] ?? null, 'answer' => $healthCheckSettings['faq_3_answer'] ?? null],
])) !!}
@endpush

@section('content')
@php
    $activeCategories = $categories
        ->filter(fn ($category) => $category->packages->isNotEmpty())
        ->values();
    $totalPackages = $activeCategories->sum(fn ($category) => $category->packages->count());
    $heroImage = asset($healthCheckSettings['hero_image'] ?? 'assets/front/images/services/services-facility.jpg');
    $features = [
        ['title' => $healthCheckSettings['feature_1_title'] ?? 'Expert Analysis', 'description' => $healthCheckSettings['feature_1_desc'] ?? '', 'icon' => 'fa-user-doctor'],
        ['title' => $healthCheckSettings['feature_2_title'] ?? 'Affordable Care', 'description' => $healthCheckSettings['feature_2_desc'] ?? '', 'icon' => 'fa-tags'],
        ['title' => $healthCheckSettings['feature_3_title'] ?? 'Digital Reports', 'description' => $healthCheckSettings['feature_3_desc'] ?? '', 'icon' => 'fa-cloud-arrow-down'],
    ];
    $faqs = [
        ['question' => $healthCheckSettings['faq_1_question'] ?? '', 'answer' => $healthCheckSettings['faq_1_answer'] ?? ''],
        ['question' => $healthCheckSettings['faq_2_question'] ?? '', 'answer' => $healthCheckSettings['faq_2_answer'] ?? ''],
        ['question' => $healthCheckSettings['faq_3_question'] ?? '', 'answer' => $healthCheckSettings['faq_3_answer'] ?? ''],
    ];
@endphp

<main class="overflow-hidden bg-slate-50 font-sans text-slate-900">
    <section class="relative isolate overflow-hidden bg-slate-950">
        <div class="absolute inset-0">
            <img src="{{ $heroImage }}" alt="" class="h-full w-full object-cover object-center opacity-25 md:object-right md:opacity-40">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/95 to-slate-950/30"></div>
            <div class="absolute inset-0 opacity-70" style="background: radial-gradient(circle at 18% 18%, rgba(14, 165, 233, .2), transparent 28%), radial-gradient(circle at 85% 80%, rgba(2, 132, 199, .16), transparent 30%);"></div>
        </div>

        <div class="container relative z-10 mx-auto px-5 py-20 sm:px-6 md:py-28 lg:px-8 lg:py-32">
            <div class="max-w-3xl">
                <nav class="mb-8 flex items-center gap-2 text-xs font-bold uppercase tracking-[0.16em] text-slate-400" aria-label="Breadcrumb">
                    <a href="{{ route('fhome') }}" class="transition-colors hover:text-sky-300">Home</a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-600" aria-hidden="true"></i>
                    <span class="text-sky-300">{{ $healthCheckSettings['page_name'] ?? 'Health Check' }}</span>
                </nav>

                <p class="mb-4 text-xs font-black uppercase tracking-[0.22em] text-sky-300">
                    {{ $healthCheckSettings['page_name'] ?? 'Health Check' }}
                </p>
                <h1 class="max-w-3xl text-4xl font-black leading-[1.08] tracking-tight text-white sm:text-5xl md:text-6xl">
                    {!! $healthCheckSettings['hero_title_html'] ?? 'Invest in Your <span class="text-sky-400">Future Health</span> Today' !!}
                </h1>
                <p class="mt-6 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg sm:leading-8">
                    {{ $healthCheckSettings['hero_description'] ?? 'Comprehensive health screenings designed around your wellbeing.' }}
                </p>

                <div class="mt-9 flex flex-wrap items-center gap-3">
                    @if($activeCategories->isNotEmpty())
                        <a href="#health-category-{{ $activeCategories->first()->id }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-sky-500 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-sky-950/30 transition hover:-translate-y-0.5 hover:bg-sky-400 focus:outline-none focus:ring-4 focus:ring-sky-400/30">
                            Browse packages
                            <i class="fa-solid fa-arrow-down text-xs" aria-hidden="true"></i>
                        </a>
                    @endif
                    <div class="flex items-center gap-3 rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-sm text-slate-300 backdrop-blur-sm">
                        <span class="font-black text-white">{{ $totalPackages }}</span>
                        <span>{{ \Illuminate\Support\Str::plural('package', $totalPackages) }}</span>
                        <span class="h-4 w-px bg-white/15"></span>
                        <span class="font-black text-white">{{ $activeCategories->count() }}</span>
                        <span>{{ \Illuminate\Support\Str::plural('category', $activeCategories->count()) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($activeCategories->isNotEmpty())
        <section class="relative z-20 -mt-7 px-4 sm:px-6" aria-label="Health check categories">
            <div class="container mx-auto">
                <div class="flex items-center gap-3 overflow-x-auto rounded-2xl border border-slate-200/80 bg-white p-3 shadow-xl shadow-slate-900/5 sm:p-4">
                    <span class="hidden flex-shrink-0 px-2 text-xs font-black uppercase tracking-[0.16em] text-slate-400 sm:inline">Explore</span>
                    <span class="hidden h-6 w-px flex-shrink-0 bg-slate-200 sm:inline"></span>
                    @foreach($activeCategories as $category)
                        <a href="#health-category-{{ $category->id }}" class="flex flex-shrink-0 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-bold text-slate-700 transition hover:border-sky-200 hover:bg-sky-50 hover:text-sky-700">
                            {{ $category->name }}
                            <span class="rounded-md bg-white px-2 py-0.5 text-[11px] font-black text-slate-500 shadow-sm">{{ $category->packages->count() }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="pb-6 pt-14 md:pb-8 md:pt-16" aria-label="Health check benefits">
        <div class="container mx-auto px-5 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                @foreach($features as $feature)
                    <article class="group flex items-start gap-4 rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-sky-200 hover:shadow-lg hover:shadow-slate-900/5 sm:p-6">
                        <span class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600 transition group-hover:bg-sky-600 group-hover:text-white">
                            <i class="fa-solid {{ $feature['icon'] }} text-lg" aria-hidden="true"></i>
                        </span>
                        <span>
                            <strong class="block text-sm font-black text-slate-950">{{ $feature['title'] }}</strong>
                            <span class="mt-1 block text-xs leading-5 text-slate-500">{{ $feature['description'] }}</span>
                        </span>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    @forelse($activeCategories as $category)
        <section id="health-category-{{ $category->id }}" class="scroll-mt-24 py-16 md:py-20 {{ $loop->odd ? 'bg-slate-50' : 'border-y border-slate-100 bg-white' }}">
            <div class="container mx-auto px-5 sm:px-6 lg:px-8">
                <div class="mb-9 flex flex-col justify-between gap-4 sm:flex-row sm:items-end md:mb-12">
                    <div>
                        <p class="mb-2 text-xs font-black uppercase tracking-[0.18em] text-sky-600">
                            Collection {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </p>
                        <h2 class="text-2xl font-black tracking-tight text-slate-950 sm:text-3xl md:text-4xl">{{ $category->name }}</h2>
                    </div>
                    <p class="text-sm font-medium text-slate-500">
                        {{ $category->packages->count() }} {{ \Illuminate\Support\Str::plural('option', $category->packages->count()) }} available
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($category->packages as $package)
                        @php
                            $detailsUrl = route('package-details', ['slug' => $package->slug]);
                            $packageImage = asset($package->image ?: 'assets/front/images/services/services-facility.jpg');
                        @endphp

                        <article class="group flex h-full flex-col overflow-hidden rounded-[1.75rem] border border-slate-200/80 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-sky-200 hover:shadow-2xl hover:shadow-slate-900/10">
                            <a href="{{ $detailsUrl }}" class="relative block aspect-[4/3] overflow-hidden bg-slate-100" aria-label="View {{ $package->name }}">
                                <img src="{{ $packageImage }}" alt="{{ $package->name }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]">
                                <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-slate-950/45 to-transparent"></div>
                                <span class="absolute left-4 top-4 rounded-lg bg-white/95 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.12em] text-sky-700 shadow-sm backdrop-blur">
                                    Health check
                                </span>
                            </a>

                            <div class="flex flex-1 flex-col p-5 sm:p-6">
                                <div class="mb-5">
                                    <h3 class="text-lg font-black leading-snug tracking-tight text-slate-950 transition-colors group-hover:text-sky-700">
                                        <a href="{{ $detailsUrl }}">{{ $package->name }}</a>
                                    </h3>
                                    <p class="mt-2 text-xs font-medium text-slate-500">{{ $category->name }}</p>
                                </div>

                                <div class="mb-6 border-b border-slate-100 pb-5">
                                    <span class="text-2xl font-black tracking-tight text-sky-700">{{ formated_price($package->price) }}</span>
                                </div>

                                <div class="mt-auto">
                                    <a href="{{ $detailsUrl }}" class="flex w-full items-center justify-between rounded-xl bg-slate-950 px-4 py-3 text-sm font-bold text-white transition hover:bg-sky-600 focus:outline-none focus:ring-4 focus:ring-sky-100">
                                        Explore package
                                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-white/10">
                                            <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @empty
        <section class="bg-white py-24">
            <div class="container mx-auto px-5 text-center sm:px-6">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-sky-50 text-sky-600">
                    <i class="fa-solid fa-heart-pulse text-2xl" aria-hidden="true"></i>
                </div>
                <h2 class="mt-6 text-2xl font-black text-slate-900">Health packages are coming soon</h2>
                <p class="mx-auto mt-3 max-w-md text-slate-500">No health check packages are available right now.</p>
            </div>
        </section>
    @endforelse

    <section class="border-t border-slate-100 bg-white py-16 md:py-20">
        <div class="container mx-auto max-w-4xl px-5 sm:px-6 lg:px-8">
            <div class="mb-10 text-center md:mb-12">
                <p class="mb-3 text-xs font-black uppercase tracking-[0.18em] text-sky-600">Good to know</p>
                <h2 class="text-3xl font-black tracking-tight text-slate-950 md:text-4xl">{{ $healthCheckSettings['faq_title'] ?? 'Common Questions' }}</h2>
                <p class="mx-auto mt-4 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base">{{ $healthCheckSettings['faq_subtitle'] ?? '' }}</p>
            </div>

            <div class="space-y-4">
                @foreach($faqs as $faq)
                    @if($faq['question'])
                        <details class="group overflow-hidden rounded-2xl border border-slate-200/80 bg-slate-50 transition open:border-sky-200 open:bg-white open:shadow-lg open:shadow-slate-900/5">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-5 p-5 text-sm font-bold text-slate-800 transition hover:text-sky-700 sm:p-6 sm:text-base">
                                <span>{{ $faq['question'] }}</span>
                                <span class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-white text-sky-600 shadow-sm">
                                    <i class="fa-solid fa-plus text-xs transition group-open:rotate-45" aria-hidden="true"></i>
                                </span>
                            </summary>
                            <div class="px-5 pb-5 pr-16 text-sm leading-7 text-slate-500 sm:px-6 sm:pb-6 sm:pr-20">
                                {{ $faq['answer'] }}
                            </div>
                        </details>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
</main>
@endsection
