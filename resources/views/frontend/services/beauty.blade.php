@extends('layouts.front')

@section('title', 'Beauty Wellness - Imperial Health Bangladesh')

@section('content')
<!-- Services Section -->
<section class="py-16 px-4 bg-gray-50">
    <div class="container mx-auto max-w-7xl">
        
        <!-- Responsive Grid: 1 col mobile, 2 col tablet, 3 col desktop -->
        <!-- The original CSS used a 12-column grid with span 4, which equals 3 items per row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- Card 1: Your Skin -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-xl transition-all duration-300">
                <!-- Text Content -->
                <div class="p-8 pb-4">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-imperial-primary transition-colors">Your Skin</h2>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        At Praava we treat your skin with care. From simply wanting to look fresher with a HydraFacial to more stubborn conditions like acne, our caring dermatologists are here to help.
                    </p>
                </div>

                <!-- Spacer/Image Area: flex-grow forces this to take remaining space -->
                <div class="flex-grow w-full overflow-hidden relative">
                    <img src="https://www.praavahealth.com/media-images/6DVXGMQghghVjr6B-yzngOAPT60=/266/fill-372x279-c0/Beauty__Wellness_your_skin_1.jpg" 
                         alt="Your Skin" 
                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                </div>

                <!-- Button Area: Sticks to bottom -->
                <div class="p-8 pt-4 mt-auto">
                    <a href="/praava-services/beauty-wellness/your-skin/" class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-imperial-primary text-white font-medium rounded-full hover:bg-imperial-600 transition-colors shadow-sm">
                        Read More
                        <!-- Simple Arrow Icon (SVG) -->
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Card 2: Your Smile -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-xl transition-all duration-300">
                <div class="p-8 pb-4">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-imperial-primary transition-colors">Your Smile</h2>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Your smile is your best asset and we help you to ensure that you can smile with confidence. Our caring dentists have years of experience with everything from teeth whitening to jacket crowns.
                    </p>
                </div>
                <div class="flex-grow w-full overflow-hidden relative">
                    <img src="https://www.praavahealth.com/media-images/zXHwJVRVgXp6YHs9qvHGXp3R5VY=/216/fill-372x279-c0/Beauty__Wellness_your_smile.jpeg" 
                         alt="Your Smile" 
                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8 pt-4 mt-auto">
                    <a href="/praava-services/beauty-wellness/your-smile/" class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-imperial-primary text-white font-medium rounded-full hover:bg-imperial-600 transition-colors shadow-sm">
                        Read More
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Card 3: Your Body -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-xl transition-all duration-300">
                <div class="p-8 pb-4">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-imperial-primary transition-colors">Your Body</h2>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        We want to understand your weight goals, so together we can help you achieve them. Our nutritionists create personalized plans to help you feel your best.
                    </p>
                </div>
                <div class="flex-grow w-full overflow-hidden relative">
                    <img src="https://www.praavahealth.com/media-images/nRyy8GWGpp64tGhlxMRmO5GAYK4=/168/fill-372x279-c0/Beauty__Wellness_your_body.png" 
                         alt="Your Body" 
                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8 pt-4 mt-auto">
                    <a href="/praava-services/beauty-wellness/your-body/" class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-imperial-primary text-white font-medium rounded-full hover:bg-imperial-600 transition-colors shadow-sm">
                        Read More
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Card 4: Your Wellness -->
            <!-- Note: With 3 columns on desktop, this card will wrap to a new row. 
                 If you want it centered, you can add 'lg:col-start-2' to this div. -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-xl transition-all duration-300">
                <div class="p-8 pb-4">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-imperial-primary transition-colors">Your Wellness</h2>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Physical, mental, and emotional health are all important aspects of a balanced and beautiful life. Our customized treatments are designed to help you reach that balance.
                    </p>
                </div>
                <div class="flex-grow w-full overflow-hidden relative">
                    <img src="https://www.praavahealth.com/media-images/1ugfsVdBDJas4WuSV0qcEAT2ntI=/169/fill-372x279-c0/Beauty__Wellness_your_wellness.png" 
                         alt="Your Wellness" 
                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8 pt-4 mt-auto">
                    <a href="/praava-services/beauty-wellness/your-wellness/" class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-imperial-primary text-white font-medium rounded-full hover:bg-imperial-600 transition-colors shadow-sm">
                        Read More
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection