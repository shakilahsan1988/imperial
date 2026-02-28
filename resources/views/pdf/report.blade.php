@extends('layouts.pdf')
@section('content')
<style>
    .test_title {
        background-color: #f1f5f9;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 4px;
    }
    .test_title h2 {
        margin: 0;
        font-size: 18px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .test_head th {
        background-color: #f8fafc;
        border-bottom: 2px solid #e2e8f0 !important;
        text-transform: uppercase;
        font-size: 11px;
        color: #64748b;
    }
    .test_name {
        font-weight: 600;
        color: #1e293b;
    }
    .result {
        font-weight: 700;
        color: var(--primary);
    }
    .comment-box {
        margin-top: 15px;
        padding: 10px;
        background-color: #fdfdfd;
        border-left: 4px solid #cbd5e1;
        font-style: italic;
    }
    .sensitivity-table thead th {
        background-color: #f8fafc;
    }
    /* Dynamic Settings Overrides */
    .test_title {
        color:{{$reports_settings['test_title']['color']}}!important;
        font-size:{{$reports_settings['test_title']['font-size']}}!important;
        font-family:{{$reports_settings['test_title']['font-family']}}!important;
    }
    .test_name {
        color:{{$reports_settings['test_name']['color']}}!important;
        font-size:{{$reports_settings['test_name']['font-size']}}!important;
        font-family:{{$reports_settings['test_name']['font-family']}}!important;
    }
</style>
<div class="printable">
    @php 
        $count=0;
    @endphp
    @if(count($group['tests']))
        @foreach($group['tests'] as $test)
            @php 
                $count++;
            @endphp
        <table class="table test" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th class="test_title" align="center" colspan="5">
                        <h2>{{$test['test']['name']}}</h2>
                    </th>
                </tr>
                <tr class="test_head">
                    <th width="35%" align="left">Investigation</th>
                    <th width="15%" align="center">Result</th>
                    <th width="15%" align="center">Unit</th>
                    <th width="20%" align="center">Reference Range</th>
                    <th width="15%" align="center">Status</th>
                </tr>
            </thead>
            <tbody class="table-bordered">
                @foreach($test["results"] as $result)
                    @if(isset($result['component']))
                        @if($result['component']['title'])
                            <tr>
                                <td colspan="5" style="background-color: #f8fafc; padding: 8px 12px;">
                                    <b style="color: #475569; font-size: 13px;">{{$result['component']['name']}}</b>
                                </td>
                            </tr>
                        @else
                        <tr>
                            <td class="test_name">{{$result["component"]["name"]}}</td>
                            <td align="center" class="result">{{$result["result"]}}</td>
                            <td align="center" class="unit" style="color: #64748b;">{{$result["component"]["unit"]}}</td>
                            <td align="center" class="reference_range" style="font-size: 11px;">{!! $result["component"]["reference_range"] !!}</td>
                            <td align="center">
                                @if(strtolower($result['status']) == 'high' || strtolower($result['status']) == 'abnormal')
                                    <b style="color: #ef4444;">{{$result['status']}}</b>
                                @else
                                    {{$result['status']}}
                                @endif
                            </td>
                        </tr>
                        @endif
                    @endif
                @endforeach
            </tbody>
        </table>
        
        @if(!empty($test['comment']))
            <div class="comment-box">
                <b>Note:</b> {{$test['comment']}}
            </div>
        @endif
        @endforeach
    @endif

    @foreach($group['cultures'] as $culture)
        @php $count++; @endphp
        @if($count > 1) <pagebreak> @endif
        
        <div class="test_title" style="text-align: center; margin-top: 20px;">
            <h2>{{$culture['culture']['name']}}</h2>
        </div>

        <table class="table" width="100%" style="margin-bottom: 20px;">
            <tbody>
                @foreach($culture['culture_options'] as $culture_option)
                    @if(isset($culture_option['value']) && isset($culture_option['culture_option']))
                        <tr>
                            <td width="200px" style="font-weight: 600; color: #64748b; border: none;">{{$culture_option['culture_option']['value']}}:</td>
                            <td style="color: #1e293b; border: none;">{{$culture_option['value']}}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <table class="table table-bordered sensitivity-table" width="100%">
            <thead>
                <tr class="test_head">
                    <th align="left">Antibiotic Name</th>
                    <th align="center">Sensitivity</th>
                    <th align="left">Commercial Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach(['high_antibiotics', 'moderate_antibiotics', 'resident_antibiotics'] as $level)
                    @foreach($culture[$level] as $antibiotic)
                        <tr>
                            <td class="test_name">{{$antibiotic['antibiotic']['name']}}</td>
                            <td align="center">
                                @if($level == 'high_antibiotics')
                                    <span style="color: #10b981; font-weight: 700;">{{$antibiotic['sensitivity']}}</span>
                                @elseif($level == 'resident_antibiotics')
                                    <span style="color: #ef4444; font-weight: 700;">{{$antibiotic['sensitivity']}}</span>
                                @else
                                    {{$antibiotic['sensitivity']}}
                                @endif
                            </td>
                            <td style="color: #64748b; font-size: 11px;">{{$antibiotic['antibiotic']['commercial_name']}}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        @if(!empty($culture['comment']))
            <div class="comment-box">
                <b>Culture Note:</b> {{$culture['comment']}}
            </div>
        @endif
    @endforeach
</div>

@endsection