@extends('layouts.front')

@section('title', ($pageSettings['page_name'] ?? 'Video Consultation') . ' - Imperial Health Bangladesh')
@section('meta_description', $pageSettings['hero_description'] ?? null)

@push('schema')
{!! \App\Support\SchemaBuilder::script(\App\Support\SchemaBuilder::faqPage([
    ['question' => $pageSettings['faq_1_question'] ?? null, 'answer' => $pageSettings['faq_1_answer'] ?? null],
    ['question' => $pageSettings['faq_2_question'] ?? null, 'answer' => $pageSettings['faq_2_answer'] ?? null],
    ['question' => $pageSettings['faq_3_question'] ?? null, 'answer' => $pageSettings['faq_3_answer'] ?? null],
])) !!}
@endpush

@section('content')
@php
    $heroImage = asset($pageSettings['hero_image'] ?? 'assets/front/images/services/consult.jpg');
    $whyImage = asset($pageSettings['why_image'] ?? 'assets/front/images/services/con4.jpg');
    $whyItems = collect([
        ['text' => $pageSettings['why_item_1'] ?? 'Access to experienced, internationally trained doctors', 'icon' => 'fa-user-doctor'],
        ['text' => $pageSettings['why_item_2'] ?? 'Secure access through our own consultation platform', 'icon' => 'fa-shield-halved'],
        ['text' => $pageSettings['why_item_3'] ?? 'Confidentiality for patient and doctor communications', 'icon' => 'fa-lock'],
        ['text' => $pageSettings['why_item_4'] ?? 'Minimum 15 minutes quality consultation per session', 'icon' => 'fa-clock'],
        ['text' => $pageSettings['why_item_5'] ?? 'Electronic Health Records to track your health journey', 'icon' => 'fa-file-waveform'],
    ])->filter(fn ($item) => filled($item['text']))->values();
    $faqs = [
        ['question' => $pageSettings['faq_1_question'] ?? '', 'answer' => $pageSettings['faq_1_answer'] ?? ''],
        ['question' => $pageSettings['faq_2_question'] ?? '', 'answer' => $pageSettings['faq_2_answer'] ?? ''],
        ['question' => $pageSettings['faq_3_question'] ?? '', 'answer' => $pageSettings['faq_3_answer'] ?? ''],
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
                    <span class="text-sky-300">{{ $pageSettings['page_name'] ?? 'Video Consultation' }}</span>
                </nav>

                <p class="mb-4 text-xs font-black uppercase tracking-[0.22em] text-sky-300">
                    {{ $pageSettings['page_name'] ?? 'Video Consultation' }}
                </p>
                <h1 class="max-w-3xl text-4xl font-black leading-[1.08] tracking-tight text-white sm:text-5xl md:text-6xl">
                    {!! $pageSettings['hero_title_html'] ?? 'Video <span class="text-sky-400">Consultation</span>' !!}
                </h1>
                <p class="mt-6 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg sm:leading-8">
                    {{ $pageSettings['hero_description'] ?? 'Consult our doctors from the comfort of your home.' }}
                </p>

                <div class="mt-9 flex flex-wrap items-center gap-3">
                    @if($plans->isNotEmpty())
                        <a href="#consultation-plans" class="inline-flex items-center justify-center gap-2 rounded-xl bg-sky-500 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-sky-950/30 transition hover:-translate-y-0.5 hover:bg-sky-400 focus:outline-none focus:ring-4 focus:ring-sky-400/30">
                            Browse plans
                            <i class="fa-solid fa-arrow-down text-xs" aria-hidden="true"></i>
                        </a>
                    @endif
                    <div class="flex items-center gap-3 rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-sm text-slate-300 backdrop-blur-sm">
                        <span class="font-black text-white">{{ $plans->count() }}</span>
                        <span>{{ \Illuminate\Support\Str::plural('plan', $plans->count()) }}</span>
                        <span class="h-4 w-px bg-white/15"></span>
                        <i class="fa-solid fa-video text-sky-300" aria-hidden="true"></i>
                        <span>Remote care</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative z-20 -mt-7 px-4 sm:px-6" aria-label="Video consultation highlights">
        <div class="container mx-auto">
            <div class="grid overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-xl shadow-slate-900/5 md:grid-cols-3">
                @foreach($whyItems->take(3) as $item)
                    <div class="flex items-center gap-4 border-b border-slate-100 p-5 last:border-b-0 md:border-b-0 md:border-r md:last:border-r-0 sm:p-6">
                        <span class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                            <i class="fa-solid {{ $item['icon'] }}" aria-hidden="true"></i>
                        </span>
                        <p class="text-sm font-bold leading-5 text-slate-700">{{ $item['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="consultation-plans" class="scroll-mt-24 py-16 md:py-20">
        <div class="container mx-auto px-5 sm:px-6 lg:px-8">
            <div class="mb-10 flex flex-col justify-between gap-5 md:mb-12 md:flex-row md:items-end">
                <div class="max-w-3xl">
                    <p class="mb-3 text-xs font-black uppercase tracking-[0.18em] text-sky-600">Care that travels with you</p>
                    <h2 class="text-3xl font-black tracking-tight text-slate-950 md:text-4xl">{{ $pageSettings['plans_section_title'] ?? 'Affordable Video Consultation Packages' }}</h2>
                    <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base sm:leading-7">
                        {{ $pageSettings['plans_section_description'] ?? 'Choose a flexible plan for regular online doctor consultations for you and your family.' }}
                    </p>
                </div>
                @if($plans->isNotEmpty())
                    <p class="flex-shrink-0 text-sm font-medium text-slate-500">{{ $plans->count() }} {{ \Illuminate\Support\Str::plural('option', $plans->count()) }} available</p>
                @endif
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($plans as $plan)
                    @php
                        $detailsUrl = route('membership-details', ['id' => $plan->slug ?: $plan->id]);
                        $planImage = asset($plan->image ?: 'assets/front/images/services/con1.png');
                        $hasServiceSavings = ! empty($plan->service_discount)
                            && strtoupper(trim((string) $plan->service_discount)) !== 'N/A';
                    @endphp

                    <article class="group flex h-full flex-col overflow-hidden rounded-[1.75rem] border border-slate-200/80 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-sky-200 hover:shadow-2xl hover:shadow-slate-900/10">
                        <a href="{{ $detailsUrl }}" class="relative block aspect-[16/9] overflow-hidden bg-slate-100" aria-label="View {{ $plan->name }}">
                            <img src="{{ $planImage }}" alt="{{ $plan->name }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]">
                            <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-slate-950/50 to-transparent"></div>

                            @if(! empty($plan->badge_text))
                                <span class="absolute left-4 top-4 rounded-lg bg-white/95 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.12em] text-sky-700 shadow-sm backdrop-blur">
                                    {{ $plan->badge_text }}
                                </span>
                            @endif

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
                                <p class="mt-2 text-sm leading-6 text-slate-500">{{ $plan->subtitle ?: 'Flexible online doctor consultations' }}</p>
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
                                                <i class="fa-solid fa-video w-4 text-sky-600" aria-hidden="true"></i>
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
                @empty
                    <div class="col-span-full rounded-[1.75rem] border border-slate-200 bg-white px-6 py-20 text-center shadow-sm">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-sky-50 text-sky-600">
                            <i class="fa-solid fa-video text-2xl" aria-hidden="true"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-black text-slate-900">Video consultation plans are coming soon</h3>
                        <p class="mx-auto mt-3 max-w-md text-sm leading-6 text-slate-500">{{ $pageSettings['plans_empty_text'] ?? 'No video consultation packages available now.' }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="border-y border-slate-100 bg-white py-16 md:py-20">
        <div class="container mx-auto px-5 sm:px-6 lg:px-8">
            <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
                <div class="relative">
                    <div class="absolute -left-5 -top-5 h-24 w-24 rounded-[2rem] bg-sky-100"></div>
                    <div class="absolute -bottom-5 -right-5 h-32 w-32 rounded-full bg-slate-100"></div>
                    <div class="relative overflow-hidden rounded-[2rem] bg-slate-100 shadow-xl shadow-slate-900/10">
                        <img src="{{ $whyImage }}" alt="Imperial video consultation care" class="aspect-[4/3] h-full w-full object-cover">
                    </div>
                    <div class="absolute bottom-5 left-5 flex items-center gap-3 rounded-2xl border border-white/50 bg-white/90 px-4 py-3 shadow-lg backdrop-blur sm:bottom-7 sm:left-7">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-600 text-white">
                            <i class="fa-solid fa-house-medical" aria-hidden="true"></i>
                        </span>
                        <span>
                            <strong class="block text-xs font-black uppercase tracking-[0.12em] text-slate-900">Care from home</strong>
                            <span class="mt-0.5 block text-xs text-slate-500">Private and convenient</span>
                        </span>
                    </div>
                </div>

                <div>
                    <p class="mb-3 text-xs font-black uppercase tracking-[0.18em] text-sky-600">Built around your day</p>
                    <h2 class="text-3xl font-black tracking-tight text-slate-950 md:text-4xl">{{ $pageSettings['why_title'] ?? 'Why choose Imperial CareConnect?' }}</h2>
                    <p class="mt-4 max-w-xl text-sm leading-7 text-slate-500 sm:text-base">Professional medical guidance, a secure digital experience, and continuity of care wherever you are.</p>

                    <ul class="mt-8 grid gap-3 sm:grid-cols-2">
                        @foreach($whyItems as $item)
                            <li class="flex items-start gap-3 rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                <span class="mt-0.5 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-white text-sky-600 shadow-sm">
                                    <i class="fa-solid {{ $item['icon'] }} text-xs" aria-hidden="true"></i>
                                </span>
                                <span class="text-sm font-semibold leading-6 text-slate-700">{{ $item['text'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 md:py-20">
        <div class="container mx-auto max-w-4xl px-5 sm:px-6 lg:px-8">
            <div class="mb-10 text-center md:mb-12">
                <p class="mb-3 text-xs font-black uppercase tracking-[0.18em] text-sky-600">Good to know</p>
                <h2 class="text-3xl font-black tracking-tight text-slate-950 md:text-4xl">{{ $pageSettings['faq_title'] ?? 'Frequently Asked Questions' }}</h2>
                <p class="mx-auto mt-4 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base">{{ $pageSettings['faq_subtitle'] ?? '' }}</p>
            </div>

            <div class="space-y-4">
                @foreach($faqs as $faq)
                    @if($faq['question'])
                        <details class="group overflow-hidden rounded-2xl border border-slate-200/80 bg-white transition open:border-sky-200 open:shadow-lg open:shadow-slate-900/5">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-5 p-5 text-sm font-bold text-slate-800 transition hover:text-sky-700 sm:p-6 sm:text-base">
                                <span>{{ $faq['question'] }}</span>
                                <span class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-slate-50 text-sky-600 shadow-sm">
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
