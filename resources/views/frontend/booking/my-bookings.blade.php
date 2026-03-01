@extends('layouts.front')

@section('title', 'My Bookings - Imperial Health Bangladesh')

@section('content')
    <main class="bg-white font-sans">
        <section class="py-20">
            <div class="container mx-auto px-4">
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-8">My Bookings</h1>

                @if($bookings->isEmpty())
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fa-solid fa-calendar-xmark text-4xl text-slate-400"></i>
                        </div>
                        <h2 class="text-xl font-bold text-slate-900 mb-2">No Bookings Yet</h2>
                        <p class="text-slate-600 mb-6">You haven't made any bookings yet.</p>
                        <a href="{{ route('services') }}" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold inline-block">
                            Browse Services
                        </a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($bookings as $booking)
                            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="text-sm text-slate-500">#BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                                            @if($booking->booking_type == 'home_visit')
                                                <span class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded text-xs">Home Visit</span>
                                            @else
                                                <span class="bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded text-xs">Branch Visit</span>
                                            @endif
                                            
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                                    'confirmed' => 'bg-blue-100 text-blue-700',
                                                    'sample_collected' => 'bg-purple-100 text-purple-700',
                                                    'in_progress' => 'bg-indigo-100 text-indigo-700',
                                                    'completed' => 'bg-green-100 text-green-700',
                                                    'cancelled' => 'bg-red-100 text-red-700',
                                                ];
                                            @endphp
                                            <span class="{{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-700' }} px-2 py-0.5 rounded text-xs">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900">{{ $booking->service->name }}</h3>
                                        <p class="text-sm text-slate-500">
                                            {{ Carbon\Carbon::parse($booking->scheduled_date)->format('d M Y') }} 
                                            at {{ Carbon\Carbon::parse($booking->scheduled_time)->format('h:i A') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xl font-bold text-slate-900">৳{{ number_format($booking->total_amount, 2) }}</p>
                                        <p class="text-sm text-slate-500">
                                            @if($booking->payment_status == 'paid')
                                                <span class="text-green-600">Paid</span>
                                            @else
                                                <span class="text-yellow-600">Pending Payment</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
