@extends('layouts.front')

@section('title', 'Your Cart - Imperial Health Bangladesh')

@section('content')
<main class="bg-slate-50 font-sans min-h-screen py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-extrabold text-slate-900 mb-8 flex items-center gap-3">
            <i class="fa-solid fa-cart-shopping text-indigo-600"></i>
            Your Selection
        </h1>

        @if(count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cart as $id => $details)
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex justify-between items-center group hover:border-indigo-200 transition-all" id="cart-item-{{ $id }}">
                            <div class="flex gap-6 items-center">
                                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center font-bold">
                                    {{ strtoupper(substr($details['category'], 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $details['name'] }}</h3>
                                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $details['category'] }}</p>
                                    
                                    @if(isset($details['components']) && count($details['components']) > 0)
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            @foreach($details['components'] as $comp)
                                                <span class="text-[10px] bg-slate-50 text-slate-500 px-2 py-1 rounded-md border border-slate-100 italic">
                                                    {{ $comp }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-8">
                                <span class="text-lg font-black text-slate-900">{{ formated_price($details['price']) }}</span>
                                <button onclick="removeFromCart({{ $id }})" class="text-slate-300 hover:text-rose-500 transition-colors p-2">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <div class="pt-6">
                        <a href="{{ route('lab-test') }}" class="inline-flex items-center gap-2 text-indigo-600 font-bold hover:gap-3 transition-all">
                            <i class="fa-solid fa-arrow-left"></i> Add more tests
                        </a>
                    </div>
                </div>

                <!-- Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-8 rounded-3xl shadow-xl shadow-indigo-100/50 border border-slate-100 sticky top-24">
                        <h2 class="text-xl font-black text-slate-900 mb-6 uppercase tracking-tight">Order Summary</h2>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-slate-500 font-medium">
                                <span>Subtotal ({{ count($cart) }} Items)</span>
                                <span class="text-slate-900">{{ formated_price($total) }}</span>
                            </div>
                            <div class="flex justify-between text-slate-500 font-medium pb-4 border-bottom border-slate-50">
                                <span>Processing Fee</span>
                                <span class="text-emerald-600 font-bold">FREE</span>
                            </div>
                            <div class="flex justify-between items-center pt-4 border-t-2 border-slate-50">
                                <span class="text-lg font-bold text-slate-900">Total Amount</span>
                                <span class="text-2xl font-black text-indigo-600">{{ formated_price($total) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('cart.checkout') }}" class="block w-full py-4 bg-indigo-600 text-white text-center rounded-2xl font-black uppercase tracking-widest text-sm shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 transition-all active:scale-95">
                            Proceed to Booking
                        </a>
                        
                        <div class="mt-6 flex items-center justify-center gap-4 text-slate-400">
                            <i class="fa-solid fa-shield-halved text-xl"></i>
                            <span class="text-[10px] font-bold uppercase tracking-widest leading-tight">Secure 256-bit<br>SSL Encryption</span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-3xl p-16 text-center border border-slate-100 shadow-sm">
                <div class="w-24 h-24 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-cart-shopping text-4xl"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-900 mb-2">Your cart is empty</h2>
                <p class="text-slate-500 mb-8 max-w-sm mx-auto">Looks like you haven't added any diagnostic tests to your selection yet.</p>
                <a href="{{ route('lab-test') }}" class="inline-block px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all">
                    Browse All Tests
                </a>
            </div>
        @endif
    </div>
</main>
@endsection

@push('scripts')
<script>
    function removeFromCart(serviceId) {
        if(!confirm('Remove this test from your selection?')) return;

        $.ajax({
            url: "{{ route('cart.remove') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                service_id: serviceId
            },
            success: function(response) {
                location.reload(); // Simple reload for now to update summary
            },
            error: function() {
                alert('Error removing item');
            }
        });
    }
</script>
@endpush
