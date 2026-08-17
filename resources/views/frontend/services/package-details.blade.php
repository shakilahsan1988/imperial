@extends('layouts.front')

@section('title', $package->name . ' - Imperial Health Bangladesh')
@section('meta_description', meta_excerpt($package->subtitle ?: $package->description ?? ''))
@section('og_image', $package->image ? asset($package->image) : asset('assets/front/images/services/services-facility.jpg'))

@push('schema')
{!! \App\Support\SchemaBuilder::script(\App\Support\SchemaBuilder::faqPage([
    ['question' => $package->faq_1_question ?? null, 'answer' => $package->faq_1_answer ?? null],
    ['question' => $package->faq_2_question ?? null, 'answer' => $package->faq_2_answer ?? null],
])) !!}
@endpush

@section('content')

    @php
        $packageImage = asset($package->image ?: 'assets/front/images/services/services-facility.jpg');
        $inclusions = collect(preg_split('/\r\n|\r|\n/', (string) $package->inclusions))->filter()->values();
        $preparationSteps = collect(preg_split('/\r\n|\r|\n/', (string) $package->preparation_steps))->filter()->values();
        $patient = auth()->guard('patient')->user();
    @endphp

    <main class="bg-white font-sans text-slate-900">
        <section class="relative overflow-hidden bg-slate-950 py-16 md:py-24">
            <div class="absolute inset-0 opacity-70" style="background: radial-gradient(circle at 85% 15%, rgba(14, 165, 233, .22), transparent 32%), radial-gradient(circle at 10% 100%, rgba(2, 132, 199, .16), transparent 30%);"></div>
            <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-sky-400/40 to-transparent"></div>

            <div class="container relative z-10 mx-auto px-4">
                <nav class="mb-8 flex flex-wrap items-center gap-2 text-xs font-bold uppercase tracking-[0.16em] text-slate-400" aria-label="Breadcrumb">
                    <a href="{{ route('health-check') }}" class="transition-colors hover:text-sky-300">Health Check</a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-600" aria-hidden="true"></i>
                    <span class="text-sky-300">Package Details</span>
                </nav>

                <div class="max-w-4xl">
                    <div class="mb-6 flex flex-wrap items-center gap-3">
                        <span class="rounded-full border border-sky-400/25 bg-sky-400/10 px-4 py-2 text-[10px] font-black uppercase tracking-[0.18em] text-sky-300">
                            {{ $package->badge_text ?: 'Comprehensive Screening' }}
                        </span>
                        @if($package->recommended)
                            <span class="rounded-full border border-emerald-400/25 bg-emerald-400/10 px-4 py-2 text-[10px] font-black uppercase tracking-[0.18em] text-emerald-300">Recommended</span>
                        @endif
                    </div>

                    <h1 class="max-w-4xl text-4xl font-extrabold leading-tight tracking-tight text-white md:text-6xl">
                        {{ $package->name }}
                    </h1>
                    <p class="mt-6 max-w-3xl text-base leading-8 text-slate-300 md:text-lg">
                        {{ $package->subtitle ?: 'A comprehensive health screening designed to provide a clear and reliable view of your wellbeing.' }}
                    </p>
                </div>
            </div>
        </section>

        <section class="bg-slate-50 py-12 md:py-20">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-12">
                    <div class="lg:col-span-7">
                        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white p-3 shadow-sm">
                            <img src="{{ $packageImage }}"
                                 alt="{{ $package->name }}"
                                 class="block h-auto w-full rounded-2xl"
                                 width="1653"
                                 height="952">
                        </div>
                        <div class="mt-5 flex items-start gap-3 rounded-2xl border border-sky-100 bg-sky-50/70 px-5 py-4 text-sm leading-6 text-slate-600">
                            <i class="fa-solid fa-circle-info mt-1 text-sky-600" aria-hidden="true"></i>
                            <p>Review the package information and preparation guidance below. Our team will confirm your preferred appointment date after submission.</p>
                        </div>
                    </div>

                    <aside class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm md:p-8 lg:col-span-5" aria-label="Package overview">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full bg-sky-50 px-3 py-1.5 text-[10px] font-black uppercase tracking-wider text-sky-700">
                                {{ $package->category->name ?? 'Health Package' }}
                            </span>
                            @if($package->immediate_availability)
                                <span class="rounded-full bg-emerald-50 px-3 py-1.5 text-[10px] font-black uppercase tracking-wider text-emerald-700">Immediate Availability</span>
                            @endif
                        </div>

                        <p class="mt-7 text-xs font-black uppercase tracking-[0.16em] text-slate-400">Package price</p>
                        <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-2">
                            <span class="text-4xl font-extrabold tracking-tight text-slate-950">{{ formated_price($package->price) }}</span>
                            @if($package->old_price)
                                <span class="text-lg font-semibold text-slate-400 line-through">{{ formated_price($package->old_price) }}</span>
                            @endif
                            @if($package->discount_text)
                                <span class="rounded-full bg-rose-50 px-3 py-1 text-[10px] font-black uppercase tracking-wider text-rose-600">{{ $package->discount_text }}</span>
                            @endif
                        </div>

                        <p class="mt-6 border-b border-slate-100 pb-7 text-base leading-7 text-slate-600">{{ $package->description }}</p>

                        <dl class="divide-y divide-slate-100">
                            <div class="flex items-center justify-between gap-4 py-4">
                                <dt class="flex items-center gap-3 text-sm font-semibold text-slate-500">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-sky-50 text-sky-600"><i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i></span>
                                    Duration
                                </dt>
                                <dd class="text-right text-sm font-bold text-slate-900">{{ $package->duration ?: 'Contact us' }}</dd>
                            </div>
                            <div class="flex items-center justify-between gap-4 py-4">
                                <dt class="flex items-center gap-3 text-sm font-semibold text-slate-500">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-sky-50 text-sky-600"><i class="fa-solid fa-file-shield" aria-hidden="true"></i></span>
                                    Report turnaround
                                </dt>
                                <dd class="text-right text-sm font-bold text-slate-900">{{ $package->turnaround ?: 'Contact us' }}</dd>
                            </div>
                            <div class="flex items-center justify-between gap-4 py-4">
                                <dt class="flex items-center gap-3 text-sm font-semibold text-slate-500">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-sky-50 text-sky-600"><i class="fa-solid fa-mug-hot" aria-hidden="true"></i></span>
                                    Fasting requirement
                                </dt>
                                <dd class="text-right text-sm font-bold text-slate-900">{{ $package->fasting ?: 'Not specified' }}</dd>
                            </div>
                        </dl>

                        <a href="#book-package" class="mt-6 flex w-full items-center justify-center gap-2 rounded-xl bg-sky-600 px-6 py-4 text-sm font-black uppercase tracking-wider text-white shadow-lg shadow-sky-600/20 transition hover:bg-sky-700">
                            Book This Package
                            <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                        </a>
                        <p class="mt-4 text-center text-xs leading-5 text-slate-400">Submitting a request does not require online payment.</p>
                    </aside>
                </div>

                <div id="book-package" class="scroll-mt-24 mt-12 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <div class="grid grid-cols-1 lg:grid-cols-12">
                        <div class="bg-slate-950 p-7 text-white md:p-10 lg:col-span-4">
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-500/15 text-xl text-sky-300">
                                <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                            </span>
                            <h2 class="mt-6 text-2xl font-extrabold tracking-tight md:text-3xl">Request an appointment</h2>
                            <p class="mt-4 text-sm leading-7 text-slate-300">Share your details and preferred date. Our care team will contact you to confirm availability and guide you through the next steps.</p>
                            <div class="mt-8 space-y-4 text-sm text-slate-300">
                                <p class="flex items-center gap-3"><i class="fa-solid fa-check text-emerald-400" aria-hidden="true"></i> Secure booking request</p>
                                <p class="flex items-center gap-3"><i class="fa-solid fa-check text-emerald-400" aria-hidden="true"></i> Confirmation from our care team</p>
                                <p class="flex items-center gap-3"><i class="fa-solid fa-check text-emerald-400" aria-hidden="true"></i> No advance online payment</p>
                            </div>
                        </div>

                        <form action="{{ route('package-booking.submit', ['slug' => $package->slug]) }}" method="POST" class="p-7 md:p-10 lg:col-span-8">
                            @csrf
                            @if($errors->any())
                                <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700" role="alert">
                                    Please review the highlighted fields and try again.
                                </div>
                            @endif

                            <div class="grid grid-cols-1 gap-x-5 gap-y-5 md:grid-cols-2">
                                <div>
                                    <label for="package-patient-name" class="mb-2 block text-xs font-bold text-slate-600">Patient Name <span class="text-rose-500">*</span></label>
                                    <input id="package-patient-name" type="text" name="patient_name" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-100" placeholder="Your full name" value="{{ old('patient_name', $patient->name ?? '') }}" required>
                                    @error('patient_name')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="package-phone" class="mb-2 block text-xs font-bold text-slate-600">Phone Number <span class="text-rose-500">*</span></label>
                                    <input id="package-phone" type="text" name="phone" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-100" placeholder="Phone number" value="{{ old('phone', $patient->phone ?? '') }}" required>
                                    @error('phone')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="package-email" class="mb-2 block text-xs font-bold text-slate-600">Email Address <span class="text-rose-500">*</span></label>
                                    <input id="package-email" type="email" name="email" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-100 disabled:bg-slate-50" placeholder="Email address" value="{{ old('email', $patient->email ?? '') }}" {{ $patient ? 'readonly' : '' }} required>
                                    @error('email')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="package-dob" class="mb-2 block text-xs font-bold text-slate-600">Date of Birth <span class="text-rose-500">*</span></label>
                                    <input id="package-dob" type="date" name="dob" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-100" value="{{ old('dob', (!empty($patient->dob) && strtotime($patient->dob)) ? date('Y-m-d', strtotime($patient->dob)) : '') }}" required>
                                    @error('dob')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label for="package-preferred-date" class="mb-2 block text-xs font-bold text-slate-600">Preferred Date <span class="font-normal text-slate-400">(Optional)</span></label>
                                    <input id="package-preferred-date" type="date" name="preferred_date" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-100" value="{{ old('preferred_date') }}">
                                    @error('preferred_date')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label for="package-notes" class="mb-2 block text-xs font-bold text-slate-600">Notes <span class="font-normal text-slate-400">(Optional)</span></label>
                                    <textarea id="package-notes" name="notes" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-100" rows="3" placeholder="Anything our care team should know?">{{ old('notes') }}</textarea>
                                    @error('notes')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <button type="submit" class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-sky-600 px-6 py-4 text-sm font-black uppercase tracking-wider text-white transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200">
                                Submit Booking Request
                                <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-y border-slate-100 bg-white py-16 md:py-20">
            <div class="container mx-auto px-4">
                <div class="mb-10 max-w-2xl">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-sky-600">Package coverage</p>
                    <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950 md:text-4xl">What's included</h2>
                    <p class="mt-3 text-base leading-7 text-slate-500">The following tests and services are included in this health package.</p>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @forelse($inclusions as $item)
                        <div class="flex items-start gap-4 rounded-2xl border border-slate-200 bg-white p-5 transition hover:border-sky-200 hover:shadow-sm">
                            <span class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600"><i class="fa-solid fa-check text-sm" aria-hidden="true"></i></span>
                            <p class="pt-1.5 font-semibold leading-6 text-slate-800">{{ $item }}</p>
                        </div>
                    @empty
                        <div class="col-span-full rounded-2xl border border-dashed border-slate-300 p-8 text-center text-slate-500">No inclusions added.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="bg-slate-50 py-16 md:py-20">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <div class="rounded-3xl border border-slate-200 bg-white p-7 shadow-sm md:p-9">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-sky-600">Before your visit</p>
                        <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950">How to prepare</h2>
                        <div class="mt-8 space-y-6">
                            @forelse($preparationSteps as $idx => $step)
                                <div class="flex gap-4">
                                    <span class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-slate-950 text-sm font-black text-white">{{ $idx + 1 }}</span>
                                    <p class="pt-1.5 leading-7 text-slate-600">{{ $step }}</p>
                                </div>
                            @empty
                                <p class="rounded-xl bg-slate-50 p-5 text-slate-500">No preparation steps added.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-7 shadow-sm md:p-9">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-sky-600">Helpful information</p>
                        <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950">Common questions</h2>
                        <div class="mt-8 space-y-4">
                            @if($package->faq_1_question)
                                <details class="group overflow-hidden rounded-2xl border border-slate-200 bg-slate-50/70">
                                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 p-5 font-bold text-slate-800">
                                        {{ $package->faq_1_question }}
                                        <i class="fa-solid fa-plus text-sky-600 transition-transform group-open:rotate-45" aria-hidden="true"></i>
                                    </summary>
                                    <div class="border-t border-slate-200 px-5 py-4 text-sm leading-7 text-slate-600">{{ $package->faq_1_answer }}</div>
                                </details>
                            @endif
                            @if($package->faq_2_question)
                                <details class="group overflow-hidden rounded-2xl border border-slate-200 bg-slate-50/70">
                                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 p-5 font-bold text-slate-800">
                                        {{ $package->faq_2_question }}
                                        <i class="fa-solid fa-plus text-sky-600 transition-transform group-open:rotate-45" aria-hidden="true"></i>
                                    </summary>
                                    <div class="border-t border-slate-200 px-5 py-4 text-sm leading-7 text-slate-600">{{ $package->faq_2_answer }}</div>
                                </details>
                            @endif
                            @if(!$package->faq_1_question && !$package->faq_2_question)
                                <p class="rounded-xl bg-slate-50 p-5 text-slate-500">No frequently asked questions added.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
