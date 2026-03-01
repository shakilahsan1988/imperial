@extends('layouts.app')
@section('title', 'Edit Booking')

@section('header')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">Edit Booking #BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</h3>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit mr-2"></i>Edit Booking Information
                    </h3>
                </div>
                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        {{-- Section 1: Patient Info --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                                <i class="fas fa-user-injured mr-1"></i> Patient Information
                            </h6>
                            
                            <input type="hidden" name="patient_id" value="{{ $booking->patient_id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Patient Name *</label>
                                        <input type="text" name="patient_name" id="patientName" class="form-control" value="{{ $booking->patient_name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone *</label>
                                        <input type="text" name="patient_phone" id="patientPhone" class="form-control" value="{{ $booking->patient_phone }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="patient_email" id="patientEmail" class="form-control" value="{{ $booking->patient_email }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Service Selection --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                                <i class="fas fa-microscope mr-1"></i> Service Selection
                            </h6>

                            @php
                                $selectedServiceIds = $booking->services->pluck('id')->toArray();
                            @endphp

                            <div class="form-group">
                                <label>Select Service(s) *</label>
                                <select name="service_id[]" id="serviceSelect" class="form-control select2" multiple="multiple" required>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" 
                                            {{ in_array($service->id, $selectedServiceIds) ? 'selected' : '' }}
                                            data-price="{{ $service->price }}" 
                                            data-home-price="{{ $service->home_visit_price }}" 
                                            data-home-available="{{ $service->home_visit_available }}">
                                            {{ $service->name }} ({{ ucfirst($service->category) }}) - {{ get_currency() }} {{ number_format($service->price, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="p-3 bg-light rounded d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 font-weight-bold">Total Price:</h5>
                                        <h4 class="mb-0 text-primary font-weight-bold" id="totalPrice">{{ get_currency() }} {{ number_format($booking->total_amount, 2) }}</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Booking Type *</label>
                                <div class="d-flex align-items-center">
                                    <div class="custom-control custom-radio mr-4">
                                        <input type="radio" class="custom-control-input" id="branchVisit" name="booking_type" value="branch_visit" {{ $booking->booking_type == 'branch_visit' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="branchVisit">Branch Visit</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="homeVisit" name="booking_type" value="home_visit" {{ $booking->booking_type == 'home_visit' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="homeVisit">Home Visit</label>
                                    </div>
                                </div>
                                <small id="homeVisitWarning" class="text-danger d-none mt-1">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Some selected services do not support Home Visit.
                                </small>
                            </div>

                            <div id="branchSelection" class="form-group" style="{{ $booking->booking_type == 'branch_visit' ? '' : 'display: none;' }}">
                                <label>Select Branch *</label>
                                <select name="branch_id" id="branchSelect" class="form-control select2" {{ $booking->booking_type == 'branch_visit' ? 'required' : '' }}>
                                    <option value="">Select Branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ $booking->branch_id == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }} ({{ $branch->address }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="homeVisitFields" style="{{ $booking->booking_type == 'home_visit' ? '' : 'display: none;' }}" class="bg-light p-3 border rounded">
                                <div class="form-group">
                                    <label>Address *</label>
                                    <textarea name="patient_address" id="patientAddress" class="form-control" rows="2" placeholder="Street address for collection..." {{ $booking->booking_type == 'home_visit' ? 'required' : '' }}>{{ $booking->patient_address }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-md-0">
                                            <label>City</label>
                                            <input type="text" name="city" class="form-control" value="{{ $booking->city }}" placeholder="City">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-0">
                                            <label>Postal Code</label>
                                            <input type="text" name="postal_code" class="form-control" value="{{ $booking->postal_code }}" placeholder="Postal Code">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 3: Schedule --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                                <i class="fas fa-clock mr-1"></i> Schedule
                            </h6>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Scheduled Date *</label>
                                        <input type="date" name="scheduled_date" class="form-control" value="{{ $booking->scheduled_date->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Scheduled Time *</label>
                                        <input type="time" name="scheduled_time" class="form-control" value="{{ \Carbon\Carbon::parse($booking->scheduled_time)->format('H:i') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 4: Payment & Additional --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                                <i class="fas fa-money-bill-wave mr-1"></i> Payment & Additional Info
                            </h6>

                            <div class="form-group">
                                <label>Payment Method *</label>
                                <div class="d-flex align-items-center">
                                    <div class="custom-control custom-radio mr-4">
                                        <input type="radio" class="custom-control-input" id="payAtBranch" name="payment_type" value="pay_at_branch" {{ $booking->payment_type == 'pay_at_branch' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="payAtBranch">Pay at Branch / On Collection</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="payOnline" name="payment_type" value="online" {{ $booking->payment_type == 'online' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="payOnline">Online Payment</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Paid Amount</label>
                                        <div class="input-group">
                                            <input type="number" name="paid_amount" id="paidAmount" class="form-control" value="{{ $booking->paid_amount }}" step="0.01" min="0">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Discount (Flat)</label>
                                        <div class="input-group">
                                            <input type="number" name="discount" id="discount" class="form-control" value="{{ $booking->discount }}" step="0.01" min="0">
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{ get_currency() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Due Amount</label>
                                        <div class="input-group">
                                            <input type="number" name="due_amount" id="dueAmount" class="form-control" value="{{ $booking->due_amount }}" step="0.01" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Internal Notes</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Any additional requirements or information...">{{ $booking->notes }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-white">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Update Booking
                        </button>
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            if ($.fn.select2) {
                $('.select2').select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: 'Click to select...'
                });
            }

            var currentTotal = 0;

            function calculateTotalPrice() {
                var total = 0;
                var allHomeVisitSupported = true;
                var hasSelections = false;

                $('#serviceSelect option:selected').each(function() {
                    hasSelections = true;
                    var price = parseFloat($(this).data('price')) || 0;
                    var homeAvailable = $(this).data('home-available');
                    
                    total += price;
                    
                    if (homeAvailable != "1") {
                        allHomeVisitSupported = false;
                    }
                });

                currentTotal = total;
                $('#totalPrice').text('{{ get_currency() }} ' + total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                
                calculateDueAmount();

                if (hasSelections && !allHomeVisitSupported) {
                    $('#homeVisit').prop('disabled', true);
                    if ($('#homeVisit').is(':checked')) {
                        $('#branchVisit').prop('checked', true).trigger('change');
                    }
                } else {
                    $('#homeVisit').prop('disabled', false);
                }
            }

            function calculateDueAmount() {
                var paid = parseFloat($('#paidAmount').val()) || 0;
                var discount = parseFloat($('#discount').val()) || 0;
                var due = currentTotal - paid - discount;
                
                if (due < 0) due = 0;
                $('#dueAmount').val(due.toFixed(2));
            }

            $('#paidAmount, #discount').on('input', function() {
                calculateDueAmount();
            });

            $('#payOnline').change(function() {
                if ($(this).is(':checked')) {
                    var total = currentTotal - (parseFloat($('#discount').val()) || 0);
                    $('#paidAmount').val(total.toFixed(2));
                    calculateDueAmount();
                }
            });

            $('#serviceSelect').change(function() {
                calculateTotalPrice();
            });

            // Initial calculation on page load
            calculateTotalPrice();

            $('input[name="booking_type"]').change(function() {
                if ($(this).val() === 'home_visit') {
                    $('#homeVisitFields').slideDown();
                    $('#patientAddress').prop('required', true);
                    $('#branchSelection').slideUp();
                    $('#branchSelect').prop('required', false);
                } else {
                    $('#homeVisitFields').slideUp();
                    $('#patientAddress').prop('required', false);
                    $('#branchSelection').slideDown();
                    $('#branchSelect').prop('required', true);
                }
            });
        });
    </script>
@endpush
