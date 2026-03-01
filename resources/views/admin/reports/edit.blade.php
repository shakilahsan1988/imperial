@extends('layouts.app')

@section('title', __('Edit Report'))

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-end mb-2">
            <div>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Back to List') }}
                </a>
                <a href="{{ route('admin.reports.show', $group->id) }}" class="btn btn-info shadow-sm ml-2" target="_blank">
                    <i class="fas fa-print mr-1"></i> {{ __('Print Report') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
    @php $antibiotic_count = 0; @endphp
    
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
                            <label class="text-xs text-uppercase text-muted mb-1 d-block">{{ __('Registration Date') }}</label>
                            <p class="mb-0 text-dark font-weight-600">{{ $group->created_at->format('d M, Y h:i A') }}</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <button type="button" class="btn btn-link text-primary p-0" data-toggle="modal" data-target="#patient_modal">
                                <i class="fas fa-info-circle mr-1"></i> {{ __('View Full Details') }}
                            </button>
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
                <i class="fas fa-microscope mr-2"></i>{{ __('Diagnostic Test Results') }}
            </h5>
        </div>
        <div class="card-body p-4">
            @if(count($group->tests))
            <div class="row">
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills nav-pills-custom" id="test-tabs" role="tablist" aria-orientation="vertical">
                        @foreach($group->tests as $index => $test)
                        <a class="nav-link mb-3 p-3 shadow-sm {{ $index == 0 ? 'active' : '' }}" 
                           id="v-pills-test-{{$test->id}}-tab" data-toggle="pill" href="#v-pills-test-{{$test->id}}" 
                           role="tab" aria-controls="v-pills-test-{{$test->id}}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                            <div class="d-flex justify-content-between align-items-center text-left">
                                <span class="font-weight-bold">{{ $test->service ? $test->service->name : ($test->test ? $test->test->name : 'Unknown') }}</span>
                                @if($test->done)
                                    <i class="fas fa-check-circle text-success ml-2"></i>
                                @else
                                    <i class="fas fa-clock text-warning ml-2"></i>
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        @foreach($group->tests as $index => $test)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="v-pills-test-{{$test->id}}" role="tabpanel" aria-labelledby="v-pills-test-{{$test->id}}-tab">
                            <div class="p-3 border rounded bg-white">
                                <form action="{{ route('admin.reports.update', $test->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                                        <h6 class="font-weight-bold text-dark mb-0">
                                            {{ $test->service ? $test->service->name : ($test->test ? $test->test->name : 'Result') }} {{ __('Entry') }}
                                        </h6>
                                        @if($test->done)
                                            <span class="badge bg-success-soft text-success px-3 py-1 rounded-pill">
                                                <i class="fas fa-check mr-1"></i> Completed
                                            </span>
                                        @else
                                            <span class="badge bg-warning-soft text-warning px-3 py-1 rounded-pill">
                                                <i class="fas fa-history mr-1"></i> Pending
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @if($test->service_id)
                                        {{-- Check if service has multiple parameters (Profile) --}}
                                        @php
                                            $components = $test->service->components;
                                        @endphp

                                        @if($components->count() > 0)
                                            {{-- Profile/Panel Result Entry --}}
                                            <div class="table-responsive">
                                                <table class="table table-hover align-middle">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="border-0 text-xs text-uppercase text-muted">{{ __('Parameter') }}</th>
                                                            <th class="border-0 text-xs text-uppercase text-muted">{{ __('Unit') }}</th>
                                                            <th class="border-0 text-xs text-uppercase text-muted">{{ __('Reference Range') }}</th>
                                                            <th class="border-0 text-xs text-uppercase text-muted" style="width: 250px;">{{ __('Result') }}</th>
                                                            <th class="border-0 text-xs text-uppercase text-muted" style="width: 150px;">{{ __('Status') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($components as $component)
                                                            @php
                                                                $existingResult = $test->results->where('service_component_id', $component->id)->first();
                                                            @endphp
                                                            <tr>
                                                                <td class="font-weight-600 text-dark">{{ $component->name }}</td>
                                                                <td class="text-muted">{{ $component->unit }}</td>
                                                                <td class="small text-muted">{!! $component->reference_range !!}</td>
                                                                <td>
                                                                    <input type="text" name="results[{{$component->id}}][result]" class="form-control form-control-sm shadow-none" value="{{ $existingResult->result ?? '' }}" placeholder="Enter value">
                                                                </td>
                                                                <td>
                                                                    <select name="results[{{$component->id}}][status]" class="form-control form-control-sm shadow-none">
                                                                        <option value="Normal" {{ ($existingResult->status ?? '') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                                        <option value="High" {{ ($existingResult->status ?? '') == 'High' ? 'selected' : '' }} class="text-danger font-weight-bold">High</option>
                                                                        <option value="Low" {{ ($existingResult->status ?? '') == 'Low' ? 'selected' : '' }} class="text-warning font-weight-bold">Low</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            {{-- Single Service Result Entry --}}
                                            <div class="table-responsive">
                                                <table class="table table-hover align-middle">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="border-0 text-xs text-uppercase text-muted">{{ __('Test Name') }}</th>
                                                            <th class="border-0 text-xs text-uppercase text-muted">{{ __('Unit') }}</th>
                                                            <th class="border-0 text-xs text-uppercase text-muted">{{ __('Reference Range') }}</th>
                                                            <th class="border-0 text-xs text-uppercase text-muted" style="width: 250px;">{{ __('Result') }}</th>
                                                            <th class="border-0 text-xs text-uppercase text-muted" style="width: 150px;">{{ __('Status') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="font-weight-600 text-dark">{{ $test->service->name }}</td>
                                                            <td class="text-muted">{{ $test->service->unit }}</td>
                                                            <td class="small text-muted">{!! $test->service->reference_range !!}</td>
                                                            <td>
                                                                <input type="text" name="result" class="form-control form-control-sm shadow-none" value="{{ $test->result }}" placeholder="Enter value" required>
                                                            </td>
                                                            <td>
                                                                <select name="status" class="form-control form-control-sm shadow-none">
                                                                    <option value="Normal" {{ $test->status == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                                    <option value="High" {{ $test->status == 'High' ? 'selected' : '' }} class="text-danger font-weight-bold">High</option>
                                                                    <option value="Low" {{ $test->status == 'Low' ? 'selected' : '' }} class="text-warning font-weight-bold">Low</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    @else
                                        {{-- Legacy Tests Library Results (if any) --}}
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="border-0 text-xs text-uppercase text-muted">{{ __('Parameter') }}</th>
                                                        <th class="border-0 text-xs text-uppercase text-muted">{{ __('Unit') }}</th>
                                                        <th class="border-0 text-xs text-uppercase text-muted">{{ __('Reference Range') }}</th>
                                                        <th class="border-0 text-xs text-uppercase text-muted" style="width: 250px;">{{ __('Result') }}</th>
                                                        <th class="border-0 text-xs text-uppercase text-muted" style="width: 150px;">{{ __('Status') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($test->results as $result)
                                                        @if(isset($result->component))
                                                            @if($result->component->title)
                                                                <tr class="bg-slate-50">
                                                                    <td colspan="5" class="py-2">
                                                                        <span class="font-weight-bold text-primary small">{{ $result->component->name }}</span>
                                                                    </td>
                                                                </tr>
                                                            @else
                                                                <tr>
                                                                    <td class="font-weight-600 text-dark">{{ $result->component->name }}</td>
                                                                    <td class="text-muted">{{ $result->component->unit }}</td>
                                                                    <td class="small text-muted">{!! $result->component->reference_range !!}</td>
                                                                    <td>
                                                                        @if($result->component->type == 'text')
                                                                            <input type="text" name="result[{{$result->id}}][result]" class="form-control form-control-sm shadow-none" value="{{ $result->result }}" placeholder="Enter value">
                                                                        @else
                                                                            <select name="result[{{$result->id}}][result]" class="form-control form-control-sm select2 shadow-none">
                                                                                <option value="">{{ __('Select result') }}</option>
                                                                                @foreach($result->component->options as $option)
                                                                                    <option value="{{ $option->name }}" {{ $option->name == $result->result ? 'selected' : '' }}>{{ $option->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if($result->component->status)
                                                                            <select name="result[{{$result->id}}][status]" class="form-control form-control-sm shadow-none">
                                                                                <option value="Normal" {{ $result->status == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                                                <option value="High" {{ $result->status == 'High' ? 'selected' : '' }} class="text-danger font-weight-bold">High</option>
                                                                                <option value="Low" {{ $result->status == 'Low' ? 'selected' : '' }} class="text-warning font-weight-bold">Low</option>
                                                                            </select>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                    <div class="form-group mt-4">
                                        <label class="text-xs text-uppercase text-muted font-weight-bold">{{ __('Test Comment') }}</label>
                                        <textarea name="comment" rows="2" class="form-control" placeholder="Optional comments for this test...">{{ $test->comment }}</textarea>
                                    </div>

                                    <div class="mt-4 text-right">
                                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                            <i class="fas fa-save mr-1"></i> {{ __('Save Results') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                    <i class="fas fa-vials text-muted fa-3x"></i>
                </div>
                <h6 class="text-muted">{{ __('No tests have been added to this report yet.') }}</h6>
            </div>
            @endif
        </div>
    </div>

    {{-- Cultures Section --}}
    @if(count($group->cultures))
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom-0 pt-4 px-4">
            <h5 class="card-title font-weight-bold text-primary">
                <i class="fas fa-vial mr-2"></i>{{ __('Culture & Sensitivity Reports') }}
            </h5>
        </div>
        <div class="card-body p-4">
            <ul class="nav nav-pills mb-4" id="culture-tabs" role="tablist">
                @foreach($group->cultures as $index => $culture)
                <li class="nav-item mr-2">
                    <a class="nav-link rounded-pill border px-4 {{ $index == 0 ? 'active' : '' }}" 
                       id="culture-{{$culture->id}}-tab" data-toggle="pill" href="#culture-{{$culture->id}}" role="tab">
                        {{ $culture->culture->name }}
                        @if($culture->done) <i class="fas fa-check-circle ml-1 text-success"></i> @endif
                    </a>
                </li>
                @endforeach
            </ul>

            <div class="tab-content border p-4 rounded bg-white shadow-xs">
                @foreach($group->cultures as $index => $culture)
                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="culture-{{$culture->id}}" role="tabpanel">
                    <form method="POST" action="{{ route('admin.reports.update_culture', $culture->id) }}" class="culture_form">
                        @csrf
                        <div class="row mb-4">
                            @foreach($culture->options as $culture_option)
                                @if(isset($culture_option->culture_option))
                                    <div class="col-lg-4 mb-3">
                                        <div class="form-group mb-0">
                                            <label class="text-xs text-uppercase text-muted font-weight-bold">{{ $culture_option->culture_option->value }}</label>
                                            <select class="form-control select2" name="culture_options[{{$culture_option->id}}]">
                                                <option value="">{{ __('none') }}</option>
                                                @foreach($culture_option->culture_option->childs as $option)
                                                    <option value="{{ $option->value }}" {{ $option->value == $culture_option->value ? 'selected' : '' }}>{{ $option->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <h6 class="font-weight-bold text-dark mb-0">{{ __('Antibiotics Sensitivity') }}</h6>
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="add_antibiotic('{{$select_antibiotics}}', this)">
                                <i class="fas fa-plus mr-1"></i> {{ __('Add Antibiotic') }}
                            </button>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>{{ __('Antibiotic') }}</th>
                                        <th style="width: 250px;">{{ __('Sensitivity') }}</th>
                                        <th style="width: 50px;"></th>
                                    </tr>
                                </thead>
                                <tbody class="antibiotics">
                                    @foreach($culture->antibiotics as $antibiotic)
                                        @php $antibiotic_count++; @endphp
                                        <tr>
                                            <td>
                                                <select class="form-control antibiotic select2" name="antibiotic[{{$antibiotic_count}}][antibiotic]" required>
                                                    <option value="">{{ __('Select Antibiotic') }}</option>
                                                    @foreach($select_antibiotics as $select_antibiotic)
                                                        <option value="{{ $select_antibiotic->id }}" {{ $select_antibiotic->id == $antibiotic->antibiotic_id ? 'selected' : '' }}>{{ $select_antibiotic->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="antibiotic[{{$antibiotic_count}}][sensitivity]" required>
                                                    <option value="High" {{ $antibiotic->sensitivity == 'High' ? 'selected' : '' }}>{{ __('High (Sensitive)') }}</option>
                                                    <option value="Moderate" {{ $antibiotic->sensitivity == 'Moderate' ? 'selected' : '' }}>{{ __('Moderate') }}</option>
                                                    <option value="Resident" {{ $antibiotic->sensitivity == 'Resident' ? 'selected' : '' }}>{{ __('Resistant') }}</option>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-link text-danger delete_row p-0">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <label class="text-xs text-uppercase text-muted font-weight-bold">{{ __('Comment') }}</label>
                            <textarea class="form-control" name="comment" rows="3">{{ $culture->comment }}</textarea>
                        </div>

                        <div class="mt-4 text-right">
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-1"></i> {{ __('Save Culture Results') }}
                            </button>
                        </div>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <input type="hidden" id="antibiotic_count" value="{{ $antibiotic_count }}">

    @include('admin.reports._patient_modal')
@endsection

@push('scripts')
<style>
    .bg-primary-soft { background-color: rgba(79, 70, 229, 0.1); }
    .bg-slate-50 { background-color: #f8fafc; }
    .shadow-xs { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    .text-xs { font-size: 0.75rem; }
    .font-weight-600 { font-weight: 600; }
    
    .nav-pills-custom .nav-link {
        color: #475569;
        background: #fff;
        border-radius: 12px;
        transition: all 0.3s;
        border: 1px solid #e2e8f0;
    }
    
    .nav-pills-custom .nav-link.active {
        color: #fff;
        background: var(--primary);
        border-color: var(--primary);
    }
    
    .nav-pills-custom .nav-link:hover:not(.active) {
        background: #f1f5f9;
    }
</style>
<script src="{{url('js/admin/reports.js')}}"></script>
@endpush
