@extends('layouts.front')

@section('title', 'Doctor Booking Failed - Imperial Health Bangladesh')

@section('content')
<main class="min-h-screen bg-[#F8FAFC] font-sans pb-20">
    <nav class="bg-white border-b border-slate-100 py-4 mb-8">
        <div class="container mx-auto px-4">
            <ol class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                <li><a href="{{ route('fhome') }}" class="hover:text-indigo-600 transition">Home</a></li>
                <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
                <li><a href="{{ route('doctor') }}" class="hover:text-indigo-600 transition">Doctors</a></li>
                <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
                <li class="text-red-500">Payment Failed</li>
            </ol>
        </div>
    </nav>

    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">

            {{-- Failure Header --}}
            <div class="bg-white rounded-[2.5rem] p-12 text-center shadow-xl shadow-red-100/50 border border-slate-100 mb-8 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-red-500"></div>

                <div class="w-24 h-24 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                    <i class="fa-solid fa-xmark text-4xl"></i>
                </div>

                <h1 class="text-3xl font-black text-slate-900 mb-2 uppercase tracking-tight">Payment Failed</h1>
                <p class="text-slate-500 font-medium text-lg">
                    @if(session('error'))
                        {{ session('error') }}
                    @else
                        Your payment could not be processed. Your booking has been saved but not confirmed as paid.
                    @endif
                </p>

                <div class="mt-8 inline-block px-6 py-3 bg-red-50 rounded-2xl border border-red-100">
                    <span class="text-xs font-black text-red-400 uppercase tracking-widest block mb-1">Booking Reference</span>
                    <span class="text-2xl font-black text-red-500">DCB-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>

            {{-- Booking Info --}}
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 mb-8">
                <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Booking Summary</h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">Doctor</p>
                        <p class="font-black text-slate-900">{{ $booking->doctor->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">Date</p>
                        <p class="font-black text-slate-900">{{ optional($booking->appointment_date)->format('d M, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">Fee</p>
                        <p class="font-black text-slate-900">{{ formated_price($booking->consultation_fee) }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">Payment Status</p>
                        <p class="font-black text-red-500">Unpaid</p>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-lg shadow-slate-200/40 mb-8">
                <p class="text-sm text-slate-500 mb-4 text-center">You can try paying again or choose Cash Payment at the clinic.</p>
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <a href="{{ route('doctor-booking.confirm', $booking->id) }}" class="flex-grow py-4 bg-indigo-600 text-white text-center rounded-2xl font-black uppercase tracking-widest text-xs shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all">
                    <i class="fa-solid fa-rotate-right mr-2"></i> Try Again
                </a>
                <a href="{{ route('fhome') }}" class="flex-grow py-4 bg-white text-slate-900 text-center rounded-2xl font-black uppercase tracking-widest text-xs shadow-lg border border-slate-100 hover:bg-slate-50 transition-all">
                    Back to Home
                </a>
            </div>

        </div>
    </div>
</main>
@endsection
