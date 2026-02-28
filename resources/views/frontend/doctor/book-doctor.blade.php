
@extends('layouts.front')

@section('title', 'Book Appointment - Dr. Ahmed Farukh')

@section('content')

    <main class="min-h-screen bg-[#F8FAFC] font-sans pb-20">

        <!-- BREADCRUMBS -->
        <nav class="bg-white border-b border-slate-100 py-4 mb-8">
            <div class="container mx-auto px-4">
                <ol class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                    <li><a href="{{ route('fhome') }}" class="hover:text-indigo-600 transition">Home</a></li>
                    <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
                    <li><a href="{{ route('doctor') }}" class="hover:text-indigo-600 transition">Doctors</a></li>
                    <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
                    <li class="text-indigo-600">Book Appointment</li>
                </ol>
            </div>
        </nav>

        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <!-- LEFT COLUMN: Profile & Schedule -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- DOCTOR PROFILE CARD -->
                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-50">
                        <div class="flex flex-col md:flex-row">
                            <!-- Image -->
                            <div class="w-full md:w-64 bg-slate-100 aspect-square md:aspect-auto overflow-hidden">
                                <img src="{{ asset('assets/front/images/doctor/5.jpg') }}" class="w-full h-full object-cover">
                            </div>
                            <!-- Details -->
                            <div class="p-8 flex-1">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <span class="bg-indigo-50 text-indigo-600 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest mb-2 inline-block">Specialist</span>
                                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-1">Dr. Ahmed Farukh</h1>
                                        <p class="text-indigo-600 font-bold text-sm">Consultant - Energetic medicine & acupuncture</p>
                                    </div>
                                    <div class="text-right hidden md:block">
                                        <p class="text-xs text-slate-400 uppercase font-bold tracking-widest mb-1">Consultation Fee</p>
                                        <p class="text-3xl font-black text-slate-900 tracking-tighter">৳ 1,200</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-6 py-6 border-y border-slate-50 mb-6">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Qualification</p>
                                        <p class="text-sm font-bold text-slate-700">MBBS (RMC), PhD (Germany)</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Experience</p>
                                        <p class="text-sm font-bold text-slate-700">21+ Years Practice</p>
                                    </div>
                                </div>

                                <div class="text-slate-500 text-sm leading-relaxed italic">
                                    "Dr. Ahmed is a bio-energetic medicine specialist with international training in Germany & Switzerland, providing holistic patient care for over two decades."
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- APPOINTMENT STEPPER -->
                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 border border-slate-50">
                        <div class="flex items-center gap-3 mb-10">
                            <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-bold shadow-lg shadow-indigo-200">1</div>
                            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Select Preferred Schedule</h2>
                        </div>

                        <!-- Consultation Type -->
                        <div class="flex flex-wrap gap-4 mb-10">
                            <label class="cursor-pointer relative flex-1 min-w-[150px]">
                                <input type="radio" name="appt_type" class="peer sr-only" checked>
                                <div class="p-4 border-2 border-slate-100 rounded-2xl peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center">
                                        <i class="fa-solid fa-hospital text-indigo-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">In-Hub Visit</p>
                                        <p class="text-[10px] text-slate-500">Visit our facility</p>
                                    </div>
                                </div>
                            </label>
                            <label class="cursor-pointer relative flex-1 min-w-[150px]">
                                <input type="radio" name="appt_type" class="peer sr-only">
                                <div class="p-4 border-2 border-slate-100 rounded-2xl peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center">
                                        <i class="fa-solid fa-video text-indigo-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Video Consult</p>
                                        <p class="text-[10px] text-slate-500">Safe from home</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Date Scroller -->
                        <div class="mb-10">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Select Appointment Date</p>
                            <div class="flex gap-3 overflow-x-auto pb-4 no-scrollbar">
                                @foreach(['Thu 22', 'Fri 23', 'Sat 24', 'Sun 25', 'Mon 26', 'Tue 27', 'Wed 28'] as $day)
                                    <label class="cursor-pointer flex-shrink-0">
                                        <input type="radio" name="appt_date" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                                        <div class="w-20 h-24 border-2 border-slate-50 rounded-2xl flex flex-col items-center justify-center transition-all peer-checked:border-indigo-600 peer-checked:bg-indigo-600 peer-checked:text-white shadow-sm">
                                            <span class="text-xs font-bold opacity-60">{{ explode(' ', $day)[0] }}</span>
                                            <span class="text-2xl font-black">{{ explode(' ', $day)[1] }}</span>
                                            <span class="text-[8px] font-bold uppercase mt-1">Jan</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Time Slots Segmented -->
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Select Time Slot</p>
                            
                            <div class="space-y-6">
                                <!-- Morning -->
                                <div>
                                    <div class="flex items-center gap-2 mb-3 text-amber-500">
                                        <i class="fa-solid fa-cloud-sun text-xs"></i>
                                        <span class="text-xs font-bold uppercase tracking-widest">Morning Slots</span>
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                        @foreach(['09:00 AM', '10:30 AM', '11:15 AM'] as $time)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="appt_time" class="peer sr-only">
                                                <div class="py-2 text-center border border-slate-200 rounded-xl text-xs font-bold text-slate-600 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition-all hover:border-indigo-300">{{ $time }}</div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Afternoon -->
                                <div>
                                    <div class="flex items-center gap-2 mb-3 text-indigo-500">
                                        <i class="fa-solid fa-sun text-xs"></i>
                                        <span class="text-xs font-bold uppercase tracking-widest">Afternoon Slots</span>
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                        @foreach(['02:00 PM', '03:30 PM', '04:45 PM', '05:30 PM'] as $time)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="appt_time" class="peer sr-only">
                                                <div class="py-2 text-center border border-slate-200 rounded-xl text-xs font-bold text-slate-600 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition-all hover:border-indigo-300">{{ $time }}</div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Policy Note -->
                        <div class="mt-12 p-5 bg-slate-50 rounded-2xl border border-slate-100 flex gap-4">
                            <i class="fa-solid fa-circle-info text-indigo-500 text-xl mt-1"></i>
                            <div class="text-xs text-slate-500 leading-relaxed font-medium">
                                <strong class="text-slate-900">Note:</strong> Submitting a request does not guarantee an appointment. Our patient coordination team will call you within 30 minutes to confirm your final slot and specialist availability.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Booking Sticky Summary -->
                <div class="lg:col-span-4">
                    <div class="sticky top-24">
                        <div class="bg-indigo-900 rounded-[32px] p-8 text-white shadow-2xl shadow-indigo-200 overflow-hidden relative">
                            <!-- Background Decor -->
                            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                            
                            <h3 class="text-lg font-bold mb-8 border-b border-white/10 pb-4 tracking-tight">Booking Summary</h3>
                            
                            <div class="space-y-6 mb-10">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-indigo-300 uppercase tracking-widest">Specialist</span>
                                    <span class="text-sm font-bold">Dr. Ahmed Farukh</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-indigo-300 uppercase tracking-widest">Visit Type</span>
                                    <span class="text-sm font-bold">In-Hub Visit</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-indigo-300 uppercase tracking-widest">Date & Time</span>
                                    <span class="text-sm font-bold">22 Jan, 02:00 PM</span>
                                </div>
                            </div>

                            <div class="bg-white/10 rounded-2xl p-5 mb-8">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-indigo-300 uppercase tracking-widest">Total Payable</span>
                                    <span class="text-2xl font-black tracking-tighter">৳ 1,200</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-white hover:bg-slate-100 text-indigo-900 py-4 rounded-2xl font-black uppercase tracking-widest text-sm shadow-xl transition-all transform active:scale-95 flex items-center justify-center gap-3">
                                <span>Complete Booking</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>

                            <p class="text-center text-[10px] text-white/40 mt-6 font-medium">
                                Secure Payment Powered by Imperial Health
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>

@endsection
