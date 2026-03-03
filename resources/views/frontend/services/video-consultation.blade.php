@extends('layouts.front')

@section('title', ($pageSettings['page_name'] ?? 'Video Consultation') . ' - Imperial Health Bangladesh')

@section('content')

<section class="relative py-24 md:py-40 bg-[#1E293B] overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <img src="{{ asset($pageSettings['hero_image']) }}" alt="Video Consultation" class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>
    <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl">
                <p class="text-xs md:text-sm text-indigo-300 uppercase tracking-[0.2em] font-black mb-4">{{ $pageSettings['page_name'] }}</p>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">{!! $pageSettings['hero_title_html'] !!}</h1>
                <p class="text-xl text-slate-300 font-light leading-relaxed max-w-2xl">{{ $pageSettings['hero_description'] }}</p>
            </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $pageSettings['plans_section_title'] ?? 'Affordable Video Consultation Packages' }}</h2>
            <p class="text-lg text-gray-600 leading-relaxed">
                {{ $pageSettings['plans_section_description'] ?? 'Choose a flexible plan for regular online doctor consultations for you and your family.' }}
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
            <div class="col-span-full text-center py-8 text-gray-500">{{ $pageSettings['plans_empty_text'] ?? 'No video consultation packages available now.' }}</div>
            @endforelse
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <img src="{{ asset($pageSettings['why_image'] ?? 'assets/front/images/services/con4.jpg') }}" alt="Why choose plan" class="rounded-2xl shadow-lg w-full h-auto object-cover">
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">{{ $pageSettings['why_title'] ?? 'Why choose Amar Jotno Plan?' }}</h2>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3 text-gray-700">
                        <i class="fa-solid fa-check-circle text-imperial-primary mt-1"></i>
                        <span>{{ $pageSettings['why_item_1'] ?? 'Access to experienced, internationally trained doctors' }}</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700">
                        <i class="fa-solid fa-check-circle text-imperial-primary mt-1"></i>
                        <span>{{ $pageSettings['why_item_2'] ?? 'Secure access through our own consultation platform' }}</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700">
                        <i class="fa-solid fa-check-circle text-imperial-primary mt-1"></i>
                        <span>{{ $pageSettings['why_item_3'] ?? 'Confidentiality for patient and doctor communications' }}</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700">
                        <i class="fa-solid fa-check-circle text-imperial-primary mt-1"></i>
                        <span>{{ $pageSettings['why_item_4'] ?? 'Minimum 15 minutes quality consultation per session' }}</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700">
                        <i class="fa-solid fa-check-circle text-imperial-primary mt-1"></i>
                        <span>{{ $pageSettings['why_item_5'] ?? 'Electronic Health Records to track your health journey' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $pageSettings['faq_title'] ?? 'Frequently Asked Questions' }}</h2>
            <p class="text-gray-600">{{ $pageSettings['faq_subtitle'] ?? 'Take a look at the most commonly asked questions. We are here to help.' }}</p>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <details class="group">
                    <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900">{{ $pageSettings['faq_1_question'] ?? 'How do I book a video consultation?' }}</span>
                        <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                        <p>{{ $pageSettings['faq_1_answer'] ?? 'You can book through our website by selecting a plan and following the booking process.' }}</p>
                    </div>
                </details>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <details class="group">
                    <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900">{{ $pageSettings['faq_2_question'] ?? 'How long does a consultation last?' }}</span>
                        <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                        <p>{{ $pageSettings['faq_2_answer'] ?? 'Each consultation is typically around 15 minutes, depending on your needs.' }}</p>
                    </div>
                </details>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <details class="group">
                    <summary class="flex justify-between items-center p-5 cursor-pointer list-none hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900">{{ $pageSettings['faq_3_question'] ?? 'How do I receive prescriptions?' }}</span>
                        <i class="fa-solid fa-chevron-down text-imperial-primary transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                        <p>{{ $pageSettings['faq_3_answer'] ?? 'Doctors provide digital prescriptions in your profile after the consultation.' }}</p>
                    </div>
                </details>
            </div>
        </div>
    </div>
</section>

@endsection
