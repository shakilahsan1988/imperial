@extends('layouts.app')

@section('title')
    {{ __('পদবী এডিট করুন') }}
@endsection

@section('css')
 <link rel="stylesheet" href="{{url('css/select2.css')}}">
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
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{route('admin.roles.index')}}">{{ __('পদবী') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('এডিট পদবী') }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('এডিট পদবী') }}</h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.roles.update',$role['id'])}}">
        @csrf
        @method('put')
        <div class="card-body">
            <div class="col-lg-12">
                    @include('admin.roles._form')
            </div>
        </div>
        <div class="card-footer">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-check"></i>
                    {{__('সেইভ করুন')}}
                </button>
            </div>
        </div>
    </form>

    <!-- /.card-body -->
</div>

@endsection
@section('scripts')
    <script src="{{url('js/admin/roles.js')}}"></script>
    <script>
        (function($){

            "use strict";
            
            @if(isset($role))
                @foreach($role['permissions'] as $permission)
                    $("#{{$permission['permission']['key']}}").prop('checked',true);
                @endforeach
            @endif

        })(jQuery);
    </script>
@endsection