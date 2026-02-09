@extends('layouts.front')

@section('title', 'Doctors - Imperial Health Bangladesh')

@section('content')

    <!-- Main Content Start -->
    <main class="min-h-screen bg-gray-50 font-sans text-imperial-text flex flex-col">

        <!-- HERO SECTION -->
        <section class="relative h-[60vh] md:h-[65vh] w-full overflow-hidden group">
            <!-- Background Image -->
            <img src="{{ asset('assets/front/images/doctor/1.jpg') }}" 
                 alt="Healthcare Background" 
                 class="absolute inset-0 w-full h-full object-cover transition-transform duration-[10s] ease-linear group-hover:scale-105">
            
            <!-- Subtle Dark Overlay -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/10"></div>
        </section>

        <!-- INTRO OVERLAP SECTION -->
        <section class="relative z-10 -mt-24 px-4">
            <div class="max-w-5xl mx-auto bg-white px-6 py-10 md:py-16 text-center shadow-xl rounded-xl border border-gray-100">    
                <h1 class="text-3xl md:text-4xl font-bold mb-4 text-gray-900">Our Doctors</h1>
            
                <p class="text-gray-600 max-w-3xl mx-auto font-roboto text-lg leading-relaxed">
                    At Imperial, our Family Medicine Doctors as well as Visiting Specialists take care of you. 
                    Our doctors have years of local and international experience and treat you with 
                    respect and empathy you deserve.
                </p>
            </div>
        </section>

        <!-- Filter Section (Static, Non-Floating) -->
        <section class="bg-white border-b border-gray-200 py-8 mt-8">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <form id="filterForm" action="{{ route('doctor') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-8">
                    
                    <!-- Speciality Search (Span 3 cols on desktop) -->
                    <div class="flex flex-col gap-2 md:col-span-3">
                        <label for="speciality" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Speciality</label>
                        <div class="relative">
                            <select id="speciality" name="speciality" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-imperial-primary focus:border-imperial-primary appearance-none font-roboto text-gray-900 transition-shadow">
                                <option value="" disabled selected>Select Speciality</option>
                                <option value="">All Specialities</option>
                                <option value="1">Acupuncture</option>
                                <option value="21">Anesthesiology</option>
                                <option value="2">Cardiology</option>
                                <option value="4">Dentistry</option>
                                <option value="5">Dermatology</option>
                                <option value="6">Diabetology</option>
                                <option value="35">ENT</option>
                                <option value="8">Family Physicians</option>
                                <option value="9">Gastroenterology & Hepatology</option>
                                <option value="13">Nephrology</option>
                                <option value="14">Neurology</option>
                                <option value="15">Nutrition</option>
                                <option value="16">Obstetrics & Gynecology</option>
                                <option value="17">Oncology</option>
                                <option value="18">Ophthalmology</option>
                                <option value="19">Orthopedics</option>
                                <option value="22">Pediatrics</option>
                                <option value="24">Physiotherapy</option>
                                <option value="25">Plastic Surgeon</option>
                                <option value="30">Respiratory & Internal Medicine</option>
                                <option value="36">Rheumatology</option>
                                <option value="32">Urology</option>
                            </select>
                            <!-- Custom Arrow Icon (FontAwesome) -->
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-imperial-primary">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Name Search (Span 3 cols on desktop) -->
                    <div class="flex flex-col gap-2 md:col-span-3">
                        <label for="name" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Doctor Name</label>
                        <div class="relative">
                            <input type="text" id="name" name="name" placeholder="Search by name..." 
                                class="w-full p-3 pl-10 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-imperial-primary focus:border-imperial-primary font-roboto text-gray-900 transition-shadow">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Date Search (Span 3 cols on desktop) -->
                    <div class="flex flex-col gap-2 md:col-span-3">
                        <label for="date" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Availability Date</label>
                        <input type="date" id="date" name="date" 
                            class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-imperial-primary focus:border-imperial-primary font-roboto text-gray-900 transition-shadow">
                    </div>

                    <!-- Submit Button (Span 3 cols on desktop) -->
                    <div class="flex items-end md:col-span-3">
                        <button type="submit" class="w-full bg-imperial-primary hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform active:scale-[0.98] flex items-center justify-center gap-2">
                            <span>Find Doctors</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </form>

                <!-- Alphabet Navigation -->
                <div class="flex flex-wrap items-center justify-center gap-2 md:justify-start pt-4 border-t border-gray-100">
                    <span class="text-xs font-bold text-imperial-gray uppercase mr-2 hidden md:inline">Jump to:</span>
                    <button class="w-9 h-9 rounded-full bg-imperial-primary text-white hover:bg-imperial-dark transition-colors text-sm font-bold shadow-sm">All</button>
                    <!-- A-Z -->
                    @foreach(range('A', 'Z') as $letter)
                        <button class="w-9 h-9 rounded-full border border-gray-300 text-imperial-text hover:border-imperial-primary hover:text-imperial-primary hover:bg-blue-50 transition-colors text-sm font-medium focus:outline-none focus:ring-2 focus:ring-imperial-primary">
                            {{ $letter }}
                        </button>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Doctor Lists Container -->
        <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow">
            
            <!-- Category: Acupuncture -->
            <div class="mb-16">
                <div class="flex items-center mb-6">
                    <div class="w-1.5 h-8 bg-imperial-primary rounded-full mr-3"></div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 font-sans">Acupuncture</h2>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    
                    <!-- Card 1 -->
                    <a href="{{ route('book-doctor') }}" class="group block bg-white rounded-xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-200 relative">
                            <img src="{{ asset('assets/front/images/doctor/2.jpg') }}" 
                                 alt="Dr. Ahmed Farukh" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <!-- Hover Overlay -->
                            <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 font-sans group-hover:text-imperial-primary transition-colors">Dr. Ahmed Farukh</h3>
                            <p class="text-sm text-imperial-gray mb-4 font-roboto line-clamp-2">Consultant - Energetic medicine & acupuncture</p>
                            <span class="inline-block px-4 py-2 border border-imperial-primary text-imperial-primary font-bold text-xs uppercase tracking-widest rounded hover:bg-imperial-primary hover:text-white transition-colors w-full">
                                See Details
                            </span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Category: Cardiology -->
            <div class="mb-16">
                <div class="flex items-center mb-6">
                    <div class="w-1.5 h-8 bg-imperial-primary rounded-full mr-3"></div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 font-sans">Cardiology</h2>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    
                    <!-- Doctor 1 -->
                    <a href="{{ route('book-doctor') }}" class="group block bg-white rounded-xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-200 relative">
                            <img src="{{ asset('assets/front/images/doctor/3.jpg') }}" 
                                 alt="Assistant Professor DR. AZM Ahsan Ullah" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 font-sans group-hover:text-imperial-primary transition-colors leading-tight">Asst. Prof. DR. AZM Ahsan Ullah</h3>
                            <p class="text-sm text-imperial-gray mb-4 font-roboto">Consultant - Cardiology</p>
                            <span class="inline-block px-4 py-2 border border-imperial-primary text-imperial-primary font-bold text-xs uppercase tracking-widest rounded hover:bg-imperial-primary hover:text-white transition-colors w-full">
                                See Details
                            </span>
                        </div>
                    </a>

                    <!-- Doctor 2 -->
                    <a href="{{ route('book-doctor') }}" class="group block bg-white rounded-xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-200 relative">
                            <img src="{{ asset('assets/front/images/doctor/4.jpg') }}" 
                                 alt="Dr. AHM Masud Sinha" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 font-sans group-hover:text-imperial-primary transition-colors">Dr. AHM Masud Sinha</h3>
                            <p class="text-sm text-imperial-gray mb-4 font-roboto">Consultant - Cardiology</p>
                            <span class="inline-block px-4 py-2 border border-imperial-primary text-imperial-primary font-bold text-xs uppercase tracking-widest rounded hover:bg-imperial-primary hover:text-white transition-colors w-full">
                                See Details
                            </span>
                        </div>
                    </a>

                    <!-- Doctor 3 (Placeholder) -->
                  <a href="{{ route('book-doctor') }}" class="group block bg-white rounded-xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-200 relative">
                            <img src="{{ asset('assets/front/images/doctor/5.jpg') }}" 
                                 alt="Dr. AHM Masud Sinha" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 font-sans group-hover:text-imperial-primary transition-colors">Dr. AHM Masud Sinha</h3>
                            <p class="text-sm text-imperial-gray mb-4 font-roboto">Consultant - Cardiology</p>
                            <span class="inline-block px-4 py-2 border border-imperial-primary text-imperial-primary font-bold text-xs uppercase tracking-widest rounded hover:bg-imperial-primary hover:text-white transition-colors w-full">
                                See Details
                            </span>
                        </div>
                    </a>

                </div>
            </div>
            
            <!-- More Categories would go here... -->

        </section>
    </main>



@endsection