@extends('layouts.app')

@section('title', __('View Report'))

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div>
                <h3 class="mb-0 text-dark font-weight-bold">{{ __('Diagnostic Report') }}</h3>
                <p class="text-muted mb-0">Invoice #{{ $group->barcode ?? $group->id }}</p>
            </div>
            <div>
                <a href="{{ route('admin.results.index') }}" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Back to Results') }}
                </a>
                <a href="{{ route('admin.reports.pdf', $group->id) }}" class="btn btn-info shadow-sm ml-2" target="_blank">
                    <i class="fas fa-print mr-1"></i> {{ __('Print Report') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
    {{-- Patient Summary Card --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-1">
                            <div class="bg-primary-soft rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px;">
                                <i class="fas fa-user-injured text-primary fa-lg"></i>
                            </div>
                        </div>
                        <div class="col-md-3 border-right">
                            <label class="text-xs text-uppercase text-muted mb-1 d-block">{{ __('Patient Name') }}</label>
                            <h5 class="font-weight-bold mb-0 text-dark">{{ $group->patient->name }}</h5>
                            <small class="text-muted">{{ $group->patient->phone }}</small>
                        </div>
                        <div class="col-md-2 border-right">
                            <label class="text-xs text-uppercase text-muted mb-1 d-block">{{ __('Gender / Age') }}</label>
                            <p class="mb-0 text-dark font-weight-600">{{ ucfirst($group->patient->gender) }} / {{ $group->patient->age }}</p>
                        </div>
                        <div class="col-md-3 border-right">
                            <label class="text-xs text-uppercase text-muted mb-1 d-block">{{ __('Report Date') }}</label>
                            <p class="mb-0 text-dark font-weight-600">{{ $group->updated_at->format('d M, Y h:i A') }}</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <span class="badge bg-success-soft text-success px-4 py-2 rounded-pill border border-success">
                                <i class="fas fa-check-circle mr-1"></i> COMPLETED
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tests Section --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom-0 pt-4 px-4">
            <h5 class="card-title font-weight-bold text-primary mb-0">
                <i class="fas fa-microscope mr-2"></i>{{ __('Diagnostic Results') }}
            </h5>
        </div>
        <div class="card-body p-4">
            @foreach($group->tests as $test)
            <div class="border rounded mb-4 overflow-hidden">
                <div class="bg-light px-4 py-2 border-bottom">
                    <h6 class="mb-0 font-weight-bold text-dark">{{ $test->service->name ?? 'Unknown Test' }}</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-white">
                            <tr>
                                <th class="border-0 text-xs text-uppercase text-muted px-4">{{ __('Investigation') }}</th>
                                <th class="border-0 text-xs text-uppercase text-muted text-center">{{ __('Result') }}</th>
                                <th class="border-0 text-xs text-uppercase text-muted text-center">{{ __('Unit') }}</th>
                                <th class="border-0 text-xs text-uppercase text-muted text-center">{{ __('Reference Range') }}</th>
                                <th class="border-0 text-xs text-uppercase text-muted text-center">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 font-weight-600 text-dark">{{ $test->service->name }}</td>
                                <td class="text-center h5 mb-0 font-weight-bold text-primary">{{ $test->result }}</td>
                                <td class="text-center text-muted">{{ $test->service->unit }}</td>
                                <td class="text-center small text-muted">{!! $test->service->reference_range !!}</td>
                                <td class="text-center">
                                    @php $status = strtolower($test->status); @endphp
                                    @if($status == 'high')
                                        <span class="badge bg-danger px-3 py-1">HIGH</span>
                                    @elseif($status == 'low')
                                        <span class="badge bg-warning px-3 py-1">LOW</span>
                                    @else
                                        <span class="badge bg-success-soft text-success px-3 py-1">Normal</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if($test->comment)
                <div class="bg-slate-50 p-3 border-top">
                    <small class="text-uppercase text-muted font-weight-bold d-block mb-1">Pathologist Comment:</small>
                    <p class="mb-0 text-dark italic">"{{ $test->comment }}"</p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
<style>
    .bg-primary-soft { background-color: rgba(79, 70, 229, 0.1); }
    .bg-success-soft { background-color: rgba(16, 185, 129, 0.1); }
    .bg-slate-50 { background-color: #f8fafc; }
    .text-xs { font-size: 0.75rem; }
    .font-weight-600 { font-weight: 600; }
    .italic { font-style: italic; }
</style>
@endpush
