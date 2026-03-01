@extends('layouts.app')
@section('title', 'Create Booking')

@section('header')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">Create New Booking</h3>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.bookings.store') }}" method="POST">
                        @csrf

                        <h5 class="mb-3">Patient Information</h5>
                        
                        <div class="form-group">
                            <label>Search Existing Patient (Optional)</label>
                            <select id="patientSearch" class="form-control select2">
                                <option value="">Search by name or phone...</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Patient Name *</label>
                                    <input type="text" name="patient_name" id="patientName" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone *</label>
                                    <input type="text" name="patient_phone" id="patientPhone" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="patient_email" id="patientEmail" class="form-control">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5 class="mb-3">Service Information</h5>

                        <div class="form-group">
                            <label>Select Service *</label>
                            <select name="service_id" id="serviceSelect" class="form-control select2" required>
                                <option value="">Select Service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" data-price="{{ $service->price }}" data-home-price="{{ $service->home_visit_price }}" data-home-available="{{ $service->home_visit_available }}">
                                        {{ $service->name }} ({{ ucfirst($service->category) }}) - {{ number_format($service->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Booking Type *</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="branchVisit" name="booking_type" value="branch_visit" checked>
                                        <label class="custom-control-label" for="branchVisit">Branch Visit</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="homeVisit" name="booking_type" value="home_visit">
                                        <label class="custom-control-label" for="homeVisit">Home Visit</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="homeVisitFields" style="display: none;">
                            <div class="form-group">
                                <label>Address *</label>
                                <textarea name="patient_address" id="patientAddress" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name="city" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Postal Code</label>
                                        <input type="text" name="postal_code" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5 class="mb-3">Schedule & Payment</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Scheduled Date *</label>
                                    <input type="date" name="scheduled_date" class="form-control" min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Scheduled Time *</label>
                                    <input type="time" name="scheduled_time" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Payment Type *</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="payOnline" name="payment_type" value="online">
                                        <label class="custom-control-label" for="payOnline">Pay Online</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="payAtBranch" name="payment_type" value="pay_at_branch" checked>
                                        <label class="custom-control-label" for="payAtBranch">Pay at Branch</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Notes</label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#serviceSelect').change(function() {
            var option = $(this).find(':selected');
            var homeAvailable = option.data('home-available');
            
            if (homeAvailable) {
                $('#homeVisit').prop('disabled', false);
            } else {
                $('#homeVisit').prop('disabled', true);
                $('#branchVisit').prop('checked', true);
            }
        });

        $('input[name="booking_type"]').change(function() {
            if ($(this).val() === 'home_visit') {
                $('#homeVisitFields').slideDown();
            } else {
                $('#homeVisitFields').slideUp();
            }
        });

        $('#patientSearch').change(function() {
            var patientId = $(this).val();
            if (patientId) {
                $.get('/admin/bookings/patients?q=' + patientId, function(patients) {
                    if (patients.length > 0) {
                        var patient = patients[0];
                        $('#patientName').val(patient.name);
                        $('#patientPhone').val(patient.phone);
                        $('#patientEmail').val(patient.email || '');
                        $('#patientAddress').val(patient.address || '');
                    }
                });
            }
        });
    </script>
@endpush
