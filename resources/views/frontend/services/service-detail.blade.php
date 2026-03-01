@extends('layouts.front')

@section('title', $service->name . ' - Imperial Health Bangladesh')

@section('content')
    <main class="bg-white font-sans">
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Service Details -->
                    <div class="lg:col-span-2">
                        <div class="mb-6">
                            <a href="{{ route('services') }}" class="text-indigo-600 font-bold flex items-center gap-2">
                                <i class="fa-solid fa-arrow-left"></i> Back to Services
                            </a>
                        </div>

                        <div class="inline-block px-4 py-1.5 bg-indigo-50 text-indigo-600 text-xs font-bold uppercase tracking-widest rounded-full mb-4">
                            {{ ucfirst($service->category) }}
                        </div>

                        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">{{ $service->name }}</h1>

                        @if($service->short_name)
                            <p class="text-lg text-slate-500 mb-6">{{ $service->short_name }}</p>
                        @endif

                        <div class="flex items-center gap-6 mb-8">
                            <div>
                                <p class="text-sm text-slate-500">Price</p>
                                <p class="text-3xl font-bold text-indigo-600">৳{{ number_format($service->price, 2) }}</p>
                            </div>
                            @if($service->home_visit_available)
                                <div>
                                    <p class="text-sm text-slate-500">Home Visit</p>
                                    <p class="text-lg font-bold text-slate-700">
                                        +৳{{ number_format($service->home_visit_price ?? 0, 2) }}
                                    </p>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm text-slate-500">Duration</p>
                                <p class="text-lg font-bold text-slate-700">{{ $service->duration_minutes }} mins</p>
                            </div>
                        </div>

                        @if($service->description)
                            <div class="mb-8">
                                <h2 class="text-xl font-bold text-slate-900 mb-4">Description</h2>
                                <p class="text-slate-600 leading-relaxed">{{ $service->description }}</p>
                            </div>
                        @endif

                        @if($service->specimen_type)
                            <div class="mb-8">
                                <h2 class="text-xl font-bold text-slate-900 mb-4">Specimen Type</h2>
                                <p class="text-slate-600">{{ $service->specimen_type }}</p>
                            </div>
                        @endif

                        @if($service->preparation)
                            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 mb-8">
                                <h2 class="text-xl font-bold text-amber-800 mb-2">
                                    <i class="fa-solid fa-triangle-exclamation mr-2"></i> Preparation Instructions
                                </h2>
                                <p class="text-amber-700">{{ $service->preparation }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Booking Form -->
                    <div class="lg:col-span-1">
                        <div class="bg-slate-50 rounded-2xl p-6 sticky top-24">
                            <h2 class="text-xl font-bold text-slate-900 mb-6">Book This Service</h2>

                            <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->id }}">

                                <!-- Visit Type -->
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Visit Type *</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-white transition-colors">
                                            <input type="radio" name="booking_type" value="branch_visit" class="mr-3" checked onchange="toggleAddressField()">
                                            <div>
                                                <p class="font-bold text-slate-900">Branch Visit</p>
                                                <p class="text-sm text-slate-500">Visit our clinic</p>
                                            </div>
                                        </label>
                                        @if($service->home_visit_available)
                                            <label class="flex items-center p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-white transition-colors">
                                                <input type="radio" name="booking_type" value="home_visit" class="mr-3" onchange="toggleAddressField()">
                                                <div>
                                                    <p class="font-bold text-slate-900">Home Visit</p>
                                                    <p class="text-sm text-slate-500">+৳{{ number_format($service->home_visit_price ?? 0, 2) }}</p>
                                                </div>
                                            </label>
                                        @endif
                                    </div>
                                </div>

                                <!-- Schedule -->
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Date *</label>
                                        <input type="date" name="scheduled_date" class="w-full p-3 border border-slate-200 rounded-xl" min="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Time *</label>
                                        <input type="time" name="scheduled_time" class="w-full p-3 border border-slate-200 rounded-xl" required>
                                    </div>
                                </div>

                                <!-- Patient Info -->
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Name *</label>
                                    <input type="text" name="patient_name" class="w-full p-3 border border-slate-200 rounded-xl" required>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Phone *</label>
                                    <input type="text" name="patient_phone" class="w-full p-3 border border-slate-200 rounded-xl" required>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                                    <input type="email" name="patient_email" class="w-full p-3 border border-slate-200 rounded-xl">
                                </div>

                                <!-- Address (Home Visit Only) -->
                                <div id="addressField" class="mb-4" style="display: none;">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Address *</label>
                                    <textarea name="patient_address" class="w-full p-3 border border-slate-200 rounded-xl" rows="2"></textarea>
                                </div>

                                <!-- Payment -->
                                <div class="mb-6">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Payment *</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-white transition-colors">
                                            <input type="radio" name="payment_type" value="pay_at_branch" class="mr-3" checked>
                                            <span class="font-bold text-slate-900">Pay at Branch</span>
                                        </label>
                                        <label class="flex items-center p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-white transition-colors">
                                            <input type="radio" name="payment_type" value="online" class="mr-3">
                                            <span class="font-bold text-slate-900">Pay Online (Coming Soon)</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Notes -->
                                <div class="mb-6">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Notes</label>
                                    <textarea name="notes" class="w-full p-3 border border-slate-200 rounded-xl" rows="2" placeholder="Any special instructions..."></textarea>
                                </div>

                                <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all">
                                    Confirm Booking
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        function toggleAddressField() {
            const bookingType = document.querySelector('input[name="booking_type"]:checked').value;
            const addressField = document.getElementById('addressField');
            const addressInput = addressField.querySelector('textarea');
            
            if (bookingType === 'home_visit') {
                addressField.style.display = 'block';
                addressInput.setAttribute('required', 'required');
            } else {
                addressField.style.display = 'none';
                addressInput.removeAttribute('required');
            }
        }
    </script>
@endsection
