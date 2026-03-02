@extends('layouts.app')
@section('title', 'Consultation Booking Details')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h3 class="card-title font-weight-bold mb-0">
            <i class="fas fa-file-medical-alt mr-2 text-primary"></i> Consultation Booking Details
        </h3>
    </div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Doctor</dt>
            <dd class="col-sm-9">{{ $booking->doctor->name ?? '-' }}</dd>

            <dt class="col-sm-3">Specialty</dt>
            <dd class="col-sm-9">{{ optional($booking->doctor->specialty)->name ?: '-' }}</dd>

            <dt class="col-sm-3">Department</dt>
            <dd class="col-sm-9">{{ optional($booking->doctor->department)->name ?: '-' }}</dd>

            <dt class="col-sm-3">Patient</dt>
            <dd class="col-sm-9">{{ $booking->patient_name }}</dd>

            <dt class="col-sm-3">Phone</dt>
            <dd class="col-sm-9">{{ $booking->phone }}</dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $booking->email }}</dd>

            <dt class="col-sm-3">DOB</dt>
            <dd class="col-sm-9">{{ $booking->dob ?: '-' }}</dd>

            <dt class="col-sm-3">Visit Type</dt>
            <dd class="col-sm-9">{{ $booking->visit_type === 'in_hub' ? 'In-Hub Visit' : 'Video Consult' }}</dd>

            <dt class="col-sm-3">Hub</dt>
            <dd class="col-sm-9">{{ optional($booking->branch)->name ?: '-' }}</dd>

            <dt class="col-sm-3">Date</dt>
            <dd class="col-sm-9">{{ optional($booking->appointment_date)->format('Y-m-d') }}</dd>

            <dt class="col-sm-3">Time Slot</dt>
            <dd class="col-sm-9">{{ optional($booking->slot)->label ?: '-' }}</dd>

            <dt class="col-sm-3">Fee</dt>
            <dd class="col-sm-9">{{ formated_price($booking->consultation_fee) }}</dd>

            <dt class="col-sm-3">Commission %</dt>
            <dd class="col-sm-9">{{ $booking->commission_percentage }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">{{ ucfirst($booking->status) }}</dd>

            <dt class="col-sm-3">Notes</dt>
            <dd class="col-sm-9">{{ $booking->notes ?: '-' }}</dd>
        </dl>
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.doctor_consultation_bookings.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#doctor_consultation_bookings').addClass('active');
$('#manage_doctors_link').addClass('active');
$('#manage_doctors').addClass('menu-open');
</script>
@endpush
