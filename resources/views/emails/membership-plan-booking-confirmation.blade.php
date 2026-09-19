<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Membership Plan Booking Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #007caa; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background-color: #f9f9f9; }
        .footer { padding: 20px; text-align: center; font-size: 12px; color: #666; }
        .details { background: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; }
        .detail-row:last-child { border-bottom: none; }
        .label { font-weight: bold; color: #666; }
        .value { color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Booking Received!</h1>
        </div>

        <div class="content">
            <p>Dear <strong>{{ $booking->patient_name }}</strong>,</p>

            <p>Thank you for your membership plan booking request. Here are your booking details:</p>

            <div class="details">
                <div class="detail-row">
                    <span class="label">Booking ID:</span>
                    <span class="value">#MP-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Plan:</span>
                    <span class="value">{{ optional($booking->plan)->name }}</span>
                </div>
                @if($booking->preferred_start_date)
                <div class="detail-row">
                    <span class="label">Preferred Start Date:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($booking->preferred_start_date)->format('d M Y') }}</span>
                </div>
                @endif
                <div class="detail-row">
                    <span class="label">Total Amount:</span>
                    <span class="value">৳{{ number_format($booking->total_amount, 2) }}</span>
                </div>
            </div>

            <p>Our team will contact you shortly to confirm your membership.</p>

            <p>Thank you for choosing Imperial Health Bangladesh!</p>
        </div>

        @php($infoSettings = setting('info') ?? [])
        <div class="footer">
            <p>&copy; {{ date('Y') }} Imperial Health Bangladesh. All rights reserved.</p>
            <p>Hotline: {{ $infoSettings['phone'] ?? 'N/A' }} | Email: {{ $infoSettings['email'] ?? 'N/A' }}</p>
        </div>
    </div>
</body>
</html>
