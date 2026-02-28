@extends('layouts.auth')

@section('title')
  {{__('Patient Login')}}
@endsection

@section('content')

<div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-100 max-w-lg w-full mx-auto">
    <div class="p-10">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">{{__('Welcome Back')}}</h1>
            <p class="text-slate-500 font-medium">{{__('Enter your patient code to access your medical records')}}</p>
        </div>

        @include('partials.validation_errors')

        <form action="{{route('patient.auth.login_submit')}}" method="post" class="space-y-6">
            @csrf
            
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">{{__('Patient Code')}}</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-id-card text-slate-400 group-focus-within:text-indigo-600 transition-colors"></i>
                    </div>
                    <input type="text" name="code" placeholder="{{__('Enter your unique code')}}" required
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-4 pl-12 pr-4 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold text-slate-700 tracking-widest uppercase">
                </div>
            </div>

            <div class="flex items-center justify-between px-1">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-xs font-bold text-slate-500">{{__('Remember Me')}}</span>
                </label>
                <a href="{{route('patient.auth.mail')}}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">{{__('Forgot Code?')}}</a>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-5 rounded-2xl font-black uppercase tracking-widest text-sm shadow-xl shadow-indigo-200 transition-all transform active:scale-95 flex items-center justify-center gap-3">
                <span>{{__('Access Portal')}}</span>
                <i class="fa-solid fa-right-to-bracket"></i>
            </button>
        </form>

        <div class="mt-10 pt-8 border-t border-slate-50 text-center">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">{{__('New to Imperial Health?')}}</p>
            <a href="{{route('patient.auth.register')}}" class="inline-flex items-center gap-2 text-sm font-black text-indigo-600 hover:gap-3 transition-all">
                {{__('Register as a New Patient')}} <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

@endsection
