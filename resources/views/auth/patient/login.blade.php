@extends('layouts.auth')
@section('title')
  {{__('Patient Login')}}
@endsection
@section('content')

<form action="{{route('patient.login_submit')}}" method="post" class="validate-form">
    @csrf
    <span class="login100-form-title p-b-43">
        {{__('Login to software')}}
    </span>
    
    <div class="wrap-input100 validate-input @if($errors->has('email')) alert-validate @endif" data-validate="{{__('Please enter your email')}}">
        <input class="input100" type="text" name="email" id="email" value="{{old('email')}}" required>
        <span class="focus-input100"></span>
        <span class="label-input100">{{__('Email')}}</span>
    </div>
    
    
    <div class="wrap-input100 validate-input @if($errors->has('password')) alert-validate @endif" data-validate="{{__('Please enter your password')}}">
        <input class="input100" type="password" name="password" id="password" required>
        <span class="focus-input100"></span>
        <span class="label-input100">{{__('Password')}}</span>
    </div>

    <div class="flex-sb-m w-full p-t-3 p-b-32">
        <div class="contact100-form-checkbox">
            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember">
            <label class="label-checkbox100" for="ckb1">
                {{__('Remember Me')}}
            </label>
        </div>

        <div>
            <a href="{{route('patient.mail')}}" class="txt1">
                {{__('Forgot Password?')}}
            </a>
        </div>
    </div>


    <div class="container-login100-form-btn">
        <button class="login100-form-btn" type="submit">
            {{__('Login')}}
        </button>
    </div>
    
    <div class="text-center p-t-46 p-b-20">
        <span class="txt2">
            {{__('or sign up using')}}
        </span>
    </div>

    <div class="login100-form-social flex-c-m">
        <a href="#" class="login100-form-social-item flex-c-m bg1 m-r-5">
            <i class="fab fa-facebook-f" aria-hidden="true"></i>
        </a>

        <a href="#" class="login100-form-social-item flex-c-m bg2 m-r-5">
            <i class="fab fa-twitter" aria-hidden="true"></i>
        </a>
    </div>
</form>

@endsection
