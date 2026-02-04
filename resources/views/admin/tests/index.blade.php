@extends('layouts.app')

@section('title')
{{__('Tests')}}
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
        </div><div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item active">{{__('Tests')}}</li>
          </ol>
        </div></div></div></div>
@endsection

@section('content')
{{-- ইউজার এবং সুপার এডমিন চেক করার জন্য লজিক --}}
@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">{{__('Tests Table')}}</h3>
      
      {{-- @can('create_test') এর পরিবর্তে কাস্টম লজিক ব্যবহার করা হলো --}}
      @if($u && ($isSuper || $u->hasPermission('create_test')))
      <a href="{{route('admin.tests.create')}}" class="btn btn-primary btn-sm float-right">
        <i class="fa fa-plus"></i> {{__('Create')}} 
      </a>
      @endif
    </div>
    <div class="card-body">
      <div class="row">
       <div class="col-lg-12 table-responsive">
        <table id="tests_table" class="table table-striped table-hover table-bordered"  width="100%">
          <thead>
            <tr>
              <th width="10px">#</th>
              <th>{{__('Name')}}</th>
              <th>{{__('Shortcut')}}</th>
              <th>{{__('Sample Type')}}</th>
              <th>{{__('Price')}}</th>
              <th width="100px">{{__('Action')}}</th>
            </tr>
          </thead>
          <tbody>
            {{-- ডেটাবেস থেকে ডেটা JS (tests.js) এর মাধ্যমে লোড হবে --}}
          </tbody>
        </table>
       </div>
      </div>
     
    </div>
    </div>

@endsection

@section('scripts')
  <script src="{{url('js/admin/tests.js')}}"></script>
@endsection