@extends('layouts.front')

@section('title', 'Lab Test - Imperial Health Bangladesh')

@section('content')

    <!-- HERO SECTION -->
    <section class="relative h-[50vh] min-h-[350px]">
        <img src="https://img.freepik.com/free-photo/coronavirus-vaccine-lab-with-samples_23-2148920827.jpg" 
             alt="Lab Services" 
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 to-slate-900/40"></div>
        <div class="absolute inset-0 flex items-center">
            <div class="container mx-auto px-6">
                <div class="max-w-2xl">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Lab Tests & Procedures</h1>
                    <p class="text-lg text-white/90">World-class diagnostic services with international quality standards</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURE CARDS -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 -mt-40 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                
                <!-- Feature 1 -->
                <div class="bg-white rounded-2xl p-10 shadow-xl border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                    <div class="flex items-start gap-6">
                        <div class="w-20 h-20 rounded-full bg-imperial-primary/10 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-award text-imperial-primary text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3 text-xl">Quality Assured</h3>
                            <p class="text-gray-600 text-base">Laboratories set up according to international standards and protocols</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl p-10 shadow-xl border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                    <div class="flex items-start gap-6">
                        <div class="w-20 h-20 rounded-full bg-imperial-primary/10 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-bolt text-imperial-primary text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3 text-xl">Quick Results</h3>
                            <p class="text-gray-600 text-base">Fast turnaround time for most test results</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl p-10 shadow-xl border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                    <div class="flex items-start gap-6">
                        <div class="w-20 h-20 rounded-full bg-imperial-primary/10 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-house-medical text-imperial-primary text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3 text-xl">Home Service</h3>
                            <p class="text-gray-600 text-base">Sample collection from the comfort of your home</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SERVICES LIST SECTION -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            
            <!-- FILTER & SEARCH -->
            <div class="flex flex-col md:flex-row gap-4 justify-between items-center mb-6">
                <!-- Search -->
                <div class="relative w-full md:w-80">
                    <input type="text" 
                           id="customSearch"
                           placeholder="Search tests..." 
                           class="w-full border border-gray-200 rounded-lg px-4 py-3 pl-10 focus:outline-none focus:border-imperial-primary focus:ring-1 focus:ring-imperial-primary transition">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>

                <!-- Filter -->
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <span class="text-sm text-gray-600 whitespace-nowrap">Filter by:</span>
                    <div class="relative">
                        <select id="categoryFilter" class="appearance-none bg-white border border-gray-200 rounded-lg px-4 py-3 pr-10 focus:outline-none focus:border-imperial-primary cursor-pointer">
                            <option value="">All Categories</option>
                            <option value="Lab">Lab</option>
                            <option value="Imaging">Imaging</option>
                            <option value="Procedures">Procedures</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <!-- DataTable -->
            <div class="table-responsive">
                <table id="labTestsTable" class="table table-striped table-bordered table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-start">Test Name</th>
                            <th class="text-start" style="width: 140px;">Category</th>
                            <th class="text-end" style="width: 130px;">Price</th>
                            <th class="text-center" style="width: 130px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->
                        <tr data-category="Imaging">
                            <td>Bite Impression by Dr. Nafees Uddin Chowdhury</td>
                            <td><span class="badge bg-primary">Imaging</span></td>
                            <td class="text-end fw-bold">৳ 1,000</td>
                            <td class="text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <!-- Row 2 -->
                        <tr data-category="Imaging">
                            <td>Echocardiogram (2D Mode)</td>
                            <td><span class="badge bg-primary">Imaging</span></td>
                            <td class="text-end fw-bold">৳ 2,050</td>
                            <td class="text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <!-- Row 3 -->
                        <tr data-category="Imaging">
                            <td>Echocardiogram (Color Doppler)</td>
                            <td><span class="badge bg-primary">Imaging</span></td>
                            <td class="text-end fw-bold">৳ 2,650</td>
                            <td class="text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <!-- Row 4 -->
                        <tr data-category="Imaging">
                            <td>Mammography of Both Breasts</td>
                            <td><span class="badge bg-primary">Imaging</span></td>
                            <td class="text-end fw-bold">৳ 3,500</td>
                            <td class="text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <!-- Row 5 -->
                        <tr data-category="Imaging">
                            <td>Mammography of Right Breast</td>
                            <td><span class="badge bg-primary">Imaging</span></td>
                            <td class="text-end fw-bold">৳ 1,800</td>
                            <td class="text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <!-- Row 6 -->
                        <tr data-category="Lab">
                            <td>24 Hours Urinary Cortisol</td>
                            <td><span class="badge bg-success">Lab</span></td>
                            <td class="text-end fw-bold">৳ 1,400</td>
                            <td class="text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <!-- Row 7 -->
                        <tr data-category="Lab">
                            <td>24 Hours Urine Calcium</td>
                            <td><span class="badge bg-success">Lab</span></td>
                            <td class="text-end fw-bold">৳ 700</td>
                            <td class="text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <!-- Row 8 -->
                        <tr data-category="Lab">
                            <td>24 Hours Urine Total Protein</td>
                            <td><span class="badge bg-success">Lab</span></td>
                            <td class="text-end fw-bold">৳ 850</td>
                            <td class="text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <!-- Row 9 -->
                        <tr data-category="Lab">
                            <td>24 Hours Urine Uric Acid</td>
                            <td><span class="badge bg-success">Lab</span></td>
                            <td class="text-end fw-bold">৳ 750</td>
                            <td class="text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <!-- Row 10 -->
                        <tr data-category="Lab">
                            <td>24 Hrs Urine Phosphate</td>
                            <td><span class="badge bg-success">Lab</span></td>
                            <td class="text-end fw-bold">৳ 900</td>
                            <td class="text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <!-- Row 11 -->
                        <tr data-category="Lab">
                            <td>25-OH Vitamin-D</td>
                            <td><span class="badge bg-success">Lab</span></td>
                            <td class="text-end fw-bold">৳ 4,200</td>
                            <td class="text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <!-- Row 12 -->
                        <tr data-category="Lab">
                            <td>Activated Partial Thromboplastin Time</td>
                            <td><span class="badge bg-success">Lab</span></td>
                            <td class="text-end fw-bold">৳ 1,450</td>
                            <td class="text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <!-- Row 13 -->
                        <tr data-category="Lab">
                            <td>A/G Ratio</td>
                            <td><span class="badge bg-success">Lab</span></td>
                            <td class="text-end fw-bold">৳ 1,500</td>
                            <td class="text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <!-- Row 14 -->
                        <tr data-category="Lab">
                            <td>Alanine Aminotransferase-ALT</td>
                            <td><span class="badge bg-success">Lab</span></td>
                            <td class="text-end fw-bold">৳ 620</td>
                            <td class="text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                        <!-- Row 15 -->
                        <tr data-category="Lab">
                            <td>Albumin</td>
                            <td><span class="badge bg-success">Lab</span></td>
                            <td class="text-end fw-bold">৳ 650</td>
                            <td class="text-center">
                                <button class="btn-add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Custom Pagination -->
                <div class="flex justify-center items-center mt-6 gap-2">
                    <p class="text-sm text-gray-600 mr-4">Showing 1 to 10 of 15 entries</p>
                    <button class="w-10 h-10 rounded-lg border border-gray-200 text-gray-400 flex items-center justify-center hover:border-imperial-primary hover:text-imperial-primary transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        <i class="fa-solid fa-chevron-left text-sm"></i>
                    </button>
                    <button class="w-10 h-10 rounded-lg bg-imperial-primary text-white flex items-center justify-center text-sm font-medium">1</button>
                    <button class="w-10 h-10 rounded-lg border border-gray-200 text-gray-600 flex items-center justify-center text-sm font-medium hover:border-imperial-primary hover:text-imperial-primary transition-colors">2</button>
                    <button class="w-10 h-10 rounded-lg border border-gray-200 text-gray-600 flex items-center justify-center hover:border-imperial-primary hover:text-imperial-primary transition-colors">
                        <i class="fa-solid fa-chevron-right text-sm"></i>
                    </button>
                </div>
            </div>

        </div>
    </section>

    <!-- DataTable Initialization Script -->
    <script>
        $(document).ready(function() {
            var table = $('#labTestsTable').DataTable({
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search tests...",
                    emptyTable: "No tests found",
                    zeroRecords: "No matching tests found",
                    paginate: false
                },
                paging: false,
                info: false,
                ordering: true,
                responsive: true,
                autoWidth: false,
                columnDefs: [
                    { orderable: false, targets: 2 }
                ]
            });
            
            // Custom Search
            $('#customSearch').on('keyup', function() {
                table.search($(this).val()).draw();
            });
            
            // Category Filter
            $('#categoryFilter').on('change', function() {
                var category = $(this).val();
                if (category) {
                    table.column(1).search('^' + category + '$', true, false).draw();
                } else {
                    table.column(1).search('').draw();
                }
            });
        });
    </script>

@endsection
