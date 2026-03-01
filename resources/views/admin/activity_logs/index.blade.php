@extends('layouts.app')
@section('title', __('Activity Logs'))

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-end mb-2">
            <div class="d-flex align-items-center">
                @php
                    $u = auth()->guard('admin')->user();
                    $isSuper = ($u && $u->id == 1);
                @endphp
                
                @if($u && ($isSuper || $u->hasPermission('clear_activity_log')))
                <form action="{{route('admin.activity_logs.clear')}}" method="POST" onsubmit="return confirm('Are you sure you want to clear all logs?')">
                    @csrf
                    <button type="submit" class="btn btn-danger shadow-sm">
                        <i class="fas fa-trash-alt mr-1"></i> {{ __('Clear Logs') }}
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
    {{-- Filter Section --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <div class="col-md-1 text-center border-right">
                    <i class="fas fa-filter text-muted fa-lg"></i>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label class="text-xs text-uppercase text-muted font-weight-bold mb-1">{{ __('Filter by User') }}</label>
                        <select name="filter_user" id="filter_user" class="form-control form-control-sm select2">
                            <option value="">{{ __('All Users') }}</option>
                            @foreach($users as $user)
                                <option value="{{$user['id']}}">{{$user['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Logs Table --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h3 class="card-title font-weight-bold mb-0">
                        <i class="fas fa-table mr-2 text-primary"></i>{{ __('System Activity') }}
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="activity_logs_table" class="table table-hover align-middle mb-0" width="100%">
                            <thead class="bg-light">
                                <tr>
                                    <th width="10px" class="border-0 text-xs text-uppercase text-muted px-4 py-3">#</th>
                                    <th class="border-0 text-xs text-uppercase text-muted py-3">{{ __('Action / Description') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted py-3">{{ __('Performed By') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted py-3">{{ __('Timestamp') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{url('js/admin/activity_logs.js')}}"></script>
    <style>
        .text-xs { font-size: 0.75rem; }
        .table td { vertical-align: middle; }
        .bg-light { background-color: #f8fafc !important; }
    </style>
@endpush
