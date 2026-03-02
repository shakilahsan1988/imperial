@extends('layouts.front')

@section('title', 'Membership Plan - Imperial Health Bangladesh')

@section('content')
<section class="relative h-[50vh] min-h-[350px]">
    <img src="{{ asset('assets/front/images/services/con5.jpg') }}" alt="Membership Plan" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 to-slate-900/40"></div>
    <div class="absolute inset-0 flex items-center">
        <div class="container mx-auto px-6">
            <div class="max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Membership Plans</h1>
                <p class="text-lg text-white/90">Comprehensive healthcare solutions for you and your family</p>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        @forelse($categories as $category)
            @if($category->plans->count())
            <div class="mb-16">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">{{ $category->name }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($category->plans as $plan)
                    @php
                        $image = !empty($plan->image) ? asset($plan->image) : asset('assets/front/images/services/con6.jpeg');
                    @endphp
                    <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">
                        <a href="{{ route('membership-details', ['id' => $plan->slug ?: $plan->id]) }}" class="block h-48 overflow-hidden">
                            <img src="{{ $image }}" alt="{{ $plan->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </a>
                        <div class="p-6 flex flex-col flex-grow">
                            @if(!empty($plan->badge_text))
                            <div class="mb-2">
                                <span class="inline-flex px-3 py-1 bg-imperial-primary/10 text-imperial-primary text-xs font-medium rounded-full">{{ $plan->badge_text }}</span>
                            </div>
                            @endif
                            <h3 class="text-lg font-bold mb-2 text-gray-900">{{ $plan->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ $plan->subtitle ?: $category->name }}</p>
                            <div class="mb-4">
                                <span class="text-3xl font-bold text-imperial-primary">{{ formated_price($plan->price) }}</span>
                                @if($plan->duration)
                                <span class="text-gray-500 text-sm">/{{ $plan->duration }}</span>
                                @endif
                            </div>
                            @if(!empty($plan->doctor_visits) || !empty($plan->service_discount))
                            <ul class="text-sm text-gray-600 mb-4 space-y-2">
                                @if(!empty($plan->doctor_visits))
                                <li class="flex items-center gap-2">
                                    <i class="fa-solid fa-check text-green-500 text-xs"></i>
                                    <span>{{ $plan->doctor_visits }} Doctor Visits</span>
                                </li>
                                @endif
                                @if(!empty($plan->service_discount))
                                <li class="flex items-center gap-2">
                                    <i class="fa-solid fa-check text-green-500 text-xs"></i>
                                    <span>{{ $plan->service_discount }} on Additional Services</span>
                                </li>
                                @endif
                            </ul>
                            @endif
                            <div class="mt-auto">
                                <a href="{{ route('membership-details', ['id' => $plan->slug ?: $plan->id]) }}" class="block w-full bg-imperial-primary hover:bg-imperial-dark text-white text-center py-3 rounded-lg font-semibold transition">View Details</a>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            @endif
        @empty
            <div class="text-center py-16 text-gray-500">No membership plans available now.</div>
        @endforelse
    </div>
</section>
@endsection
