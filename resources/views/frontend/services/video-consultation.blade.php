@extends('layouts.front')

@section('title', 'Amar Jotno Plans - Imperial Health Bangladesh')

@section('content')

    <!-- HERO SECTION -->
    <section class="relative h-[65vh] z-0">
        <img src="{{ asset('assets/front/images/services/consult.jpg') }}" alt="Healthcare Background" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/30"></div>
    </section>

    <!-- INTRO OVERLAP SECTION -->
    <section class="-mt-24 relative z-10 mb-16">
        <div class="max-w-5xl mx-auto bg-white px-10 py-16 text-center shadow-xl">    
            <h1 class="text-3xl font-semibold mb-4">Amar Jotno Plans</h1>
            <h2 class="text-xl text-gray-500 mb-4">Video consultations from comfort of your home</h2>
            <p class="text-gray-600 max-w-3xl mx-auto">
              We have right plan for you and your family! We are now offering video consultations with our doctors on monthly plan packages.
            </p>
        </div>
    </section>

    <!-- PLANS CAROUSEL SECTION -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- CARD 1: 3 Months -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden flex flex-col h-full hover:shadow-lg transition-shadow">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('assets/front/images/services/con1.png') }}" alt="3 Month Plan" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <a href="{{ route('membership') }}" class="block mb-2">
                            <h3 class="text-xl font-bold text-gray-800 hover:text-imperial-primary transition-colors">3 Months Video Consultation Plan</h3>
                        </a>
                        <h2 class="text-lg font-semibold text-imperial-primary mb-2">Price: ৳ 3,850</h2>
                        <p class="text-gray-500 mb-6">3 Months</p>
                        
                        <div class="grid grid-cols-2 gap-4 mt-auto mb-4">
                            <button class="bg-imperial-primary text-white py-2 px-4 rounded text-sm font-medium hover:bg-imperial-primary-dark transition-colors">Buy Now</button>
                            <button class="border border-gray-300 text-gray-700 py-2 px-4 rounded text-sm font-medium hover:bg-gray-50 transition-colors">Add to Cart</button>
                        </div>
                        
                        <div class="text-center mt-2">
                            <a href="{{ route('membership') }}" class="text-sm font-semibold text-imperial-primary hover:underline">See details</a>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: 6 Months -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden flex flex-col h-full hover:shadow-lg transition-shadow">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('assets/front/images/services/con2.jpg') }}" alt="6 Month Plan" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <a href="{{ route('membership') }}" class="block mb-2">
                            <h3 class="text-xl font-bold text-gray-800 hover:text-imperial-primary transition-colors">6 Months Video Consultation Plan</h3>
                        </a>
                        <h2 class="text-lg font-semibold text-imperial-primary mb-2">Price: ৳ 5,050</h2>
                        <p class="text-gray-500 mb-6">6 Months</p>
                        
                        <div class="grid grid-cols-2 gap-4 mt-auto mb-4">
                            <button class="bg-imperial-primary text-white py-2 px-4 rounded text-sm font-medium hover:bg-imperial-primary-dark transition-colors">Buy Now</button>
                            <button class="border border-gray-300 text-gray-700 py-2 px-4 rounded text-sm font-medium hover:bg-gray-50 transition-colors">Add to Cart</button>
                        </div>
                        
                        <div class="text-center mt-2">
                            <a href="{{ route('membership') }}" class="text-sm font-semibold text-imperial-primary hover:underline">See details</a>
                        </div>
                    </div>
                </div>

                <!-- CARD 3: 12 Months -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden flex flex-col h-full hover:shadow-lg transition-shadow">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('assets/front/images/services/con3.jpeg') }}" alt="12 Month Plan" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <a href="{{ route('membership') }}" class="block mb-2">
                            <h3 class="text-xl font-bold text-gray-800 hover:text-imperial-primary transition-colors">12 Months Video Consultation Plan</h3>
                        </a>
                        <h2 class="text-lg font-semibold text-imperial-primary mb-2">Price: ৳ 6,250</h2>
                        <p class="text-gray-500 mb-6">12 Months</p>
                        
                        <div class="grid grid-cols-2 gap-4 mt-auto mb-4">
                            <button class="bg-imperial-primary text-white py-2 px-4 rounded text-sm font-medium hover:bg-imperial-primary-dark transition-colors">Buy Now</button>
                            <button class="border border-gray-300 text-gray-700 py-2 px-4 rounded text-sm font-medium hover:bg-gray-50 transition-colors">Add to Cart</button>
                        </div>
                        
                        <div class="text-center mt-2">
                            <a href="{{ route('membership') }}" class="text-sm font-semibold text-imperial-primary hover:underline">See details</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- WHY CHOOSE SECTION -->
    <section class="py-16 md:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Left: Image -->
                <div class="order-2 md:order-1">
                    <img src="{{ asset('assets/front/images/services/con4.jpg') }}" alt="Why Choose Amar Jotno Plan" class="rounded-lg shadow-lg w-full h-auto object-cover">
                </div>

                <!-- Right: Content -->
                <div class="order-1 md:order-2">
                    <h2 class="text-2xl md:text-3xl font-bold text-imperial-primary mb-8">Why choose Amar Jotno Plan?</h2>
                    
                    <ul class="space-y-6">
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-imperial-primary text-white flex items-center justify-center text-xs mt-1 mr-3">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <span class="text-gray-700 text-lg leading-relaxed">Access to experienced, internationally trained doctors</span>
                        </li>
                        
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-imperial-primary text-white flex items-center justify-center text-xs mt-1 mr-3">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <span class="text-gray-700 text-lg leading-relaxed">Secure access: speak to our doctors via our own platform</span>
                        </li>

                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-imperial-primary text-white flex items-center justify-center text-xs mt-1 mr-3">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <span class="text-gray-700 text-lg leading-relaxed">Confidentiality: only patient and doctors can access chats</span>
                        </li>

                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-imperial-primary text-white flex items-center justify-center text-xs mt-1 mr-3">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <span class="text-gray-700 text-lg leading-relaxed">Quality: our doctors spend at least 15 minutes with each patient per session</span>
                        </li>

                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-imperial-primary text-white flex items-center justify-center text-xs mt-1 mr-3">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <span class="text-gray-700 text-lg leading-relaxed">Electronic Health Records (EHR) to easily access your medical history</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ SECTION (FIXED STRUCTURE) -->
    <section class="py-16 md:py-24" id="faq-block">
        <div class="max-w-5xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Frequently Asked Questions</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Take a look at most commonly asked questions. We are here to help.</p>
            </div>

            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="bg-white border-b border-gray-200 faq-wrapper">
                    <button onclick="toggleFaq(this)" class="w-full flex justify-between items-center py-6 text-left focus:outline-none group">
                        <div class="flex items-center gap-4">
                            <div class="faq-circle w-5 h-5 flex-shrink-0 text-imperial-primary">
                                <svg viewBox="0 0 20 21" fill="currentColor" class="w-full h-full"><path d="M10 0.75C4.48 0.75 0 5.23 0 10.75C0 16.27 4.48 20.75 10 20.75C15.52 20.75 20 16.27 20 10.75C20 5.23 15.52 0.75 10 0.75ZM15 11.75H11V15.75H9V11.75H5V9.75H9V5.75H11V9.75H15V11.75Z"></path></svg>
                            </div>
                            <span class="faq-text text-lg font-medium text-gray-800 group-hover:text-imperial-primary transition-colors">How do I book a video consultation?</span>
                        </div>
                        <div class="faq-icon w-6 h-6 flex items-center justify-center text-imperial-primary">
                            <i class="fa-solid fa-plus transition-transform duration-300 transform"></i>
                        </div>
                    </button>
                    <div class="faq-content hidden pb-6 pl-9 pr-6 text-gray-600">
                        <p>You can book a video consultation through our website by selecting a doctor and a time slot that suits you.</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white border-b border-gray-200 faq-wrapper">
                    <button onclick="toggleFaq(this)" class="w-full flex justify-between items-center py-6 text-left focus:outline-none group">
                        <div class="flex items-center gap-4">
                            <div class="faq-circle w-5 h-5 flex-shrink-0 text-imperial-primary">
                                <svg viewBox="0 0 20 21" fill="currentColor" class="w-full h-full"><path d="M10 0.75C4.48 0.75 0 5.23 0 10.75C0 16.27 4.48 20.75 10 20.75C15.52 20.75 20 16.27 20 10.75C20 5.23 15.52 0.75 10 0.75ZM15 11.75H11V15.75H9V11.75H5V9.75H9V5.75H11V9.75H15V11.75Z"></path></svg>
                            </div>
                            <span class="faq-text text-lg font-medium text-gray-800 group-hover:text-imperial-primary transition-colors">How long do video consultations last?</span>
                        </div>
                        <div class="faq-icon w-6 h-6 flex items-center justify-center text-imperial-primary">
                            <i class="fa-solid fa-plus transition-transform duration-300 transform"></i>
                        </div>
                    </button>
                    <div class="faq-content hidden pb-6 pl-9 pr-6 text-gray-600">
                        <p>Video consultations typically last for 15 minutes, ensuring you have enough time to discuss your health concerns.</p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white border-b border-gray-200 faq-wrapper">
                    <button onclick="toggleFaq(this)" class="w-full flex justify-between items-center py-6 text-left focus:outline-none group">
                        <div class="flex items-center gap-4">
                            <div class="faq-circle w-5 h-5 flex-shrink-0 text-imperial-primary">
                                <svg viewBox="0 0 20 21" fill="currentColor" class="w-full h-full"><path d="M10 0.75C4.48 0.75 0 5.23 0 10.75C0 16.27 4.48 20.75 10 20.75C15.52 20.75 20 16.27 20 10.75C20 5.23 15.52 0.75 10 0.75ZM15 11.75H11V15.75H9V11.75H5V9.75H9V5.75H11V9.75H15V11.75Z"></path></svg>
                            </div>
                            <span class="faq-text text-lg font-medium text-gray-800 group-hover:text-imperial-primary transition-colors">How will I receive my prescription after a consultation?</span>
                        </div>
                        <div class="faq-icon w-6 h-6 flex items-center justify-center text-imperial-primary">
                            <i class="fa-solid fa-plus transition-transform duration-300 transform"></i>
                        </div>
                    </button>
                    <div class="faq-content hidden pb-6 pl-9 pr-6 text-gray-600">
                        <p>After the consultation, doctor will upload your prescription to your account, which you can access digitally.</p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white border-b border-gray-200 faq-wrapper">
                    <button onclick="toggleFaq(this)" class="w-full flex justify-between items-center py-6 text-left focus:outline-none group">
                        <div class="flex items-center gap-4">
                            <div class="faq-circle w-5 h-5 flex-shrink-0 text-imperial-primary">
                                <svg viewBox="0 0 20 21" fill="currentColor" class="w-full h-full"><path d="M10 0.75C4.48 0.75 0 5.23 0 10.75C0 16.27 4.48 20.75 10 20.75C15.52 20.75 20 16.27 20 10.75C20 5.23 15.52 0.75 10 0.75ZM15 11.75H11V15.75H9V11.75H5V9.75H9V5.75H11V9.75H15V11.75Z"></path></svg>
                            </div>
                            <span class="faq-text text-lg font-medium text-gray-800 group-hover:text-imperial-primary transition-colors">How do I pay for a video consultation?</span>
                        </div>
                        <div class="faq-icon w-6 h-6 flex items-center justify-center text-imperial-primary">
                            <i class="fa-solid fa-plus transition-transform duration-300 transform"></i>
                        </div>
                    </button>
                    <div class="faq-content hidden pb-6 pl-9 pr-6 text-gray-600">
                        <p>Payment can be made securely online via credit card, mobile banking, or bKash.</p>
                    </div>
                </div>

                <!-- FAQ Item 5 (Open by default) -->
                <div class="bg-white border-b border-gray-200 faq-wrapper">
                    <button onclick="toggleFaq(this)" class="w-full flex justify-between items-center py-6 text-left focus:outline-none group">
                        <div class="flex items-center gap-4">
                            <div class="faq-circle w-5 h-5 flex-shrink-0 text-imperial-primary">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-full h-full"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM15 11H5V9H15V11Z" fill-opacity="0.5"></path></svg>
                            </div>
                            <span class="faq-text text-lg font-medium text-imperial-primary">What can I expect from a video consultation?</span>
                        </div>
                        <div class="faq-icon w-6 h-6 flex items-center justify-center text-imperial-primary">
                            <i class="fa-solid fa-minus transition-transform duration-300 transform"></i>
                        </div>
                    </button>
                    <!-- Content visible by default -->
                    <div class="faq-content pb-6 pl-9 pr-6 text-gray-600">
                        <p>We provide same great care via video consultation as we would in in-person consultations. Whether you are new to imperial or already a patient, a typical consultation will start with understanding your symptoms and medical history. The doctor will make recommendations and if necessary book a follow-up visit and/or prescribe medication.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ROBUST JS FOR THIS PAGE -->
    <script>
        function toggleFaq(button) {
            // Find wrapper parent to avoid DOM structure issues
            const wrapper = button.closest('.faq-wrapper');
            if (!wrapper) return;

            // Find elements strictly inside of wrapper
            const content = wrapper.querySelector('.faq-content');
            const icon = wrapper.querySelector('.faq-icon i');
            const svgContainer = wrapper.querySelector('.faq-circle');
            const title = wrapper.querySelector('.faq-text');

            if (!content) return;

            const isOpen = !content.classList.contains('hidden');

            if (isOpen) {
                // CLOSE
                content.classList.add('hidden');
                
                if (icon) {
                    icon.classList.remove('fa-minus');
                    icon.classList.add('fa-plus');
                }
                
                if (title) {
                    title.classList.remove('text-imperial-primary');
                    title.classList.add('text-gray-800');
                }

                if (svgContainer) {
                    svgContainer.innerHTML = '<svg viewBox="0 0 20 21" fill="currentColor" class="w-full h-full"><path d="M10 0.75C4.48 0.75 0 5.23 0 10.75C0 16.27 4.48 20.75 10 20.75C15.52 20.75 20 16.27 20 10.75C20 5.23 15.52 0.75 10 0.75ZM15 11.75H11V15.75H9V11.75H5V9.75H9V5.75H11V9.75H15V11.75Z"></path></svg>';
                }

            } else {
                // OPEN
                content.classList.remove('hidden');
                
                if (icon) {
                    icon.classList.remove('fa-plus');
                    icon.classList.add('fa-minus');
                }
                
                if (title) {
                    title.classList.remove('text-gray-800');
                    title.classList.add('text-imperial-primary');
                }

                if (svgContainer) {
                    svgContainer.innerHTML = '<svg viewBox="0 0 20 20" fill="currentColor" class="w-full h-full"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM15 11H5V9H15V11Z" fill-opacity="0.5"></path></svg>';
                }
            }
        }
    </script>

@endsection