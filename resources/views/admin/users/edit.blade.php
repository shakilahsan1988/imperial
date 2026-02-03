@extends('layouts.app')

@section('title')
{{ __('এডিট ইউজার') }}
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
                    <i class="fa fa-user-circle"></i>
                    {{__('ইউজার')}}
                </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('হোম')}}</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.users.index')}}">{{ __('ইউজার') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('এডিট ইউজার') }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('এডিট ইউজার') }}</h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.users.update',$user['id'])}}">
        @csrf
        @method('put')
        <input type="hidden" id="user_roles" value="{{$user['roles']}}">
        <div class="card-body">
            <div class="col-lg-12">
                @include('admin.users._form')
            </div>
        </div>
        <div class="card-footer">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-primary">
                  <i class="fa fa-check"></i>  {{__('সেইভ করুন')}}
                </button>
            </div>
        </div>
    </form>

    <!-- /.card-body -->
</div>

@endsection
@section('scripts')
    <script src="{{url('js/admin/users.js')}}"></script>
@endsection