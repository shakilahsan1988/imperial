@extends('layouts.app')

@section('title')
{{__('User Details')}}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="fa fa-users"></i>
            {{__('Users')}}
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">{{__('Users')}}</a></li>
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
      <h3 class="card-title">{{__('User Details')}}</h3>
      <a href="{{route('admin.users.edit', $user->id)}}" class="btn btn-warning btn-sm float-right">
        <i class="fa fa-edit"></i> {{__('Edit')}}
      </a>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-3 text-center">
          <img class="img-thumbnail mb-3"
               src="@if(!empty($user->image)){{url('uploads/users/'.$user->image)}}@else{{url('img/no-image.png')}}@endif"
               alt="{{$user->name}}">
        </div>
        <div class="col-lg-9">
          <table class="table table-bordered">
            <tr>
              <th width="30%">{{__('Name')}}</th>
              <td>{{$user->name}}</td>
            </tr>
            <tr>
              <th>{{__('Email')}}</th>
              <td>{{$user->email}}</td>
            </tr>
            <tr>
              <th>{{__('Phone')}}</th>
              <td>{{$user->phone}}</td>
            </tr>
            <tr>
              <th>{{__('Address')}}</th>
              <td>{{$user->address}}</td>
            </tr>
            <tr>
              <th>{{__('Roles')}}</th>
              <td>
                @forelse($user->roles as $role)
                  <span class="badge badge-info">{{$role->name}}</span>
                @empty
                  <span class="text-muted">{{__('No roles assigned')}}</span>
                @endforelse
              </td>
            </tr>
            <tr>
              <th>{{__('Technician')}}</th>
              <td>
                @if($user->is_technician)
                  <span class="badge badge-success">{{__('Yes')}}</span>
                  @if($user->technician_specialty)
                    <small class="text-muted ml-1">{{$user->technician_specialty}}</small>
                  @endif
                @else
                  <span class="badge badge-secondary">{{__('No')}}</span>
                @endif
              </td>
            </tr>
            <tr>
              <th>{{__('Created At')}}</th>
              <td>{{$user->created_at}}</td>
            </tr>
          </table>
        </div>
      </div>

      @if(!empty($user->signature))
      <div class="row mt-3">
        <div class="col-lg-12">
          <h5>{{__('Signature')}}</h5>
          <img class="img-thumbnail" src="{{url('uploads/signature/'.$user->signature)}}" alt="{{__('Signature')}}" height="120">
        </div>
      </div>
      @endif
    </div>
    <div class="card-footer">
      <a href="{{route('admin.users.index')}}" class="btn btn-danger btn-sm">
        <i class="fa fa-arrow-left"></i> {{__('Back')}}
      </a>
    </div>
</div>
@endsection
