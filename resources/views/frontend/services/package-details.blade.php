@extends('layouts.front')

@section('title', ($package->page_name ?: 'Package Details') . ' - Imperial Health Bangladesh')

@section('content')

    <main class="bg-white font-sans overflow-hidden">
        <section class="relative py-20 md:py-32 bg-[#1E293B] overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <img src="{{ asset($package->image ?: 'assets/front/images/healthcheck/1.jpg') }}" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>

            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-3xl">
                    <span class="inline-block px-4 py-1.5 bg-indigo-500/20 text-indigo-300 text-[10px] font-black uppercase tracking-widest rounded-full mb-6">{{ $package->badge_text ?: 'Comprehensive Screening' }}</span>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">
                        {{ $package->page_name }}
                    </h1>
                    <p class="text-xl text-slate-300 font-light leading-relaxed max-w-2xl">
                        {{ $package->subtitle ?: 'Deep dive into our specialized health package designed to give you a complete picture of your wellness.' }}
                    </p>
                </div>
            </div>
        </section>

        <section class="py-24">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                    <div class="lg:col-span-5 relative">
                        <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-100 rounded-full blur-3xl opacity-50"></div>
                        <img src="{{ asset($package->image ?: 'assets/front/images/healthcheck/1.jpg') }}" class="rounded-[40px] shadow-2xl relative z-10 w-full object-cover aspect-[4/5]">
                        @if($package->recommended)
                        <div class="absolute top-8 right-8 z-20">
                            <span class="bg-white/90 backdrop-blur-md text-indigo-600 text-[10px] font-black px-4 py-2 rounded-2xl shadow-xl uppercase tracking-widest border border-white">Recommended</span>
                        </div>
                        @endif
                    </div>

                    <div class="lg:col-span-7 space-y-8">
                        <div>
                            <div class="flex items-center gap-3 mb-6">
                                <span class="bg-indigo-50 text-indigo-600 text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-tighter">{{ $package->category->name ?? 'Health Package' }}</span>
                                @if($package->immediate_availability)
                                <span class="bg-emerald-50 text-emerald-600 text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-tighter">Immediate Availability</span>
                                @endif
                            </div>
                            <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">{{ $package->name }}</h2>

                            <div class="flex items-baseline gap-4 mb-8">
                                <span class="text-5xl font-black text-slate-900 tracking-tighter">{{ formated_price($package->price) }}</span>
                                @if($package->old_price)
                                <span class="text-xl text-slate-400 line-through">{{ formated_price($package->old_price) }}</span>
                                @endif
                                @if($package->discount_text)
                                <span class="bg-rose-50 text-rose-600 text-[10px] font-black px-3 py-1.5 rounded-lg uppercase">{{ $package->discount_text }}</span>
                                @endif
                            </div>

                            <p class="text-lg text-slate-600 leading-relaxed font-medium mb-10">{{ $package->description }}</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-12">
                            <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 flex flex-col items-center text-center group hover:bg-white hover:shadow-xl transition-all">
                                <i class="fa-solid fa-clock-rotate-left text-indigo-500 text-xl mb-3"></i>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Duration</p>
                                <p class="text-sm font-bold text-slate-900">{{ $package->duration ?: '-' }}</p>
                            </div>
                            <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 flex flex-col items-center text-center group hover:bg-white hover:shadow-xl transition-all">
                                <i class="fa-solid fa-file-shield text-indigo-500 text-xl mb-3"></i>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Turnaround</p>
                                <p class="text-sm font-bold text-slate-900">{{ $package->turnaround ?: '-' }}</p>
                            </div>
                            <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 flex flex-col items-center text-center group hover:bg-white hover:shadow-xl transition-all">
                                <i class="fa-solid fa-mug-hot text-indigo-500 text-xl mb-3"></i>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Fasting</p>
                                <p class="text-sm font-bold text-slate-900">{{ $package->fasting ?: '-' }}</p>
                            </div>
                        </div>

                        <form action="{{ route('package-booking.submit', ['slug' => $package->slug]) }}" method="POST" class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                            @csrf
                            <h4 class="font-bold text-slate-800 mb-4">Book This Package</h4>
                            @php($patient = auth()->guard('patient')->user())
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Patient Name</label>
                                    <input type="text" name="patient_name" class="form-control" placeholder="Your Name" value="{{ old('patient_name', $patient->name ?? '') }}" required>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="{{ old('phone', $patient->phone ?? '') }}" required>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Email Address</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email Address" value="{{ old('email', $patient->email ?? '') }}" {{ $patient ? 'readonly' : '' }} required>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Date Of Birth</label>
                                    <input type="date" name="dob" class="form-control" value="{{ old('dob', (!empty($patient->dob) && strtotime($patient->dob)) ? date('Y-m-d', strtotime($patient->dob)) : '') }}" required>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Preferred Date (Optional)</label>
                                    <input type="date" name="preferred_date" class="form-control" value="{{ old('preferred_date') }}">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Notes (Optional)</label>
                                    <textarea name="notes" class="form-control" rows="2" placeholder="Notes"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-black uppercase tracking-widest text-xs transition-all">Submit Booking Request</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 bg-slate-50">
            <div class="container mx-auto px-4">
                <div class="flex items-center gap-4 mb-16">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight whitespace-nowrap">What's Included</h2>
                    <div class="h-px bg-slate-200 flex-grow"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse(collect(preg_split('/\r\n|\r|\n/', (string) $package->inclusions))->filter()->values() as $item)
                    <div class="bg-white p-6 rounded-[24px] border border-slate-100 flex items-center gap-5 shadow-sm group hover:border-indigo-200 transition-all">
                        <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-check text-sm"></i></div>
                        <div>
                            <p class="font-bold text-slate-900 leading-none mb-1 group-hover:text-indigo-600 transition-colors">{{ $item }}</p>
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Included Test</p>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-slate-400">No inclusions added.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="py-24">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20">
                    <div>
                        <h3 class="text-3xl font-extrabold text-slate-900 mb-10 tracking-tight">How to Prepare</h3>
                        <div class="space-y-6">
                            @forelse(collect(preg_split('/\r\n|\r|\n/', (string) $package->preparation_steps))->filter()->values() as $idx => $step)
                            <div class="flex gap-6">
                                <span class="w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center font-black flex-shrink-0">{{ $idx + 1 }}</span>
                                <p class="text-slate-600 font-medium leading-relaxed pt-2">{{ $step }}</p>
                            </div>
                            @empty
                            <p class="text-slate-500">No preparation steps added.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-3xl font-extrabold text-slate-900 mb-10 tracking-tight">Common Questions</h3>
                        @if($package->faq_1_question)
                        <div class="group bg-slate-50 rounded-3xl border border-slate-100 overflow-hidden">
                            <details class="peer">
                                <summary class="flex justify-between items-center p-6 cursor-pointer list-none font-bold text-slate-700">
                                    {{ $package->faq_1_question }}
                                    <i class="fa-solid fa-plus text-indigo-500 transition-transform peer-open:rotate-45"></i>
                                </summary>
                                <div class="px-6 pb-6 text-slate-500 text-sm leading-relaxed">{{ $package->faq_1_answer }}</div>
                            </details>
                        </div>
                        @endif
                        @if($package->faq_2_question)
                        <div class="group bg-slate-50 rounded-3xl border border-slate-100 overflow-hidden">
                            <details class="peer">
                                <summary class="flex justify-between items-center p-6 cursor-pointer list-none font-bold text-slate-700">
                                    {{ $package->faq_2_question }}
                                    <i class="fa-solid fa-plus text-indigo-500 transition-transform peer-open:rotate-45"></i>
                                </summary>
                                <div class="px-6 pb-6 text-slate-500 text-sm leading-relaxed">{{ $package->faq_2_answer }}</div>
                            </details>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
