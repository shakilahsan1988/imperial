@extends('layouts.auth')
@section('title')
  {{__('Reset Password')}}
@endsection
@section('content')

<form action="{{route('patient.reset_password_submit',$token)}}" method="post" class="validate-form">
    @csrf
    <span class="login100-form-title p-b-43">
        {{__('Reset Password')}}
    </span>
    
    <div class="wrap-input100 validate-input @if($errors->has('password')) alert-validate @endif" data-validate = "{{__('Please enter your password')}}">
        <input class="input100" type="password" name="password" id="password" required>
        <span class="focus-input100"></span>
        <span class="label-input100">{{__('Enter New Password')}}</span>
    </div>

    <div class="wrap-input100 validate-input @if($errors->has('password_confirmation')) alert-validate @endif" data-validate = "{{__('Please enter your password confirmation')}}">
        <input class="input100" type="password" name="password_confirmation" id="password_confirmation" required>
        <span class="focus-input100"></span>
        <span class="label-input100">{{__('Confirm New Password')}}</span>
    </div>

    <div class="container-login100-form-btn">
        <button class="login100-form-btn">
            {{__('Reset Password')}}
        </button>
    </div>
    
    <div class="text-center p-t-46 p-b-20">
        <a href="{{route('patient.login')}}" class="txt1">
            {{__('Login')}}
        </a>
    </div>

</form>

@endsection
