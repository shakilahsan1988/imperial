@extends('layouts.app')

@section('title')
{{__('Test Details')}}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="fa fa-flask"></i>
            {{__('Tests')}}
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.tests.index')}}">{{__('Tests')}}</a></li>
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
      <h3 class="card-title">{{__('Test Details')}}</h3>
      <a href="{{route('admin.tests.edit', $test->id)}}" class="btn btn-warning btn-sm float-right">
        <i class="fa fa-edit"></i> {{__('Edit')}} 
      </a>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-6">
          <table class="table table-bordered">
            <tr>
              <th width="30%">{{__('Name')}}</th>
              <td>{{$test->name}}</td>
            </tr>
            <tr>
              <th>{{__('Shortcut')}}</th>
              <td>{{$test->shortcut}}</td>
            </tr>
            <tr>
              <th>{{__('Sample Type')}}</th>
              <td>{{$test->sample_type}}</td>
            </tr>
            <tr>
              <th>{{__('Price')}}</th>
              <td>{{formated_price($test->price)}}</td>
            </tr>
          </table>
        </div>
        <div class="col-lg-6">
          <table class="table table-bordered">
            <tr>
              <th>{{__('Precautions')}}</th>
              <td>{{$test->precautions}}</td>
            </tr>
          </table>
        </div>
      </div>

      @if($test->components->count() > 0)
      <div class="row mt-4">
        <div class="col-lg-12">
          <h4>{{__('Components')}}</h4>
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>{{__('Name')}}</th>
                <th>{{__('Type')}}</th>
                <th>{{__('Unit')}}</th>
                <th>{{__('Reference Range')}}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($test->components as $component)
              <tr>
                <td>{{$component->name}}</td>
                <td>{{$component->type}}</td>
                <td>{{$component->unit}}</td>
                <td>{!! $component->reference_range !!}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      @endif
    </div>
</div>
@endsection