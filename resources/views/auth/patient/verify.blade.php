@extends('layouts.front')

@section('title', 'Verify Code - Imperial Health')

@section('content')
<main class="min-h-screen bg-slate-50 flex items-center justify-center py-20 px-4">
    <div class="max-w-md w-full bg-white rounded-[40px] shadow-2xl border border-slate-100 overflow-hidden">
        <div class="p-10 md:p-14">
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-user-shield text-2xl"></i>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">{{__('Verify Identity')}}</h1>
                <p class="text-slate-500 font-medium leading-relaxed">
                    {{__('We sent a 6-digit code to')}} <br>
                    <span class="text-slate-900 font-bold">{{ session('login_email') }}</span>
                </p>
            </div>

            @include('partials.validation_errors')

            <form action="{{route('patient.auth.verify_submit')}}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">{{__('Verification Code')}}</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-key text-slate-400 group-focus-within:text-indigo-600 transition-colors"></i>
                        </div>
                        <input type="text" name="otp" placeholder="000000" required maxlength="6"
                               class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-4 pl-12 pr-4 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-black text-slate-700 tracking-[10px] text-center text-xl">
                    </div>
                </div>

                <button type="submit" class="w-full bg-slate-900 hover:bg-indigo-600 text-white py-5 rounded-2xl font-black uppercase tracking-widest text-sm shadow-xl transition-all transform active:scale-95 flex items-center justify-center gap-3">
                    <span>{{__('Verify & Login')}}</span>
                    <i class="fa-solid fa-check"></i>
                </button>
            </form>

            <div class="mt-10 pt-8 border-t border-slate-50 text-center">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">{{__("Didn't receive the code?")}}</p>
                <form action="{{route('patient.auth.login_submit')}}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('login_email') }}">
                    <button type="submit" class="text-sm font-black text-indigo-600 hover:text-indigo-700 transition-colors">
                        {{__('Resend New Code')}}
                    </button>
                </form>
                <a href="{{route('patient.auth.login')}}" class="block mt-4 text-[10px] font-bold text-slate-400 uppercase hover:text-indigo-600">
                    {{__('Change Email Address')}}
                </a>
            </div>
        </div>
    </div>
</main>
@endsection
