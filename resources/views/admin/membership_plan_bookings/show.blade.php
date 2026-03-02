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

            <dt class="col-sm-3">Total Amount</dt>
            <dd class="col-sm-9">{{ formated_price($booking->total_amount) }}</dd>

            <dt class="col-sm-3">Paid Amount</dt>
            <dd class="col-sm-9">{{ formated_price($booking->paid_amount) }}</dd>

            <dt class="col-sm-3">Due Amount</dt>
            <dd class="col-sm-9">{{ formated_price($booking->due_amount) }}</dd>

            <dt class="col-sm-3">Payment Status</dt>
            <dd class="col-sm-9">{{ ucfirst($booking->payment_status) }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">{{ ucfirst($booking->status) }}</dd>

            <dt class="col-sm-3">Notes</dt>
            <dd class="col-sm-9">{{ $booking->notes ?: '-' }}</dd>
        </dl>

        <hr>
        <h5 class="mb-3">Update Booking Status</h5>
        <form action="{{ route('admin.membership_plan_bookings.update', $booking->id) }}" method="POST" class="form-inline mb-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="module" value="{{ $isVideoModule ? 'video_consultant' : 'membership' }}">
            <select name="status" class="form-control form-control-sm mr-2">
                @foreach(['pending','confirmed','completed','cancelled'] as $status)
                    <option value="{{ $status }}" {{ $booking->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button class="btn btn-sm btn-primary">Update Status</button>
        </form>

        <h5 class="mb-3">Add Payment</h5>
        <form action="{{ route('admin.membership_plan_bookings.payments.store', $booking->id) }}" method="POST" class="row">
            @csrf
            <input type="hidden" name="module" value="{{ $isVideoModule ? 'video_consultant' : 'membership' }}">
            <div class="col-md-3">
                <label>Amount</label>
                <input type="number" step="0.01" min="0.01" name="amount" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Payment Type</label>
                <input type="text" name="payment_type" class="form-control" placeholder="cash/card/mobile_banking">
            </div>
            <div class="col-md-3">
                <label>Paid At</label>
                <input type="datetime-local" name="paid_at" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Notes</label>
                <input type="text" name="notes" class="form-control">
            </div>
            <div class="col-12 mt-3">
                <button class="btn btn-success">Add Payment</button>
                <a href="{{ route('admin.membership_plan_bookings.invoice', ['membership_plan_booking' => $booking->id, 'module' => $isVideoModule ? 'video_consultant' : 'membership']) }}" target="_blank" class="btn btn-secondary">Print Invoice</a>
            </div>
        </form>

        <hr>
        <h5 class="mb-3">Payment History</h5>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($booking->payments as $p)
                    <tr>
                        <td>{{ optional($p->paid_at)->format('Y-m-d H:i') ?: optional($p->created_at)->format('Y-m-d H:i') }}</td>
                        <td>{{ formated_price($p->amount) }}</td>
                        <td>{{ $p->payment_type ?: '-' }}</td>
                        <td>{{ $p->notes ?: '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted">No payment records yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
