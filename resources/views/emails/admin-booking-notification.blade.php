<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Booking Notification</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #1e293b; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background-color: #f9f9f9; }
        .footer { padding: 20px; text-align: center; font-size: 12px; color: #666; }
        .details { background: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; }
        .detail-row:last-child { border-bottom: none; }
        .label { font-weight: bold; color: #666; }
        .value { color: #333; text-align: right; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New {{ $typeLabel }}</h1>
        </div>

        <div class="content">
            <p>A new booking has just been submitted on the website. Details below:</p>

            <div class="details">
                @foreach($rows as $label => $value)
                <div class="detail-row">
                    <span class="label">{{ $label }}:</span>
                    <span class="value">{{ $value }}</span>
                </div>
                @endforeach
            </div>

            <p>Log in to the admin panel to view and manage this booking.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Imperial Health Bangladesh. Internal booking notification.</p>
        </div>
    </div>
</body>
</html>
