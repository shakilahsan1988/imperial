@extends('layouts.front')

@section('title', 'Booking Confirmed - Imperial Health Bangladesh')

@section('content')
    <main class="bg-white font-sans">
        <section class="py-20">
            <div class="container mx-auto px-4">
                <div class="max-w-2xl mx-auto text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-check text-4xl text-green-600"></i>
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">Booking Confirmed!</h1>
                    
                    <p class="text-lg text-slate-600 mb-8">
                        Your booking has been successfully submitted. Here are your booking details:
                    </p>

                    <div class="bg-slate-50 rounded-2xl p-8 text-left mb-8">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-slate-500">Booking ID</p>
                                <p class="font-bold text-slate-900">#BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">Service</p>
                                <p class="font-bold text-slate-900">{{ $booking->service->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">Type</p>
                                <p class="font-bold text-slate-900">
                                    @if($booking->booking_type == 'home_visit')
                                        <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs">Home Visit</span>
                                    @else
                                        <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded text-xs">Branch Visit</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">Schedule</p>
                                <p class="font-bold text-slate-900">
                                    {{ Carbon\Carbon::parse($booking->scheduled_date)->format('d M Y') }} 
                                    at {{ Carbon\Carbon::parse($booking->scheduled_time)->format('h:i A') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">Total Amount</p>
                                <p class="font-bold text-slate-900">৳{{ number_format($booking->total_amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">Payment</p>
                                <p class="font-bold text-slate-900">
                                    @if($booking->payment_type == 'pay_at_branch')
                                        Pay at Branch
                                    @else
                                        Online Payment
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($booking->patient_address)
                        <div class="mt-4 pt-4 border-t border-slate-200">
                            <p class="text-sm text-slate-500">Collection Address</p>
                            <p class="font-bold text-slate-900">{{ $booking->patient_address }}</p>
                        </div>
                        @endif
                    </div>

                    <p class="text-slate-600 mb-8">
                        A confirmation email has been sent to <strong>{{ $booking->patient_email ?? $booking->patient_phone }}</strong>.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('fhome') }}" class="px-8 py-3 bg-slate-900 text-white rounded-xl font-bold">
                            Back to Home
                        </a>
                        @auth('patient')
                            <a href="{{ route('my-bookings') }}" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold">
                                View My Bookings
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
