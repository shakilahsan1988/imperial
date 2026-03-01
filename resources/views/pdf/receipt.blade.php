@extends('layouts.pdf')

@section('content')
<style>
    /* Professional Layout Reset */
    @page { margin: 20px; }
    
    .invoice-container { font-family: 'Helvetica', 'Arial', sans-serif; color: #334155; }
    
    /* Header Section */
    .header-table { width: 100%; border-bottom: 2px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 30px; }
    .logo-box { width: 50%; }
    .logo-box img { max-height: 70px; }
    .invoice-title-box { width: 50%; text-align: right; }
    .invoice-label { font-size: 28px; font-weight: 900; color: #1e293b; text-transform: uppercase; letter-spacing: 1px; margin: 0; }
    .invoice-number { font-size: 14px; font-weight: 700; color: #64748b; margin-top: 5px; }

    /* Patient & Booking Grid */
    .details-grid { width: 100%; margin-bottom: 40px; }
    .details-col { width: 50%; vertical-align: top; }
    .section-title { font-size: 10px; font-weight: 900; color: #4f46e5; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; border-bottom: 1px solid #eef2ff; padding-bottom: 5px; display: inline-block; }
    
    .info-row { margin-bottom: 8px; }
    .info-label { font-size: 10px; color: #94a3b8; text-transform: uppercase; font-weight: 700; }
    .info-value { font-size: 13px; color: #1e293b; font-weight: 800; }

    /* Items Table */
    .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
    .items-table th { background-color: #f8fafc; color: #475569; font-size: 11px; font-weight: 800; text-transform: uppercase; padding: 12px 15px; border-top: 1px solid #e2e8f0; border-bottom: 2px solid #e2e8f0; text-align: left; }
    .items-table td { padding: 15px; border-bottom: 1px solid #f1f5f9; color: #1e293b; font-size: 13px; }
    
    /* Totals Area */
    .totals-wrapper { width: 100%; }
    .totals-box { width: 35%; float: right; }
    .total-row { padding: 10px 0; display: block; border-bottom: 1px solid #f1f5f9; }
    .total-label { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; }
    .total-value { font-size: 14px; font-weight: 800; color: #1e293b; text-align: right; }
    
    .grand-total-row { background-color: #4f46e5; color: white; padding: 15px; border-radius: 12px; margin-top: 10px; }
    .grand-total-label { font-size: 14px; font-weight: 900; text-transform: uppercase; }
    .grand-total-value { font-size: 22px; font-weight: 900; text-align: right; }

    .status-badge { display: inline-block; padding: 4px 12px; border-radius: 6px; font-size: 10px; font-weight: 900; text-transform: uppercase; margin-top: 15px; }
    .status-paid { background-color: #ecfdf5; color: #059669; }
    .status-pending { background-color: #fffbeb; color: #d97706; }

    .footer { position: fixed; bottom: 0; width: 100%; text-align: center; border-top: 1px solid #f1f5f9; padding-top: 15px; font-size: 9px; color: #94a3b8; }
</style>

<div class="invoice-container">
    {{-- Top Header with Logo --}}
    <table class="header-table">
        <tr>
            <td class="logo-box">
                <div style="color: #4f46e5; font-size: 24px; font-weight: 900; text-transform: uppercase;">
                    {{ $info_settings['name'] ?? 'IMPERIAL HEALTH' }}
                </div>
                <div style="font-size: 10px; color: #64748b; font-weight: 700; margin-top: 5px; text-transform: uppercase; letter-spacing: 1px;">
                    Diagnostic & Consultation Center
                </div>
            </td>
            <td class="invoice-title-box">
                <h1 class="invoice-label">Receipt</h1>
                <p class="invoice-number">ID: #BK-{{ str_pad($group->id, 5, '0', STR_PAD_LEFT) }}</p>
            </td>
        </tr>
    </table>

    {{-- Info Grid --}}
    <table class="details-grid">
        <tr>
            <td class="details-col">
                <div class="section-title">Patient Information</div>
                <div class="info-row">
                    <span class="info-label">Name:</span><br>
                    <span class="info-value">{{ $group->patient_name ?? ($group->patient->name ?? 'N/A') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Contact:</span><br>
                    <span class="info-value">{{ $group->patient_phone ?? ($group->patient->phone ?? 'N/A') }}</span>
                </div>
                @if($group->patient_email)
                <div class="info-row">
                    <span class="info-label">Email:</span><br>
                    <span class="info-value" style="font-size: 11px;">{{ $group->patient_email }}</span>
                </div>
                @endif
            </td>
            <td class="details-col" style="text-align: right;">
                <div class="section-title">Appointment Details</div>
                <div class="info-row">
                    <span class="info-label">Schedule Date:</span><br>
                    <span class="info-value">{{ \Carbon\Carbon::parse($group->scheduled_date)->format('d M, Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Preferred Time:</span><br>
                    <span class="info-value">{{ \Carbon\Carbon::parse($group->scheduled_time)->format('h:i A') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Method:</span><br>
                    <span class="info-value">
                        {{ $group->booking_type == 'home_visit' ? '🏠 Home Collection' : '🏥 Branch Visit' }}
                    </span>
                </div>
            </td>
        </tr>
    </table>

    {{-- Order Items --}}
    <table class="items-table">
        <thead>
            <tr>
                <th width="75%">Diagnostic Investigation / Procedure</th>
                <th width="25%" style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($group->services as $service)
            <tr>
                <td>
                    <div style="font-weight: 800; font-size: 14px;">{{ $service->name }}</div>
                    <div style="font-size: 10px; color: #64748b; text-transform: uppercase; margin-top: 3px;">
                        {{ $service->category }}
                    </div>
                </td>
                <td style="text-align: right; font-weight: 900; font-size: 15px;">
                    {{ formated_price($service->pivot->price) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Summary Area --}}
    <div class="totals-wrapper">
        <div class="totals-box">
            <table width="100%">
                <tr>
                    <td class="total-label">Subtotal</td>
                    <td class="total-value">{{ formated_price($group->total_amount) }}</td>
                </tr>
                <tr>
                    <td class="total-label" style="padding-top: 10px;">Flat Discount</td>
                    <td class="total-value" style="padding-top: 10px; color: #ef4444;">- {{ formated_price($group->discount ?? 0) }}</td>
                </tr>
            </table>
            
            <div class="grand-total-row">
                <table width="100%">
                    <tr>
                        <td class="grand-total-label">Total Payable</td>
                        <td class="grand-total-value">{{ formated_price($group->total_amount - ($group->discount ?? 0)) }}</td>
                    </tr>
                </table>
            </div>

            <div style="text-align: right;">
                <span class="status-badge {{ $group->payment_status == 'paid' ? 'status-paid' : 'status-pending' }}">
                    Payment: {{ strtoupper($group->payment_status) }}
                </span>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>Thank you for choosing Imperial Health. This is a system-generated document.</p>
        <p>{{ $info_settings['name'] }} | {{ $info_settings['address'] }} | {{ $info_settings['website'] }}</p>
    </div>
</div>
@endsection
