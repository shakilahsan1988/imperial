@extends('layouts.app')
@section('title', __('Contracts'))

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-end mb-2">
            <div class="d-flex align-items-center">
                @php
                    $u = auth()->guard('admin')->user();
                    $isSuper = ($u && $u->id == 1);
                @endphp
                
                @if($u && ($isSuper || $u->hasPermission('create_contract')))
                <a href="{{ route('admin.contracts.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus mr-1"></i> {{ __('Create Contract') }}
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
                        <i class="fas fa-table mr-2 text-primary"></i>{{ __('Contracts Table') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="contracts_table" class="table table-hover align-middle" width="100%">
                            <thead class="bg-light">
                                <tr>
                                    <th width="10px" class="border-0 text-xs text-uppercase text-muted">#</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">{{ __('Contract Name') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">{{ __('Discount') }}</th>
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
    <script src="{{url('js/admin/contracts.js')}}"></script>
    <style>
        .text-xs { font-size: 0.75rem; }
        .table td { vertical-align: middle; }
    </style>
@endpush
