@extends('layouts.app')

@section('title')
{{__('Expenses')}}
@endsection

@section('breadcrumb')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">
          <i class="nav-icon fas fa-dollar-sign"></i>   
          {{__('Expenses')}}
        </h1>
      </div><div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Expenses')}}</li>
        </ol>
      </div></div></div></div>
@endsection

@section('content')
{{-- পারমিশন চেক করার জন্য ইউজার ভেরিয়েবল সেটআপ --}}
@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title">{{__('Expenses Table')}}</h3>
    
    {{-- এখানে ভুল পারমিশন 'create_antibiotic' পরিবর্তন করে সঠিক লজিক দেওয়া হলো --}}
    @if($u && ($isSuper || $u->hasPermission('create_expense')))
    <a href="{{route('admin.expenses.create')}}" class="btn btn-primary btn-sm float-right">
     <i class="fa fa-plus"></i> {{__('Create')}}
    </a>
    @endif
    
  </div>
  <div class="card-body">
    <div class="row table-responsive">
      <div class="col-12">
        <table id="expenses_table" class="table table-striped table-hover table-bordered"  width="100%">
          <thead>
            <tr>
              <th width="10px">#</th>
              <th>{{__('Category')}}</th>
              <th>{{__('Date')}}</th>
              <th>{{__('Amount')}}</th>
              <th width="100px">{{__('Action')}}</th>
            </tr>
          </thead>
          <tbody>
              {{-- ডাটা টেবিলের তথ্য JS এর মাধ্যমে লোড হবে --}}
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>

@endsection

@section('scripts')
  <script src="{{url('js/admin/expenses.js')}}"></script>
@endsection