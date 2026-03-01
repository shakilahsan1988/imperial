@extends('layouts.app')
@section('title', __('Patients'))

@section('header')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">{{ __('Patients') }}</h3>
        <div class="d-flex align-items-center">
            @php
                $u = auth()->guard('admin')->user();
                $isSuper = ($u && $u->id == 1);
            @endphp
            
            @if($u && ($isSuper || $u->hasPermission('view_patient')))
            <a href="{{ route('admin.patients.export') }}" class="btn btn-success mr-2">
                <i class="fas fa-file-excel"></i> {{ __('Export') }}
            </a>
            @endif

            @if($u && ($isSuper || $u->hasPermission('create_patient')))
            <a href="{{ route('admin.patients.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> {{ __('Create Patient') }}
            </a>
            @endif
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-injured mr-2 text-primary"></i>{{ __('Patients Table') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="patients_table" class="table table-bordered table-striped table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Total') }}</th>
                                    <th>{{ __('Paid') }}</th>
                                    <th>{{ __('Due') }}</th>
                                    <th width="100px" class="text-center">{{ __('Action') }}</th>
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
    <script src="{{url('js/admin/patients.js')}}"></script>
@endpush
