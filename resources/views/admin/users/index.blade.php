@extends('layouts.app')

@section('title')
    {{__('Users')}}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="fa fa-user-circle"></i>
            {{__('Users')}}
          </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item active">{{__('Users')}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')

{{-- Logic for User and Super Admin Check --}}
@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">
        {{__('Users Table')}}
      </h3>
      
      {{-- Custom logic instead of @can('create_user') --}}
      @if($u && ($isSuper || $u->hasPermission('create_user')))
        <a href="{{route('admin.users.create')}}" class="btn btn-primary btn-sm float-right">
          <i class="fa fa-plus"></i> {{ __('Create User') }}
        </a>
      @endif
    </div>
    <div class="card-body">
        <div class="col-lg-12 table-responsive">
          <table id="reports_table" class="table table-striped table-hover table-bordered" width="100%">
            <thead>
            <tr>
              <th width="10px">#</th>
              <th>{{__('Name')}}</th>
              <th>{{__('Email')}}</th>
              <th>{{__('Roles')}}</th>
              <th width="150px">{{__('Action')}}</th>
            </tr>
            </thead>
            <tbody>
               {{-- DataTable will load data here via JS (users.js) --}}
            </tbody>
          </table>
        </div>
    </div>
    </div>

@endsection

@section('scripts')
  <script src="{{url('js/admin/users.js')}}"></script>
@endsection
