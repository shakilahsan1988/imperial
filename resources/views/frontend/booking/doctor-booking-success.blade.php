@extends('layouts.front')

@section('title', 'Doctor Booking Successful - Imperial Health Bangladesh')

@section('content')
<main class="min-h-screen bg-[#F8FAFC] font-sans pb-20">
    <nav class="bg-white border-b border-slate-100 py-4 mb-8">
        <div class="container mx-auto px-4">
            <ol class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                <li><a href="{{ route('fhome') }}" class="hover:text-indigo-600 transition">Home</a></li>
                <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
                <li><a href="{{ route('doctor') }}" class="hover:text-indigo-600 transition">Doctors</a></li>
                <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
                <li class="text-indigo-600">Booking Confirmed</li>
            </ol>
        </div>
    </nav>

    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">

            {{-- Success Header --}}
            <div class="bg-white rounded-[2.5rem] p-12 text-center shadow-xl shadow-indigo-100/50 border border-slate-100 mb-8 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-emerald-500"></div>

                <div class="w-24 h-24 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                    <i class="fa-solid fa-check text-4xl"></i>
                </div>

                @if($booking->payment_method === 'sslcommerz' && $booking->payment_status === 'paid')
                    <h1 class="text-3xl font-black text-slate-900 mb-2 uppercase tracking-tight">Payment Successful!</h1>
                    <p class="text-slate-500 font-medium text-lg">Your payment was successful and appointment has been scheduled.</p>
                @elseif($booking->payment_method === 'cash' && $booking->payment_status === 'paid')
                    <h1 class="text-3xl font-black text-slate-900 mb-2 uppercase tracking-tight">Booking Confirmed!</h1>
                    <p class="text-slate-500 font-medium text-lg">Your appointment has been confirmed. Please pay at the clinic.</p>
                @else
                    <h1 class="text-3xl font-black text-slate-900 mb-2 uppercase tracking-tight">Booking Confirmed!</h1>
                    <p class="text-slate-500 font-medium text-lg">Your appointment request has been received.</p>
                @endif

                <div class="mt-8 inline-block px-6 py-3 bg-slate-50 rounded-2xl border border-slate-100">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest block mb-1">Your Booking ID</span>
                    <span class="text-2xl font-black text-indigo-600">DCB-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>

            {{-- Payment Details (only for online payments) --}}
            @if($booking->payment_method === 'sslcommerz' && $booking->payment_status === 'paid')
            <div class="bg-[#1E293B] text-white p-8 rounded-[2rem] shadow-2xl overflow-hidden mb-8 relative">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <i class="fa-solid fa-credit-card text-8xl rotate-12"></i>
                </div>

                <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Payment Details</h2>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between pb-3 border-b border-slate-700/50">
                        <span class="text-slate-400">Payment Status</span>
                        <span class="font-black text-emerald-400">Paid</span>
                    </div>
                    <div class="flex justify-between pb-3 border-b border-slate-700/50">
                        <span class="text-slate-400">Amount Paid</span>
                        <span class="font-black text-indigo-400">{{ formated_price($booking->paid_amount) }}</span>
                    </div>
                    <div class="flex justify-between pb-3 border-b border-slate-700/50">
                        <span class="text-slate-400">Payment Method</span>
                        <span class="font-black">SSLCommerz (Online)</span>
                    </div>
                    @if($booking->transaction_id)
                    <div class="flex justify-between pb-3 border-b border-slate-700/50">
                        <span class="text-slate-400">Transaction ID</span>
                        <span class="font-black text-xs">{{ $booking->transaction_id }}</span>
                    </div>
                    @endif
                    @if($booking->bank_transaction_id)
                    <div class="flex justify-between">
                        <span class="text-slate-400">Bank Transaction ID</span>
                        <span class="font-black text-xs">{{ $booking->bank_transaction_id }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Appointment Details --}}
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
                            <p class="font-black text-slate-900">{{ $booking->phone }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Email</p>
                            <p class="font-black text-slate-900">{{ $booking->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Appointment</h2>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Doctor</p>
                            <p class="font-black text-slate-900">{{ $booking->doctor->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Department</p>
                            <p class="font-black text-slate-900">{{ optional($booking->doctor->department)->name ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Date & Time Slot</p>
                            <p class="font-black text-slate-900">
                                {{ optional($booking->appointment_date)->format('d M, Y') }}
                                @if($booking->slot) - {{ $booking->slot->label }} @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Visit Type</p>
                            <p class="font-black text-slate-900">{{ $booking->visit_type === 'in_hub' ? 'In-Hub Visit' : 'Video Consultation' }}</p>
                        </div>
                        @if($booking->branch)
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Branch</p>
                            <p class="font-black text-slate-900">{{ $booking->branch->name }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <a href="{{ route('fhome') }}" class="flex-grow py-4 bg-white text-slate-900 text-center rounded-2xl font-black uppercase tracking-widest text-xs shadow-lg border border-slate-100 hover:bg-slate-50 transition-all">
                    Back to Home
                </a>
                <a href="{{ route('doctor') }}" class="flex-grow py-4 bg-indigo-600 text-white text-center rounded-2xl font-black uppercase tracking-widest text-xs shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all">
                    <i class="fa-solid fa-calendar-plus mr-2"></i> Book Another Appointment
                </a>
            </div>

        </div>
    </div>
</main>
@endsection
