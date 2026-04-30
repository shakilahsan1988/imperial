@extends('layouts.front')

@section('title', ($pageSettings['page_name'] ?? 'Gallery') . ' - Imperial Health Bangladesh')

@php
    $hasManagedGroups = $galleryGroups->contains(fn ($group) => $group->images->isNotEmpty());
@endphp

@section('content')

<section class="relative py-24 md:py-40 bg-[#1E293B] overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <img src="{{ asset($pageSettings['hero_image']) }}" alt="Gallery" class="w-full h-full object-cover">
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
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-imperial-text mb-4">{{ $pageSettings['page_name'] }}</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">{{ strip_tags($pageSettings['hero_description']) }}</p>
        </div>

        @if($hasManagedGroups)
            @foreach($galleryGroups as $group)
                @continue($group->images->isEmpty())

                <div class="mb-16">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <h3 class="text-2xl md:text-3xl font-bold text-slate-900">{{ $group->name }}</h3>
                        <span class="text-sm uppercase tracking-[0.2em] text-slate-400">{{ $group->images->count() }} Images</span>
                    </div>

                    <div class="masonry-grid">
                        @foreach($group->images as $image)
                            <div class="masonry-item">
                                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                                    <img
                                        src="{{ asset($image->image) }}"
                                        alt="{{ $image->name ?: $group->name }}"
                                        class="w-full h-auto object-cover"
                                        loading="lazy"
                                    >
                                    <div class="gallery-overlay">
                                        <i class="fa-solid fa-magnifying-plus"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="max-w-2xl mx-auto text-center py-16 border border-slate-200 rounded-[32px] bg-slate-50">
                <h3 class="text-2xl font-bold text-slate-900 mb-3">No gallery images yet</h3>
                <p class="text-slate-600">Add gallery groups and images from the admin gallery settings page to publish them here.</p>
            </div>
        @endif
    </div>
</section>

<div id="lightbox" class="fixed inset-0 bg-black/90 z-[9999] hidden items-center justify-center opacity-0 transition-opacity duration-300">
    <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 z-10">
        <i class="fa-solid fa-times"></i>
    </button>
    <button onclick="navigateLightbox(-1)" class="absolute left-4 text-white text-3xl hover:text-gray-300 z-10">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button onclick="navigateLightbox(1)" class="absolute right-4 text-white text-3xl hover:text-gray-300 z-10">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

    <div class="max-w-5xl max-h-[90vh] px-16">
        <img id="lightbox-img" src="" alt="Gallery Image" class="max-w-full max-h-[90vh] object-contain">
    </div>

    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white text-sm">
        <span id="lightbox-counter">1 / 1</span>
    </div>
</div>

@endsection

@push('styles')
<style>
    .gallery-overlay {
        background: linear-gradient(to top, rgba(15, 23, 42, 0.78), rgba(15, 23, 42, 0.2));
        position: absolute;
        inset: 0;
        opacity: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #fff;
        transition: opacity 0.3s ease;
    }
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    .gallery-overlay-title {
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }
</style>
@endpush

@push('scripts')
<script>
    let galleryItems = [];
    let galleryIndex = 0;

    document.querySelectorAll('.gallery-item').forEach(function (item, index) {
        const image = item.querySelector('img');
        const overlay = item.querySelector('.gallery-overlay');
        if (!image || !overlay) return;

        galleryItems.push({
            src: image.getAttribute('src'),
            alt: image.getAttribute('alt') || 'Gallery',
        });

        if (!overlay.querySelector('.gallery-overlay-title')) {
            const title = document.createElement('span');
            title.className = 'gallery-overlay-title';
            title.textContent = image.getAttribute('alt') || 'Gallery';
            overlay.appendChild(title);
        }

        item.dataset.galleryIndex = index;
    });

    function openLightbox(element) {
        galleryIndex = parseInt(element.dataset.galleryIndex || '0', 10);
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        requestAnimationFrame(() => lightbox.classList.remove('opacity-0'));
        renderLightbox();
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.add('opacity-0');
        setTimeout(function () {
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');
        }, 300);
    }

    function navigateLightbox(direction) {
        if (!galleryItems.length) return;
        galleryIndex = (galleryIndex + direction + galleryItems.length) % galleryItems.length;
        renderLightbox();
    }

    function renderLightbox() {
        if (!galleryItems.length) return;
        const current = galleryItems[galleryIndex];
        document.getElementById('lightbox-img').src = current.src;
        document.getElementById('lightbox-img').alt = current.alt;
        document.getElementById('lightbox-counter').textContent = (galleryIndex + 1) + ' / ' + galleryItems.length;
    }

    document.addEventListener('keydown', function (event) {
        const lightbox = document.getElementById('lightbox');
        if (lightbox.classList.contains('hidden')) return;

        if (event.key === 'Escape') closeLightbox();
        if (event.key === 'ArrowLeft') navigateLightbox(-1);
        if (event.key === 'ArrowRight') navigateLightbox(1);
    });

    document.getElementById('lightbox').addEventListener('click', function (event) {
        if (event.target === this) {
            closeLightbox();
        }
    });
</script>
@endpush
