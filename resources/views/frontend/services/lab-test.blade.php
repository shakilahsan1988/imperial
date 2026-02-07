@extends('layouts.front')

@section('title', 'Lab Test - Imperial Health Bangladesh')

@section('content')

    <!-- MAIN HEADER SECTION -->
     <!-- HERO -->
        <section class="relative h-[65vh]">
            <img src="https://img.freepik.com/free-photo/coronavirus-vaccine-lab-with-samples_23-2148920827.jpg" alt="Healthcare Background" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/30"></div>
        </section>
	<!-- INTRO OVERLAP SECTION -->
	<section class="-mt-24 relative z-10">
	    <div class="max-w-5xl mx-auto bg-white px-10 py-16 text-center shadow-xl">    
	      <h1 class="text-3xl font-semibold mb-4">Lab Tests & Procedures</h1>
            <p class="text-gray-600 max-w-3xl mx-auto">
              Imperial Health’s biggest differentiator from other diagnostics centers is quality. We offer diagnostic labs and a full range of imaging services that are set to international standards (including the first molecular cancer diagnostics lab in Bangladesh). Book any service necessary without any hesitation.
            </p>
	    </div>
	</section>
	
 <!-- SERVICES TABLE SECTION -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            
            <!-- FILTER & SEARCH BAR GRID -->
            <!-- Layout: 12 column grid. Search (Left) 4 cols, Filter (Right) 8 cols -->
            <div class="grid grid-cols-12 gap-x-[60px] items-center mb-10">
                
                <!-- FILTER (Right Side) -->
                <!-- Using margin logic to push this to the right based on your provided HTML structure -->
                <div class="col-span-8 ml-[50%_+_30px] hidden md:block">
                    <div class="grid grid-cols-12 gap-x-2.5 items-center">
                        <div class="col-span-4 text-right font-semibold text-gray-700">
                            <label>Filter By:</label>
                        </div>
                        <div class="col-span-8">
                            <div class="relative">
                                <select class="w-full border border-gray-300 rounded-md px-4 py-2.5 appearance-none bg-white focus:outline-none focus:border-imperial-primary">
                                    <option>All</option>
                                    <option>Lab</option>
                                    <option>Imaging</option>
                                    <option>Procedures</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEARCH (Left Side) -->
                <div class="col-span-4 relative">
                    <div class="relative">
                        <input type="text" placeholder="Search" class="w-full border border-gray-300 rounded-md px-4 py-2.5 pl-10 focus:outline-none focus:border-imperial-primary">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <!-- Search Icon SVG -->
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DATA TABLE -->
            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                  <!-- DATA TABLE -->
            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="p-4 font-semibold text-gray-700 w-1/2">Name</th>
                            <th class="p-4 font-semibold text-gray-700 w-1/4 hidden md:table-cell">Category</th>
                            <th class="p-4 font-semibold text-gray-700 w-1/6">Price</th>
                            <th class="p-4 font-semibold text-gray-700 w-1/6 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- ROW 1 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 align-middle">
                                <!-- Name is no longer a link -->
                                <h2 >Bite Impression by Dr. Nafees Uddin Chowdhury</h2>
                                <p class="text-sm text-gray-500 md:hidden">Imaging</p>
                            </td>
                            <td class="p-4 text-gray-600 hidden md:table-cell">Imaging</td>
                            <!-- Price Logic: Hidden by default, button toggles visibility -->
                            <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 1,000</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </td>
                        </tr>

                        <!-- ROW 2 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 align-middle">
                                <h2 >Echocardiogram (2D Mode)</h2>
                                <p class="text-sm text-gray-500 md:hidden">Imaging</p>
                            </td>
                            <td class="p-4 text-gray-600 hidden md:table-cell">Imaging</td>
                            <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 2,050</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </td>
                        </tr>

                        <!-- ROW 3 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 align-middle">
                                <h2 >Echocardiogram (Color Doppler)</h2>
                                <p class="text-sm text-gray-500 md:hidden">Imaging</p>
                            </td>
                            <td class="p-4 text-gray-600 hidden md:table-cell">Imaging</td>
                            <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 2,650</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </td>
                        </tr>

                        <!-- ROW 4 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 align-middle">
                                <h2 >Mammography of Both Breasts</h2>
                                <p class="text-sm text-gray-500 md:hidden">Imaging</p>
                            </td>
                            <td class="p-4 text-gray-600 hidden md:table-cell">Imaging</td>
                            <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 3,500</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </td>
                        </tr>

                         <!-- ROW 5 -->
                         <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 align-middle">
                                <h2 >Mammography of Right Breast</h2>
                                <p class="text-sm text-gray-500 md:hidden">Imaging</p>
                            </td>
                            <td class="p-4 text-gray-600 hidden md:table-cell">Imaging</td>
                            <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 1,800</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </td>
                        </tr>

                        <!-- ROW 6 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 align-middle">
                                <h2 >24 Hours Urinary Cortisol</h2>
                                <p class="text-sm text-gray-500 md:hidden">Lab</p>
                            </td>
                            <td class="p-4 text-gray-600 hidden md:table-cell">Lab</td>
                            <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 1,400</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </td>
                        </tr>

                         <!-- ROW 7 -->
                         <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 align-middle">
                                <h2 >24 Hours Urine Calcium</h2>
                                <p class="text-sm text-gray-500 md:hidden">Lab</p>
                            </td>
                            <td class="p-4 text-gray-600 hidden md:table-cell">Lab</td>
                            <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 700</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </td>
                        </tr>

                        <!-- ROW 8 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 align-middle">
                                <h2 >24 Hours Urine Total Protein</h2>
                                <p class="text-sm text-gray-500 md:hidden">Lab</p>
                            </td>
                            <td class="p-4 text-gray-600 hidden md:table-cell">Lab</td>
                            <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 850</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </td>
                        </tr>

                         <!-- ROW 9 -->
                         <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 align-middle">
                                <h2 >24 Hours Urine Uric Acid</h2>
                                <p class="text-sm text-gray-500 md:hidden">Lab</p>
                            </td>
                            <td class="p-4 text-gray-600 hidden md:table-cell">Lab</td>
                            <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 750</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </td>
                        </tr>

                         <!-- ROW 10 -->
                         <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 align-middle">
                                <h2 >24 Hrs Urine Phosphate</h2>
                                <p class="text-sm text-gray-500 md:hidden">Lab</p>
                            </td>
                            <td class="p-4 text-gray-600 hidden md:table-cell">Lab</td>
                            <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 900</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </td>
                        </tr>
                        
                         <!-- ROW 11 -->
                         <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 align-middle">
                                <h2 >25-OH Vitamin-D</h2>
                                <p class="text-sm text-gray-500 md:hidden">Lab</p>
                            </td>
                            <td class="p-4 text-gray-600 hidden md:table-cell">Lab</td>
                            <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 4,200</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </td>
                        </tr>

                        <!-- ROW 12 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                           <td class="p-4 align-middle">
                               <h2 >Activated Partial Thromboplastin Time</h2>
                               <p class="text-sm text-gray-500 md:hidden">Lab</p>
                           </td>
                           <td class="p-4 text-gray-600 hidden md:table-cell">Lab</td>
                           <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 1,450</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                           <td class="p-4 text-center">
                               <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                                   <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                               </button>
                           </td>
                       </tr>

                       <!-- ROW 13 -->
                       <tr class="hover:bg-gray-50 transition-colors">
                          <td class="p-4 align-middle">
                              <h2 >A/G Ratio</h2>
                              <p class="text-sm text-gray-500 md:hidden">Lab</p>
                          </td>
                          <td class="p-4 text-gray-600 hidden md:table-cell">Lab</td>
                          <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 1,500</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                          <td class="p-4 text-center">
                              <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                                  <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                              </button>
                          </td>
                      </tr>

                      <!-- ROW 14 -->
                      <tr class="hover:bg-gray-50 transition-colors">
                         <td class="p-4 align-middle">
                             <h2 >Alanine Aminotransferase-ALT</h2>
                             <p class="text-sm text-gray-500 md:hidden">Lab</p>
                         </td>
                         <td class="p-4 text-gray-600 hidden md:table-cell">Lab</td>
                         <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 620</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                         <td class="p-4 text-center">
                             <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                                 <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                             </button>
                         </td>
                     </tr>

                     <!-- ROW 15 -->
                     <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 align-middle">
                            <h2 >Albumin</h2>
                            <p class="text-sm text-gray-500 md:hidden">Lab</p>
                        </td>
                        <td class="p-4 text-gray-600 hidden md:table-cell">Lab</td>
                        <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 650</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                        <td class="p-4 text-center">
                            <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                                <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                            </button>
                        </td>
                    </tr>

                    <!-- ROW 16 -->
                    <tr class="hover:bg-gray-50 transition-colors">
                       <td class="p-4 align-middle">
                           <h2 >Albumin Globulin Ratio</h2>
                           <p class="text-sm text-gray-500 md:hidden">Lab</p>
                       </td>
                       <td class="p-4 text-gray-600 hidden md:table-cell">Lab</td>
                       <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 1,500</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                       <td class="p-4 text-center">
                           <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                               <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                           </button>
                       </td>
                   </tr>

                   <!-- ROW 17 -->
                   <tr class="hover:bg-gray-50 transition-colors">
                      <td class="p-4 align-middle">
                          <h2 >ALK1</h2>
                          <p class="text-sm text-gray-500 md:hidden">Lab</p>
                      </td>
                      <td class="p-4 text-gray-600 hidden md:table-cell">Lab</td>
                      <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 8,000</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                      <td class="p-4 text-center">
                          <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                              <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                          </button>
                      </td>
                  </tr>

                  <!-- ROW 18 -->
                  <tr class="hover:bg-gray-50 transition-colors">
                     <td class="p-4 align-middle">
                         <h2 >Alkaline Phosphatase-ALP</h2>
                         <p class="text-sm text-gray-500 md:hidden">Lab</p>
                     </td>
                     <td class="p-4 text-gray-600 hidden md:table-cell">Lab</td>
                     <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 550</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                     <td class="p-4 text-center">
                         <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                             <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                         </button>
                     </td>
                 </tr>

                 <!-- ROW 19 -->
                 <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 align-middle">
                        <h2 >Alpha Fetoprotein</h2>
                        <p class="text-sm text-gray-500 md:hidden">Lab</p>
                    </td>
                    <td class="p-4 text-gray-600 hidden md:table-cell">Lab</td>
                    <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 2,100</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                    <td class="p-4 text-center">
                        <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                            <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                        </button>
                    </td>
                </tr>

                <!-- ROW 20 -->
                <tr class="hover:bg-gray-50 transition-colors">
                   <td class="p-4 align-middle">
                       <h2 >Amphetamine</h2>
                       <p class="text-sm text-gray-500 md:hidden">Lab</p>
                   </td>
                   <td class="p-4 text-gray-600 hidden md:table-cell">Lab</td>
                   <td class="p-4 text-gray-700 font-medium align-middle">
                                <div class="flex items-center gap-2">
                                    <span class="price-tag hidden text-lg font-medium">৳ 1,500</span>
                                    <button class="text-sm font-bold text-imperial-primary hover:underline focus:outline-none" onclick="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');">Show Price</button>
                                </div>
                            </td>
                   <td class="p-4 text-center">
                       <button class="bg-imperial-primary hover:bg-imperial-primary-dark text-white text-xs px-3 py-2 rounded transition-colors flex items-center gap-2 ml-auto">
                           <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                       </button>
                   </td>
               </tr>

                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="flex justify-end items-center mt-8 gap-2">
                <button class="p-2 rounded-full border border-gray-200 text-gray-400 cursor-not-allowed" disabled>
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button class="w-8 h-8 rounded bg-imperial-primary text-white flex items-center justify-center text-sm font-medium">1</button>
                <button class="w-8 h-8 rounded hover:bg-gray-100 text-gray-600 flex items-center justify-center text-sm font-medium">2</button>
                <button class="w-8 h-8 rounded hover:bg-gray-100 text-gray-600 flex items-center justify-center text-sm font-medium">3</button>
                <button class="w-8 h-8 rounded hover:bg-gray-100 text-gray-600 flex items-center justify-center text-sm font-medium">4</button>
                <button class="w-8 h-8 rounded hover:bg-gray-100 text-gray-600 flex items-center justify-center text-sm font-medium">5</button>
                <span class="text-gray-400 mx-1">...</span>
                <button class="w-8 h-8 rounded hover:bg-gray-100 text-gray-600 flex items-center justify-center text-sm font-medium">39</button>
                <button class="p-2 rounded-full border border-gray-200 text-gray-600 hover:bg-gray-50">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>

        </div>
    </section>

@endsection