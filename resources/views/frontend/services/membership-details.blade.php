@extends('layouts.front')

@section('title', ($plan->page_name ?: 'Membership Details') . ' - Imperial Health Bangladesh')
@section('meta_description', meta_excerpt($plan->subtitle ?: $plan->description ?? ''))
@section('og_image', !empty($plan->image) ? asset($plan->image) : asset('assets/front/images/services/con6.jpeg'))

@push('schema')
{!! \App\Support\SchemaBuilder::script(\App\Support\SchemaBuilder::faqPage([
    ['question' => $plan->faq_1_question ?? null, 'answer' => $plan->faq_1_answer ?? null],
    ['question' => $plan->faq_2_question ?? null, 'answer' => $plan->faq_2_answer ?? null],
    ['question' => $plan->faq_3_question ?? null, 'answer' => $plan->faq_3_answer ?? null],
])) !!}
@endpush

@section('content')
@php
    $image = !empty($plan->image) ? asset($plan->image) : asset('assets/front/images/services/con6.jpeg');
    $features = collect(preg_split('/\r\n|\r|\n/', (string) $plan->key_features))->filter()->values();
    $inclusions = collect(preg_split('/\r\n|\r|\n/', (string) $plan->inclusions))->filter()->values();
    $exclusions = collect(preg_split('/\r\n|\r|\n/', (string) $plan->exclusions))->filter()->values();
    $importantNotes = collect(preg_split('/\r\n|\r|\n/', (string) $plan->important_notes))->filter()->values();
    $patient = auth()->guard('patient')->user();
    $bookingUrl = route('membership-booking.submit', ['slug' => $plan->slug ?: $plan->id]);
@endphp

