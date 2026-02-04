@extends('layouts.app')

@section('title')
{{__('Culture options')}}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="nav-icon fas fa-vial"></i>
            {{__('Culture options')}}
          </h1>
        </div><div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item active">{{__('Culture options')}}</li>
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
      <h3 class="card-title">{{__('Culture options Table')}}</h3>
      
      {{-- @can('create_culture_option') এর পরিবর্তে আপনার কাস্টম লজিক --}}
      @if($u && ($isSuper || $u->hasPermission('create_culture_option')))
      <a href="{{route('admin.culture_options.create')}}" class="btn btn-primary btn-sm float-right">
        <i class="fa fa-plus"></i>  {{__('Create')}} 
      </a>
      @endif
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-12">
          <table id="culture_options_table" class="table table-striped table-hover table-bordered"  width="100%">
            <thead>
              <tr>
                <th width="10px">#</th>
                <th>{{__('Option')}}</th>
                <th width="80px">{{__('Action')}}</th>
              </tr>
            </thead>
            <tbody>
                {{-- ডাটা টেবিল থেকে ডাটা JS এর মাধ্যমে লোড হবে --}}
            </tbody>
          </table>
        </div>
      </div>
    </div>
    </div>

@endsection

@section('scripts')
  <script src="{{url('js/admin/culture_options.js')}}"></script>
@endsection