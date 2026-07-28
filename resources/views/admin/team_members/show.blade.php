@extends('layouts.app')

@section('title')
{{__('Team Member Details')}}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="fa fa-users-cog"></i>
            {{__('Management Team')}}
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.team_members.index')}}">{{__('Management Team')}}</a></li>
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
      <h3 class="card-title">{{__('Team Member Details')}}</h3>
      <a href="{{route('admin.team_members.edit', $team_member->id)}}" class="btn btn-warning btn-sm float-right">
        <i class="fa fa-edit"></i> {{__('Edit')}}
      </a>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-3 text-center">
          <img class="img-thumbnail mb-3"
               src="@if(!empty($team_member->image)){{asset($team_member->image)}}@else{{url('img/no-image.png')}}@endif"
               alt="{{$team_member->name}}">
        </div>
        <div class="col-lg-9">
          <table class="table table-bordered">
            <tr>
              <th width="30%">{{__('Name')}}</th>
              <td>{{$team_member->name}}</td>
            </tr>
            <tr>
              <th>{{__('Designation')}}</th>
              <td>{{$team_member->designation}}</td>
            </tr>
            <tr>
              <th>{{__('Branch')}}</th>
              <td>{{optional($team_member->branch)->name}}</td>
            </tr>
            <tr>
              <th>{{__('Slug')}}</th>
              <td>{{$team_member->slug}}</td>
            </tr>
            <tr>
              <th>{{__('Sort Order')}}</th>
              <td>{{$team_member->sort_order}}</td>
            </tr>
            <tr>
              <th>{{__('Status')}}</th>
              <td>
                @if($team_member->status)
                  <span class="badge badge-success">{{__('Active')}}</span>
                @else
                  <span class="badge badge-danger">{{__('Inactive')}}</span>
                @endif
              </td>
            </tr>
          </table>
        </div>
      </div>

      @if($team_member->bio)
      <div class="row mt-3">
        <div class="col-lg-12">
          <h5>{{__('Biography')}}</h5>
          <p>{!! nl2br(e($team_member->bio)) !!}</p>
        </div>
      </div>
      @endif
    </div>
    <div class="card-footer">
      <a href="{{route('admin.team_members.index')}}" class="btn btn-danger btn-sm">
        <i class="fa fa-arrow-left"></i> {{__('Back')}}
      </a>
      @if($team_member->slug)
        <a href="{{route('management-details', $team_member->slug)}}" target="_blank" class="btn btn-info btn-sm">
          <i class="fa fa-external-link-alt"></i> {{__('View on site')}}
        </a>
      @endif
    </div>
</div>
@endsection
