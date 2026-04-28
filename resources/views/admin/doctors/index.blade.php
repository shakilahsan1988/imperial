@extends('layouts.app')
@section('title', __('Doctors'))

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-end mb-2">
            <div class="d-flex align-items-center">
                @php
                    $u = auth()->guard('admin')->user();
                    $isSuper = ($u && $u->id == 1);
                @endphp
                
                @if($u && ($isSuper || $u->hasPermission('view_doctor')))
                <a href="{{ route('admin.doctors.export') }}" class="btn btn-success shadow-sm mr-2">
                    <i class="fas fa-file-excel mr-1"></i> {{ __('Export') }}
                </a>
                @endif

                @if($u && ($isSuper || $u->hasPermission('create_doctor')))
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus mr-1"></i> {{ __('Create Doctor') }}
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h3 class="card-title font-weight-bold mb-0">
                        <i class="fas fa-table mr-2 text-primary"></i>{{ __('Doctors Table') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="doctors_table" class="table table-hover align-middle" width="100%">
                            <thead class="bg-light">
                                <tr>
                                    <th width="10px" class="border-0 text-xs text-uppercase text-muted">#</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">{{ __('Code') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">{{ __('Name') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">{{ __('Specialty') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">{{ __('Department') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">{{ __('Phone') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">{{ __('Email') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">{{ __('Schedule') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">{{ __('In-Hub Fee') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">{{ __('Video Fee') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">{{ __('Video Consult') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">{{ __('Commission') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">{{ __('Total') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">{{ __('Paid') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">{{ __('Due') }}</th>
                                    <th width="100px" class="border-0 text-xs text-uppercase text-muted text-center">{{ __('Action') }}</th>
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
    <script src="{{url('js/admin/doctors.js')}}"></script>
    <style>
        .text-xs { font-size: 0.75rem; }
        .table td { vertical-align: middle; }
    </style>
@endpush
