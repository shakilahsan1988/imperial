@extends('layouts.auth')

@section('title')
  {{__('Patient Registration')}}
@endsection

@section('content')

<div class="bg-white rounded-[40px] shadow-2xl overflow-hidden border border-slate-100 max-w-2xl w-full mx-auto my-10">
    <div class="p-10 md:p-16">
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-3">{{__('Create Account')}}</h1>
            <p class="text-slate-500 font-medium leading-relaxed">{{__('Join Imperial Health to manage your medical records and book appointments with ease.')}}</p>
        </div>

        @include('partials.validation_errors')

        <form action="{{route('patient.auth.register_submit')}}" method="post" class="space-y-8">
            @csrf
            
            <!-- Basic Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">{{__('Full Name')}}</label>
                    <input type="text" name="name" placeholder="e.g. John Doe" required value="{{old('name')}}"
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-4 px-6 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">{{__('Phone Number')}}</label>
                    <input type="tel" name="phone" placeholder="e.g. +880" required value="{{old('phone')}}"
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-4 px-6 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">{{__('Email Address')}}</label>
                <input type="email" name="email" placeholder="name@example.com" required value="{{old('email')}}"
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-4 px-6 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700">
            </div>

            <!-- Demographics -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">{{__('Gender')}}</label>
                    <select name="gender" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-4 px-6 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700 appearance-none">
                        <option value="" disabled selected>{{__('Select Gender')}}</option>
                        <option value="male" @if(old('gender')=='male') selected @endif>{{__('Male')}}</option>
                        <option value="female" @if(old('gender')=='female') selected @endif>{{__('Female')}}</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">{{__('Date of Birth')}}</label>
                    <input type="date" name="dob" required value="{{old('dob')}}"
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-4 px-6 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700 uppercase">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">{{__('Address')}}</label>
                <textarea name="address" rows="3" placeholder="{{__('Enter your permanent address')}}" required
                          class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-4 px-6 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700">{{old('address')}}</textarea>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-5 rounded-2xl font-black uppercase tracking-widest text-sm shadow-xl shadow-indigo-200 transition-all transform active:scale-95 flex items-center justify-center gap-3">
                    <span>{{__('Create My Account')}}</span>
                    <i class="fa-solid fa-user-plus"></i>
                </button>
            </div>
        </form>

        <div class="mt-12 pt-8 border-t border-slate-50 text-center">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">{{__('Already a patient?')}}</p>
            <a href="{{route('patient.auth.login')}}" class="inline-flex items-center gap-2 text-sm font-black text-indigo-600 hover:gap-3 transition-all">
                {{__('Sign In to Your Account')}} <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

@endsection
