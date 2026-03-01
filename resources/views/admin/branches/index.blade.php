@extends('layouts.app')
@section('title', __('Branches'))

@section('header')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">{{ __('Branches') }}</h3>
        @php
            $u = auth()->guard('admin')->user();
            $isSuper = ($u && $u->id == 1);
        @endphp
        @if($u && ($isSuper || $u->hasPermission('create_branch')))
        <a href="{{ route('admin.branches.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> {{ __('Create Branch') }}
        </a>
        @endif
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
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
                                    <th>{{ __('Branch Name') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Address') }}</th>
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
