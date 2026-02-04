@extends('layouts.app')

@section('title')
{{__('Edit Report')}}
@endsection

@section('breadcrumb')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">
          <i class="fa fa-flag"></i>
          {{__('Reports')}}
        </h1>
      </div><div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item"><a href="{{route('admin.reports.index')}}">{{__('Reports')}}</a></li>
          <li class="breadcrumb-item active">{{__('Edit Report')}}</li>
        </ol>
      </div></div></div></div>
@endsection

@section('content')
{{-- ইউজার এবং সুপার এডমিন চেক করার জন্য লজিক --}}
@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

{{-- @can('view_report') এর পরিবর্তে কাস্টম লজিক --}}
@if($u && ($isSuper || $u->hasPermission('view_report')))
<div class="row">
  <div class="col-lg-12">

    <a href="{{route('admin.reports.show',$group['id'])}}" class="btn btn-danger float-right mb-3">
      <i class="fa fa-file-pdf"></i> {{__('Print Report')}}
    </a>

    <button type="button" class="btn btn-info float-right mb-3 mr-1" data-toggle="modal" data-target="#patient_modal">
      <i class="fas fa-user-injured"></i> {{__('Patient info')}}
    </button>

  </div>
</div>
@endif

<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title">{{__('Tests')}}</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">
    @if(count($group['tests']))
    <div class="card card-primary card-tabs">
      <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="taps">
          @foreach($group['tests'] as $test)
          <li class="nav-item">
            <a class="nav-link text-capitalize" href="#test_{{$test['id']}}" data-toggle="tab">@if($test['done']) <i class="fa fa-check text-success"></i> @endif {{$test['test']['name']}}</a>
          </li>
          @endforeach
        </ul>
      </div><div class="card-body">
        <div class="tab-content">
          @foreach($group['tests'] as $test)
          <div class="tab-pane overflow-auto" id="test_{{$test['id']}}">
            <form action="{{route('admin.reports.update',$test['id'])}}" method="POST">
              @csrf
              @method('put')
              <table class="table table-hover table-bordered">
                <thead>
                  <th>{{__('Name')}}</th>
                  <th width="100px">{{__('Unit')}}</th>
                  <th width="300px">{{__('Reference Range')}}</th>
                  <th width="300px">{{__('Result')}}</th>
                  <th style="width:200px">{{__('Status')}}</th>
                </thead>
                <tbody>
                  @foreach($test['results'] as $result)
                    @if(isset($result['component']))
                      @if($result['component']['title'])
                        <tr>
                          <td colspan="5">
                            <b>{{$result['component']['name']}}</b>
                          </td>
                        </tr>
                      @else
                        <tr>
                          <td>{{$result['component']['name']}}</td>
                          <td>{{$result['component']['unit']}}</td>
                          <td>{!! $result['component']['reference_range'] !!}</td>
                          <td>
                            @if($result['component']['type']=='text')
                              <input type="text" name="result[{{$result['id']}}][result]" class="form-control"
                              value="{{$result['result']}}">
                            @else
                              <select name="result[{{$result['id']}}][result]" id="" class="form-control select_result">
                                <option value="" value="" disabled selected>{{__('Select result')}}</option>
                                @foreach($result['component']['options'] as $option)
                                  <option value="{{$option['name']}}" @if($option['name']==$result['result']) selected @endif>{{$option['name']}}</option>
                                @endforeach
                                @if(!$result['component']['options']->contains('name',$result['result']))
                                  <option value="{{$result['result']}}" selected>{{$result['result']}}</option>
                                @endif
                                </select>
                            @endif
                          </td>
                          <td style="width:10px" class="text-center">
                            @if($result['component']['status'])
                              <select name="result[{{$result['id']}}][status]" class="form-control select_result">
                                <option value="" value="" disabled selected>{{__('Select status')}}</option>
                                <option value="High" @if($result['status']=='High') selected @endif>{{__('High')}}</option>
                                <option value="Normal" @if($result['status']=='Normal') selected @endif>{{__('Normal')}}</option>
                                <option value="Low" @if($result['status']=='Low') selected @endif>{{__('Low')}}</option>
                                @if(!empty($result['status'])&&!in_array($result['status'],['High','Normal','Low']))
                                  <option value="{{$result['status']}}" selected>{{$result['status']}}</option>
                                @endif
                                </select>
                            @endif
                          </td>
                        </tr>
                      @endif
                    @endif
                  @endforeach
                  <tr>
                    <td colspan="5">
                      <textarea name="comment" id="" cols="30" rows="3" placeholder="{{__('Comment')}}" class="form-control">{{$test['comment']}}</textarea>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="5">
                      <button class="btn btn-primary"><i class="fa fa-check"></i> {{__('Save')}}</button>
                    </td>
                  </tr>
                </tfoot>
              </table>

            </form>
          </div>
          @endforeach
          </div>
        </div></div>
    @else 
       <h6 class="text-center">
          {{__('No data available')}}
       </h6>
    @endif
   
  </div>
  </div>
{{-- কালচার এবং অন্য সব সেকশন একইভাবে কাজ করবে --}}