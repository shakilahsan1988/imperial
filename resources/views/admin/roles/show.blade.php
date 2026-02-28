@extends('layouts.app')

@section('title')
{{__('Role Details')}}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="fa fa-window-maximize"></i>
            {{__('Roles')}}
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.roles.index')}}">{{__('Roles')}}</a></li>
            <li class="breadcrumb-item active">{{__('Details')}}</li>
          </ol>
        </div>
      </div>
    </div>
</div>
@endsection

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">{{__('Role Details')}}</h3>
      <a href="{{route('admin.roles.edit', $role->id)}}" class="btn btn-warning btn-sm float-right">
        <i class="fa fa-edit"></i> {{__('Edit')}} 
      </a>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-12">
          <table class="table table-bordered">
            <tr>
              <th width="20%">{{__('Name')}}</th>
              <td>{{$role->name}}</td>
            </tr>
            <tr>
              <th>{{__('Description')}}</th>
              <td>{{$role->description}}</td>
            </tr>
          </table>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-lg-12">
          <h4>{{__('Permissions')}}</h4>
          <hr>
          <div class="row">
            @foreach($role->permissions->groupBy('module.name') as $module => $permissions)
            <div class="col-lg-4 mb-3">
                <div class="card card-outline card-secondary">
                    <div class="card-header">
                        <h5 class="card-title">{{$module}}</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            @foreach($permissions as $permission)
                            <li><i class="fa fa-check text-success"></i> {{$permission->name}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
</div>
@endsection