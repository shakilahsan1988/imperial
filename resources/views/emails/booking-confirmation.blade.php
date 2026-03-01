<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Confirmation</title>
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
            <h1>Booking Confirmed!</h1>
        </div>
        
        <div class="content">
            <p>Dear <strong>{{ $booking->patient_name }}</strong>,</p>
            
            <p>Your booking has been confirmed. Here are your booking details:</p>
            
            <div class="details">
                <div class="detail-row">
                    <span class="label">Booking ID:</span>
                    <span class="value">#BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Service:</span>
                    <span class="value">{{ $booking->service->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Type:</span>
                    <span class="value">{{ $booking->booking_type == 'home_visit' ? 'Home Visit' : 'Branch Visit' }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Date:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($booking->scheduled_date)->format('d M Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Time:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($booking->scheduled_time)->format('h:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Total Amount:</span>
                    <span class="value">৳{{ number_format($booking->total_amount, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Payment:</span>
                    <span class="value">{{ $booking->payment_type == 'pay_at_branch' ? 'Pay at Branch' : 'Online Payment' }}</span>
                </div>
            </div>
            
            @if($booking->booking_type == 'home_visit' && $booking->patient_address)
            <p><strong>Collection Address:</strong><br>
            {{ $booking->patient_address }}</p>
            @endif
            
            <p>Please arrive 15 minutes before your scheduled time. If you need to reschedule or cancel, please contact us at least 24 hours in advance.</p>
            
            <p>Thank you for choosing Imperial Health Bangladesh!</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Imperial Health Bangladesh. All rights reserved.</p>
            <p>Hotline: 10648 | Email: info@imperialhealth.com</p>
        </div>
    </div>
</body>
</html>
