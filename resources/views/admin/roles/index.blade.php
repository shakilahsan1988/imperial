@extends('layouts.app')

@section('title')
{{ __('পদবী') }}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fas fa-users-cog"></i>
                    {{__('পদবী')}}
                </h1>
            </div><div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="#">{{ __('পদবী') }}</a></li>
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
        <h3 class="card-title">{{ __('পদবী টেবিল') }}</h3>
        
        {{-- @can('create_role') এর পরিবর্তে কাস্টম লজিক ব্যবহার করা হলো --}}
        @if($u && ($isSuper || $u->hasPermission('create_role')))
        <a href="{{route('admin.roles.create')}}" class="btn btn-primary btn-sm float-right">
           <i class="fa fa-plus"></i> {{ __('ক্রিয়েট করুন') }}
        </a>
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table id="roles_table" class="table table-striped table-hover table-bordered"  width="100%">
                    <thead>
                        <tr>
                            <th width="10px">#</th>
                            <th>{{ __('পদবী এর নাম') }}</th>
                            <th width="150px">{{ __('একশন') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- ডাটা টেবিলের ডাটা JS এর মাধ্যমে এখানে লোড হবে --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

@endsection
@section('scripts')
    <script src="{{url('js/admin/roles.js')}}"></script>
@endsection