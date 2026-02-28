@extends('layouts.app')

@section('title')
    {{__('Backups')}}
@endsection

@section('breadcrumb')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">
          <i class="fa fa-database nav-icon"></i>
          {{__('Database Backups')}}
        </h1>
      </div><div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Database Backups')}}</li>
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
    <h3 class="card-title">
      {{__('Backups Table')}}
    </h3>
    @if($u && ($isSuper || $u->hasPermission('create_backup')))
    <a href="{{route('admin.backups.create')}}" class="btn btn-primary btn-sm float-right">
        <i class="fa fa-plus"></i> {{__('Create Backup')}}
    </a>
    @endif
  </div>
  <div class="card-body">
    <div class="row table-responsive">
      <div class="col-12">
        <table id="example1" class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
              <th>{{__('Backup')}}</th>
              <th>{{__('Date')}}</th>
              <th width="100px">{{__('Action')}}</th>
            </tr>
          </thead>
          <tbody>
              @foreach($backups as $backup)
              <tr>
                <td>{{$backup->getFilename()}}</td>
                <td>{{date('d-m-Y',$backup->getATime())}}</td>
                <td>
                    @if($u && ($isSuper || $u->hasPermission('view_backup')))
                      <a href="{{route('admin.backups.show',$backup->getFilename())}}" class="btn btn-primary btn-sm">
                        <i class="fa fa-download"></i>
                      </a>
                    @endif

                    @if($u && ($isSuper || $u->hasPermission('delete_backup')))
                      <form action="{{route('admin.backups.destroy',$backup->getFilename())}}" class="d-inline" method="POST">
                        @csrf 
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm delete_backup">
                          <i class="fa fa-trash"></i>
                        </button>
                      </form>
                    @endif
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>
@endsection

@section('scripts')
  <script src="{{url('js/admin/backups.js')}}"></script>
@endsection