@extends('layouts.front')

@section('title', ($branch->title ?: $branch->name) . ' - Imperial Health Bangladesh')

@section('content')
<main class="bg-white font-sans">
    <section class="relative py-24 md:py-36 bg-[#1E293B] overflow-hidden">
        <div class="absolute inset-0 opacity-25">
            <img src="{{ asset($branch->feature_image ?: 'assets/front/images/about/1.jpg') }}" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/85 to-transparent"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-10 xl:items-end">
                <div class="xl:col-span-7 max-w-4xl">
                    <p class="text-xs md:text-sm text-indigo-300 uppercase tracking-[0.2em] font-black mb-4">Branch Details</p>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">{{ $branch->title ?: $branch->name }}</h1>
                    <p class="text-xl text-slate-300 font-light leading-relaxed">{{ $branch->address }}</p>
                </div>
                <div class="xl:col-span-5">
                    <div class="bg-white/10 backdrop-blur-md rounded-[32px] p-8 text-white border border-white/10 shadow-2xl">
                        <h2 class="text-2xl font-extrabold mb-6">Contact & Visit</h2>
                        <div class="space-y-6">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-indigo-300 font-black mb-2">Address</p>
                                <p class="text-slate-200 leading-relaxed whitespace-pre-line">{{ $branch->address }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-indigo-300 font-black mb-2">Contact Information</p>
                                <p class="text-slate-200 leading-relaxed whitespace-pre-line">{{ $branch->contact_information }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-indigo-300 font-black mb-3">Google Map Location</p>
                                <a href="{{ $branch->google_map_location }}" target="_blank" class="inline-flex w-full items-center justify-center gap-2 px-6 py-4 rounded-2xl bg-white text-slate-900 font-bold hover:bg-indigo-50 transition-all">
                                    Open Location <i class="fa-solid fa-location-arrow text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="space-y-10">
                <div class="bg-slate-50 rounded-[32px] p-8 md:p-10 border border-slate-100">
                    <h2 class="text-3xl font-extrabold text-slate-900 mb-6">About This Branch</h2>
                    <p class="text-slate-600 leading-relaxed whitespace-pre-line">{{ $branch->description }}</p>
                </div>

                @if($branch->doctors->isNotEmpty())
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 mb-6">Related Doctors</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">
                        @foreach($branch->doctors as $doctor)
                        <div class="group bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 relative flex flex-col h-full">
                            <a href="{{ route('book-doctor', ['doctor' => $doctor->slug ?: $doctor->id]) }}" class="block aspect-[4/5] overflow-hidden bg-slate-100">
                                <img src="{{ asset($doctor->image ?: 'assets/front/images/doctor/2.jpg') }}" alt="{{ $doctor->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            </a>
                            <div class="p-6 flex flex-col flex-1">
                                <div class="mb-4">
                                    <h3 class="text-xl font-bold text-slate-900 mb-1 group-hover:text-indigo-600 transition-colors">
                                        <a href="{{ route('book-doctor', ['doctor' => $doctor->slug ?: $doctor->id]) }}">{{ $doctor->name }}</a>
                                    </h3>
                                    <p class="text-sm text-slate-500 font-medium leading-snug">{{ $doctor->designation ?: 'Consultant' }}</p>
                                    <p class="text-xs text-indigo-600 font-bold mt-1">{{ optional($doctor->specialty)->name ?: 'Specialist' }}</p>
                                </div>
                                <div class="text-xs text-slate-500 mb-6 space-y-1 flex-1">
                                    <div class="flex items-start justify-between gap-3">
                                        <span>{{ $branch->title ?: $branch->name }}</span>
                                        <strong class="text-right text-slate-700">
                                            {{ $doctor->pivot->schedule_days ?: 'On request' }}@if($doctor->pivot->schedule_time), {{ $doctor->pivot->schedule_time }}@endif
                                        </strong>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span>In-Hub Fee</span>
                                        <strong class="text-slate-700">{{ formated_price($doctor->consultation_fee ?? 0) }}</strong>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span>Video Fee</span>
                                        <strong class="{{ $doctor->video_consultation_available ? 'text-emerald-700' : 'text-slate-400' }}">
                                            {{ $doctor->video_consultation_available ? formated_price($doctor->video_consultation_fee ?? $doctor->consultation_fee ?? 0) : 'N/A' }}
                                        </strong>
                                    </div>
                                </div>
                                <a href="{{ route('book-doctor', ['doctor' => $doctor->slug ?: $doctor->id]) }}" class="mt-auto flex items-center justify-center w-full py-3 bg-slate-900 group-hover:bg-indigo-600 text-white rounded-xl font-bold text-sm tracking-wide transition-all">
                                    Book Appointment
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($branch->managementTeams->isNotEmpty())
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 mb-6">Management Team</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($branch->managementTeams as $member)
                        <div class="bg-white border border-slate-100 rounded-[28px] p-6 shadow-sm">
                            <div class="flex items-start gap-4">
                                <img src="{{ asset($member->image ?: 'assets/front/images/management/1.jpg') }}" alt="{{ $member->name }}" class="w-24 h-24 rounded-2xl object-cover">
                                <div>
                                    <h3 class="text-xl font-bold text-slate-900">{{ $member->name }}</h3>
                                    <p class="text-sm text-indigo-600 font-medium mb-3">{{ $member->designation }}</p>
                                    <p class="text-sm text-slate-600 leading-relaxed">{{ \Illuminate\Support\Str::limit(strip_tags($member->bio), 180, '...') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($branch->galleries->isNotEmpty())
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 mb-6">Gallery</h2>
                    <div class="masonry-grid" id="branchGalleryGrid">
                        @foreach($branch->galleries as $gallery)
                        <div class="masonry-item">
                            <div class="gallery-item group cursor-pointer rounded-[28px] overflow-hidden border border-slate-100 shadow-sm bg-white" onclick="openBranchGalleryLightbox(this)">
                                <img src="{{ asset($gallery->image) }}" alt="{{ $gallery->name ?: ($branch->title ?: $branch->name) }}" class="w-full h-auto object-cover" loading="lazy">
                                <div class="gallery-overlay">
                                    <i class="fa-solid fa-magnifying-plus"></i>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    @if($branch->galleries->isNotEmpty())
    <div id="branch-gallery-lightbox" class="fixed inset-0 bg-black/90 z-[9999] hidden items-center justify-center opacity-0 transition-opacity duration-300">
        <button onclick="closeBranchGalleryLightbox()" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 z-10">
            <i class="fa-solid fa-times"></i>
        </button>
        <button onclick="navigateBranchGalleryLightbox(-1)" class="absolute left-4 text-white text-3xl hover:text-gray-300 z-10">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button onclick="navigateBranchGalleryLightbox(1)" class="absolute right-4 text-white text-3xl hover:text-gray-300 z-10">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
        <div class="max-w-5xl max-h-[90vh] px-16">
            <img id="branch-gallery-lightbox-img" src="" alt="Gallery Image" class="max-w-full max-h-[90vh] object-contain">
        </div>
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white text-sm">
            <span id="branch-gallery-lightbox-counter">1 / 1</span>
        </div>
    </div>
    @endif
</main>
@endsection

@push('styles')
<style>
    #branchGalleryGrid {
        column-count: 1;
        column-gap: 16px;
    }
    @media (min-width: 640px) {
        #branchGalleryGrid {
            column-count: 2;
        }
    }
    @media (min-width: 1024px) {
        #branchGalleryGrid {
            column-count: 4;
        }
    }
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

@if($branch->galleries->isNotEmpty())
@push('scripts')
<script>
    let branchGalleryItems = [];
    let branchGalleryIndex = 0;

    document.querySelectorAll('#branchGalleryGrid .gallery-item').forEach(function(item, index) {
        const image = item.querySelector('img');
        const overlay = item.querySelector('.gallery-overlay');
        if (!image || !overlay) return;

        branchGalleryItems.push({
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

    function openBranchGalleryLightbox(element) {
        branchGalleryIndex = parseInt(element.dataset.galleryIndex || '0', 10);
        const lightbox = document.getElementById('branch-gallery-lightbox');
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        requestAnimationFrame(() => lightbox.classList.remove('opacity-0'));
        renderBranchGalleryLightbox();
    }

    function closeBranchGalleryLightbox() {
        const lightbox = document.getElementById('branch-gallery-lightbox');
        lightbox.classList.add('opacity-0');
        setTimeout(() => {
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');
        }, 300);
    }

    function navigateBranchGalleryLightbox(direction) {
        if (!branchGalleryItems.length) return;
        branchGalleryIndex = (branchGalleryIndex + direction + branchGalleryItems.length) % branchGalleryItems.length;
        renderBranchGalleryLightbox();
    }

    function renderBranchGalleryLightbox() {
        if (!branchGalleryItems.length) return;
        const current = branchGalleryItems[branchGalleryIndex];
        document.getElementById('branch-gallery-lightbox-img').src = current.src;
        document.getElementById('branch-gallery-lightbox-img').alt = current.alt;
        document.getElementById('branch-gallery-lightbox-counter').textContent = (branchGalleryIndex + 1) + ' / ' + branchGalleryItems.length;
    }

    document.addEventListener('keydown', function(event) {
        const lightbox = document.getElementById('branch-gallery-lightbox');
        if (!lightbox || lightbox.classList.contains('hidden')) return;

        if (event.key === 'Escape') closeBranchGalleryLightbox();
        if (event.key === 'ArrowLeft') navigateBranchGalleryLightbox(-1);
        if (event.key === 'ArrowRight') navigateBranchGalleryLightbox(1);
    });
</script>
@endpush
@endif
