@extends('layouts.front')

@section('title', 'Booking Confirmation - Imperial Health Bangladesh')

@section('content')
<main class="min-h-screen bg-[#F8FAFC] font-sans pb-20">
    <nav class="bg-white border-b border-slate-100 py-4 mb-8">
        <div class="container mx-auto px-4">
            <ol class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                <li><a href="{{ route('fhome') }}" class="hover:text-indigo-600 transition">Home</a></li>
                <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
                <li><a href="{{ route('doctor') }}" class="hover:text-indigo-600 transition">Doctors</a></li>
                <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
                <li class="text-indigo-600">Booking Confirmation</li>
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

                <h1 class="text-3xl font-black text-slate-900 mb-2 uppercase tracking-tight">Booking Confirmed!</h1>
                <p class="text-slate-500 font-medium text-lg">Your appointment request has been received.</p>

                <div class="mt-8 inline-block px-6 py-3 bg-slate-50 rounded-2xl border border-slate-100">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest block mb-1">Your Booking ID</span>
                    <span class="text-2xl font-black text-indigo-600">DCB-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>

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

            {{-- Fee Summary --}}
            @if($booking->consultation_fee > 0)
            <div class="bg-[#1E293B] text-white p-8 rounded-[2rem] shadow-2xl overflow-hidden mb-8 relative">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <i class="fa-solid fa-file-invoice-dollar text-8xl rotate-12"></i>
                </div>

                <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Consultation Fee</h2>
                <div class="flex justify-between items-center">
                    <span class="text-lg font-bold">{{ $booking->visit_type === 'video' ? 'Video Consultation Fee' : 'In-Hub Consultation Fee' }}</span>
                    <span class="text-3xl font-black text-indigo-400">{{ formated_price($booking->consultation_fee) }}</span>
                </div>
            </div>

            {{-- Make Payment --}}
            <div class="bg-white rounded-[2rem] p-8 shadow-lg shadow-slate-200/40 border border-slate-100 mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-bold">
                        <i class="fa-solid fa-wallet text-sm"></i>
                    </div>
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Make Payment</h2>
                </div>

                @if(session('error'))
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Cash Payment --}}
                    <form action="{{ route('doctor-booking.confirm-cash', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left p-6 border-2 border-slate-100 rounded-2xl hover:border-indigo-600 hover:bg-indigo-50 transition-all group cursor-pointer">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-indigo-50 group-hover:bg-indigo-100 rounded-xl flex items-center justify-center transition">
                                    <i class="fa-solid fa-money-bill-wave text-indigo-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-900">Cash Payment</p>
                                    <p class="text-[11px] text-slate-500 font-medium">Pay at the clinic when you visit</p>
                                </div>
                            </div>
                        </button>
                    </form>

                    {{-- Online Payment (SSLCommerz) --}}
                    @if($sslEnabled && $booking->consultation_fee > 0)
                    <form action="{{ route('doctor-booking.pay-online', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left p-6 border-2 border-slate-100 rounded-2xl hover:border-indigo-600 hover:bg-indigo-50 transition-all group cursor-pointer">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-indigo-50 group-hover:bg-indigo-100 rounded-xl flex items-center justify-center transition">
                                    <i class="fa-solid fa-credit-card text-indigo-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-900">Online Payment</p>
                                    <p class="text-[11px] text-slate-500 font-medium">Pay now via SSLCommerz gateway</p>
                                </div>
                            </div>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @else
            {{-- Free consultation --}}
            <div class="bg-emerald-50 border border-emerald-200 rounded-[2rem] p-8 text-center mb-8">
                <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-gift text-emerald-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 mb-2">Free Consultation</h3>
                <p class="text-slate-500 font-medium">No payment required. Please arrive at the clinic on your scheduled date.</p>
            </div>
            @endif

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
