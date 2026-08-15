@extends('layouts.front')

@section('title', 'Our Branches - Imperial Health Bangladesh')
@section('meta_description', 'Find every Imperial Health branch in Dhaka, with location, contact details, and the doctors available at each hub.')
@section('canonical', route('branches'))

@section('content')
<main class="bg-white font-sans">
    <section class="relative py-24 md:py-36 bg-[#1E293B] overflow-hidden">
        <div class="container mx-auto px-6 relative z-10 text-center">
            <p class="text-xs md:text-sm text-indigo-300 uppercase tracking-[0.2em] font-black mb-4">Our Locations</p>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">Imperial Health Branches</h1>
            <p class="text-xl text-slate-300 font-light leading-relaxed max-w-2xl mx-auto">Find a branch near you, with full contact details, photos, and the doctors available on-site.</p>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                @forelse($branches as $branch)
                <article class="group bg-slate-50 rounded-[36px] overflow-hidden border border-slate-100 hover:bg-white hover:shadow-2xl transition-all duration-500">
                    <a href="{{ route('branch-details', $branch->slug) }}" class="block aspect-[16/10] overflow-hidden bg-slate-200">
                        <img src="{{ asset($branch->feature_image ?: 'assets/front/images/about/reception.jpg') }}" alt="{{ $branch->title ?: $branch->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    </a>
                    <div class="p-8">
                        <a href="{{ route('branch-details', $branch->slug) }}" class="block">
                            <h2 class="text-2xl font-extrabold text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors">{{ $branch->title ?: $branch->name }}</h2>
                        </a>
                        <p class="text-sm text-slate-500 mb-2">{{ $branch->address }}</p>
                        @if($branch->phone)
                        <p class="text-sm text-slate-500 mb-4"><i class="fa-solid fa-phone text-indigo-600 mr-2"></i>{{ $branch->phone }}</p>
                        @endif
                        <p class="text-slate-600 leading-relaxed mb-8">{{ meta_excerpt($branch->description ?? '', 120) }}</p>
                        <a href="{{ route('branch-details', $branch->slug) }}" class="inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl bg-slate-900 text-white font-bold hover:bg-indigo-600 transition-all">
                            View Branch <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </article>
                @empty
                <div class="col-span-full text-center py-12 text-slate-500">
                    <p>No branches found.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
</main>
@endsection
