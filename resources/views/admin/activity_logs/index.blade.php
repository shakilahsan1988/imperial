@extends('layouts.app')

@section('title')
{{__('Activity Logs')}}
@endsection

@section('breadcrumb')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">
          <i class="nav-icon fas fa-server"></i>   
          {{__('Activity Logs')}}
        </h1>
      </div><div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Activity Logs')}}</li>
        </ol>
      </div></div></div></div>
@endsection

@section('content')
@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title">{{__('Activity Logs Table')}}</h3>

    @if($u && ($isSuper || $u->hasPermission('clear_activity_log')))
      <form action="{{route('admin.activity_logs.clear')}}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger btn-sm float-right">
          <i class="fa fa-trash"></i> {{__('Clear')}}
        </button>
      </form>
    @endif
  </div>
  <div class="card-body">
    <div id="accordion">
        <div class="card card-info">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary collapsed" aria-expanded="false">
            <i class="fas fa-filter"></i> {{__('Filter')}}
          </a>
          <div id="collapseOne" class="panel-collapse in collapse">
            <div class="card-body">
              <div class="row justify-content-center">
                <div class="col-lg-3">
                  <div class="form-group">
                     <label for="filter_user">{{__('User')}}</label>
                     <select name="filter_user" id="filter_user" class="form-control select2">
                        <option value="" selected>{{__('All')}}</option>
                        @foreach($users as $user)
                            <option value="{{$user['id']}}">{{$user['name']}}</option>
                        @endforeach
                     </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <div class="row">
      <div class="col-12 table-responsive">
        <table id="activity_logs_table" class="table table-striped table-hover table-bordered"  width="100%">
          <thead>
            <tr>
              <th width="10px">#</th>
              <th>{{__('Action')}}</th>
              <th>{{__('User')}}</th>
              <th>{{__('Time')}}</th>
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
  <script src="{{url('js/admin/activity_logs.js')}}"></script>
@endsection