@extends('layouts.app')

@section('title')
{{__('Patient Details')}}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="fa fa-user"></i>
            {{__('Patients')}}
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.patients.index')}}">{{__('Patients')}}</a></li>
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
      <h3 class="card-title">{{__('Patient Details')}}</h3>
      <a href="{{route('admin.patients.edit', $patient->id)}}" class="btn btn-warning btn-sm float-right">
        <i class="fa fa-edit"></i> {{__('Edit')}} 
      </a>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-6">
          <table class="table table-bordered">
            <tr>
              <th width="30%">{{__('Code')}}</th>
              <td>{{$patient->code}}</td>
            </tr>
            <tr>
              <th>{{__('Name')}}</th>
              <td>{{$patient->name}}</td>
            </tr>
            <tr>
              <th>{{__('Gender')}}</th>
              <td>{{__(ucwords($patient->gender))}}</td>
            </tr>
            <tr>
              <th>{{__('DOB')}}</th>
              <td>{{$patient->dob}}</td>
            </tr>
          </table>
        </div>
        <div class="col-lg-6">
          <table class="table table-bordered">
            <tr>
              <th width="30%">{{__('Phone')}}</th>
              <td>{{$patient->phone}}</td>
            </tr>
            <tr>
              <th>{{__('Email')}}</th>
              <td>{{$patient->email}}</td>
            </tr>
            <tr>
              <th>{{__('Address')}}</th>
              <td>{{$patient->address}}</td>
            </tr>
          </table>
        </div>
      </div>

      @if($patient->groups->count() > 0)
      <div class="row mt-4">
        <div class="col-lg-12">
          <h4>{{__('Invoice History')}}</h4>
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>{{__('Barcode')}}</th>
                <th>{{__('Date')}}</th>
                <th>{{__('Total')}}</th>
                <th>{{__('Paid')}}</th>
                <th>{{__('Due')}}</th>
                <th>{{__('Status')}}</th>
                <th width="100px">{{__('Action')}}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($patient->groups as $group)
              <tr @if($group->booking && $group->booking->status === 'cancelled') class="bg-light text-muted" @endif>
                <td>{{$group->barcode}}</td>
                <td>{{$group->created_at}}</td>
                <td>{{formated_price($group->total)}}</td>
                <td>{{formated_price($group->paid)}}</td>
                <td>{{formated_price($group->due)}}</td>
                <td>
                  @if($group->booking && $group->booking->status === 'cancelled')
                    <span class="badge badge-danger">{{__('Cancelled')}}</span>
                  @elseif($group->done)
                    <span class="badge badge-success">{{__('Done')}}</span>
                  @else
                    <span class="badge badge-warning">{{__('Pending')}}</span>
                  @endif
                </td>
                <td>
                  <a href="{{route('admin.groups.show', $group->id)}}" class="btn btn-primary btn-sm">
                    <i class="fa fa-eye"></i>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr class="bg-light">
                <th colspan="2" class="text-right">{{__('Total Balance (Active Only)')}}</th>
                <th>{{formated_price($patient->total)}}</th>
                <th>{{formated_price($patient->paid)}}</th>
                <th>{{formated_price($patient->due)}}</th>
                <th colspan="2"></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      @endif
    </div>
</div>
@endsection