@extends('layouts.front')

@section('title', ($pageSettings['page_name'] ?? 'Blog') . ' - Imperial Health Bangladesh')

@section('content')

<main class="w-full bg-white">

    <section class="relative py-24 md:py-40 bg-[#1E293B] overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="{{ asset($pageSettings['hero_image']) }}" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl">
                <p class="text-xs md:text-sm text-indigo-300 uppercase tracking-[0.2em] font-black mb-4">{{ $pageSettings['page_name'] }}</p>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">{!! $pageSettings['hero_title_html'] !!}</h1>
                <p class="text-xl text-slate-300 font-light leading-relaxed max-w-2xl">{{ $pageSettings['hero_description'] }}</p>
            </div>
        </div>
    </section>

    <section class="py-16 lg:py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                <div class="lg:col-span-5 order-2 lg:order-1">
                    <div class="blog-card">
                        <div class="mb-4">
                            <span class="text-imperial-primary font-bold tracking-wider uppercase text-xs">{{ $pageSettings['founder_badge'] ?? 'Our Story' }}</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-imperial-text mb-6 font-sans leading-tight">
                            {{ $pageSettings['founder_title'] ?? 'Meet Our Founder & Chair of the Board' }}
                        </h1>
                        <p class="text-gray-600 text-lg leading-relaxed mb-8">
                            {{ $pageSettings['founder_description'] ?? '' }}
                        </p>
                        <div class="press-btn mt-4">
                            <a href="{{ $pageSettings['founder_button_url'] ?? '#' }}" rel="noopener noreferrer" class="inline-flex items-center text-imperial-primary font-bold text-lg group hover:text-imperial-dark transition duration-300">
                                {{ $pageSettings['founder_button_text'] ?? 'See Details' }}
                                <i class="fa-solid fa-arrow-right ml-3 transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7 order-1 lg:order-2">
                    <div class="blog-imgwrap relative h-[400px] md:h-[500px] lg:h-[550px] w-full rounded-lg overflow-hidden shadow-xl">
                        <img
                            src="{{ asset($pageSettings['founder_image'] ?? 'assets/front/images/management/1.jpg') }}"
                            alt="Founder"
                            class="w-full h-full object-cover object-center"
                            loading="lazy"
                        >
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white border-t border-gray-100">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8 items-center">
                <div class="lg:col-span-7">
                    <h1 class="text-3xl md:text-4xl font-bold text-imperial-text font-sans">{{ $pageSettings['blog_list_title'] ?? 'Blog list' }}</h1>
                </div>

                <div class="lg:col-span-5">
                    <form method="GET" action="{{ route('blog') }}" class="relative w-full">
                        @if(!empty($categorySlug))
                            <input type="hidden" name="category" value="{{ $categorySlug }}">
                        @endif
                        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Search" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-imperial-primary focus:border-imperial-primary transition shadow-sm text-gray-700">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </form>
                </div>
            </div>

            @if(isset($categories) && $categories->count() > 0)
                <div class="mb-8 flex flex-wrap gap-3">
                    <a href="{{ route('blog', ['q' => $q ?: null]) }}" class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest border {{ empty($categorySlug) ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-slate-600 border-slate-200' }}">All</a>
                    @foreach($categories as $cat)
                        <a href="{{ route('blog', ['category' => $cat->slug, 'q' => $q ?: null]) }}" class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest border {{ ($categorySlug ?? '') === $cat->slug ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-slate-600 border-slate-200' }}">{{ $cat->name }}</a>
                    @endforeach
                </div>
            @endif

            @if($blogs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($blogs as $item)
                        <div class="flex flex-col h-full">
                            <a href="{{ route('blog-details', ['slug' => $item->slug]) }}" class="group block h-full">
                                <div class="w-full h-56 bg-gray-100 rounded-md overflow-hidden mb-4 flex items-center justify-center">
                                    <img src="{{ !empty($item->featured_image) ? asset($item->featured_image) : asset('assets/front/images/management/1.jpg') }}" alt="{{ $item->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-gray-500 mb-1">{{ optional($item->published_at)->format('M d, Y') ?? optional($item->created_at)->format('M d, Y') }}</h3>
                                    <p class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">{{ $item->title }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $blogs->links() }}
                </div>
            @else
                <div class="py-16 text-center text-gray-500 font-medium">
                    No blog items found.
                </div>
            @endif

        </div>
    </section>

</main>

@endsection
