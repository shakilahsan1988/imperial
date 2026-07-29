@extends('layouts.app')

@section('title')
{{__('Doctor Details')}}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="fa fa-user-md"></i>
            {{__('Doctors')}}
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.doctors.index')}}">{{__('Doctors')}}</a></li>
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
      <h3 class="card-title">{{__('Doctor Details')}}</h3>
      <a href="{{route('admin.doctors.edit', $doctor->id)}}" class="btn btn-warning btn-sm float-right">
        <i class="fa fa-edit"></i> {{__('Edit')}}
      </a>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-3 text-center">
          <img class="img-thumbnail mb-3"
               src="{{ $doctor->effective_image_url }}"
               alt="{{$doctor->name}}">
        </div>
        <div class="col-lg-9">
          <table class="table table-bordered">
            <tr>
              <th width="30%">{{__('Code')}}</th>
              <td>{{$doctor->code}}</td>
            </tr>
            <tr>
              <th>{{__('Name')}}</th>
              <td>{{$doctor->name}}</td>
            </tr>
            <tr>
              <th>{{__('Specialty')}}</th>
              <td>{{optional($doctor->specialty)->name}}</td>
            </tr>
            <tr>
              <th>{{__('Department')}}</th>
              <td>{{optional($doctor->department)->name}}</td>
            </tr>
            <tr>
              <th>{{__('Designation')}}</th>
              <td>{{$doctor->designation}}</td>
            </tr>
            <tr>
              <th>{{__('Qualification')}}</th>
              <td>{{$doctor->qualification}}</td>
            </tr>
            <tr>
              <th>{{__('Phone')}}</th>
              <td>{{$doctor->phone}}</td>
            </tr>
            <tr>
              <th>{{__('Email')}}</th>
              <td>{{$doctor->email}}</td>
            </tr>
            <tr>
              <th>{{__('Consultation Fee')}}</th>
              <td>{{formated_price($doctor->consultation_fee)}}</td>
            </tr>
            <tr>
              <th>{{__('Video Consultation')}}</th>
              <td>
                @if($doctor->video_consultation_available)
                  <span class="badge badge-success">{{__('Available')}}</span>
                  <small class="text-muted ml-1">{{formated_price($doctor->video_consultation_fee)}}</small>
                @else
                  <span class="badge badge-secondary">{{__('Not Available')}}</span>
                @endif
              </td>
            </tr>
            <tr>
              <th>{{__('Commission')}}</th>
              <td>{{$doctor->commission}} %</td>
            </tr>
            <tr>
              <th>{{__('Status')}}</th>
              <td>
                @if($doctor->status)
                  <span class="badge badge-success">{{__('Active')}}</span>
                @else
                  <span class="badge badge-danger">{{__('Inactive')}}</span>
                @endif
              </td>
            </tr>
          </table>
        </div>
      </div>

      @if($doctor->bio)
      <div class="row mt-3">
        <div class="col-lg-12">
          <h5>{{__('Biography')}}</h5>
          <p>{{$doctor->bio}}</p>
        </div>
      </div>
      @endif

      <h5 class="mt-4">{{__('Branch Schedules')}}</h5>
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th>{{__('Branch')}}</th>
            <th>{{__('Consultant')}}</th>
            <th>{{__('Days')}}</th>
            <th>{{__('Time')}}</th>
          </tr>
        </thead>
        <tbody>
          @forelse($doctor->branchSchedules as $schedule)
            <tr>
              <td>{{optional($schedule->branch)->name}}</td>
              <td>{{$schedule->consultant}}</td>
              <td>{{$schedule->schedule_days}}</td>
              <td>{{$schedule->schedule_time}}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center text-muted">{{__('No schedules added')}}</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      <a href="{{route('admin.doctors.index')}}" class="btn btn-danger btn-sm">
        <i class="fa fa-arrow-left"></i> {{__('Back')}}
      </a>
    </div>
</div>
@endsection
