@extends('layouts.app')

@section('title')
{{__('Home Visits')}}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="nav-icon fas fa-home"></i>   
            {{__('Home Visits')}}
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item active">{{__('Home Visits')}}</li>
          </ol>
        </div>
      </div>
    </div>
</div>
@endsection

@section('content')
@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">{{__('Home Visits Table')}}</h3>
      
      @if($u && ($isSuper || $u->hasPermission('create_visit')))
        <a href="{{route('admin.visits.create')}}" class="btn btn-primary btn-sm float-right">
          <i class="fa fa-plus"></i> {{ __('Create') }}
        </a>
      @endif
    </div>
    <div class="card-body">
        <div class="row">
          <div class="col-lg-12 table-responsive">
            <table id="visits_table" class="table table-striped table-hover table-bordered"  width="100%">
              <thead>
                <tr>
                  <th width="10px">#</th>
                  <th>{{__('Patient Name')}}</th>
                  <th>{{__('Phone')}}</th>
                  <th>{{__('Address')}}</th>
                  <th>{{__('Visit Date')}}</th>
                  <th>{{__('Status')}}</th>
                  <th>{{__('Viewed')}}</th>
                  <th width="100px">{{__('Action')}}</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{url('js/admin/visits.js')}}"></script>
@endsection