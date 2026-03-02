@extends('layouts.front')

@section('title', 'Video Consultation Plans - Imperial Health Bangladesh')

@section('content')

<section class="relative h-[50vh] min-h-[350px]">
    <img src="{{ asset('assets/front/images/services/consult.jpg') }}" alt="Video Consultation" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 to-slate-900/40"></div>
    <div class="absolute inset-0 flex items-center">
        <div class="container mx-auto px-6">
            <div class="max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Amar Jotno Plans</h1>
                <p class="text-lg text-white/90">Video consultations from the comfort of your home</p>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Affordable Video Consultation Packages</h2>
            <p class="text-lg text-gray-600 leading-relaxed">
                Choose a flexible plan for regular online doctor consultations for you and your family.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($plans as $plan)
            <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                <a href="{{ route('membership-details', ['id' => $plan->slug ?: $plan->id]) }}" class="block h-44 overflow-hidden">
                    <img src="{{ !empty($plan->image) ? asset($plan->image) : asset('assets/front/images/services/con1.png') }}" alt="{{ $plan->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                </a>
                <div class="p-5 flex flex-col flex-grow">
                    @if(!empty($plan->badge_text))
                    <div class="mb-2">
                        <span class="inline-flex px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded">{{ $plan->badge_text }}</span>
                    </div>
                    @endif
                    <h3 class="font-bold text-gray-900 mb-1">{{ $plan->name }}</h3>
                    <p class="text-gray-500 text-xs mb-3">{{ $plan->subtitle ?: 'Unlimited video consultations' }}</p>
                    <div class="mb-3">
                        <span class="text-2xl font-bold text-imperial-primary">{{ formated_price($plan->price) }}</span>
                    </div>
                    <div class="mt-auto">
                        <a href="{{ route('membership-details', ['id' => $plan->slug ?: $plan->id]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-2.5 rounded-lg font-medium transition">View Details</a>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-full text-center py-8 text-gray-500">No video consultation packages available now.</div>
            @endforelse
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <img src="{{ asset('assets/front/images/services/con4.jpg') }}" alt="Why choose Amar Jotno Plan" class="rounded-2xl shadow-lg w-full h-auto object-cover">
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">Why choose Amar Jotno Plan?</h2>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3 text-gray-700">
                        <i class="fa-solid fa-check-circle text-imperial-primary mt-1"></i>
                        <span>Access to experienced, internationally trained doctors</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700">
                        <i class="fa-solid fa-check-circle text-imperial-primary mt-1"></i>
                        <span>Secure access through our own consultation platform</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700">
                        <i class="fa-solid fa-check-circle text-imperial-primary mt-1"></i>
                        <span>Confidentiality for patient and doctor communications</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700">
                        <i class="fa-solid fa-check-circle text-imperial-primary mt-1"></i>
                        <span>Minimum 15 minutes quality consultation per session</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700">
                        <i class="fa-solid fa-check-circle text-imperial-primary mt-1"></i>
                        <span>Electronic Health Records to track your health journey</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Frequently Asked Questions</h2>
            <p class="text-gray-600">Take a look at the most commonly asked questions. We are here to help.</p>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <details class="group">
                    <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900">How do I book a video consultation?</span>
                        <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                        <p>You can book through our website by selecting a plan and following the booking process.</p>
                    </div>
                </details>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <details class="group">
                    <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900">How long does a consultation last?</span>
                        <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                        <p>Each consultation is typically around 15 minutes, depending on your needs.</p>
                    </div>
                </details>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <details class="group">
                    <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900">How do I receive prescriptions?</span>
                        <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                        <p>Doctors provide digital prescriptions in your profile after the consultation.</p>
                    </div>
                </details>
            </div>
        </div>
    </div>
</section>

@endsection
