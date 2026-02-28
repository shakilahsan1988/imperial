@extends('layouts.email')

@section('content')
<div style="text-align: center; padding: 20px;">
    <h2 style="color: #1e293b; font-family: 'Inter', sans-serif;">{{__('Your Verification Code')}}</h2>
    <p style="color: #64748b; font-size: 16px;">{{__('Use the following code to complete your login to Imperial Health.')}}</p>
    
    <div style="margin: 30px 0;">
        <span style="font-size: 40px; font-weight: 800; letter-spacing: 10px; color: #4f46e5; background: #f8fafc; padding: 15px 30px; border-radius: 12px; border: 1px solid #e2e8f0;">
            {{$otp}}
        </span>
    </div>

    <p style="color: #94a3b8; font-size: 12px;">{{__('This code will expire in 10 minutes. If you did not request this, please ignore this email.')}}</p>
</div>
@endsection
