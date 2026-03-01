@extends('layouts.pdf')

@section('content')
<style>
    .report-container { padding: 20px 0; }
    .test-card { margin-bottom: 30px; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
    .test-header { background-color: #f8fafc; padding: 12px 20px; border-bottom: 1px solid #e2e8f0; }
    .test-title { margin: 0; color: #1e293b; font-size: 16px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .results-table { width: 100%; border-collapse: collapse; }
    .results-table th { background-color: #fff; color: #64748b; font-size: 11px; font-weight: 600; text-transform: uppercase; padding: 12px 20px; border-bottom: 2px solid #f1f5f9; text-align: left; }
    .results-table td { padding: 15px 20px; border-bottom: 1px solid #f1f5f9; color: #334155; font-size: 13px; }
    
    .result-value { font-weight: 700; color: #0f172a; font-size: 14px; }
    .status-normal { color: #10b981; font-weight: 600; }
    .status-high { color: #ef4444; font-weight: 700; }
    .status-low { color: #f59e0b; font-weight: 700; }
    
    .comment-section { padding: 15px 20px; background-color: #fcfcfc; border-top: 1px dashed #e2e8f0; }
    .comment-label { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 4px; display: block; }
    .comment-text { font-style: italic; color: #475569; font-size: 12px; }
</style>

<div class="report-container">
    @foreach($group->tests as $test)
    <div class="test-card">
        <div class="test-header">
            <h3 class="test-title">{{ $test->service->name ?? 'Diagnostic Test' }}</h3>
        </div>
        
        <table class="results-table">
            <thead>
                <tr>
                    <th width="40%">Investigation / Parameter</th>
                    <th width="15%">Result</th>
                    <th width="15%">Unit</th>
                    <th width="20%">Reference Range</th>
                    <th width="10%">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: 600;">{{ $test->service->name }}</td>
                    <td class="result-value">{{ $test->result }}</td>
                    <td style="color: #64748b;">{{ $test->service->unit }}</td>
                    <td style="font-size: 12px; color: #475569;">{!! $test->service->reference_range !!}</td>
                    <td>
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
            </tbody>
        </table>

        @if($test->comment)
        <div class="comment-section">
            <span class="comment-label">Pathologist Observations:</span>
            <p class="comment-text">{{ $test->comment }}</p>
        </div>
        @endif
    </div>
    @endforeach
</div>
@endsection
