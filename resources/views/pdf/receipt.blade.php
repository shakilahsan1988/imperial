@extends('layouts.pdf')

@section('content')
<style>
    .receipt_header h2 {
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #1e293b;
        margin: 0;
        padding: 10px 0;
    }
    .invoice-table thead th {
        background-color: #f8fafc;
        border-bottom: 2px solid #e2e8f0 !important;
        color: #64748b;
        font-size: 12px;
        text-transform: uppercase;
    }
    .total-row td {
        background-color: #f8fafc;
        border-top: 2px solid #e2e8f0 !important;
        font-weight: 700;
    }
    .summary-table td {
        border: none !important;
        padding: 5px 10px;
    }
    .summary-label {
        color: #64748b;
        font-weight: 600;
    }
    .summary-value {
        text-align: right;
        font-weight: 700;
        color: #1e293b;
    }
    .due-amount {
        color: #ef4444 !important;
        font-size: 16px;
    }
</style>

<div class="invoice">
    <div class="receipt_header" style="text-align: center; border-bottom: 1px solid #f1f5f9; margin-bottom: 20px;">
        <h2>Invoice</h2>
        <p style="color: #64748b;">Date: {{date('d-m-Y', strtotime($group['created_at']))}}</p>
    </div>

    <table class="table table-bordered invoice-table" width="100%">
        <thead>
            <tr>
                <th align="left" width="75%">Test / Investigation Name</th>
                <th align="right" width="25%">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($group['tests'] as $test)
            <tr>
                <td class="test_name">@if(isset($test['test'])) {{$test['test']['name']}} @endif</td>
                <td align="right">{{formated_price($test['price'])}}</td>
            </tr>
            @endforeach

            @foreach($group['cultures'] as $culture)
            <tr>
                <td class="test_name">@if(isset($culture['culture'])) {{$culture['culture']['name']}} @endif</td>
                <td align="right">{{formated_price($culture['price'])}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; width: 300px; float: right;">
        <table class="summary-table" width="100%">
            <tr>
                <td class="summary-label">{{__('Subtotal')}}:</td>
                <td class="summary-value">{{formated_price($group['subtotal'])}}</td>
            </tr>
            @if($group['discount'] > 0)
            <tr>
                <td class="summary-label">{{__('Discount')}} @if(!empty($group['contract'])) ({{$group['contract']['discount']}}%) @endif:</td>
                <td class="summary-value" style="color: #10b981;">- {{formated_price($group['discount'])}}</td>
            </tr>
            @endif
            <tr style="border-top: 1px solid #e2e8f0 !important;">
                <td class="summary-label" style="padding-top: 10px;">{{__('Total')}}:</td>
                <td class="summary-value" style="padding-top: 10px; font-size: 18px; color: var(--primary);">{{formated_price($group['total'])}}</td>
            </tr>
            <tr>
                <td class="summary-label">{{__('Paid')}}:</td>
                <td class="summary-value">{{formated_price($group['paid'])}}</td>
            </tr>
            @if($group['due'] > 0)
            <tr>
                <td class="summary-label">{{__('Due Amount')}}:</td>
                <td class="summary-value due-amount">{{formated_price($group['due'])}}</td>
            </tr>
            @endif
        </table>
    </div>
    <div style="clear: both;"></div>
</div>

@endsection