<main class="overflow-hidden bg-slate-50 font-sans text-slate-900">
    <section class="relative isolate overflow-hidden bg-slate-950">
        <div class="absolute inset-0 opacity-70" style="background: radial-gradient(circle at 12% 18%, rgba(14, 165, 233, .22), transparent 28%), radial-gradient(circle at 90% 80%, rgba(2, 132, 199, .16), transparent 30%);"></div>
        <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-sky-400/40 to-transparent"></div>

        <div class="container relative z-10 mx-auto px-5 py-14 sm:px-6 md:py-20 lg:px-8 lg:py-24">
            <nav class="mb-10 flex flex-wrap items-center gap-2 text-xs font-bold uppercase tracking-[0.16em] text-slate-400" aria-label="Breadcrumb">
                <a href="{{ route('fhome') }}" class="transition-colors hover:text-sky-300">Home</a>
                <i class="fa-solid fa-chevron-right text-[9px] text-slate-600" aria-hidden="true"></i>
                <a href="{{ route('membership') }}" class="transition-colors hover:text-sky-300">Membership</a>
                <i class="fa-solid fa-chevron-right text-[9px] text-slate-600" aria-hidden="true"></i>
                <span class="text-sky-300">Plan details</span>
            </nav>

            <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-7">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="rounded-full border border-sky-400/25 bg-sky-400/10 px-4 py-2 text-[10px] font-black uppercase tracking-[0.16em] text-sky-300">
                            {{ $plan->category->name ?? 'Membership Plan' }}
                        </span>
                        @if(!empty($plan->badge_text))
                            <span class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-[10px] font-black uppercase tracking-[0.16em] text-white">
                                {{ $plan->badge_text }}
                            </span>
                        @endif
                    </div>

                    <h1 class="mt-7 max-w-4xl text-4xl font-black leading-[1.08] tracking-tight text-white sm:text-5xl md:text-6xl">
                        {{ $plan->name }}
                    </h1>
                    <p class="mt-6 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg sm:leading-8">
                        {{ $plan->subtitle ?: 'Comprehensive healthcare coverage for you and your family.' }}
                    </p>

                    <div class="mt-8 flex flex-wrap items-end gap-x-4 gap-y-2">
                        <span class="text-4xl font-black tracking-tight text-sky-300 sm:text-5xl">{{ formated_price($plan->price) }}</span>
                        @if(!empty($plan->old_price))
                            <span class="pb-1 text-base font-semibold text-slate-500 line-through">{{ formated_price($plan->old_price) }}</span>
                        @endif
                        @if(!empty($plan->discount_text))
                            <span class="mb-1 rounded-lg bg-emerald-400/10 px-3 py-1.5 text-[10px] font-black uppercase tracking-wider text-emerald-300">{{ $plan->discount_text }}</span>
                        @endif
                    </div>

                    <div class="mt-9 flex flex-wrap items-center gap-3">
                        <a href="#book-membership" class="inline-flex items-center justify-center gap-2 rounded-xl bg-sky-500 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-sky-950/30 transition hover:-translate-y-0.5 hover:bg-sky-400 focus:outline-none focus:ring-4 focus:ring-sky-400/30">
                            Request membership
                            <i class="fa-solid fa-arrow-down text-xs" aria-hidden="true"></i>
                        </a>
                        <a href="#plan-coverage" class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/5 px-6 py-3.5 text-sm font-bold text-slate-200 backdrop-blur-sm transition hover:border-white/20 hover:bg-white/10 hover:text-white">
                            View coverage
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="relative mx-auto max-w-xl">
                        <div class="absolute -inset-5 rounded-[2.25rem] bg-sky-400/10 blur-2xl"></div>
                        <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-white/5 p-2.5 shadow-2xl shadow-black/30 backdrop-blur-sm">
                            <div class="relative aspect-[16/10] overflow-hidden rounded-[1.45rem] bg-slate-900">
                                <img src="{{ $image }}" alt="{{ $plan->name }}" class="h-full w-full object-cover">
                                <div class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-slate-950/70 to-transparent"></div>
                                @if(!empty($plan->duration))
                                    <span class="absolute bottom-4 right-4 rounded-lg border border-white/20 bg-slate-950/70 px-3 py-1.5 text-xs font-bold text-white backdrop-blur">
                                        {{ $plan->duration }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative z-20 -mt-1 py-14 md:py-20">
        <div class="container mx-auto px-5 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-12">
                <div class="lg:col-span-7">
                    <div class="rounded-[1.75rem] border border-slate-200/80 bg-white p-7 shadow-sm md:p-9">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-sky-600">Plan overview</p>
                        <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950 md:text-4xl">About this membership plan</h2>
                        @if(!empty($plan->description))
                            <p class="mt-5 text-base leading-8 text-slate-600">{{ $plan->description }}</p>
                        @endif

                        @if($features->isNotEmpty())
                            <div class="mt-8 border-t border-slate-100 pt-8">
                                <h3 class="text-sm font-black uppercase tracking-[0.14em] text-slate-900">Key features</h3>
                                <ul class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    @foreach($features as $feature)
                                        <li class="flex items-start gap-3 rounded-2xl bg-slate-50 p-4 text-sm font-semibold leading-6 text-slate-700">
                                            <span class="mt-0.5 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-lg bg-sky-100 text-sky-600">
                                                <i class="fa-solid fa-check text-[10px]" aria-hidden="true"></i>
                                            </span>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <aside class="lg:col-span-5" aria-label="Membership facts">
                    <div class="rounded-[1.75rem] border border-slate-200/80 bg-white p-7 shadow-sm md:p-8">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-sky-600">At a glance</p>
                        <dl class="mt-5 divide-y divide-slate-100">
                            <div class="flex items-center justify-between gap-5 py-5">
                                <dt class="flex items-center gap-3 text-sm font-semibold text-slate-500">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-600"><i class="fa-solid fa-calendar-days" aria-hidden="true"></i></span>
                                    Duration
                                </dt>
                                <dd class="text-right text-sm font-black text-slate-900">{{ $plan->duration ?: 'Not specified' }}</dd>
                            </div>
                            <div class="flex items-center justify-between gap-5 py-5">
                                <dt class="flex items-center gap-3 text-sm font-semibold text-slate-500">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-600"><i class="fa-solid fa-user-doctor" aria-hidden="true"></i></span>
                                    Doctor access
                                </dt>
                                <dd class="max-w-[48%] text-right text-sm font-black text-slate-900">{{ $plan->doctor_visits ?: 'Not specified' }}</dd>
                            </div>
                            <div class="flex items-center justify-between gap-5 py-5">
                                <dt class="flex items-center gap-3 text-sm font-semibold text-slate-500">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-600"><i class="fa-solid fa-tag" aria-hidden="true"></i></span>
                                    Service savings
                                </dt>
                                <dd class="max-w-[48%] text-right text-sm font-black text-slate-900">{{ $plan->service_discount ?: 'Not specified' }}</dd>
                            </div>
                        </dl>
                        <a href="#book-membership" class="mt-5 flex w-full items-center justify-between rounded-xl bg-slate-950 px-5 py-4 text-sm font-bold text-white transition hover:bg-sky-600 focus:outline-none focus:ring-4 focus:ring-sky-100">
                            Request this plan
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-white/10"><i class="fa-solid fa-arrow-down text-xs" aria-hidden="true"></i></span>
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <section id="book-membership" class="scroll-mt-24 border-y border-slate-200/70 bg-white py-16 md:py-20">
        <div class="container mx-auto px-5 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-900/5">
                <div class="grid grid-cols-1 lg:grid-cols-12">
                    <div class="relative overflow-hidden bg-slate-950 p-8 text-white md:p-10 lg:col-span-4 lg:p-12">
                        <div class="absolute inset-0 opacity-60" style="background: radial-gradient(circle at 20% 15%, rgba(14, 165, 233, .28), transparent 30%);"></div>
                        <div class="relative">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-400/15 text-xl text-sky-300">
                                <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                            </span>
                            <p class="mt-8 text-xs font-black uppercase tracking-[0.18em] text-sky-300">Membership request</p>
                            <h2 class="mt-3 text-3xl font-black tracking-tight">Start your booking request</h2>
                            <p class="mt-5 text-sm leading-7 text-slate-300">Enter your details and preferred start date. The Imperial care team will contact you to confirm the request.</p>

                            <div class="mt-9 rounded-2xl border border-white/10 bg-white/5 p-5">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-slate-400">Selected plan</p>
                                <p class="mt-2 font-bold leading-6 text-white">{{ $plan->name }}</p>
                                <p class="mt-3 text-2xl font-black text-sky-300">{{ formated_price($plan->price) }}</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ $bookingUrl }}" class="p-7 md:p-10 lg:col-span-8 lg:p-12">
                        @csrf
                        @if(session('success'))
                            <div class="mb-7 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" role="status">{{ session('success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="mb-7 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700" role="alert">
                                <p class="font-bold">Please review the highlighted fields and try again.</p>
                                <ul class="mt-2 list-inside list-disc space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-8">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-sky-600">Your information</p>
                            <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Tell us who the membership is for</h3>
                        </div>

                        <div class="grid grid-cols-1 gap-x-5 gap-y-5 md:grid-cols-2">
                            <div>
                                <label for="membership-patient-name" class="mb-2 block text-xs font-bold text-slate-600">Patient Name <span class="text-rose-500">*</span></label>
                                <input id="membership-patient-name" type="text" name="patient_name" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100" placeholder="Your full name" value="{{ old('patient_name', $patient->name ?? '') }}" required>
                            </div>
                            <div>
                                <label for="membership-phone" class="mb-2 block text-xs font-bold text-slate-600">Phone Number <span class="text-rose-500">*</span></label>
                                <input id="membership-phone" type="text" name="phone" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100" placeholder="Phone number" value="{{ old('phone', $patient->phone ?? '') }}" required>
                            </div>
                            <div>
                                <label for="membership-email" class="mb-2 block text-xs font-bold text-slate-600">Email Address <span class="text-rose-500">*</span></label>
                                <input id="membership-email" type="email" name="email" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100 read-only:cursor-not-allowed read-only:text-slate-500" placeholder="Email address" value="{{ old('email', $patient->email ?? '') }}" {{ $patient ? 'readonly' : '' }} required>
                            </div>
                            <div>
                                <label for="membership-dob" class="mb-2 block text-xs font-bold text-slate-600">Date of Birth <span class="text-rose-500">*</span></label>
                                <input id="membership-dob" type="date" name="dob" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100" value="{{ old('dob', (!empty($patient->dob) && strtotime($patient->dob)) ? date('Y-m-d', strtotime($patient->dob)) : '') }}" required>
                            </div>
                            <div class="md:col-span-2">
                                <label for="membership-start-date" class="mb-2 block text-xs font-bold text-slate-600">Preferred Start Date <span class="font-normal text-slate-400">(Optional)</span></label>
                                <input id="membership-start-date" type="date" name="preferred_start_date" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100" min="{{ date('Y-m-d') }}" value="{{ old('preferred_start_date') }}">
                            </div>
                            <div class="md:col-span-2">
                                <label for="membership-notes" class="mb-2 block text-xs font-bold text-slate-600">Notes <span class="font-normal text-slate-400">(Optional)</span></label>
                                <textarea id="membership-notes" name="notes" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100" rows="3" placeholder="Anything our care team should know?">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="mt-7 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-sky-600 px-6 py-4 text-sm font-black uppercase tracking-wider text-white transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200">
                            Submit booking request
                            <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section id="plan-coverage" class="scroll-mt-24 py-16 md:py-20">
        <div class="container mx-auto px-5 sm:px-6 lg:px-8">
            <div class="mb-10 max-w-2xl">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-sky-600">Plan coverage</p>
                <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950 md:text-4xl">Know what the plan covers</h2>
                <p class="mt-4 text-base leading-7 text-slate-500">Review the recorded inclusions and exclusions before submitting your request.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div class="rounded-[1.75rem] border border-emerald-100 bg-white p-7 shadow-sm md:p-9">
                    <div class="flex items-center gap-4">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-sky-50 text-sky-600"><i class="fa-solid fa-check" aria-hidden="true"></i></span>
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.14em] text-sky-600">Included</p>
                            <h3 class="mt-1 text-xl font-black text-slate-950">What’s covered</h3>
                        </div>
                    </div>
                    <ul class="mt-7 space-y-4">
                        @forelse($inclusions as $item)
                            <li class="flex items-start gap-3 text-sm font-medium leading-6 text-slate-700">
                                <i class="fa-solid fa-circle-check mt-1 text-emerald-500" aria-hidden="true"></i>
                                <span>{{ $item }}</span>
                            </li>
                        @empty
                            <li class="rounded-xl bg-slate-50 p-4 text-sm text-slate-500">No inclusion details provided.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="rounded-[1.75rem] border border-rose-100 bg-white p-7 shadow-sm md:p-9">
                    <div class="flex items-center gap-4">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-rose-50 text-rose-600"><i class="fa-solid fa-xmark" aria-hidden="true"></i></span>
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.14em] text-rose-600">Excluded</p>
                            <h3 class="mt-1 text-xl font-black text-slate-950">What’s not covered</h3>
                        </div>
                    </div>
                    <ul class="mt-7 space-y-4">
                        @forelse($exclusions as $item)
                            <li class="flex items-start gap-3 text-sm font-medium leading-6 text-slate-700">
                                <i class="fa-solid fa-circle-xmark mt-1 text-rose-500" aria-hidden="true"></i>
                                <span>{{ $item }}</span>
                            </li>
                        @empty
                            <li class="rounded-xl bg-slate-50 p-4 text-sm text-slate-500">No exclusion details provided.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            @if($importantNotes->isNotEmpty())
                <div class="mt-6 rounded-[1.75rem] border border-amber-100 bg-amber-50/70 p-7 md:p-8">
                    <div class="flex items-start gap-4">
                        <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-700"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></span>
                        <div>
                            <h3 class="font-black text-slate-900">Important notes</h3>
                            <ul class="mt-3 space-y-2 text-sm leading-6 text-slate-600">
                                @foreach($importantNotes as $note)
                                    <li>{{ $note }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @if($plan->faq_1_question || $plan->faq_2_question || $plan->faq_3_question)
        <section class="border-y border-slate-200/70 bg-white py-16 md:py-20">
            <div class="container mx-auto grid grid-cols-1 gap-10 px-5 sm:px-6 lg:grid-cols-12 lg:px-8">
                <div class="lg:col-span-4">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-sky-600">Helpful information</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950 md:text-4xl">Common questions</h2>
                    <p class="mt-4 text-base leading-7 text-slate-500">Answers recorded for this membership plan.</p>
                </div>
                <div class="space-y-4 lg:col-span-8">
                    @foreach([1, 2, 3] as $faqNumber)
                        @php
                            $question = $plan->{'faq_' . $faqNumber . '_question'};
                            $answer = $plan->{'faq_' . $faqNumber . '_answer'};
                        @endphp
                        @if($question)
                            <details class="group overflow-hidden rounded-2xl border border-slate-200 bg-slate-50/70">
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-5 p-5 font-bold text-slate-900 transition hover:bg-slate-100/70 md:p-6">
                                    {{ $question }}
                                    <span class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-white text-sky-600 shadow-sm">
                                        <i class="fa-solid fa-plus text-xs transition-transform group-open:rotate-45" aria-hidden="true"></i>
                                    </span>
                                </summary>
                                <div class="border-t border-slate-200 px-5 py-5 text-sm leading-7 text-slate-600 md:px-6">{{ $answer }}</div>
                            </details>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($relatedPlans->isNotEmpty())
        <section class="py-16 md:py-20">
            <div class="container mx-auto px-5 sm:px-6 lg:px-8">
                <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-sky-600">Keep exploring</p>
                        <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950 md:text-4xl">Related membership plans</h2>
                    </div>
                    <a href="{{ route('membership') }}" class="inline-flex items-center gap-2 text-sm font-bold text-sky-700 transition hover:text-sky-900">
                        View all plans
                        <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($relatedPlans as $related)
                        @php
                            $relatedUrl = route('membership-details', ['id' => $related->slug ?: $related->id]);
                            $relatedImage = !empty($related->image) ? asset($related->image) : asset('assets/front/images/services/con7.jpeg');
                        @endphp
                        <article class="group flex h-full flex-col overflow-hidden rounded-[1.75rem] border border-slate-200/80 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-sky-200 hover:shadow-xl hover:shadow-slate-900/10">
                            <a href="{{ $relatedUrl }}" class="relative block aspect-[16/9] overflow-hidden bg-slate-100" aria-label="View {{ $related->name }}">
                                <img src="{{ $relatedImage }}" alt="{{ $related->name }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]">
                                @if(!empty($related->duration))
                                    <span class="absolute bottom-4 right-4 rounded-lg border border-white/20 bg-slate-950/65 px-3 py-1.5 text-xs font-bold text-white backdrop-blur">{{ $related->duration }}</span>
                                @endif
                            </a>
                            <div class="flex flex-1 flex-col p-6">
                                <h3 class="text-lg font-black leading-snug tracking-tight text-slate-950 transition-colors group-hover:text-sky-700">
                                    <a href="{{ $relatedUrl }}">{{ $related->name }}</a>
                                </h3>
                                <p class="mt-2 text-sm leading-6 text-slate-500">{{ $related->subtitle ?: 'Membership Plan' }}</p>
                                <p class="mt-5 text-2xl font-black tracking-tight text-sky-700">{{ formated_price($related->price) }}</p>
                                <a href="{{ $relatedUrl }}" class="mt-6 flex w-full items-center justify-between rounded-xl bg-slate-950 px-5 py-3.5 text-sm font-bold text-white transition hover:bg-sky-600">
                                    Explore plan
                                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-white/10"><i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i></span>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</main>
@endsection
