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
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors group test-row" data-category="{{$s->category}}">
                            <td class="px-8 py-6">
                                <p class="font-bold text-slate-900 group-hover:text-indigo-600 transition-colors test-name">{{$s->name}}</p>
                                <p class="text-[10px] text-slate-400 font-medium">
                                    {{ $s->subCategory->name ?? ($s->serviceCategory->name ?? 'Diagnostic Test') }}
                                </p>
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
                                <a href="{{ route('service.detail', $s->id) }}" class="inline-flex w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl items-center justify-center hover:bg-indigo-600 hover:text-white transition-all transform active:scale-90">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Custom Pagination -->
            <div class="mt-12 mb-20">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">
                        Showing {{ $services->firstItem() ?? 0 }} - {{ $services->lastItem() ?? 0 }} <span class="mx-2 text-slate-200">/</span> {{ $services->total() }} Tests
                    </p>
                    
                    <div class="flex items-center gap-2">
                        @if ($services->onFirstPage())
                            <span class="w-12 h-12 flex items-center justify-center rounded-2xl border border-slate-100 text-slate-300 cursor-not-allowed">
                                <i class="fa-solid fa-chevron-left text-xs"></i>
                            </span>
                        @else
                            <a href="{{ $services->previousPageUrl() }}" class="w-12 h-12 flex items-center justify-center rounded-2xl border border-slate-200 text-slate-600 hover:border-indigo-600 hover:text-indigo-600 transition-all active:scale-90 shadow-sm hover:shadow-md">
                                <i class="fa-solid fa-chevron-left text-xs"></i>
                            </a>
                        @endif

                        <div class="flex items-center gap-2 px-4">
                            <span class="text-sm font-black text-indigo-600">Page {{ $services->currentPage() }}</span>
                            <span class="text-xs font-bold text-slate-300 uppercase tracking-widest ml-1">of {{ $services->lastPage() }}</span>
                        </div>

                        @if ($services->hasMorePages())
                            <a href="{{ $services->nextPageUrl() }}" class="w-12 h-12 flex items-center justify-center rounded-2xl border border-slate-200 text-slate-600 hover:border-indigo-600 hover:text-indigo-600 transition-all active:scale-90 shadow-sm hover:shadow-md">
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </a>
                        @else
                            <span class="w-12 h-12 flex items-center justify-center rounded-2xl border border-slate-100 text-slate-300 cursor-not-allowed">
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </span>
                        @endif
                    </div>
                </div>
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
            
            $('#labTestsTable tbody tr').each(function() {
                const row = $(this);
                const testName = row.find('.test-name').text().toLowerCase();
                const category = row.data('category');
                
                const matchesSearch = searchTerm === '' || testName.indexOf(searchTerm) > -1;
                const matchesCategory = currentCategory === '' || category === currentCategory;
                
                if (matchesSearch && matchesCategory) {
                    row.show();
                } else {
                    row.hide();
                }
            });
        }

        $(document).ready(function() {
            // Real-time filter
            $('#customSearch').on('keyup input', function(e) {
                applyFilters();
            });

            // Manual filter on Enter key
            $('#customSearch').on('keypress', function(e) {
                if (e.which === 13) { // Enter key
                    e.preventDefault();
                    applyFilters();
                }
            });
        });
    </script>
@endpush
