@extends('layouts.front')

@section('title', 'Our Corporate Clients - Imperial Health Bangladesh')

@section('content')

    <!-- Main Content Start -->
    <main class="font-sans text-imperial-text bg-white pb-20">
        
        <!-- HEADER SECTION -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center flex flex-col py-12 lg:py-16">
                
                <!-- Title -->
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Our Corporate Clients
                </h1>
                
                <!-- Description -->
                <p class="text-lg md:text-xl text-gray-600 font-roboto max-w-3xl mx-auto leading-relaxed">
                    Imperial cares for the employees of Bangladesh's biggest national and international companies. Already over 2000 companies trust Imperial as their healthcare provider. Join our family!
                </p>
            </div>
        </div>

        <!-- CLIENTS GRID SECTION -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-20">
                
                <!-- CLIENT 1 -->
                <a href="#" class="group block bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="aspect-[3/2] w-full overflow-hidden bg-gray-50 rounded-t-lg flex items-center justify-center relative">
                        <img src="https://picsum.photos/id/180/400/300" alt="Corporate Client" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-sm font-bold text-gray-900 mb-1">Corporate Partner</h3>
                        <p class="text-xs text-gray-500">Trusted Partner</p>
                    </div>
                </a>

                <!-- CLIENT 2 -->
                <a href="#" class="group block bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="aspect-[3/2] w-full overflow-hidden bg-gray-50 rounded-t-lg flex items-center justify-center relative">
                        <img src="https://picsum.photos/id/181/400/300" alt="Corporate Client" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-sm font-bold text-gray-900 mb-1">Global Partner</h3>
                        <p class="text-xs text-gray-500">Healthcare Solutions</p>
                    </div>
                </a>

                <!-- CLIENT 3 -->
                <a href="#" class="group block bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="aspect-[3/2] w-full overflow-hidden bg-gray-50 rounded-t-lg flex items-center justify-center relative">
                        <img src="https://picsum.photos/id/182/400/300" alt="Corporate Client" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-sm font-bold text-gray-900 mb-1">Industry Leader</h3>
                        <p class="text-xs text-imperial-primary font-medium">Telemedicine</p>
                    </div>
                </a>

                <!-- CLIENT 4 -->
                <a href="#" class="group block bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="aspect-[3/2] w-full overflow-hidden bg-gray-50 rounded-t-lg flex items-center justify-center relative">
                        <img src="https://picsum.photos/id/183/400/300" alt="Corporate Client" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-sm font-bold text-gray-900 mb-1">Retail Giant</h3>
                        <p class="text-xs text-imperial-primary font-medium">Commerce</p>
                    </div>
                </a>

                <!-- CLIENT 5 -->
                <a href="#" class="group block bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="aspect-[3/2] w-full overflow-hidden bg-gray-50 rounded-t-lg flex items-center justify-center relative">
                        <img src="https://picsum.photos/id/184/400/300" alt="Corporate Client" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-sm font-bold text-gray-900 mb-1">Tech Innovator</h3>
                        <p class="text-xs text-imperial-primary font-medium">Logistics</p>
                    </div>
                </a>

                <!-- CLIENT 6 -->
                <a href="#" class="group block bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="aspect-[3/2] w-full overflow-hidden bg-gray-50 rounded-t-lg flex items-center justify-center relative">
                        <img src="https://picsum.photos/id/185/400/300" alt="Corporate Client" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-sm font-bold text-gray-900 mb-1">Financial Hub</h3>
                        <p class="text-xs text-imperial-primary font-medium">Bank</p>
                    </div>
                </a>

                <!-- CLIENT 7 -->
                <a href="#" class="group block bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="aspect-[3/2] w-full overflow-hidden bg-gray-50 rounded-t-lg flex items-center justify-center relative">
                        <img src="https://picsum.photos/id/186/400/300" alt="Corporate Client" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-sm font-bold text-gray-900 mb-1">Health Authority</h3>
                        <p class="text-xs text-imperial-primary font-medium">Insurance</p>
                    </div>
                </a>

                <!-- CLIENT 8 -->
                <a href="#" class="group block bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="aspect-[3/2] w-full overflow-hidden bg-gray-50 rounded-t-lg flex items-center justify-center relative">
                        <img src="https://picsum.photos/id/187/400/300" alt="Corporate Client" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-imperial-primary/0 group-hover:bg-imperial-primary/10 transition-colors duration-300"></div>
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-sm font-bold text-gray-900 mb-1">Educational Leader</h3>
                        <p class="text-xs text-imperial-primary font-medium">School</p>
                    </div>
                </a>

            </div>
        </div>

        <!-- QUERY FORM SECTION -->
        <section class="bg-gray-50 py-16 border-t border-gray-200">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">
                    
                    <div class="lg:col-start-2 lg:col-span-10 w-full">
                        
                        <div class="text-center mb-10">
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Query contact form</h2>
                            <p class="text-gray-600 font-roboto max-w-2xl mx-auto">
                                Just leave us your details here and we will call you back within a few working hours
                            </p>
                        </div>

                        <form action="#" method="POST" class="bg-white p-6 md:p-10 rounded-xl shadow-sm border border-gray-100">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                                
                                <!-- Name Field (Span 12) -->
                                <div class="md:col-span-12 form-anim">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Name <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="name" placeholder="Type name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-imperial-primary focus:border-imperial-primary outline-none transition duration-200 text-gray-900 placeholder-gray-400">
                                    </div>
                                </div>

                                <!-- Phone Field (Span 6) -->
                                <div class="md:col-span-6 form-anim">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Phone No <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="tel" name="phone" placeholder="Type phone number" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-imperial-primary focus:border-imperial-primary outline-none transition duration-200 text-gray-900 placeholder-gray-400">
                                    </div>
                                </div>

                                <!-- Email Field (Span 6) -->
                                <div class="md:col-span-6 form-anim">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="email" name="email" placeholder="Type email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-imperial-primary focus:border-imperial-primary outline-none transition duration-200 text-gray-900 placeholder-gray-400">
                                    </div>
                                </div>

                                <!-- Description Field (Span 12) -->
                                <div class="md:col-span-12 form-anim">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Description
                                    </label>
                                    <div class="relative">
                                        <textarea name="description" rows="3" placeholder="Type description" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-imperial-primary focus:border-imperial-primary outline-none transition duration-200 text-gray-900 placeholder-gray-400"></textarea>
                                    </div>
                                </div>

                                <!-- Captcha Placeholder (Span 12) -->
                                <div class="md:col-span-12">
                                    <div class="bg-gray-50 border border-gray-200 rounded p-4 flex items-center justify-start gap-4 w-fit">
                                        <!-- Placeholder for hCaptcha iframe logic -->
                                        <div class="w-8 h-8 border-2 border-gray-300 rounded bg-white flex items-center justify-center cursor-pointer hover:bg-gray-50">
                                            <div class="w-4 h-4 bg-white rounded-sm"></div>
                                        </div>
                                        <span class="text-xs text-gray-500 select-none">I'm not a robot</span>
                                    </div>
                                </div>

                                <!-- Submit Button (Span 12) -->
                                <div class="md:col-span-12 mt-2 form-anim">
                                    <button type="submit" class="w-full bg-imperial-primary hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md shadow transition duration-300 flex justify-center items-center">
                                        Continue
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </main>

@endsection