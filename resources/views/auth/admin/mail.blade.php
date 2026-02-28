@extends('layouts.auth')
@section('title')
  {{__('Reset Password')}}
@endsection
@section('content')

<form action="{{route('admin.mail_submit')}}" method="post" class="validate-form">
    @csrf
    <span class="login100-form-title p-b-43">
        {{__('Send Password Reset Link')}}
    </span>
    
    <div class="wrap-input100 validate-input @if($errors->has('email')) alert-validate @endif" data-validate = "{{__('Please enter your email')}}">
        <input class="input100" type="email" name="email" id="email" value="{{old('email')}}" required>
        <span class="focus-input100"></span>
        <span class="label-input100">{{__('Email')}}</span>
    </div>

    <div class="container-login100-form-btn">
        <button class="login100-form-btn">
            {{__('Send Email')}}
        </button>
    </div>
    
    <div class="text-center p-t-46 p-b-20">
        <a href="{{route('admin.login')}}" class="txt1">
            {{__('Login')}}
        </a>
    </div>

</form>

@endsection
