<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($module ?? 'membership') === 'video_consultant' ? 'Video Consultant' : 'Membership' }} Invoice #{{ $booking->id }}</title>
    <link rel="stylesheet" href="{{ url('plugins/bootstrap/css/bootstrap.min.css') }}">
    <style>
        body { font-size: 14px; color: #1f2937; }
        .invoice-wrap { max-width: 900px; margin: 20px auto; border: 1px solid #e5e7eb; border-radius: 10px; padding: 24px; }
        .label { color: #6b7280; font-weight: 600; margin-bottom: 4px; }
        .value { font-weight: 500; }
        .table th, .table td { vertical-align: middle; }
        @media print { .no-print { display: none !important; } body { margin: 0; } .invoice-wrap { border: 0; margin: 0; max-width: 100%; } }
    </style>
</head>
<body>
    @php
        $isVideoModule = ($module ?? 'membership') === 'video_consultant';
        $prefix = $isVideoModule ? 'VC' : 'MS';
    @endphp
    <div class="invoice-wrap">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="mb-1">{{ $isVideoModule ? 'Video Consultant' : 'Membership' }} Invoice</h4>
                <div class="text-muted">Invoice #{{ $prefix }}-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="text-muted">Date: {{ now()->format('Y-m-d H:i') }}</div>
            </div>
            <button onclick="window.print()" class="btn btn-primary no-print">Print Invoice</button>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="label">Patient Name</div>
                <div class="value">{{ $booking->patient_name }}</div>
                <div class="label mt-2">Email</div>
                <div class="value">{{ $booking->email ?: '-' }}</div>
                <div class="label mt-2">Phone</div>
                <div class="value">{{ $booking->phone ?: '-' }}</div>
            </div>
            <div class="col-md-6">
                <div class="label">Plan</div>
                <div class="value">{{ optional($booking->plan)->name ?: '-' }}</div>
                <div class="label mt-2">Category</div>
                <div class="value">{{ optional(optional($booking->plan)->category)->name ?: '-' }}</div>
                <div class="label mt-2">Preferred Start Date</div>
                <div class="value">{{ optional($booking->preferred_start_date)->format('Y-m-d') ?: '-' }}</div>
            </div>
        </div>

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th style="width: 35%">Total Amount</th>
                    <td>{{ formated_price($booking->total_amount) }}</td>
                </tr>
                <tr>
                    <th>Paid Amount</th>
                    <td>{{ formated_price($booking->paid_amount) }}</td>
                </tr>
                <tr>
                    <th>Due Amount</th>
                    <td>{{ formated_price($booking->due_amount) }}</td>
                </tr>
                <tr>
                    <th>Payment Status</th>
                    <td>{{ ucfirst($booking->payment_status) }}</td>
                </tr>
                <tr>
                    <th>Booking Status</th>
                    <td>{{ ucfirst($booking->status) }}</td>
                </tr>
            </tbody>
        </table>

        <h6 class="mt-4 mb-2">Payment History</h6>
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
                @forelse($booking->payments as $payment)
                <tr>
                    <td>{{ optional($payment->paid_at)->format('Y-m-d H:i') ?: optional($payment->created_at)->format('Y-m-d H:i') }}</td>
                    <td>{{ formated_price($payment->amount) }}</td>
                    <td>{{ $payment->payment_type ?: '-' }}</td>
                    <td>{{ $payment->notes ?: '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No payments recorded yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
