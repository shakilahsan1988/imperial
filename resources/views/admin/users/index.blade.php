@extends('layouts.app')

@section('title')
    {{__('ইউজার')}}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="fa fa-user-circle"></i>
            {{__('ইউজার')}}
          </h1>
        </div><div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('হোম')}}</a></li>
            <li class="breadcrumb-item active"><a href="#">{{__('ইউজার')}}</a></li>
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
      <h3 class="card-title">
        {{__('ইউজার টেবিল')}}
      </h3>
      
      {{-- @can('create_user') এর পরিবর্তে আপনার কাস্টম লজিক --}}
      @if($u && ($isSuper || $u->hasPermission('create_user')))
        <a href="{{route('admin.users.create')}}" class="btn btn-primary btn-sm float-right">
          <i class="fa fa-plus"></i> {{ __('নতুন ইউজার ক্রিয়েট করুন') }}
        </a>
      @endif
    </div>
    <div class="card-body">
        <div class="col-lg-12 table-responsive">
          <table id="reports_table" class="table table-striped table-hover table-bordered" width="100%">
            <thead>
            <tr>
              <th width="10px">#</th>
              <th>{{__('নাম')}}</th>
              <th>{{__('ইমেইল')}}</th>
              <th>{{__('পদবী')}}</th>
              <th width="150px">{{__('একশন')}}</th>
            </tr>
            </thead>
            <tbody>
               {{-- ডাটা টেবিলের ডাটা JS (users.js) এর মাধ্যমে এখানে লোড হবে --}}
            </tbody>
          </table>
        </div>
    </div>
    </div>

@endsection

@section('scripts')
  <script src="{{url('js/admin/users.js')}}"></script>
@endsection