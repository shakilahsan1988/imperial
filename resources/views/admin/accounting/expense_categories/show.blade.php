@extends('layouts.app')

@section('title')
{{__('Expense Category Details')}}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="fa fa-tags"></i>
            {{__('Expense Categories')}}
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.expense_categories.index')}}">{{__('Expense Categories')}}</a></li>
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
      <h3 class="card-title">{{__('Expense Category Details')}}</h3>
      <a href="{{route('admin.expense_categories.edit', $expense_category->id)}}" class="btn btn-warning btn-sm float-right">
        <i class="fa fa-edit"></i> {{__('Edit')}}
      </a>
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <tr>
          <th width="25%">{{__('Name')}}</th>
          <td>{{$expense_category->name}}</td>
        </tr>
        <tr>
          <th>{{__('Created At')}}</th>
          <td>{{$expense_category->created_at}}</td>
        </tr>
      </table>
    </div>
    <div class="card-footer">
      <a href="{{route('admin.expense_categories.index')}}" class="btn btn-danger btn-sm">
        <i class="fa fa-arrow-left"></i> {{__('Back')}}
      </a>
    </div>
</div>
@endsection
