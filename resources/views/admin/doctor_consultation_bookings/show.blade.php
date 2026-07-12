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

        {{-- Payment Information Section --}}
        @if($booking->payment_method || $booking->payment_status)
        <hr>
        <h5 class="mb-3"><i class="fas fa-credit-card mr-1 text-primary"></i> Payment Information</h5>
        <dl class="row mb-0">
            <dt class="col-sm-3">Payment Method</dt>
            <dd class="col-sm-9">
                @if($booking->payment_method === 'sslcommerz')
                    <span class="badge badge-primary">Online (SSLCommerz)</span>
                @else
                    <span class="badge badge-secondary">{{ ucfirst($booking->payment_method ?: 'Cash') }}</span>
                @endif
            </dd>

            <dt class="col-sm-3">Payment Status</dt>
            <dd class="col-sm-9">
                @php
                    $paymentStatusColors = [
                        'unpaid' => 'badge-warning',
                        'paid' => 'badge-success',
                        'failed' => 'badge-danger',
                        'cancelled' => 'badge-dark',
                    ];
                @endphp
                <span class="badge {{ $paymentStatusColors[$booking->payment_status] ?? 'badge-secondary' }}">
                    {{ ucfirst($booking->payment_status) }}
                </span>
            </dd>

            @if($booking->paid_amount > 0)
            <dt class="col-sm-3">Paid Amount</dt>
            <dd class="col-sm-9">{{ formated_price($booking->paid_amount) }}</dd>
            @endif

            <dt class="col-sm-3">Currency</dt>
            <dd class="col-sm-9">{{ $booking->currency ?: 'BDT' }}</dd>

            @if($booking->transaction_id)
            <dt class="col-sm-3">Transaction ID</dt>
            <dd class="col-sm-9"><code>{{ $booking->transaction_id }}</code></dd>
            @endif

            @if($booking->bank_transaction_id)
            <dt class="col-sm-3">Bank Transaction ID</dt>
            <dd class="col-sm-9"><code>{{ $booking->bank_transaction_id }}</code></dd>
            @endif

            @if($booking->validation_id)
            <dt class="col-sm-3">Validation ID</dt>
            <dd class="col-sm-9"><code>{{ $booking->validation_id }}</code></dd>
            @endif

            @if($booking->payment_date)
            <dt class="col-sm-3">Payment Date</dt>
            <dd class="col-sm-9">{{ $booking->payment_date->format('d M Y, h:i A') }}</dd>
            @endif
        </dl>
        @endif

        {{-- SSLCommerz Transaction Logs --}}
        @if($booking->sslcommerzTransactions->count())
        <hr>
        <h5 class="mb-3"><i class="fas fa-history mr-1 text-info"></i> Transaction Log</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Bank Trx ID</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Card Type</th>
                        <th>Bank Gateway</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($booking->sslcommerzTransactions as $trx)
                    <tr>
                        <td><code class="small">{{ $trx->transaction_id }}</code></td>
                        <td>{{ $trx->bank_transaction_id ?: '-' }}</td>
                        <td>{{ formated_price($trx->amount) }}</td>
                        <td>
                            @php
                                $trxColors = [
                                    'init' => 'badge-info',
                                    'success' => 'badge-success',
                                    'failed' => 'badge-danger',
                                    'cancelled' => 'badge-dark',
                                    'validated' => 'badge-primary',
                                ];
                            @endphp
                            <span class="badge {{ $trxColors[$trx->status] ?? 'badge-secondary' }}">{{ ucfirst($trx->status) }}</span>
                        </td>
                        <td>{{ $trx->card_type ?: '-' }}</td>
                        <td>{{ $trx->bank_gateway ?: '-' }}</td>
                        <td>{{ $trx->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
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
