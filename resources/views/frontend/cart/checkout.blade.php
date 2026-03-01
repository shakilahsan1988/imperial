@extends('layouts.front')

@section('title', 'Finalize Booking - Imperial Health Bangladesh')

@section('content')
<main class="bg-slate-50 font-sans min-h-screen py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-extrabold text-slate-900 mb-8 flex items-center gap-3">
                <i class="fa-solid fa-calendar-check text-indigo-600"></i>
                Complete Your Booking
            </h1>

            <form action="{{ route('bookings.store') }}" method="POST" id="checkoutForm">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Form Area -->
                    <div class="lg:col-span-2 space-y-8">
                        
                        {{-- Step 1: Patient Information --}}
                        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                            <h2 class="text-lg font-black text-slate-900 mb-6 uppercase tracking-tight flex items-center gap-3">
                                <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xs">1</span>
                                Patient Details
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Full Name *</label>
                                    <input type="text" name="patient_name" class="w-full bg-slate-50 border-0 rounded-2xl py-4 px-6 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-slate-700" value="{{ auth()->guard('patient')->check() ? auth()->guard('patient')->user()->name : '' }}" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Phone Number *</label>
                                    <input type="text" name="patient_phone" class="w-full bg-slate-50 border-0 rounded-2xl py-4 px-6 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-slate-700" value="{{ auth()->guard('patient')->check() ? auth()->guard('patient')->user()->phone : '' }}" required>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Email Address</label>
                                    <input type="email" name="patient_email" class="w-full bg-slate-50 border-0 rounded-2xl py-4 px-6 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-slate-700" value="{{ auth()->guard('patient')->check() ? auth()->guard('patient')->user()->email : '' }}">
                                </div>
                            </div>
                        </div>

                        {{-- Step 2: Visit Type --}}
                        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                            <h2 class="text-lg font-black text-slate-900 mb-6 uppercase tracking-tight flex items-center gap-3">
                                <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xs">2</span>
                                Collection Method
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative flex flex-col p-6 border-2 border-slate-100 rounded-3xl cursor-pointer hover:border-indigo-600 transition-all group">
                                    <input type="radio" name="booking_type" value="branch_visit" class="absolute top-6 right-6" checked onchange="toggleVisitFields()">
                                    <i class="fa-solid fa-clinic-medical text-2xl text-slate-300 group-hover:text-indigo-600 mb-4 transition-colors"></i>
                                    <span class="font-black text-slate-900 uppercase tracking-tight">Branch Visit</span>
                                    <span class="text-xs text-slate-400 font-bold mt-1">Visit our collection center</span>
                                </label>
                                <label class="relative flex flex-col p-6 border-2 border-slate-100 rounded-3xl cursor-pointer hover:border-indigo-600 transition-all group">
                                    <input type="radio" name="booking_type" value="home_visit" class="absolute top-6 right-6" onchange="toggleVisitFields()">
                                    <i class="fa-solid fa-house-chimney-medical text-2xl text-slate-300 group-hover:text-indigo-600 mb-4 transition-colors"></i>
                                    <span class="font-black text-slate-900 uppercase tracking-tight">Home Collection</span>
                                    <span class="text-xs text-slate-400 font-bold mt-1">We collect from your home</span>
                                </label>
                            </div>

                            <div id="branchSelection" class="mt-8">
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3">Select Branch *</label>
                                <select name="branch_id" class="w-full bg-slate-50 border-0 rounded-2xl py-4 px-6 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-slate-700">
                                    <option value="">Choose a branch...</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }} - {{ $branch->address }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="addressField" class="mt-8 hidden">
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3">Collection Address *</label>
                                <textarea name="patient_address" class="w-full bg-slate-50 border-0 rounded-2xl py-4 px-6 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-slate-700" rows="3" placeholder="Apartment, Street, Area..."></textarea>
                            </div>
                        </div>

                        {{-- Step 3: Schedule --}}
                        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                            <h2 class="text-lg font-black text-slate-900 mb-6 uppercase tracking-tight flex items-center gap-3">
                                <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xs">3</span>
                                Appointment Schedule
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Preferred Date *</label>
                                    <input type="date" name="scheduled_date" id="scheduledDate" class="w-full bg-slate-50 border-0 rounded-2xl py-4 px-6 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-slate-700" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Preferred Time *</label>
                                    <input type="time" name="scheduled_time" id="scheduledTime" class="w-full bg-slate-50 border-0 rounded-2xl py-4 px-6 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-slate-700" required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Sidebar Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-[#1E293B] text-white p-8 rounded-[2rem] shadow-2xl sticky top-24">
                            <h2 class="text-xl font-black mb-8 uppercase tracking-tight">Booking Summary</h2>
                            
                            <div class="space-y-6 mb-10 max-h-60 overflow-y-auto no-scrollbar">
                                @foreach($cart as $id => $item)
                                <div class="flex justify-between items-start gap-4">
                                    <div>
                                        <p class="text-sm font-black leading-tight">{{ $item['name'] }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">{{ $item['category'] }}</p>
                                    </div>
                                    <span class="text-sm font-black">{{ formated_price($item['price']) }}</span>
                                </div>
                                @endforeach
                            </div>

                            <div class="space-y-4 border-t border-slate-700 pt-8">
                                <div class="flex justify-between text-slate-400 font-bold text-xs uppercase tracking-widest">
                                    <span>Subtotal</span>
                                    <span class="text-white">{{ formated_price($total) }}</span>
                                </div>
                                <div class="flex justify-between text-slate-400 font-bold text-xs uppercase tracking-widest">
                                    <span>Extra Charges</span>
                                    <span class="text-emerald-400" id="extraChargesText">৳ 0.00</span>
                                </div>
                                <div class="flex justify-between items-center pt-4">
                                    <span class="text-lg font-black uppercase tracking-tight">Grand Total</span>
                                    <span class="text-2xl font-black text-indigo-400" id="grandTotalText">{{ formated_price($total) }}</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full mt-10 py-5 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-widest text-sm shadow-xl shadow-indigo-900/20 hover:bg-indigo-500 transition-all active:scale-95">
                                Confirm & Book Now
                            </button>

                            <p class="mt-6 text-[10px] text-slate-500 text-center font-bold uppercase tracking-widest leading-relaxed">
                                By clicking book, you agree to our terms of service and privacy policy.
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    function toggleVisitFields() {
        const bookingType = document.querySelector('input[name="booking_type"]:checked').value;
        const branchDiv = document.getElementById('branchSelection');
        const addressDiv = document.getElementById('addressField');
        const branchSelect = branchDiv.querySelector('select');
        const addressInput = addressDiv.querySelector('textarea');
        
        if (bookingType === 'home_visit') {
            branchDiv.classList.add('hidden');
            branchSelect.removeAttribute('required');
            addressDiv.classList.remove('hidden');
            addressInput.setAttribute('required', 'required');
            
            // Note: For real app, we'd calculate exact home visit fee from services here
            $('#extraChargesText').text('As applicable');
        } else {
            branchDiv.classList.remove('hidden');
            branchSelect.setAttribute('required', 'required');
            addressDiv.classList.add('hidden');
            addressInput.removeAttribute('required');
            $('#extraChargesText').text('৳ 0.00');
        }
    }

    // Time validation logic same as admin
    function updateMinTime() {
        var selectedDate = $('#scheduledDate').val();
        var today = new Date().toISOString().split('T')[0];
        var $timeInput = $('#scheduledTime');

        if (selectedDate === today) {
            var now = new Date();
            var hours = String(now.getHours()).padStart(2, '0');
            var minutes = String(now.getMinutes()).padStart(2, '0');
            $timeInput.attr('min', hours + ':' + minutes);
        } else {
            $timeInput.removeAttr('min');
        }
    }

    $(document).ready(function() {
        $('#scheduledDate').on('change', updateMinTime);
        updateMinTime();
        toggleVisitFields();
    });
</script>
@endpush
