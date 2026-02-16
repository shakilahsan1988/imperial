@extends('layouts.front')

@section('title', 'Gallery - Imperial Health Bangladesh')

@section('content')

<!-- Gallery Section -->
<section class="py-16 lg:py-24 bg-white">
    <div class="container mx-auto px-6">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-imperial-text mb-4">Our Gallery</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Explore moments from our hospital, events, and healthcare services.</p>
        </div>

        <!-- Masonry Grid -->
        <div class="masonry-grid" id="galleryGrid">
            
            <!-- Event Images -->
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/event/1.jpg') }}" 
                         alt="Event 1" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>
            
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/event/2.webp') }}" 
                         alt="Event 2" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>
            
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/event/3.jpg') }}" 
                         alt="Event 3" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>
            
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/event/4.jpg') }}" 
                         alt="Event 4" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>
            
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/event/5.jpg') }}" 
                         alt="Event 5" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>
            
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/event/6.jpg') }}" 
                         alt="Event 6" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>

            <!-- About Images -->
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/about/1.jpg') }}" 
                         alt="About 1" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>
            
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/about/2.jpg') }}" 
                         alt="About 2" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>
            
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/about/3.jpg') }}" 
                         alt="About 3" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>
            
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/about/4.jpg') }}" 
                         alt="About 4" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>
            
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/about/5.jpg') }}" 
                         alt="About 5" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>
            
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/about/6.jpg') }}" 
                         alt="About 6" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>

            <!-- Services Images -->
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/services/services.jpg') }}" 
                         alt="Services" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>
            
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/services/cardiology.jpg') }}" 
                         alt="Cardiology" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>
            
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/services/consult.jpg') }}" 
                         alt="Consultation" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>

            <!-- Index/Facility Images -->
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/index/tour.jpg') }}" 
                         alt="Facility Tour" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>
            
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/index/why-imperial.jpg') }}" 
                         alt="Why Imperial" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>
            
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/index/diagnosis.jpeg') }}" 
                         alt="Diagnosis" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>

            <!-- More Event Images -->
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/event/7.jpg') }}" 
                         alt="Event 7" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>
            
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/event/8.jpg') }}" 
                         alt="Event 8" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>
            
            <div class="masonry-item">
                <div class="gallery-item group cursor-pointer" onclick="openLightbox(this)">
                    <img src="{{ asset('assets/front/images/event/9.jpg') }}" 
                         alt="Event 9" 
                         class="w-full h-auto object-cover"
                         loading="lazy">
                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-plus"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 bg-black/90 z-[9999] hidden items-center justify-center opacity-0 transition-opacity duration-300">
    <!-- Close Button -->
    <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 z-10">
        <i class="fa-solid fa-times"></i>
    </button>
    
    <!-- Prev/Next Buttons -->
    <button onclick="navigateLightbox(-1)" class="absolute left-4 text-white text-3xl hover:text-gray-300 z-10">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button onclick="navigateLightbox(1)" class="absolute right-4 text-white text-3xl hover:text-gray-300 z-10">
        <i class="fa-solid fa-chevron-right"></i>
    </button>
    
    <!-- Image Container -->
    <div class="max-w-5xl max-h-[90vh] px-16">
        <img id="lightbox-img" src="" alt="Gallery Image" class="max-w-full max-h-[90vh] object-contain">
    </div>
    
    <!-- Image Counter -->
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white text-sm">
        <span id="lightbox-counter">1 / 1</span>
    </div>
</div>

@endsection
