@extends('layouts.pdf')

@section('content')
<style>
    .report-header { margin-bottom: 20px; border-bottom: 2px solid #1e293b; padding-bottom: 10px; }
    .report-title { text-align: center; text-transform: uppercase; letter-spacing: 2px; color: #1e293b; margin: 10px 0; font-size: 18px; }
    
    .results-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .results-table th { 
        background-color: #f8fafc; 
        color: #475569; 
        font-size: 11px; 
        font-weight: 700; 
        text-transform: uppercase; 
        padding: 10px 12px; 
        border-bottom: 2px solid #e2e8f0; 
        text-align: left; 
    }
    .results-table td { 
        padding: 10px 12px; 
        border-bottom: 1px solid #f1f5f9; 
        color: #1e293b; 
        font-size: 12px; 
        vertical-align: middle;
    }
    
    .test-name { font-weight: 700; color: #0f172a; }
    .component-name { padding-left: 25px !important; color: #334155; font-weight: 500; }
    .result-value { font-weight: 800; color: #000; font-size: 13px; }
    
    .status-high { color: #ef4444; font-weight: 800; }
    .status-low { color: #f59e0b; font-weight: 800; }
    .status-normal { color: #10b981; }

    .comment-row td { background-color: #fafafa; padding: 5px 12px 10px 12px; border-bottom: 1px solid #e2e8f0; }
    .comment-text { font-style: italic; font-size: 11px; color: #64748b; margin: 0; }
    .profile-row { background-color: #f1f5f9; }
</style>

<div class="report-title">Laboratory Diagnostic Report</div>

<table class="results-table">
    <thead>
        <tr>
            <th width="35%">Investigation / Parameter</th>
            <th width="15%" style="text-align: center;">Result</th>
            <th width="15%" style="text-align: center;">Unit</th>
            <th width="25%" style="text-align: center;">Normal Reference Range</th>
            <th width="10%" style="text-align: center;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($group->tests as $test)
            @if($test->results->count() > 0)
                {{-- Profile Header Row --}}
                <tr class="profile-row">
                    <td colspan="5" class="test-name">{{ $test->service->name ?? 'Diagnostic Profile' }}</td>
                </tr>
                {{-- Component Rows --}}
                @foreach($test->results as $res)
                <tr>
                    <td class="component-name">{{ $res->component->name }}</td>
                    <td class="result-value" align="center">{{ $res->result }}</td>
                    <td align="center" style="color: #64748b;">{{ $res->component->unit }}</td>
                    <td align="center" style="font-size: 11px; color: #475569;">{!! $res->component->reference_range !!}</td>
                    <td align="center">
                        @php $status = strtolower($res->status); @endphp
                        @if($status == 'high')
                            <span class="status-high">HIGH</span>
                        @elseif($status == 'low')
                            <span class="status-low">LOW</span>
                        @else
                            <span class="status-normal">Normal</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            @else
                {{-- Simple Single Test Row --}}
                <tr>
                    <td class="test-name">{{ $test->service->name ?? 'N/A' }}</td>
                    <td class="result-value" align="center">{{ $test->result }}</td>
                    <td align="center" style="color: #64748b;">{{ $test->service->unit }}</td>
                    <td align="center" style="font-size: 11px; color: #475569;">{!! $test->service->reference_range !!}</td>
                    <td align="center">
                        @php $status = strtolower($test->status); @endphp
                        @if($status == 'high')
                            <span class="status-high">HIGH</span>
                        @elseif($status == 'low')
                            <span class="status-low">LOW</span>
                        @else
                            <span class="status-normal">Normal</span>
                        @endif
                    </td>
                </tr>
            @endif

            @if($test->comment)
            <tr class="comment-row">
                <td colspan="5">
                    <p class="comment-text"><strong>Note:</strong> {{ $test->comment }}</p>
                </td>
            </tr>
            @endif
        @endforeach
    </tbody>
</table>

<div style="margin-top: 30px; font-size: 10px; color: #94a3b8; text-align: center; border-top: 1px solid #f1f5f9; padding-top: 10px;">
    *** End of Report ***
</div>
@endsection
