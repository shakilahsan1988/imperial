@extends('layouts.front')

@section('title', ($plan->page_name ?: 'Membership Details') . ' - Imperial Health Bangladesh')

@section('content')
@php
    $image = !empty($plan->image) ? asset($plan->image) : asset('assets/front/images/services/con6.jpeg');
    $features = collect(preg_split('/\r\n|\r|\n/', (string) $plan->key_features))->filter()->values();
    $inclusions = collect(preg_split('/\r\n|\r|\n/', (string) $plan->inclusions))->filter()->values();
    $exclusions = collect(preg_split('/\r\n|\r|\n/', (string) $plan->exclusions))->filter()->values();
    $importantNotes = collect(preg_split('/\r\n|\r|\n/', (string) $plan->important_notes))->filter()->values();
    $patient = auth()->guard('patient')->user();
@endphp

<section class="relative h-[40vh] min-h-[300px]">
    <img src="{{ $image }}" alt="{{ $plan->name }}" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 to-slate-900/40"></div>
    <div class="absolute inset-0 flex items-center">
        <div class="container mx-auto px-6">
            <div class="max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ $plan->name }}</h1>
                <p class="text-lg text-white/90">{{ $plan->subtitle ?: 'Comprehensive healthcare coverage for you and your family' }}</p>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <div class="relative rounded-2xl overflow-hidden shadow-xl">
                <img src="{{ $image }}" alt="{{ $plan->name }}" class="w-full h-[400px] object-cover">
                @if($plan->badge_text)
                <div class="absolute top-4 right-4 bg-yellow-500 text-white px-4 py-2 rounded-full font-semibold">
                    {{ $plan->badge_text }}
                </div>
                @endif
            </div>

            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-3 py-1 bg-imperial-primary/10 text-imperial-primary text-sm font-medium rounded-full">
                        {{ $plan->category->name ?? 'Membership Plan' }}
                    </span>
                    <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-medium rounded-full">Active</span>
                </div>

                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $plan->name }}</h2>

                <div class="mb-6">
                    <span class="text-4xl font-bold text-imperial-primary">{{ formated_price($plan->price) }}</span>
                    @if(!empty($plan->old_price))
                    <span class="text-gray-500 line-through ml-3">{{ formated_price($plan->old_price) }}</span>
                    @endif
                    @if(!empty($plan->discount_text))
                    <span class="ml-2 text-sm bg-red-100 text-red-600 px-2 py-1 rounded">{{ $plan->discount_text }}</span>
                    @endif
                </div>

                <p class="text-gray-600 mb-8 leading-relaxed">{{ $plan->description }}</p>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-8">
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <i class="fa-solid fa-calendar text-imperial-primary text-2xl mb-2"></i>
                        <p class="text-sm text-gray-600">Duration</p>
                        <p class="font-semibold text-gray-900">{{ $plan->duration ?: '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <i class="fa-solid fa-user-doctor text-imperial-primary text-2xl mb-2"></i>
                        <p class="text-sm text-gray-600">Doctor Visits</p>
                        <p class="font-semibold text-gray-900">{{ $plan->doctor_visits ?: '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <i class="fa-solid fa-percent text-imperial-primary text-2xl mb-2"></i>
                        <p class="text-sm text-gray-600">Discount</p>
                        <p class="font-semibold text-gray-900">{{ $plan->service_discount ?: '-' }}</p>
                    </div>
                </div>

                @if($features->count())
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Key Features</h3>
                    <ul class="space-y-3">
                        @foreach($features as $feature)
                        <li class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-check text-green-600 text-xs"></i>
                            </div>
                            <span class="text-gray-700">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 border border-slate-50">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-bold">1</div>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Book This Membership Plan</h3>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('membership-booking.submit', ['slug' => $plan->slug ?: $plan->id]) }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Patient Name</label>
                        <input type="text" name="patient_name" class="w-full h-[52px] rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition" placeholder="Patient Name" value="{{ old('patient_name', $patient->name ?? '') }}" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Phone Number</label>
                        <input type="text" name="phone" class="w-full h-[52px] rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition" placeholder="Phone Number" value="{{ old('phone', $patient->phone ?? '') }}" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Email Address</label>
                        <input type="email" name="email" class="w-full h-[52px] rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition" placeholder="Email Address" value="{{ old('email', $patient->email ?? '') }}" {{ $patient ? 'readonly' : '' }} required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Date Of Birth</label>
                        <input type="date" name="dob" class="w-full h-[52px] rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition" value="{{ old('dob', (!empty($patient->dob) && strtotime($patient->dob)) ? date('Y-m-d', strtotime($patient->dob)) : '') }}" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Preferred Start Date (Optional)</label>
                        <input type="date" name="preferred_start_date" class="w-full h-[52px] rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition" min="{{ date('Y-m-d') }}" value="{{ old('preferred_start_date') }}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Notes (Optional)</label>
                        <textarea name="notes" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition" rows="3" placeholder="Notes (optional)">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-8 rounded-2xl font-black uppercase tracking-widest text-sm transition-all">
                        Submit Plan Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="bg-green-50 rounded-2xl p-8">
                <h3 class="text-lg font-bold text-green-700 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    What's Included
                </h3>
                <ul class="space-y-3">
                    @forelse($inclusions as $item)
                    <li class="flex items-start gap-3 text-gray-700">
                        <i class="fa-solid fa-circle-check text-green-500 mt-1"></i>
                        <span>{{ $item }}</span>
                    </li>
                    @empty
                    <li class="text-gray-500">No inclusion details provided.</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-red-50 rounded-2xl p-8">
                <h3 class="text-lg font-bold text-red-700 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-xmark"></i>
                    What's Not Covered
                </h3>
                <ul class="space-y-3">
                    @forelse($exclusions as $item)
                    <li class="flex items-start gap-3 text-gray-700">
                        <i class="fa-solid fa-circle-xmark text-red-500 mt-1"></i>
                        <span>{{ $item }}</span>
                    </li>
                    @empty
                    <li class="text-gray-500">No exclusion details provided.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6 max-w-4xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Frequently Asked Questions</h2>

        <div class="space-y-4">
            @if($plan->faq_1_question)
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <details class="group">
                    <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900">{{ $plan->faq_1_question }}</span>
                        <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="px-5 pb-5 text-gray-600 leading-relaxed"><p>{{ $plan->faq_1_answer }}</p></div>
                </details>
            </div>
            @endif
            @if($plan->faq_2_question)
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <details class="group">
                    <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900">{{ $plan->faq_2_question }}</span>
                        <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="px-5 pb-5 text-gray-600 leading-relaxed"><p>{{ $plan->faq_2_answer }}</p></div>
                </details>
            </div>
            @endif
            @if($plan->faq_3_question)
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <details class="group">
                    <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900">{{ $plan->faq_3_question }}</span>
                        <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="px-5 pb-5 text-gray-600 leading-relaxed"><p>{{ $plan->faq_3_answer }}</p></div>
                </details>
            </div>
            @endif
        </div>
    </div>
</section>

@if($relatedPlans->count())
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Plans</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedPlans as $related)
            <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                <a href="{{ route('membership-details', ['id' => $related->slug ?: $related->id]) }}" class="block h-44 overflow-hidden">
                    <img src="{{ !empty($related->image) ? asset($related->image) : asset('assets/front/images/services/con7.jpeg') }}" alt="{{ $related->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                </a>
                <div class="p-5 flex flex-col flex-grow">
                    <h3 class="font-bold text-gray-900 mb-1">{{ $related->name }}</h3>
                    <p class="text-gray-500 text-xs mb-3">{{ $related->subtitle ?: 'Membership Plan' }}</p>
                    <div class="mb-3">
                        <span class="text-xl font-bold text-imperial-primary">{{ formated_price($related->price) }}</span>
                    </div>
                    <div class="mt-auto">
                        <a href="{{ route('membership-details', ['id' => $related->slug ?: $related->id]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
