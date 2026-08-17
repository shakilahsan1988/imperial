@extends('layouts.front')

@section('title', ($pageSettings['page_name'] ?? 'Membership') . ' - Imperial Health Bangladesh')
@section('meta_description', $pageSettings['hero_description'] ?? null)

@section('content')
@php
    $activeCategories = $categories
        ->filter(fn ($category) => $category->plans->isNotEmpty())
        ->values();
    $totalPlans = $activeCategories->sum(fn ($category) => $category->plans->count());
    $heroImage = asset($pageSettings['hero_image'] ?? 'assets/front/images/services/con5.jpg');
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
                    <span class="text-sky-300">{{ $pageSettings['page_name'] ?? 'Membership' }}</span>
                </nav>

                <p class="mb-4 text-xs font-black uppercase tracking-[0.22em] text-sky-300">
                    {{ $pageSettings['page_name'] ?? 'Membership' }}
                </p>
                <h1 class="max-w-3xl text-4xl font-black leading-[1.08] tracking-tight text-white sm:text-5xl md:text-6xl">
                    {!! $pageSettings['hero_title_html'] ?? 'Membership <span class="text-sky-400">Plans</span>' !!}
                </h1>
                <p class="mt-6 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg sm:leading-8">
                    {{ $pageSettings['hero_description'] ?? 'Comprehensive healthcare solutions for you and your family.' }}
                </p>

                <div class="mt-9 flex flex-wrap items-center gap-3">
                    @if($activeCategories->isNotEmpty())
                        <a href="#membership-category-{{ $activeCategories->first()->id }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-sky-500 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-sky-950/30 transition hover:-translate-y-0.5 hover:bg-sky-400 focus:outline-none focus:ring-4 focus:ring-sky-400/30">
                            Browse plans
                            <i class="fa-solid fa-arrow-down text-xs" aria-hidden="true"></i>
                        </a>
                    @endif
                    <div class="flex items-center gap-3 rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-sm text-slate-300 backdrop-blur-sm">
                        <span class="font-black text-white">{{ $totalPlans }}</span>
                        <span>{{ \Illuminate\Support\Str::plural('plan', $totalPlans) }}</span>
                        <span class="h-4 w-px bg-white/15"></span>
                        <span class="font-black text-white">{{ $activeCategories->count() }}</span>
                        <span>{{ \Illuminate\Support\Str::plural('category', $activeCategories->count()) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($activeCategories->isNotEmpty())
        <section class="relative z-20 -mt-7 px-4 sm:px-6" aria-label="Membership categories">
            <div class="container mx-auto">
                <div class="flex items-center gap-3 overflow-x-auto rounded-2xl border border-slate-200/80 bg-white p-3 shadow-xl shadow-slate-900/5 sm:p-4">
                    <span class="hidden flex-shrink-0 px-2 text-xs font-black uppercase tracking-[0.16em] text-slate-400 sm:inline">Explore</span>
                    <span class="hidden h-6 w-px flex-shrink-0 bg-slate-200 sm:inline"></span>
                    @foreach($activeCategories as $category)
                        <a href="#membership-category-{{ $category->id }}" class="flex flex-shrink-0 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-bold text-slate-700 transition hover:border-sky-200 hover:bg-sky-50 hover:text-sky-700">
                            {{ $category->name }}
                            <span class="rounded-md bg-white px-2 py-0.5 text-[11px] font-black text-slate-500 shadow-sm">{{ $category->plans->count() }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @forelse($activeCategories as $category)
        <section id="membership-category-{{ $category->id }}" class="scroll-mt-24 py-16 md:py-20 {{ $loop->odd ? 'bg-slate-50' : 'border-y border-slate-100 bg-white' }}">
            <div class="container mx-auto px-5 sm:px-6 lg:px-8">
                <div class="mb-9 flex flex-col justify-between gap-4 sm:flex-row sm:items-end md:mb-12">
                    <div>
                        <p class="mb-2 text-xs font-black uppercase tracking-[0.18em] text-sky-600">
                            Collection {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </p>
                        <h2 class="text-2xl font-black tracking-tight text-slate-950 sm:text-3xl md:text-4xl">{{ $category->name }}</h2>
                    </div>
                    <p class="text-sm font-medium text-slate-500">
                        {{ $category->plans->count() }} {{ \Illuminate\Support\Str::plural('option', $category->plans->count()) }} available
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($category->plans as $plan)
                        @php
                            $detailsUrl = route('membership-details', ['id' => $plan->slug ?: $plan->id]);
                            $image = ! empty($plan->image)
                                ? asset($plan->image)
                                : asset('assets/front/images/services/con6.jpeg');
                            $hasServiceSavings = ! empty($plan->service_discount)
                                && strtoupper(trim((string) $plan->service_discount)) !== 'N/A';
                        @endphp

                        <article class="group flex h-full flex-col overflow-hidden rounded-[1.75rem] border border-slate-200/80 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-sky-200 hover:shadow-2xl hover:shadow-slate-900/10">
                            <a href="{{ $detailsUrl }}" class="relative block aspect-[16/9] overflow-hidden bg-slate-100" aria-label="View {{ $plan->name }}">
                                <img src="{{ $image }}" alt="{{ $plan->name }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]">
                                <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-slate-950/50 to-transparent"></div>

                                <div class="absolute left-4 top-4 flex flex-wrap gap-2">
                                    @if(! empty($plan->badge_text))
                                        <span class="rounded-lg bg-white/95 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.12em] text-sky-700 shadow-sm backdrop-blur">
                                            {{ $plan->badge_text }}
                                        </span>
                                    @endif
                                </div>

                                @if(! empty($plan->duration))
                                    <span class="absolute bottom-4 right-4 rounded-lg border border-white/20 bg-slate-950/65 px-3 py-1.5 text-xs font-bold text-white backdrop-blur">
                                        {{ $plan->duration }}
                                    </span>
                                @endif
                            </a>

                            <div class="flex flex-1 flex-col p-6 sm:p-7">
                                <div class="mb-5">
                                    <h3 class="text-xl font-black leading-snug tracking-tight text-slate-950 transition-colors group-hover:text-sky-700">
                                        <a href="{{ $detailsUrl }}">{{ $plan->name }}</a>
                                    </h3>
                                    <p class="mt-2 text-sm leading-6 text-slate-500">{{ $plan->subtitle ?: $category->name }}</p>
                                </div>

                                <div class="mb-6 flex flex-wrap items-end gap-x-3 gap-y-1 border-b border-slate-100 pb-6">
                                    <span class="text-3xl font-black tracking-tight text-sky-700">{{ formated_price($plan->price) }}</span>
                                    @if(! empty($plan->old_price))
                                        <span class="pb-1 text-sm font-semibold text-slate-400 line-through">{{ formated_price($plan->old_price) }}</span>
                                    @endif
                                    @if(! empty($plan->discount_text))
                                        <span class="mb-1 rounded-md bg-emerald-50 px-2 py-1 text-[10px] font-black uppercase tracking-wide text-emerald-700">{{ $plan->discount_text }}</span>
                                    @endif
                                </div>

                                @if(! empty($plan->doctor_visits) || $hasServiceSavings)
                                    <dl class="mb-7 space-y-3 text-sm">
                                        @if(! empty($plan->doctor_visits))
                                            <div class="flex items-center justify-between gap-4 rounded-xl bg-slate-50 px-4 py-3">
                                                <dt class="flex items-center gap-2 font-medium text-slate-500">
                                                    <i class="fa-solid fa-user-doctor w-4 text-sky-600" aria-hidden="true"></i>
                                                    Doctor access
                                                </dt>
                                                <dd class="text-right font-bold text-slate-800">{{ $plan->doctor_visits }}</dd>
                                            </div>
                                        @endif
                                        @if($hasServiceSavings)
                                            <div class="flex items-center justify-between gap-4 rounded-xl bg-slate-50 px-4 py-3">
                                                <dt class="flex items-center gap-2 font-medium text-slate-500">
                                                    <i class="fa-solid fa-tag w-4 text-sky-600" aria-hidden="true"></i>
                                                    Service savings
                                                </dt>
                                                <dd class="text-right font-bold text-slate-800">{{ $plan->service_discount }}</dd>
                                            </div>
                                        @endif
                                    </dl>
                                @endif

                                <div class="mt-auto">
                                    <a href="{{ $detailsUrl }}" class="flex w-full items-center justify-between rounded-xl bg-slate-950 px-5 py-3.5 text-sm font-bold text-white transition hover:bg-sky-600 focus:outline-none focus:ring-4 focus:ring-sky-100">
                                        Explore plan
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
                    <i class="fa-solid fa-id-card text-2xl" aria-hidden="true"></i>
                </div>
                <h2 class="mt-6 text-2xl font-black text-slate-900">Membership plans are coming soon</h2>
                <p class="mx-auto mt-3 max-w-md text-slate-500">No membership plans are available right now.</p>
            </div>
        </section>
    @endforelse
</main>
@endsection
