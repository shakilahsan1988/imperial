@extends('layouts.front')

@section('title', ($page->meta_title ?: $page->title) . ' - Imperial Health Bangladesh')

@section('content')
<main class="bg-white font-sans overflow-hidden">
    <section class="relative py-24 md:py-40 bg-[#1E293B] overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="{{ asset($page->hero_image ?: 'assets/front/images/index/tour.jpg') }}" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl">
                <p class="text-xs md:text-sm text-indigo-300 uppercase tracking-[0.2em] font-black mb-4">{{ $page->title }}</p>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">
                    {!! $page->hero_title_html ?: e($page->title) !!}
                </h1>
                @if(!empty($page->hero_description))
                    <p class="text-xl text-slate-300 font-light leading-relaxed max-w-2xl">{{ $page->hero_description }}</p>
                @endif
            </div>
        </div>
    </section>

    <section class="py-16 md:py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto leading-relaxed text-slate-700 whitespace-pre-line">
                {{ $page->body_html }}
            </div>
        </div>
    </section>
</main>
@endsection
