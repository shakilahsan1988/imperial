@extends('layouts.auth')
@section('title')
  {{__('Login Admin Panel')}}
@endsection
@section('content')

<form action="{{route('admin.auth.login_submit')}}" method="post" class="validate-form">
    @csrf
    <span class="login100-form-title p-b-43">
        {{__('সফটওয়্যারে লগইন করুন')}}
    </span>
    
    <div class="wrap-input100 validate-input @if($errors->has('email')) error-validation @endif">
        <input class="input100" type="email" name="email" id="email" value="{{old('email')}}" required>
        <span class="focus-input100"></span>
        <span class="label-input100">{{__('ইমেইল')}}</span>
    </div>
    
    
    <div class="wrap-input100 validate-input @if($errors->has('password')) error-validation @endif">
        <input class="input100" type="password" name="password" id="password" required>
        <span class="focus-input100"></span>
        <span class="label-input100">{{__('পাসওয়ার্ড')}}</span>
    </div>

    <div class="flex-sb-m w-full p-t-3 p-b-32">
        <div class="contact100-form-checkbox">
            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember">
            <label class="label-checkbox100" for="ckb1">
                {{__('আমাকে মনে রাখুন')}}
            </label>
        </div>

        <div>
            <a href="{{route('admin.reset.mail')}}" class="txt1">
                {{__('পাসওয়ার্ড ভুলে গেছেন?')}}
            </a>
        </div>
    </div>


    <div class="container-login100-form-btn">
        <button class="login100-form-btn" type="submit">
            {{__('লগইন')}}
        </button>
    </div>


</form>



@endsection

@section('scripts')
@endsection