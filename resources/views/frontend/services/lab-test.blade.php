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
                            <button onclick="filterTable('Lab', this)" class="category-btn px-6 py-2 bg-white text-slate-600 border border-slate-200 rounded-full text-xs font-bold hover:border-indigo-500 transition-all whitespace-nowrap">Laboratory</button>
                            <button onclick="filterTable('Imaging', this)" class="category-btn px-6 py-2 bg-white text-slate-600 border border-slate-200 rounded-full text-xs font-bold hover:border-indigo-500 transition-all whitespace-nowrap">Imaging</button>
                            <button onclick="filterTable('Procedures', this)" class="category-btn px-6 py-2 bg-white text-slate-600 border border-slate-200 rounded-full text-xs font-bold hover:border-indigo-500 transition-all whitespace-nowrap">Procedures</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODERN DATA TABLE -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-12">
                <table id="labTestsTable" class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Test / Investigation Name</th>
                            <th class="px-8 py-5 text-center text-[10px] font-black uppercase tracking-widest text-slate-400">Category</th>
                            <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Standard Price</th>
                            <th class="px-8 py-5 text-center text-[10px] font-black uppercase tracking-widest text-slate-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @php
                            $tests = [
                                ['name' => 'Complete Blood Count (CBC)', 'cat' => 'Lab', 'price' => '850', 'color' => 'emerald'],
                                ['name' => 'Echocardiogram (Color Doppler)', 'cat' => 'Imaging', 'price' => '2,650', 'color' => 'indigo'],
                                ['name' => 'Mammography of Both Breasts', 'cat' => 'Imaging', 'price' => '3,500', 'color' => 'indigo'],
                                ['name' => '24 Hours Urinary Cortisol', 'cat' => 'Lab', 'price' => '1,400', 'color' => 'emerald'],
                                ['name' => 'Blood Glucose (Fasting)', 'cat' => 'Lab', 'price' => '250', 'color' => 'emerald'],
                                ['name' => 'MRI Brain with Contrast', 'cat' => 'Imaging', 'price' => '8,500', 'color' => 'indigo'],
                                ['name' => 'Endoscopy (Upper GI)', 'cat' => 'Procedures', 'price' => '4,500', 'color' => 'rose'],
                                ['name' => 'Vitamin D (25-OH)', 'cat' => 'Lab', 'price' => '4,200', 'color' => 'emerald'],
                                ['name' => 'Lipid Profile', 'cat' => 'Lab', 'price' => '1,200', 'color' => 'emerald'],
                                ['name' => 'Liver Function Test (LFT)', 'cat' => 'Lab', 'price' => '1,800', 'color' => 'emerald'],
                            ];
                        @endphp
                        @foreach($tests as $t)
                        <tr class="hover:bg-slate-50 transition-colors group" data-category="{{$t['cat']}}">
                            <td class="px-8 py-6">
                                <p class="font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">{{$t['name']}}</p>
                                <p class="text-[10px] text-slate-400 font-medium">Standard clinical procedure</p>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="bg-{{$t['color']}}-50 text-{{$t['color']}}-600 text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-tighter">{{$t['cat']}}</span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-base font-black text-slate-900">৳ {{$t['price']}}</span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <button class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all transform active:scale-90">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Custom Pagination Style -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Showing 10 of 124 diagnostic tests</p>
                <div class="flex gap-2">
                    <button class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200 text-slate-400 opacity-50 cursor-not-allowed"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-indigo-600 text-white font-bold shadow-lg shadow-indigo-100">1</button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200 text-slate-600 font-bold hover:border-indigo-500 hover:text-indigo-600 transition-all">2</button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200 text-slate-600 font-bold hover:border-indigo-500 hover:text-indigo-600 transition-all">3</button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200 text-slate-600 hover:border-indigo-500 hover:text-indigo-600 transition-all"><i class="fa-solid fa-chevron-right text-xs"></i></button>
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
    </style>

    <script>
        function filterTable(category, btn) {
            // UI Update
            $('.category-btn').removeClass('active bg-indigo-600 text-white shadow-lg shadow-indigo-100').addClass('bg-white text-slate-600 border border-slate-200');
            $(btn).addClass('active bg-indigo-600 text-white shadow-lg shadow-indigo-100').removeClass('bg-white text-slate-600 border border-slate-200');
            
            // Logic (Simple toggle for demo, in real it would filter DataTables)
            if(category === '') {
                $('#labTestsTable tbody tr').show();
            } else {
                $('#labTestsTable tbody tr').hide();
                $('#labTestsTable tbody tr[data-category="'+category+'"]').show();
            }
        }

        $(document).ready(function() {
            $('#customSearch').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#labTestsTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>

@endsection
