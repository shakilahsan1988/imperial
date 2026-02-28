@extends('layouts.front')

@section('title', 'Patient Login - Imperial Health')

@section('content')
<main class="min-h-screen bg-slate-50 flex items-center justify-center py-20 px-4">
    <div class="max-w-md w-full bg-white rounded-[40px] shadow-2xl border border-slate-100 overflow-hidden">
        <div class="p-10 md:p-14">
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-paper-plane text-2xl"></i>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">{{__('Secure Login')}}</h1>
                <p class="text-slate-500 font-medium">{{__('Enter your email to receive a login code')}}</p>
            </div>

            @include('partials.validation_errors')

            <form action="{{route('patient.auth.login_submit')}}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">{{__('Email Address')}}</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-envelope text-slate-400 group-focus-within:text-indigo-600 transition-colors"></i>
                        </div>
                        <input type="email" name="email" placeholder="name@example.com" required
                               class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-4 pl-12 pr-4 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700">
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-5 rounded-2xl font-black uppercase tracking-widest text-sm shadow-xl shadow-indigo-200 transition-all transform active:scale-95 flex items-center justify-center gap-3">
                    <span>{{__('Get Verification Code')}}</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="mt-10 pt-8 border-t border-slate-50">
                <div class="flex items-center gap-4 text-slate-400 mb-6">
                    <div class="h-px bg-slate-100 flex-grow"></div>
                    <span class="text-[10px] font-bold uppercase tracking-widest">{{__('Why Email?')}}</span>
                    <div class="h-px bg-slate-100 flex-grow"></div>
                </div>
                <p class="text-xs text-center text-slate-500 leading-relaxed">
                    {{__('Passwordless login is more secure and convenient. No more forgotten passwords. Your account is automatically created on your first login.')}}
                </p>
            </div>
        </div>
    </div>
</main>
@endsection
