@extends('layouts.app')

@section('title')
{{__('Culture Options')}}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="nav-icon fas fa-vial"></i>   
            {{__('Culture Options')}}
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item active">{{__('Culture Options')}}</li>
          </ol>
        </div>
      </div>
    </div>
</div>
@endsection

@section('content')
@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">{{__('Culture Options Table')}}</h3>
      
      @if($u && ($isSuper || $u->hasPermission('create_culture_option')))
      <a href="{{route('admin.culture_options.create')}}" class="btn btn-primary btn-sm float-right">
       <i class="fa fa-plus"></i> {{__('Create')}}
      </a>
      @endif
    </div>
    <div class="card-body">
        <div class="row table-responsive">
            <div class="col-12">
                <table id="culture_options_table" class="table table-striped table-hover table-bordered"  width="100%">
                    <thead>
                        <tr>
                            <th width="10px">#</th>
                            <th>{{__('Option Name')}}</th>
                            <th width="100px">{{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
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