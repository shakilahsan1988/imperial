@extends('layouts.front')

@section('title', 'Services - Imperial Health Bangladesh')

@section('content')

    <!-- HERO SECTION -->
    <section class="relative h-[65vh] z-0">
        <img src="{{ asset('assets/front/images/services/services.jpg') }}" alt="Healthcare Background" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/30"></div>
    </section>

    <!-- INTRO OVERLAP SECTION -->
    <section class="-mt-24 relative z-10 mb-16">
        <div class="max-w-5xl mx-auto bg-white px-10 py-16 text-center shadow-xl">    
            <h1 class="text-3xl font-semibold mb-4 text-imperial-text">Services</h1>
            <p class="text-gray-600 max-w-3xl mx-auto">
              We take care of all your outpatient needs under one roof
            </p>
        </div>
    </section>
    
    <!-- 1. CONSULTATIONS -->
    <section class="border-b border-gray-200 py-16 md:py-20">
        <div class="max-w-6xl mx-auto px-6 w-full flex flex-col md:flex-row items-center gap-8 md:gap-12">
            <div class="md:w-2/3">
                <h2 class="text-2xl md:text-3xl font-bold text-imperial-primary mb-4">Consultations</h2>
                <p class="text-gray-600 leading-relaxed">
                    Imperial’s caring doctors and healthcare providers take the time to listen and understand your needs and all doctor consultations, in-person or virtual, last for at least 15 minutes. They treat you with the respect and empathy you deserve and have years of local and international experience to give you advice that you can rely on.
                </p>
            </div>
            <div class="md:w-1/3 flex justify-start md:justify-end w-full">
                <a href="{{ route('service-details') }}" class="inline-flex items-center gap-2 text-imperial-primary font-semibold border-2 border-imperial-primary px-8 py-3 rounded hover:bg-imperial-primary hover:text-white transition-colors">
                    Read More
                </a>
            </div>
        </div>
    </section>

    <!-- 2. DIAGNOSTICS -->
    <section class="border-b border-gray-200 py-16 md:py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 w-full flex flex-col md:flex-row items-center gap-8 md:gap-12">
            <div class="md:w-2/3">
                <h2 class="text-2xl md:text-3xl font-bold text-imperial-primary mb-4">Diagnostics</h2>
                <p class="text-gray-600 leading-relaxed">
                    Imperial’s state-of-the-art diagnostic services consist of seven laboratories including the first Molecular Cancer Diagnostics laboratory in Bangladesh as well as comprehensive imaging exams. Our laboratories received Bangladesh Accreditation Board (BAB) accreditation and ISO 15189-2012 international accreditation. For external validation, Imperial participates in RIQAS, the world’s largest international external quality assessment scheme, and receives 99.9% average monthly accuracy score.
                </p>
            </div>
            <div class="md:w-1/3 flex justify-start md:justify-end w-full">
                <a href="{{ route('service-details') }}" class="inline-flex items-center gap-2 text-imperial-primary font-semibold border-2 border-imperial-primary px-8 py-3 rounded hover:bg-imperial-primary hover:text-white transition-colors">
                    Read More
                </a>
            </div>
        </div>
    </section>

    <!-- 3. PHARMACY + E-PHARMACY -->
    <section class="border-b border-gray-200 py-16 md:py-20">
        <div class="max-w-6xl mx-auto px-6 w-full flex flex-col md:flex-row items-center gap-8 md:gap-12">
            <div class="md:w-2/3">
                <h2 class="text-2xl md:text-3xl font-bold text-imperial-primary mb-4">Pharmacy + E-Pharmacy</h2>
                <p class="text-gray-600 leading-relaxed">
                    At Imperial’s in-house model pharmacy, approved by the Directorate General of Drug Administration (DGDA), medicines are sourced directly from the manufacturers and monitored by Imperial’s Grade A pharmacists to ensure the authenticity and quality of the drugs. You can directly purchase medicines at Imperial and also order online and get your prescription delivered to your doorsteps.
                </p>
            </div>
            <div class="md:w-1/3 flex justify-start md:justify-end w-full">
                <a href="{{ route('service-details') }}" class="inline-flex items-center gap-2 text-imperial-primary font-semibold border-2 border-imperial-primary px-8 py-3 rounded hover:bg-imperial-primary hover:text-white transition-colors">
                    Read More
                </a>
            </div>
        </div>
    </section>

    <!-- 4. HEALTH CHECKS & PACKAGES -->
    <section class="border-b border-gray-200 py-16 md:py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 w-full flex flex-col md:flex-row items-center gap-8 md:gap-12">
            <div class="md:w-2/3">
                <h2 class="text-2xl md:text-3xl font-bold text-imperial-primary mb-4">Health Checks & Packages</h2>
                <p class="text-gray-600 leading-relaxed">
                    Imperial believes everyone should have access to convenient, affordable, and high-quality healthcare. Our health checks and packages are specifically designed around your needs to help you stay on top of your health, no matter your age, gender, or needs.
                </p>
            </div>
            <div class="md:w-1/3 flex justify-start md:justify-end w-full">
                <a href="{{ route('health-check') }}" class="inline-flex items-center gap-2 text-imperial-primary font-semibold border-2 border-imperial-primary px-8 py-3 rounded hover:bg-imperial-primary hover:text-white transition-colors">
                    View Packages
                </a>
            </div>
        </div>
    </section>

    <!-- 5. MEMBERSHIP PLANS -->
    <section class="border-b border-gray-200 py-16 md:py-20">
        <div class="max-w-6xl mx-auto px-6 w-full flex flex-col md:flex-row items-center gap-8 md:gap-12">
            <div class="md:w-2/3">
                <h2 class="text-2xl md:text-3xl font-bold text-imperial-primary mb-4">Membership Plans</h2>
                <p class="text-gray-600 leading-relaxed">
                    Imperial’s membership plans ensure you and your family receive ongoing care throughout the year. Our plans include one health check, unlimited consultations with family doctors, and discounted rates on lab tests and diagnostics to proactively help you manage your health. Plans can be yearly or for a certain duration.
                </p>
            </div>
            <div class="md:w-1/3 flex justify-start md:justify-end w-full">
                <a href="{{ route('membership') }}" class="inline-flex items-center gap-2 text-imperial-primary font-semibold border-2 border-imperial-primary px-8 py-3 rounded hover:bg-imperial-primary hover:text-white transition-colors">
                    View Plans
                </a>
            </div>
        </div>
    </section>

    <!-- 6. VACCINES -->
    <section class="border-b border-gray-200 py-16 md:py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 w-full flex flex-col md:flex-row items-center gap-8 md:gap-12">
            <div class="md:w-2/3">
                <h2 class="text-2xl md:text-3xl font-bold text-imperial-primary mb-4">Vaccines</h2>
                <p class="text-gray-600 leading-relaxed">
                    Imperial is an approved center for the Expanded Programme on Immunization (EPI) vaccines by the Government of Bangladesh. You can get your children vaccinated against six childhood diseases at Imperial Health. We also offer vaccinations against diseases such as flu, pneumonia, typhoid, hepatitis B, rabies, cholera, and varicella.
                </p>
            </div>
            <div class="md:w-1/3 flex justify-start md:justify-end w-full">
                <a href="{{ route('service-details') }}" class="inline-flex items-center gap-2 text-imperial-primary font-semibold border-2 border-imperial-primary px-8 py-3 rounded hover:bg-imperial-primary hover:text-white transition-colors">
                    Read More
                </a>
            </div>
        </div>
    </section>

    <!-- 7. REMOTE & HOME SERVICES -->
    <section class="border-b border-gray-200 py-16 md:py-20">
        <div class="max-w-6xl mx-auto px-6 w-full flex flex-col md:flex-row items-center gap-8 md:gap-12">
            <div class="md:w-2/3">
                <h2 class="text-2xl md:text-3xl font-bold text-imperial-primary mb-4">Remote & Home Services</h2>
                <p class="text-gray-600 leading-relaxed">
                    Imperial values your time and delivers services to cater your needs. You can book appointments for sample collection of any lab tests or home visits by our Family Medicine Doctors, physiotherapists or nurses and avail our services from the comfort of your home.
                </p>
            </div>
            <div class="md:w-1/3 flex justify-start md:justify-end w-full">
                <a href="{{ route('service-details') }}" class="inline-flex items-center gap-2 text-imperial-primary font-semibold border-2 border-imperial-primary px-8 py-3 rounded hover:bg-imperial-primary hover:text-white transition-colors">
                    Read More
                </a>
            </div>
        </div>
    </section>

    <!-- 8. BEAUTY + WELLNESS -->
    <section class="border-b border-gray-200 py-16 md:py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 w-full flex flex-col md:flex-row items-center gap-8 md:gap-12">
            <div class="md:w-2/3">
                <h2 class="text-2xl md:text-3xl font-bold text-imperial-primary mb-4">Beauty + Wellness</h2>
                <p class="text-gray-600 leading-relaxed">
                    Look your absolute best with the best skin, hair, and dental treatments at Imperial’s Beauty & Wellness Center. Our experienced dermatologists and dentists offer several treatments that you can choose from to achieve your desired results. Imperial also offers psychologists and psychosocial therapists to help you with stress, depression, and other mental health issues. Imperial’s Beauty & Wellness Center offers treatment ranging from traditional treatments like acupuncture to treatments involving modern technology like laser therapy all under the same roof.
                </p>
            </div>
            <div class="md:w-1/3 flex justify-start md:justify-end w-full">
                <a href="{{ route('service-details') }}" class="inline-flex items-center gap-2 text-imperial-primary font-semibold border-2 border-imperial-primary px-8 py-3 rounded hover:bg-imperial-primary hover:text-white transition-colors">
                    Read More
                </a>
            </div>
        </div>
    </section>

    <!-- 9. COVID-19 -->
    <section class="py-16 md:py-20">
        <div class="max-w-6xl mx-auto px-6 w-full flex flex-col md:flex-row items-center gap-8 md:gap-12">
            <div class="md:w-2/3">
                <h2 class="text-2xl md:text-3xl font-bold text-imperial-primary mb-4">COVID-19</h2>
                <p class="text-gray-600 leading-relaxed">
                    Imperial is one of the first private institutions to get approval from the Directorate General of Health Services (DGHS) to test samples for COVID-19. If you or any of your loved ones think you are infected by the coronavirus and want to get tested, you can book an appointment for a home sample collection and we will come to you. You can also get tested if you are traveling abroad and get your reports in the fastest time possible.
                </p>
            </div>
            <div class="md:w-1/3 flex justify-start md:justify-end w-full">
                <a href="{{ route('service-details') }}" class="inline-flex items-center gap-2 text-imperial-primary font-semibold border-2 border-imperial-primary px-8 py-3 rounded hover:bg-imperial-primary hover:text-white transition-colors">
                    Read More
                </a>
            </div>
        </div>
    </section>

@endsection