@extends('layouts.front')

@section('title', 'Services - Imperial Health Bangladesh')

@section('content')

<!-- 
  Ensure your tailwind.config.js is exactly as requested:
  tailwind.config = {
      theme: {
          extend: {
              colors: {
                  imperial: {
                      primary: '#8A2061',
                      dark: '#690E46',
                      light: '#FCFCFC',
                      text: '#282828',
                      gray: '#646464'
                  }
              },
              fontFamily: {
                  sans: ['"IBM Plex Sans"', 'sans-serif'],
                  roboto: ['"Roboto"', 'sans-serif'],
              }
          }
      }
  }
-->

<!-- Main Content Start -->
<main class="font-sans text-imperial-text bg-imperial-light">

    <!-- NEW HERO SECTION (Overlap Style) -->
    <section class="relative h-[65vh]">
        <!-- Using the membership image from the original source for better visual consistency, 
             or you can use the picsum link: https://picsum.photos/seed/imperial_hero_about/1920/1080 -->
        <img src="https://img.freepik.com/free-vector/businessman-choosing-options-computer_1262-19222.jpg" 
             alt="Membership Background" 
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/30"></div>
    </section>

    <!-- INTRO OVERLAP SECTION -->
    <section class="-mt-24 relative z-10">
        <div class="max-w-5xl mx-auto bg-white px-10 py-16 text-center shadow-xl">    
            <h1 class="text-3xl font-bold mb-4 text-imperial-text">Membership Plan</h1>
            <p class="text-imperial-gray max-w-3xl mx-auto text-lg leading-relaxed">
                Our membership plans cover healthcare needs of you and your family. The plans allow you to access doctors as many times as you need for a one-time purchase to proactively manage your health, be it yearly or for a certain period. Membership plans also cover a set of tests especially tailored by experienced doctors to meet your healthcare needs.
            </p>
        </div>
    </section>

    <!-- Annual Membership Plan (Slider) -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-imperial-text mb-8 border-l-4 border-imperial-primary pl-4">Annual Membership Plan</h2>
            
            <div class="flex overflow-x-auto gap-6 pb-6 snap-x snap-mandatory scrollbar-hide -mx-4 px-4 md:mx-0 md:px-0">
                <!-- Card 1: Gold -->
                <article class="snap-center shrink-0 w-[85vw] md:w-[350px] bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="/services/imperial-gold-annual-membership-plan/" class="block h-48 overflow-hidden">
                        <img src="https://img.freepik.com/premium-vector/airplane-icon-design-illustration-flight-transport-sign-gold-color-style_565585-12199.jpg" alt="imperial Gold" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold mb-2"><a href="/services/imperial-gold-annual-membership-plan/" class="hover:text-imperial-primary text-imperial-text">imperial Gold Annual Membership Plan</a></h3>
                            <p class="text-lg font-semibold text-imperial-primary">Price: ৳ 12,000</p>
                            <p class="text-sm text-imperial-gray mt-1">12 Months</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-4 mt-auto">
                            <button class="bg-imperial-primary text-white py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-dark transition">Buy Now</button>
                            <button class="border border-imperial-primary text-imperial-primary py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-light transition">Add to Cart</button>
                        </div>
                        <div class="text-center">
                            <a href="/services/imperial-gold-annual-membership-plan/" class="text-imperial-primary font-medium text-sm hover:underline">See details</a>
                        </div>
                    </div>
                </article>

                <!-- Card 2: Silver -->
                <article class="snap-center shrink-0 w-[85vw] md:w-[350px] bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="/services/imperial-silver-annual-membership-plan/" class="block h-48 overflow-hidden">
                        <img src="https://img.freepik.com/premium-vector/silver-vip-cards-with-minimalist-style_23-2147662921.jpg" alt="imperial Silver" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold mb-2"><a href="/services/imperial-silver-annual-membership-plan/" class="hover:text-imperial-primary text-imperial-text">imperial Silver Annual Membership Plan</a></h3>
                            <p class="text-lg font-semibold text-imperial-primary">Price: ৳ 8,400</p>
                            <p class="text-sm text-imperial-gray mt-1">12 Months</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-4 mt-auto">
                            <button class="bg-imperial-primary text-white py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-dark transition">Buy Now</button>
                            <button class="border border-imperial-primary text-imperial-primary py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-light transition">Add to Cart</button>
                        </div>
                        <div class="text-center">
                            <a href="/services/imperial-silver-annual-membership-plan/" class="text-imperial-primary font-medium text-sm hover:underline">See details</a>
                        </div>
                    </div>
                </article>

                <!-- Card 3: Platinum -->
                <article class="snap-center shrink-0 w-[85vw] md:w-[350px] bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="/services/imperial-platinum-annual-membership-plan/" class="block h-48 overflow-hidden">
                        <img src=https://img.freepik.com/free-vector/holographic-silver-gradient-sticker-label-hologram-stickers-gradient-sticker-shinny-tag_40876-4096.jpg" alt="imperial Platinum" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold mb-2"><a href="/services/imperial-platinum-annual-membership-plan/" class="hover:text-imperial-primary text-imperial-text">imperial Platinum Annual Membership Plan</a></h3>
                            <p class="text-lg font-semibold text-imperial-primary">Price: ৳ 21,000</p>
                            <p class="text-sm text-imperial-gray mt-1">12 Months</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-4 mt-auto">
                            <button class="bg-imperial-primary text-white py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-dark transition">Buy Now</button>
                            <button class="border border-imperial-primary text-imperial-primary py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-light transition">Add to Cart</button>
                        </div>
                        <div class="text-center">
                            <a href="/services/imperial-platinum-annual-membership-plan/" class="text-imperial-primary font-medium text-sm hover:underline">See details</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Special Plan (Slider) -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-imperial-text mb-8 border-l-4 border-imperial-primary pl-4">Special Plan</h2>
            
            <div class="flex overflow-x-auto gap-6 pb-6 snap-x snap-mandatory scrollbar-hide -mx-4 px-4 md:mx-0 md:px-0">
                <!-- Card 1: Prediabetes -->
                <article class="snap-center shrink-0 w-[85vw] md:w-[350px] bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="/services/prediabetes-plan/" class="block h-48 overflow-hidden">
                        <img src="https://img.freepik.com/free-photo/confident-doctor-clinic_23-2151983463.jpg?t=st=1768969491~exp=1768973091~hmac=0b80efa6e463a76fba460c81e04ac6daea365c688be9f5a424a45065f1a73ba0&w=1060" alt="Prediabetes Plan" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold mb-2"><a href="/services/prediabetes-plan/" class="hover:text-imperial-primary text-imperial-text">Prediabetes Plan</a></h3>
                            <p class="text-lg font-semibold text-imperial-primary">Price: ৳ 27,000</p>
                            <p class="text-sm text-imperial-gray mt-1">12 Months</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-4 mt-auto">
                            <button class="bg-imperial-primary text-white py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-dark transition">Buy Now</button>
                            <button class="border border-imperial-primary text-imperial-primary py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-light transition">Add to Cart</button>
                        </div>
                        <div class="text-center">
                            <a href="/services/prediabetes-plan/" class="text-imperial-primary font-medium text-sm hover:underline">See details</a>
                        </div>
                    </div>
                </article>

                <!-- Card 2: Diabetes -->
                <article class="snap-center shrink-0 w-[85vw] md:w-[350px] bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="/services/diabetes-plan/" class="block h-48 overflow-hidden">
                        <img src="https://img.freepik.com/free-photo/confident-doctor-clinic_23-2151983463.jpg?t=st=1768969491~exp=1768973091~hmac=0b80efa6e463a76fba460c81e04ac6daea365c688be9f5a424a45065f1a73ba0&w=1060" alt="Diabetes Plan" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold mb-2"><a href="/services/diabetes-plan/" class="hover:text-imperial-primary text-imperial-text">Diabetes Plan</a></h3>
                            <p class="text-lg font-semibold text-imperial-primary">Price: ৳ 42,000</p>
                            <p class="text-sm text-imperial-gray mt-1">12 Months</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-4 mt-auto">
                            <button class="bg-imperial-primary text-white py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-dark transition">Buy Now</button>
                            <button class="border border-imperial-primary text-imperial-primary py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-light transition">Add to Cart</button>
                        </div>
                        <div class="text-center">
                            <a href="/services/diabetes-plan/" class="text-imperial-primary font-medium text-sm hover:underline">See details</a>
                        </div>
                    </div>
                </article>

                <!-- Card 3: Cardiac & Hypertension -->
                <article class="snap-center shrink-0 w-[85vw] md:w-[350px] bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="/services/cardiac-hypertension-plan/" class="block h-48 overflow-hidden">
                        <img src="https://img.freepik.com/free-photo/confident-doctor-clinic_23-2151983463.jpg?t=st=1768969491~exp=1768973091~hmac=0b80efa6e463a76fba460c81e04ac6daea365c688be9f5a424a45065f1a73ba0&w=1060" alt="Cardiac & Hypertension" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold mb-2"><a href="/services/cardiac-hypertension-plan/" class="hover:text-imperial-primary text-imperial-text">Cardiac and Hypertension Plan</a></h3>
                            <p class="text-lg font-semibold text-imperial-primary">Price: ৳ 42,000</p>
                            <p class="text-sm text-imperial-gray mt-1">12 Months</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-4 mt-auto">
                            <button class="bg-imperial-primary text-white py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-dark transition">Buy Now</button>
                            <button class="border border-imperial-primary text-imperial-primary py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-light transition">Add to Cart</button>
                        </div>
                        <div class="text-center">
                            <a href="/services/cardiac-hypertension-plan/" class="text-imperial-primary font-medium text-sm hover:underline">See details</a>
                        </div>
                    </div>
                </article>

                <!-- Card 4: Maternity -->
                <article class="snap-center shrink-0 w-[85vw] md:w-[350px] bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="/services/maternity-plan/" class="block h-48 overflow-hidden">
                        <img src="https://img.freepik.com/free-photo/confident-doctor-clinic_23-2151983463.jpg?t=st=1768969491~exp=1768973091~hmac=0b80efa6e463a76fba460c81e04ac6daea365c688be9f5a424a45065f1a73ba0&w=1060" alt="Maternity Plan" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold mb-2"><a href="/services/maternity-plan/" class="hover:text-imperial-primary text-imperial-text">Maternity Plan</a></h3>
                            <p class="text-lg font-semibold text-imperial-primary">Price: ৳ 40,800</p>
                            <p class="text-sm text-imperial-gray mt-1">12 Months</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-4 mt-auto">
                            <button class="bg-imperial-primary text-white py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-dark transition">Buy Now</button>
                            <button class="border border-imperial-primary text-imperial-primary py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-light transition">Add to Cart</button>
                        </div>
                        <div class="text-center">
                            <a href="/services/maternity-plan/" class="text-imperial-primary font-medium text-sm hover:underline">See details</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Amar Jotno Plan (Video Consultation) -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-imperial-text mb-8 border-l-4 border-imperial-primary pl-4">Amar Jotno Plan (Doctors Video Consultation)</h2>
            
            <div class="flex overflow-x-auto gap-6 pb-6 snap-x snap-mandatory scrollbar-hide -mx-4 px-4 md:mx-0 md:px-0">
                <!-- Card 1: 12 Months -->
                <article class="snap-center shrink-0 w-[85vw] md:w-[350px] bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="/services/12-month-video-consultation-plan/" class="block h-48 overflow-hidden">
                        <img src="https://img.freepik.com/free-photo/confident-doctor-clinic_23-2151983463.jpg?t=st=1768969491~exp=1768973091~hmac=0b80efa6e463a76fba460c81e04ac6daea365c688be9f5a424a45065f1a73ba0&w=1060" alt="12 Month Video Consultation" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold mb-2"><a href="/services/12-month-video-consultation-plan/" class="hover:text-imperial-primary text-imperial-text">12 Months Video Consultation Plan</a></h3>
                            <p class="text-lg font-semibold text-imperial-primary">Price: ৳ 6,250</p>
                            <p class="text-sm text-imperial-gray mt-1">12 Months</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-4 mt-auto">
                            <button class="bg-imperial-primary text-white py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-dark transition">Buy Now</button>
                            <button class="border border-imperial-primary text-imperial-primary py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-light transition">Add to Cart</button>
                        </div>
                        <div class="text-center">
                            <a href="/services/12-month-video-consultation-plan/" class="text-imperial-primary font-medium text-sm hover:underline">See details</a>
                        </div>
                    </div>
                </article>

                <!-- Card 2: 6 Months -->
                <article class="snap-center shrink-0 w-[85vw] md:w-[350px] bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="/services/6-month-video-consultation-plan/" class="block h-48 overflow-hidden">
                        <img src="https://img.freepik.com/free-photo/confident-doctor-clinic_23-2151983463.jpg?t=st=1768969491~exp=1768973091~hmac=0b80efa6e463a76fba460c81e04ac6daea365c688be9f5a424a45065f1a73ba0&w=1060" alt="6 Month Video Consultation" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold mb-2"><a href="/services/6-month-video-consultation-plan/" class="hover:text-imperial-primary text-imperial-text">6 Months Video Consultation Plan</a></h3>
                            <p class="text-lg font-semibold text-imperial-primary">Price: ৳ 5,050</p>
                            <p class="text-sm text-imperial-gray mt-1">6 Months</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-4 mt-auto">
                            <button class="bg-imperial-primary text-white py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-dark transition">Buy Now</button>
                            <button class="border border-imperial-primary text-imperial-primary py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-light transition">Add to Cart</button>
                        </div>
                        <div class="text-center">
                            <a href="/services/6-month-video-consultation-plan/" class="text-imperial-primary font-medium text-sm hover:underline">See details</a>
                        </div>
                    </div>
                </article>

                <!-- Card 3: 3 Months -->
                <article class="snap-center shrink-0 w-[85vw] md:w-[350px] bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <a href="/services/3-month-video-consultation-plan/" class="block h-48 overflow-hidden">
                        <img src="https://img.freepik.com/free-photo/confident-doctor-clinic_23-2151983463.jpg?t=st=1768969491~exp=1768973091~hmac=0b80efa6e463a76fba460c81e04ac6daea365c688be9f5a424a45065f1a73ba0&w=1060" alt="3 Month Video Consultation" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold mb-2"><a href="/services/3-month-video-consultation-plan/" class="hover:text-imperial-primary text-imperial-text">3 Months Video Consultation Plan</a></h3>
                            <p class="text-lg font-semibold text-imperial-primary">Price: ৳ 3,850</p>
                            <p class="text-sm text-imperial-gray mt-1">3 Months</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-4 mt-auto">
                            <button class="bg-imperial-primary text-white py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-dark transition">Buy Now</button>
                            <button class="border border-imperial-primary text-imperial-primary py-2 px-4 rounded text-sm font-semibold hover:bg-imperial-light transition">Add to Cart</button>
                        </div>
                        <div class="text-center">
                            <a href="/services/3-month-video-consultation-plan/" class="text-imperial-primary font-medium text-sm hover:underline">See details</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-imperial-text mb-2">Frequently Asked Questions</h2>
                <p class="text-imperial-gray">Take a look at most commonly asked questions. We are here to help.</p>
            </div>

            <div class="space-y-4">
                <!-- FAQ 1 -->
                <details class="group bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <summary class="flex justify-between items-center p-4 cursor-pointer list-none hover:bg-imperial-light transition">
                        <span class="font-semibold text-imperial-text">How can I book a plan?</span>
                        <svg class="w-5 h-5 text-imperial-primary transform group-open:rotate-45 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </summary>
                    <div class="p-4 pt-0 text-imperial-gray leading-relaxed border-t border-gray-100">
                        <p>You can book a plan by visiting our centers or using our online booking system.</p>
                    </div>
                </details>

                <!-- FAQ 2 -->
                <details class="group bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <summary class="flex justify-between items-center p-4 cursor-pointer list-none hover:bg-imperial-light transition">
                        <span class="font-semibold text-imperial-text">Why would I buy a plan if they are not sick?</span>
                        <svg class="w-5 h-5 text-imperial-primary transform group-open:rotate-45 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </summary>
                    <div class="p-4 pt-0 text-imperial-gray leading-relaxed border-t border-gray-100">
                        <p>Preventive care is key. Our plans help you monitor health proactively, catching issues early before they become serious.</p>
                    </div>
                </details>

                <!-- FAQ 3 -->
                <details class="group bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <summary class="flex justify-between items-center p-4 cursor-pointer list-none hover:bg-imperial-light transition">
                        <span class="font-semibold text-imperial-text">Are visiting specialists included in unlimited doctor access?</span>
                        <svg class="w-5 h-5 text-imperial-primary transform group-open:rotate-45 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </summary>
                    <div class="p-4 pt-0 text-imperial-gray leading-relaxed border-t border-gray-100">
                        <p>Access depends on the specific plan. Please refer to "See details" section of the specific membership card.</p>
                    </div>
                </details>

                <!-- FAQ 4 -->
                <details class="group bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <summary class="flex justify-between items-center p-4 cursor-pointer list-none hover:bg-imperial-light transition">
                        <span class="font-semibold text-imperial-text">What are excluded from 25% off for additional services?</span>
                        <svg class="w-5 h-5 text-imperial-primary transform group-open:rotate-45 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </summary>
                    <div class="p-4 pt-0 text-imperial-gray leading-relaxed border-t border-gray-100">
                        <p>Certain specialized procedures and external medications may be excluded. Please check specific terms and conditions.</p>
                    </div>
                </details>
            </div>
        </div>
    </section>

</main>
<!-- Main Content End -->

@endsection