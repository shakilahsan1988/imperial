@extends('layouts.app')
@php
    $isVideoModule = ($module ?? 'membership') === 'video_consultant';
@endphp
@section('title', $isVideoModule ? 'Consultant Booking Details' : 'Membership Booking Details')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h3 class="card-title font-weight-bold mb-0">
            <i class="fas fa-file-medical-alt mr-2 text-primary"></i> {{ $isVideoModule ? 'Consultant Booking Details' : 'Membership Booking Details' }}
        </h3>
    </div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Plan</dt>
            <dd class="col-sm-9">{{ $booking->plan->name ?? '-' }}</dd>

            <dt class="col-sm-3">Category</dt>
            <dd class="col-sm-9">{{ optional($booking->plan->category)->name ?: '-' }}</dd>

            <dt class="col-sm-3">Patient</dt>
            <dd class="col-sm-9">{{ $booking->patient_name }}</dd>

            <dt class="col-sm-3">Phone</dt>
            <dd class="col-sm-9">{{ $booking->phone }}</dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $booking->email }}</dd>

            <dt class="col-sm-3">DOB</dt>
            <dd class="col-sm-9">{{ optional($booking->dob)->format('Y-m-d') ?: '-' }}</dd>

            <dt class="col-sm-3">Preferred Start Date</dt>
            <dd class="col-sm-9">{{ optional($booking->preferred_start_date)->format('Y-m-d') ?: '-' }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">{{ ucfirst($booking->status) }}</dd>

            <dt class="col-sm-3">Notes</dt>
            <dd class="col-sm-9">{{ $booking->notes ?: '-' }}</dd>
        </dl>
    </div>
    <div class="card-footer">
        <a href="{{ $isVideoModule ? route('admin.video_consultant_bookings.index') : route('admin.membership_plan_bookings.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
@if($isVideoModule)
$('#video_consultant_bookings').addClass('active');
$('#membership_module_link').addClass('active');
$('#membership_module').addClass('menu-open');
@else
$('#membership_plan_bookings').addClass('active');
$('#membership_module_link').addClass('active');
$('#membership_module').addClass('menu-open');
@endif
</script>
@endpush
