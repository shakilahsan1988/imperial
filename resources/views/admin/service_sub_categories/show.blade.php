@extends('layouts.app')

@section('title')
{{__('Sub Category Details')}}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="fa fa-sitemap"></i>
            {{__('Service Sub Categories')}}
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.service_sub_categories.index')}}">{{__('Service Sub Categories')}}</a></li>
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
      <h3 class="card-title">{{__('Sub Category Details')}}</h3>
      <a href="{{route('admin.service_sub_categories.edit', $service_sub_category->id)}}" class="btn btn-warning btn-sm float-right">
        <i class="fa fa-edit"></i> {{__('Edit')}}
      </a>
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <tr>
          <th width="25%">{{__('Name')}}</th>
          <td>{{$service_sub_category->name}}</td>
        </tr>
        <tr>
          <th>{{__('Category')}}</th>
          <td>{{optional($service_sub_category->category)->name}}</td>
        </tr>
        <tr>
          <th>{{__('Slug')}}</th>
          <td>{{$service_sub_category->slug}}</td>
        </tr>
        <tr>
          <th>{{__('Description')}}</th>
          <td>{{$service_sub_category->description}}</td>
        </tr>
        <tr>
          <th>{{__('Sort Order')}}</th>
          <td>{{$service_sub_category->sort_order}}</td>
        </tr>
        <tr>
          <th>{{__('Status')}}</th>
          <td>
            @if($service_sub_category->status)
              <span class="badge badge-success">{{__('Active')}}</span>
            @else
              <span class="badge badge-danger">{{__('Inactive')}}</span>
            @endif
          </td>
        </tr>
      </table>

      <h5 class="mt-4">{{__('Services')}} <span class="badge badge-info">{{$service_sub_category->services->count()}}</span></h5>
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th>{{__('Name')}}</th>
            <th>{{__('Category')}}</th>
            <th>{{__('Price')}}</th>
          </tr>
        </thead>
        <tbody>
          @forelse($service_sub_category->services as $service)
            <tr>
              <td>{{$service->name}}</td>
              <td>{{__(ucwords($service->category))}}</td>
              <td>{{formated_price($service->price)}}</td>
            </tr>
          @empty
            <tr>
              <td colspan="3" class="text-center text-muted">{{__('No services in this sub category')}}</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      <a href="{{route('admin.service_sub_categories.index')}}" class="btn btn-danger btn-sm">
        <i class="fa fa-arrow-left"></i> {{__('Back')}}
      </a>
    </div>
</div>
@endsection
