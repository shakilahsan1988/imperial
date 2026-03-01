@extends('layouts.front')

@section('title', 'Diagnostics & Lab Tests - Imperial Health Bangladesh')

@section('content')

    <main class="bg-white font-sans">
        <!-- MODERN HERO SECTION -->
        <section class="relative py-20 md:py-32 bg-[#1E293B] overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <img src="https://img.freepik.com/free-photo/coronavirus-vaccine-lab-with-samples_23-2148920827.jpg" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>
            
            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-3xl">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">
                        Precision <span class="text-indigo-400">Diagnostics</span> for Better Health
                    </h1>
                    <p class="text-xl text-slate-300 font-light leading-relaxed max-w-2xl">
                        Experience world-class laboratory services with international quality standards and 99.9% accuracy in results.
                    </p>
                </div>
            </div>
        </section>

        <!-- FEATURE CARDS -->
        <section class="relative z-20 -mt-12 px-4">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                        $features = [
                            ['title' => 'Quality Assured', 'desc' => 'International standards & ISO protocols.', 'icon' => 'fa-award', 'color' => 'indigo'],
                            ['title' => 'Rapid Turnaround', 'desc' => 'Fast & reliable test result delivery.', 'icon' => 'fa-bolt', 'color' => 'emerald'],
                            ['title' => 'Home Collection', 'desc' => 'Sample collection from your doorstep.', 'icon' => 'fa-house-medical', 'color' => 'rose'],
                        ];
                    @endphp
                    @foreach($features as $f)
                    <div class="bg-white rounded-2xl shadow-xl p-8 border border-slate-50 flex items-center gap-6 group hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 bg-{{$f['color']}}-50 text-{{$f['color']}}-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fa-solid {{$f['icon']}} text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 mb-1 tracking-tight">{{$f['title']}}</h3>
                            <p class="text-slate-500 text-xs leading-relaxed">{{$f['desc']}}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- SEARCH & FILTER CONSOLE -->
        <section class="container mx-auto px-4 py-16">
            <div class="bg-slate-50 rounded-3xl p-6 mb-10 border border-slate-100 shadow-sm">
                <div class="flex flex-col md:flex-row gap-6 items-center">
                    <!-- Search -->
                    <div class="relative w-full md:w-1/2 group">
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-slate-400 group-focus-within:text-indigo-600 transition-colors"></i>
                        </div>
                        <input type="text" id="customSearch" placeholder="Search for tests or procedures..." 
                               class="w-full bg-white border border-slate-200 rounded-2xl py-4 pl-12 pr-4 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700">
                    </div>

                    <!-- Category Filter -->
                    <div class="flex items-center gap-4 w-full md:w-1/2">
                        <span class="text-xs font-black uppercase tracking-widest text-slate-400 whitespace-nowrap">Filter by:</span>
                        <div class="flex-grow flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                            <button onclick="filterTable('', this)" class="category-btn active px-6 py-2 bg-indigo-600 text-white rounded-full text-xs font-bold shadow-lg shadow-indigo-100 transition-all whitespace-nowrap">All Tests</button>
                            <button onclick="filterTable('laboratory', this)" class="category-btn px-6 py-2 bg-white text-slate-600 border border-slate-200 rounded-full text-xs font-bold hover:border-indigo-500 transition-all whitespace-nowrap">Laboratory</button>
                            <button onclick="filterTable('imaging', this)" class="category-btn px-6 py-2 bg-white text-slate-600 border border-slate-200 rounded-full text-xs font-bold hover:border-indigo-500 transition-all whitespace-nowrap">Imaging</button>
                            <button onclick="filterTable('procedure', this)" class="category-btn px-6 py-2 bg-white text-slate-600 border border-slate-200 rounded-full text-xs font-bold hover:border-indigo-500 transition-all whitespace-nowrap">Procedures</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODERN DATA TABLE -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-8">
                <table id="labTestsTable" class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Test / Investigation Name</th>
                            <th class="px-8 py-5 text-center text-[10px] font-black uppercase tracking-widest text-slate-400">Category</th>
                            <th class="px-8 py-5 text-center text-[10px] font-black uppercase tracking-widest text-slate-400">Available Home Visit</th>
                            <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Standard Price</th>
                            <th class="px-8 py-5 text-center text-[10px] font-black uppercase tracking-widest text-slate-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($services as $s)
                        @php
                            $colors = ['laboratory' => 'emerald', 'imaging' => 'indigo', 'procedure' => 'rose'];
                            $color = $colors[$s->category] ?? 'slate';
                            $catName = $s->category == 'laboratory' ? 'Lab' : ($s->category == 'procedure' ? 'Procedures' : ucfirst($s->category));
                            $hasComponents = $s->components->count() > 0;
                        @endphp
                        {{-- Main Test Row --}}
                        <tr id="test-{{$s->id}}" class="hover:bg-slate-50 transition-colors group test-row" data-category="{{$s->category}}" data-test-name="{{ strtolower($s->name) }}">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    @if($hasComponents)
                                        <button onclick="toggleAccordion({{$s->id}}, this)" class="w-6 h-6 flex items-center justify-center rounded-lg bg-slate-100 text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition-all toggle-btn">
                                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                        </button>
                                    @endif
                                    <div>
                                        <p class="font-bold text-slate-900 group-hover:text-indigo-600 transition-colors test-name-text">{{$s->name}}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <p class="text-[10px] text-slate-400 font-medium">
                                                {{ $s->subCategory->name ?? ($s->serviceCategory->name ?? 'Diagnostic Test') }}
                                            </p>
                                            @if($hasComponents)
                                                <span class="text-[9px] bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded font-black uppercase tracking-tighter">
                                                    {{ $s->components->count() }} Parameters
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="bg-{{$color}}-50 text-{{$color}}-600 text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-tighter">{{$catName}}</span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                @if($s->home_visit_available)
                                    <span class="text-emerald-600 text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-1.5">
                                        <i class="fa-solid fa-circle-check"></i> Yes
                                    </span>
                                    @if($s->home_visit_price > 0)
                                        <p class="text-[9px] text-slate-400 font-bold mt-1">+{{ formated_price($s->home_visit_price) }}</p>
                                    @endif
                                @else
                                    <span class="text-slate-300 text-[10px] font-black uppercase tracking-widest">No</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-base font-black text-slate-900">{{ formated_price($s->price) }}</span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <button onclick="addToCart({{$s->id}})" class="group/btn inline-flex w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl items-center justify-center hover:bg-indigo-600 transition-all transform active:scale-90">
                                    <i class="fa-solid fa-plus text-xs group-hover/btn:text-white"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Accordion Row (Hidden by default) --}}
                        @if($hasComponents)
                        <tr id="accordion-{{$s->id}}" class="hidden bg-slate-50/30 accordion-row" data-category="{{$s->category}}">
                            <td colspan="5" class="px-12 py-6">
                                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                                    <table class="w-full text-xs">
                                        <thead>
                                            <tr class="bg-slate-50 border-bottom border-slate-100">
                                                <th class="px-6 py-3 text-left font-black text-slate-400 uppercase tracking-widest">Included Parameter</th>
                                                <th class="px-6 py-3 text-left font-black text-slate-400 uppercase tracking-widest">Normal Range</th>
                                                <th class="px-6 py-3 text-left font-black text-slate-400 uppercase tracking-widest">Unit</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-50">
                                            @foreach($s->components as $comp)
                                            <tr>
                                                <td class="px-6 py-3 font-bold text-slate-700">{{ $comp->name }}</td>
                                                <td class="px-6 py-3 text-slate-500">{{ $comp->reference_range }}</td>
                                                <td class="px-6 py-3 text-slate-500">{{ $comp->unit }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-12 mb-20 text-center">
                <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">
                    End of Test Catalog <span class="mx-2 text-slate-200">/</span> Total {{ $services->count() }} Investigations
                </p>
            </div>
        </section>
    </main>

    <style>
        .category-btn.active {
            background-color: #4f46e5 !important;
            color: white !important;
            border-color: #4f46e5 !important;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.2);
        }
        
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        .toggle-btn.active {
            background-color: #4f46e5 !important;
            color: white !important;
            transform: rotate(90deg);
        }
    </style>

@endsection

@push('scripts')
    <script>
        let currentCategory = '';

        function filterTable(category, btn) {
            currentCategory = category;
            
            // UI Update
            $('.category-btn').removeClass('active bg-indigo-600 text-white shadow-lg shadow-indigo-100').addClass('bg-white text-slate-600 border border-slate-200');
            $(btn).addClass('active bg-indigo-600 text-white shadow-lg shadow-indigo-100').removeClass('bg-white text-slate-600 border border-slate-200');
            
            applyFilters();
        }

        function applyFilters() {
            const searchTerm = $('#customSearch').val().toLowerCase().trim();
            
            $('.test-row').each(function() {
                const row = $(this);
                const testName = row.data('test-name');
                const category = row.data('category');
                const accordionRow = $('#accordion-' + row.attr('id').split('-').pop());
                
                const matchesSearch = searchTerm === '' || testName.indexOf(searchTerm) > -1;
                const matchesCategory = currentCategory === '' || category === currentCategory;
                
                if (matchesSearch && matchesCategory) {
                    row.show();
                    // If accordion was open, keep it visible, otherwise keep it hidden
                    if (row.find('.toggle-btn').hasClass('active')) {
                        accordionRow.show();
                    }
                } else {
                    row.hide();
                    accordionRow.hide();
                }
            });
        }

        function toggleAccordion(id, btn) {
            const row = $('#accordion-' + id);
            const $btn = $(btn);
            
            if (row.hasClass('hidden')) {
                row.removeClass('hidden');
                $btn.addClass('active');
            } else {
                row.addClass('hidden');
                $btn.removeClass('active');
            }
        }

        function addToCart(serviceId) {
            $.ajax({
                url: "{{ route('cart.add') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    service_id: serviceId
                },
                success: function(response) {
                    $('#cart-count-badge').text(response.cart_count).removeClass('hidden');
                    
                    // Professional SweetAlert Toast
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });

                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error adding test to cart',
                    });
                }
            });
        }

        $(document).ready(function() {
            $('#customSearch').on('keyup input', function(e) {
                applyFilters();
            });

            $('#customSearch').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    applyFilters();
                }
            });
        });
    </script>
@endpush
