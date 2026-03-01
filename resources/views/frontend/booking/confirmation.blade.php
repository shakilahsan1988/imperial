@extends('layouts.front')

@section('title', 'Booking Confirmation - Imperial Health Bangladesh')

@section('content')
<main class="bg-slate-50 font-sans min-h-screen py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            
            {{-- Success Animation & Header --}}
            <div class="bg-white rounded-[2.5rem] p-12 text-center shadow-xl shadow-indigo-100/50 border border-slate-100 mb-8 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-emerald-500"></div>
                
                <div class="w-24 h-24 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                    <i class="fa-solid fa-check text-4xl"></i>
                </div>
                
                <h1 class="text-3xl font-black text-slate-900 mb-2 uppercase tracking-tight">Booking Confirmed!</h1>
                <p class="text-slate-500 font-medium text-lg">Thank you, your appointment has been successfully scheduled.</p>
                
                <div class="mt-8 inline-block px-6 py-3 bg-slate-50 rounded-2xl border border-slate-100">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest block mb-1">Your Booking ID</span>
                    <span class="text-2xl font-black text-indigo-600">BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>

            {{-- Summary Details --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Patient Info</h2>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Name</p>
                            <p class="font-black text-slate-900">{{ $booking->patient_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Phone</p>
                            <p class="font-black text-slate-900">{{ $booking->patient_phone }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Appointment</h2>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Date & Time</p>
                            <p class="font-black text-slate-900">
                                {{ \Carbon\Carbon::parse($booking->scheduled_date)->format('d M, Y') }} at {{ \Carbon\Carbon::parse($booking->scheduled_time)->format('h:i A') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Location</p>
                            <p class="font-black text-slate-900">
                                @if($booking->booking_type == 'home_visit')
                                    <i class="fa-solid fa-house-user text-indigo-600 mr-1"></i> Home Collection
                                @else
                                    <i class="fa-solid fa-building-medical text-indigo-600 mr-1"></i> {{ $booking->branch->name ?? 'Branch Visit' }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="bg-[#1E293B] text-white p-8 rounded-[2rem] shadow-2xl overflow-hidden mb-12 relative">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <i class="fa-solid fa-file-invoice text-8xl rotate-12"></i>
                </div>
                
                <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Selected Tests</h2>
                <div class="space-y-4 mb-8">
                    @foreach($booking->services as $service)
                    <div class="flex justify-between items-center pb-4 border-b border-slate-700/50 last:border-0">
                        <span class="font-bold text-sm">{{ $service->name }}</span>
                        <span class="font-black">{{ formated_price($service->pivot->price) }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="pt-4 border-t border-slate-700">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-black uppercase tracking-tight text-slate-400">Total Amount</span>
                        <span class="text-3xl font-black text-indigo-400">{{ formated_price($booking->total_amount) }}</span>
                    </div>
                    <p class="text-[10px] text-slate-500 font-bold uppercase mt-2">Status: {{ ucfirst($booking->payment_status) }} ({{ str_replace('_', ' ', $booking->payment_type) }})</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <a href="{{ route('fhome') }}" class="flex-grow py-4 bg-white text-slate-900 text-center rounded-2xl font-black uppercase tracking-widest text-xs shadow-lg border border-slate-100 hover:bg-slate-50 transition-all">
                    Back to Home
                </a>
                <a href="{{ route('bookings.receipt', $booking->id) }}" target="_blank" class="flex-grow py-4 bg-indigo-600 text-white text-center rounded-2xl font-black uppercase tracking-widest text-xs shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all">
                    <i class="fa-solid fa-print mr-2"></i> Print Receipt
                </a>
            </div>

        </div>
    </div>
</main>
@endsection
