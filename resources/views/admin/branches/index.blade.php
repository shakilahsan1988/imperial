@extends('layouts.app')
@section('title', __('Branches'))

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-end mb-2">
            <div class="d-flex align-items-center">
                @php
                    $u = auth()->guard('admin')->user();
                    $isSuper = ($u && $u->id == 1);
                @endphp

                @if($u && ($isSuper || $u->hasPermission('create_branch')))
                <a href="{{ route('admin.branches.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus mr-1"></i> {{ __('Add Branch') }}
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
                    <h3 class="card-title">
                        <i class="fas fa-building mr-2 text-primary"></i>{{ __('Branches Table') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="branches_table" class="table table-bordered table-striped table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Address') }}</th>
                                    <th>{{ __('Gallery') }}</th>
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
  <script src="{{url('js/admin/branches.js')}}"></script>
@endpush
