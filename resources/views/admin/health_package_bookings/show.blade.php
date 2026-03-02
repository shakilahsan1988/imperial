@extends('layouts.app')
@section('title', 'Booking Details')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h3 class="card-title font-weight-bold mb-0">
            <i class="fas fa-file-medical-alt mr-2 text-primary"></i> Booking Details
        </h3>
    </div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Package</dt>
            <dd class="col-sm-9">{{ $booking->package->name ?? '-' }}</dd>

            <dt class="col-sm-3">Category</dt>
            <dd class="col-sm-9">{{ $booking->package->category->name ?? '-' }}</dd>

            <dt class="col-sm-3">Patient Name</dt>
            <dd class="col-sm-9">{{ $booking->patient_name }}</dd>

            <dt class="col-sm-3">Phone</dt>
            <dd class="col-sm-9">{{ $booking->phone }}</dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $booking->email ?: '-' }}</dd>

            <dt class="col-sm-3">Preferred Date</dt>
            <dd class="col-sm-9">{{ optional($booking->preferred_date)->format('Y-m-d') ?: '-' }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">{{ ucfirst($booking->status) }}</dd>

            <dt class="col-sm-3">Notes</dt>
            <dd class="col-sm-9">{{ $booking->notes ?: '-' }}</dd>
        </dl>
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.health_package_bookings.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#health_package_bookings').addClass('active');
    $('#helth_check_link').addClass('active');
    $('#helth_check').addClass('menu-open');
</script>
@endpush
