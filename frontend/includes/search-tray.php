    <!-- ================= NEW SEARCH TRAY COMPONENT ================= -->
    <!-- Fixed position, slides down from top, z-index above everything else -->
    <div id="search-tray" class="fixed inset-x-0 top-0 bg-white z-[60] shadow-2xl transform -translate-y-[110%] transition-transform duration-300 ease-in-out">
        
        <!-- Container for content -->
        <div class="container mx-auto px-6 py-10 md:py-16 relative max-w-5xl">
            
            <!-- Close Button -->
            <button id="close-search-tray" class="absolute top-6 right-6 text-gray-400 hover:text-imperial-primary transition text-3xl focus:outline-none">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <!-- Search Label & Input -->
            <div class="mb-8">
                <label class="block text-imperial-primary font-semibold mb-4 text-lg uppercase tracking-wider">What are you looking for?</label>
                <div class="relative group">
                    <input type="text" 
                           placeholder="Search for doctors, services, tests..." 
                           class="w-full border-b-2 border-gray-200 py-4 pl-2 pr-12 text-2xl md:text-3xl text-imperial-text placeholder-gray-300 focus:outline-none focus:border-imperial-primary transition-colors bg-transparent">
                    <button class="absolute right-2 top-1/2 -translate-y-1/2 text-imperial-primary text-2xl hover:text-imperial-dark transition">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>

            <!-- Inline Checkboxes (Filters) -->
            <div class="flex flex-col md:flex-row md:items-center gap-6 md:gap-10 mt-8">
                
                <!-- Checkbox 1: Service Package -->
                <label class="flex items-center gap-3 cursor-pointer group select-none">
                    <div class="relative flex items-center">
                        <input type="checkbox" class="peer h-6 w-6 cursor-pointer appearance-none rounded border border-gray-300 transition-all checked:border-imperial-primary checked:bg-imperial-primary">
                        <i class="fa-solid fa-check absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-white text-sm opacity-0 peer-checked:opacity-100 pointer-events-none"></i>
                    </div>
                    <span class="text-lg text-gray-600 group-hover:text-imperial-primary transition">Service Package</span>
                </label>

                <!-- Checkbox 2: Service Plan -->
                <label class="flex items-center gap-3 cursor-pointer group select-none">
                    <div class="relative flex items-center">
                        <input type="checkbox" class="peer h-6 w-6 cursor-pointer appearance-none rounded border border-gray-300 transition-all checked:border-imperial-primary checked:bg-imperial-primary">
                        <i class="fa-solid fa-check absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-white text-sm opacity-0 peer-checked:opacity-100 pointer-events-none"></i>
                    </div>
                    <span class="text-lg text-gray-600 group-hover:text-imperial-primary transition">Service Plan</span>
                </label>

            </div>

            <!-- Quick Links (Optional Enhancement) -->
            <div class="mt-10 pt-6 border-t border-gray-100">
                <p class="text-sm text-gray-400 mb-3 font-medium">POPULAR SEARCHES:</p>
                <div class="flex flex-wrap gap-3">
                    <a href="#" class="px-3 py-1 bg-gray-100 text-gray-600 text-sm rounded hover:bg-imperial-primary hover:text-white transition">General Physician</a>
                    <a href="#" class="px-3 py-1 bg-gray-100 text-gray-600 text-sm rounded hover:bg-imperial-primary hover:text-white transition">Health Check</a>
                    <a href="#" class="px-3 py-1 bg-gray-100 text-gray-600 text-sm rounded hover:bg-imperial-primary hover:text-white transition">Pediatrician</a>
                    <a href="#" class="px-3 py-1 bg-gray-100 text-gray-600 text-sm rounded hover:bg-imperial-primary hover:text-white transition">Blood Test</a>
                </div>
            </div>

        </div>
    </div>
