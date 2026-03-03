@extends('layouts.front')

@section('title', ($blog->meta_title ?? $blog->title) . ' - Imperial Health Bangladesh')

@section('content')
<article class="w-full bg-white">
    <section class="relative py-20 md:py-28 bg-[#1E293B] overflow-hidden">
        <div class="absolute inset-0 opacity-25">
            <img src="{{ !empty($blog->featured_image) ? asset($blog->featured_image) : asset('assets/front/images/management/1.jpg') }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/85 to-transparent"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl">
                <p class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-indigo-200 text-[10px] md:text-xs font-black uppercase tracking-widest mb-5">
                    <i class="fa-solid fa-book-open"></i>
                    {{ optional($blog->category)->name ?? 'Blog' }}
                </p>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight leading-tight mb-6">
                    {{ $blog->title }}
                </h1>
                <div class="flex flex-wrap items-center gap-5 text-slate-300 text-sm font-medium">
                    <span class="inline-flex items-center gap-2"><i class="fa-regular fa-calendar"></i> {{ optional($blog->published_at)->format('M d, Y') ?? optional($blog->created_at)->format('M d, Y') }}</span>
                    <span class="inline-flex items-center gap-2"><i class="fa-regular fa-user"></i> {{ $blog->author_name ?: 'Imperial Editorial Desk' }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="py-14 md:py-20">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12">

                <div class="lg:col-span-8">
                    <figure class="overflow-hidden rounded-3xl shadow-2xl border border-slate-100 mb-10">
                        <img src="{{ !empty($blog->featured_image) ? asset($blog->featured_image) : asset('assets/front/images/management/1.jpg') }}" alt="{{ $blog->title }}" class="w-full h-[320px] md:h-[480px] object-cover">
                    </figure>

                    <div class="prose prose-lg max-w-none prose-p:text-slate-700 prose-p:leading-8 prose-headings:text-slate-900">
                        {!! $blog->content !!}
                    </div>
                </div>

                <aside class="lg:col-span-4">
                    <div class="sticky top-28 space-y-6">
                        @if(!empty($blog->meta_description))
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                                <h4 class="text-sm font-black uppercase tracking-widest text-slate-500 mb-4">Summary</h4>
                                <p class="text-sm text-slate-700 leading-relaxed">{{ $blog->meta_description }}</p>
                            </div>
                        @endif

                        @if(isset($relatedBlogs) && $relatedBlogs->count() > 0)
                            <div class="rounded-3xl border border-slate-200 bg-white p-6">
                                <h4 class="text-sm font-black uppercase tracking-widest text-slate-500 mb-4">Related Blogs</h4>
                                <div class="space-y-4">
                                    @foreach($relatedBlogs as $related)
                                        <a href="{{ route('blog-details', ['slug' => $related->slug]) }}" class="block group">
                                            <p class="text-sm font-semibold text-slate-800 group-hover:text-indigo-600 transition">{{ $related->title }}</p>
                                            <p class="text-xs text-slate-400 mt-1">{{ optional($related->published_at)->format('M d, Y') ?? optional($related->created_at)->format('M d, Y') }}</p>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <a href="{{ route('blog') }}" class="block text-center rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white py-3.5 font-black uppercase tracking-widest text-xs transition">
                            Back To Blog List
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</article>
@endsection
