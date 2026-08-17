@extends('layouts.front')

@section('title', ($page->meta_title ?: $page->title) . ' - Imperial Health Bangladesh')
@section('meta_description', $page->meta_description ?: null)
@section('og_image', $page->hero_image ? asset($page->hero_image) : null)

@section('content')
<main class="overflow-hidden bg-white font-sans">
    <section class="relative overflow-hidden bg-slate-950 py-24 md:py-36">
        <div class="absolute inset-0 opacity-20">
            <img src="{{ asset($page->hero_image ?: 'assets/front/images/index/tour.jpg') }}" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl">
                <p class="mb-4 text-xs font-black uppercase tracking-[0.2em] text-sky-300 md:text-sm">{{ $page->title }}</p>
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
            <div class="dynamic-page-content mx-auto max-w-4xl text-slate-700">
                {!! $page->body_html !!}
            </div>
        </div>
    </section>
</main>
@endsection

@push('styles')
<style>
    .dynamic-page-content { font-size: 1rem; line-height: 1.8; }
    .dynamic-page-content > * + * { margin-top: 1.25rem; }
    .dynamic-page-content h2, .dynamic-page-content h3, .dynamic-page-content h4 { color: #0f172a; font-weight: 800; line-height: 1.25; margin-top: 2.25rem; }
    .dynamic-page-content h2 { font-size: 1.875rem; }
    .dynamic-page-content h3 { font-size: 1.5rem; }
    .dynamic-page-content ul, .dynamic-page-content ol { margin-left: 1.5rem; }
    .dynamic-page-content ul { list-style: disc; }
    .dynamic-page-content ol { list-style: decimal; }
    .dynamic-page-content a { color: #0284c7; font-weight: 700; text-decoration: underline; }
    .dynamic-page-content img { border-radius: 1.25rem; height: auto; max-width: 100%; }
    .dynamic-page-content blockquote { border-left: 4px solid #0ea5e9; color: #475569; padding-left: 1.25rem; }
    @media (min-width: 768px) { .dynamic-page-content { font-size: 1.0625rem; } }
</style>
@endpush
