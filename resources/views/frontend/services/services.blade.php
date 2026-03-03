@extends('layouts.front')

@section('title', ($pageSettings['page_name'] ?? 'Our Services') . ' - Imperial Health Bangladesh')

@section('content')

    @php
        $currencyCode = get_currency();
        $currencySymbols = [
            'BDT' => '৳',
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'INR' => '₹',
        ];
        $currencyPrefix = $currencySymbols[$currencyCode] ?? ($currencyCode . ' ');
    @endphp

    <main class="bg-white font-sans">
        <!-- HERO SECTION -->
        <section class="relative py-20 md:py-32 bg-[#1E293B] overflow-hidden">
            <div class="absolute inset-0 opacity-30">
                <img src="{{ asset($pageSettings['hero_image'] ?? 'assets/front/images/services/services.jpg') }}" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>

            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-3xl">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">
                        {!! $pageSettings['hero_title_html'] ?? 'Comprehensive <span class="text-indigo-400">Healthcare</span> Solutions' !!}
                    </h1>
                    <p class="text-xl text-slate-300 font-light leading-relaxed max-w-2xl">
                        {{ $pageSettings['hero_description'] ?? 'From primary consultations to advanced diagnostics, we provide all your outpatient needs under one professional roof.' }}
                    </p>
                </div>
            </div>
        </section>

        <!-- SERVICES OVERVIEW -->
        <section class="container mx-auto px-4 py-24">
            <div class="text-center max-w-3xl mx-auto mb-20 reveal">
                <div class="inline-block px-4 py-1.5 bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase tracking-widest rounded-full mb-6">{{ $pageSettings['section_badge'] ?? 'Patient-Centered Care' }}</div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">{{ $pageSettings['section_title'] ?? 'Integrated Services for Everyday Health Needs' }}</h2>
                <p class="text-lg text-slate-600 leading-relaxed">{{ $pageSettings['section_description'] ?? 'We combine consultation, diagnostics, preventive screening, and digital follow-up to ensure every patient receives complete and coordinated care.' }}</p>
            </div>

            <!-- Block 1 -->
            <div class="flex flex-col md:flex-row items-center gap-16 mb-24 reveal">
                <div class="md:w-1/2">
                    <div class="inline-block px-4 py-1.5 bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase tracking-widest rounded-full mb-6">{{ $pageSettings['block_1_badge'] ?? 'Expert Guidance' }}</div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">{{ $pageSettings['block_1_title'] ?? 'Personalized Consultations' }}</h2>
                    <p class="text-lg text-slate-600 leading-relaxed mb-8">{{ $pageSettings['block_1_description'] ?? 'Our doctors spend meaningful time understanding each patient. Consult in person or virtually and receive practical care plans tailored to your condition and goals.' }}</p>
                    <a href="{{ $pageSettings['block_1_button_url'] ?? '/service-details' }}" class="inline-flex items-center gap-3 text-indigo-600 font-bold group">
                        {{ $pageSettings['block_1_button_text'] ?? 'Explore Specialities' }}
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                    </a>
                </div>
                <div class="md:w-1/2">
                    <img src="{{ asset($pageSettings['block_1_image'] ?? 'assets/front/images/services/con4.jpg') }}" class="rounded-3xl shadow-2xl" alt="Consultation">
                </div>
            </div>

            <!-- Block 2 -->
            <div class="flex flex-col md:flex-row-reverse items-center gap-16 mb-24 reveal">
                <div class="md:w-1/2">
                    <div class="inline-block px-4 py-1.5 bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-widest rounded-full mb-6">{{ $pageSettings['block_2_badge'] ?? 'Advanced Diagnostics' }}</div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">{{ $pageSettings['block_2_title'] ?? 'Reliable Testing with Modern Technology' }}</h2>
                    <p class="text-lg text-slate-600 leading-relaxed mb-8">{{ $pageSettings['block_2_description'] ?? 'Our laboratories and diagnostics workflow are designed for consistency, speed, and clinical accuracy, helping doctors and patients make timely decisions with confidence.' }}</p>
                    <a href="{{ $pageSettings['block_2_button_url'] ?? '/lab-test' }}" class="btn-primary text-white px-8 py-4 rounded-2xl font-bold inline-block shadow-xl shadow-indigo-200">{{ $pageSettings['block_2_button_text'] ?? 'View Lab Tests' }}</a>
                </div>
                <div class="md:w-1/2">
                    <img src="{{ asset($pageSettings['block_2_image'] ?? 'assets/front/images/services/con3.jpeg') }}" class="rounded-3xl shadow-2xl" alt="Diagnostics">
                </div>
            </div>

            <!-- Dynamic Service Catalog -->
            <div class="text-center max-w-3xl mx-auto mb-12 reveal">
                <h3 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">{{ $pageSettings['catalog_title'] ?? 'Available Services' }}</h3>
                <p class="text-lg text-slate-600 leading-relaxed">{{ $pageSettings['catalog_description'] ?? 'Browse our active services below. Each test or procedure includes essential details to help you choose the right care path.' }}</p>
            </div>

            @if($services->count() > 0)
                @php
                    $categories = [
                        'laboratory' => 'Laboratory',
                        'imaging' => 'Imaging',
                        'procedure' => 'Procedure',
                    ];
                @endphp

                <div class="mb-8 flex flex-wrap justify-center gap-3" id="service-category-tabs">
                    @foreach($categories as $key => $label)
                        <button type="button"
                                class="service-tab-btn px-5 py-2.5 rounded-full text-xs font-black uppercase tracking-widest border border-slate-200 bg-white text-slate-600 hover:border-indigo-200 hover:text-indigo-600 transition-all"
                                data-category="{{ $key }}">
                            {{ $label }} ({{ $services->where('category', $key)->count() }})
                        </button>
                    @endforeach
                </div>

                @foreach($categories as $key => $label)
                    <div class="service-category-panel hidden" data-category="{{ $key }}">
                        @php $categoryServices = $services->where('category', $key); @endphp

                        @if($categoryServices->count() > 0)
                            <div class="mb-4">
                                <h4 class="text-sm md:text-base font-extrabold text-slate-800 uppercase tracking-widest">{{ $label }} Services</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach($categoryServices as $service)
                                    <div class="p-8 bg-slate-50 rounded-3xl border border-slate-100 hover:bg-white hover:shadow-2xl hover:border-indigo-100 transition-all duration-500 group">
                                        <div class="mb-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest {{ $service->category_badge }}">
                                                {{ ucfirst($service->category ?? 'service') }}
                                            </span>
                                        </div>
                                        <h5 class="text-lg font-bold text-slate-900 mb-3">{{ $service->name }}</h5>
                                        @if(!empty($service->description))
                                            <p class="text-slate-500 text-sm leading-relaxed mb-6">{{ \Illuminate\Support\Str::limit(strip_tags((string) $service->description), 120, '...') }}</p>
                                        @else
                                            <p class="text-slate-400 text-sm leading-relaxed mb-6">-</p>
                                        @endif
                                        <div class="text-sm font-semibold text-slate-500">
                                            {{ $currencyPrefix }}{{ number_format((float) $service->price, 2) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-8 bg-slate-50 rounded-2xl text-center text-slate-500 font-medium">
                                {{ $pageSettings['empty_state_text'] ?? 'No services are available right now. Please check again shortly.' }}
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="p-8 bg-slate-50 rounded-2xl text-center text-slate-500 font-medium">
                    {{ $pageSettings['empty_state_text'] ?? 'No services are available right now. Please check again shortly.' }}
                </div>
            @endif

        </section>
    </main>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('.service-tab-btn');
        const panels = document.querySelectorAll('.service-category-panel');

        function activateCategory(category) {
            tabButtons.forEach((btn) => {
                const isActive = btn.dataset.category === category;
                btn.classList.toggle('bg-indigo-600', isActive);
                btn.classList.toggle('text-white', isActive);
                btn.classList.toggle('border-indigo-600', isActive);
                btn.classList.toggle('bg-white', !isActive);
                btn.classList.toggle('text-slate-600', !isActive);
                btn.classList.toggle('border-slate-200', !isActive);
            });

            panels.forEach((panel) => {
                panel.classList.toggle('hidden', panel.dataset.category !== category);
            });
        }

        tabButtons.forEach((btn) => {
            btn.addEventListener('click', function () {
                activateCategory(this.dataset.category);
            });
        });

        if (tabButtons.length > 0) {
            activateCategory(tabButtons[0].dataset.category);
        }
    });
</script>
@endpush
