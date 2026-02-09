@extends('layouts.front')

@section('title', 'About Us - Imperial Health Bangladesh')

@section('content')
<!-- Community Events Section -->
<section class="py-16 lg:py-24 bg-white">
    <div class="container mx-auto px-6">
        
        <!-- Section Header -->
        <div class="mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-imperial-text font-sans">Community Events</h1>
            <div class="w-20 h-1 bg-imperial-primary mt-4"></div>
        </div>

        <!-- Events Grid (3 Columns on Desktop) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Event 1 -->
            <div class="arcevent-col">
                <a href="{{ route('event-details') }}" rel="noopener noreferrer" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="press-imgwrap h-56 overflow-hidden relative">
                        <img src="{{ asset('assets/front/images/event/1.jpg') }}" alt="praava" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="card-textblock p-6">
                        <div class="text-header flex items-center gap-4 text-sm text-gray-500 mb-3 font-medium">
                            <time>Mar 07, 2017</time>
                            <span class="flex items-center gap-1 text-imperial-primary"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <h1 class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">CME: Molecular Cancer Diagnostics, Cancer Prevention, &amp; the “Moonshot” Program</h1>
                    </div>
                </a>
            </div>

            <!-- Event 2 -->
            <div class="arcevent-col">
                <a href="{{ route('event-details') }}" rel="noopener noreferrer" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="press-imgwrap h-56 overflow-hidden relative">
                        <img src="{{ asset('assets/front/images/event/2.webp') }}" alt="praava" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="card-textblock p-6">
                        <div class="text-header flex items-center gap-4 text-sm text-gray-500 mb-3 font-medium">
                            <time>Apr 05, 2017</time>
                            <span class="flex items-center gap-1 text-imperial-primary"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <h1 class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">The Journey of an Entrepreneur</h1>
                    </div>
                </a>
            </div>

            <!-- Event 3 -->
            <div class="arcevent-col">
                <a href="{{ route('event-details') }}" rel="noopener noreferrer" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="press-imgwrap h-56 overflow-hidden relative">
                        <img src="{{ asset('assets/front/images/event/3.jpg') }}" alt="praava" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="card-textblock p-6">
                        <div class="text-header flex items-center gap-4 text-sm text-gray-500 mb-3 font-medium">
                            <time>Apr 22, 2017</time>
                            <span class="flex items-center gap-1 text-imperial-primary"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <h1 class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Bondhon- An Informal Gathering to promote &amp; celebrate the power of collaboration</h1>
                    </div>
                </a>
            </div>

            <!-- Event 4 -->
            <div class="arcevent-col">
                <a href="{{ route('event-details') }}" rel="noopener noreferrer" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="press-imgwrap h-56 overflow-hidden relative">
                        <img src="{{ asset('assets/front/images/event/4.jpg') }}" alt="praava" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="card-textblock p-6">
                        <div class="text-header flex items-center gap-4 text-sm text-gray-500 mb-3 font-medium">
                            <time>Jul 17, 2017</time>
                            <span class="flex items-center gap-1 text-imperial-primary"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <h1 class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">World Hepatitis Day Awareness Program</h1>
                    </div>
                </a>
            </div>

            <!-- Event 5 -->
            <div class="arcevent-col">
                <a href="{{ route('event-details') }}" rel="noopener noreferrer" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="press-imgwrap h-56 overflow-hidden relative">
                        <img src="{{ asset('assets/front/images/event/5.jpg') }}" alt="praava" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="card-textblock p-6">
                        <div class="text-header flex items-center gap-4 text-sm text-gray-500 mb-3 font-medium">
                            <time>Jul 18, 2017</time>
                            <span class="flex items-center gap-1 text-imperial-primary"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <h1 class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">World Hepatitis Day Awareness Program</h1>
                    </div>
                </a>
            </div>

            <!-- Event 6 -->
            <div class="arcevent-col">
                <a href="{{ route('event-details') }}" rel="noopener noreferrer" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="press-imgwrap h-56 overflow-hidden relative">
                        <img src="{{ asset('assets/front/images/event/6.jpg') }}" alt="praava" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="card-textblock p-6">
                        <div class="text-header flex items-center gap-4 text-sm text-gray-500 mb-3 font-medium">
                            <time>Aug 24, 2017</time>
                            <span class="flex items-center gap-1 text-imperial-primary"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <h1 class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Praava Health Announces Its Ribbon Cutting Ceremony</h1>
                    </div>
                </a>
            </div>

            <!-- Event 7 -->
            <div class="arcevent-col">
                <a href="{{ route('event-details') }}" rel="noopener noreferrer" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="press-imgwrap h-56 overflow-hidden relative">
                        <img src="{{ asset('assets/front/images/event/7.jpg') }}" alt="praava" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="card-textblock p-6">
                        <div class="text-header flex items-center gap-4 text-sm text-gray-500 mb-3 font-medium">
                            <time>Aug 26, 2017</time>
                            <span class="flex items-center gap-1 text-imperial-primary"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <h1 class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">CME: CAR T Cell Therapy Achieving Lasting Remission in Late Stage Cancer</h1>
                    </div>
                </a>
            </div>

            <!-- Event 8 -->
            <div class="arcevent-col">
                <a href="{{ route('event-details') }}" rel="noopener noreferrer" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="press-imgwrap h-56 overflow-hidden relative">
                        <img src="{{ asset('assets/front/images/event/8.jpg') }}" alt="praava" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="card-textblock p-6">
                        <div class="text-header flex items-center gap-4 text-sm text-gray-500 mb-3 font-medium">
                            <time>Sep 26, 2017</time>
                            <span class="flex items-center gap-1 text-imperial-primary"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <h1 class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Praava Health at the Durga Puja Fair</h1>
                    </div>
                </a>
            </div>

            <!-- Event 9 -->
            <div class="arcevent-col">
                <a href="{{ route('event-details') }}" rel="noopener noreferrer" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="press-imgwrap h-56 overflow-hidden relative">
                        <img src="{{ asset('assets/front/images/event/9.jpg') }}" alt="praava" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="card-textblock p-6">
                        <div class="text-header flex items-center gap-4 text-sm text-gray-500 mb-3 font-medium">
                            <time>Apr 20, 2018</time>
                            <span class="flex items-center gap-1 text-imperial-primary"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <h1 class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">CME with Narayana Health Doctors</h1>
                    </div>
                </a>
            </div>

            <!-- Event 10 -->
            <div class="arcevent-col">
                <a href="{{ route('event-details') }}" rel="noopener noreferrer" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="press-imgwrap h-56 overflow-hidden relative">
                        <img src="{{ asset('assets/front/images/event/10.jpg') }}" alt="praava" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="card-textblock p-6">
                        <div class="text-header flex items-center gap-4 text-sm text-gray-500 mb-3 font-medium">
                            <time>May 19, 2018</time>
                            <span class="flex items-center gap-1 text-imperial-primary"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <h1 class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">World Family Doctor Day Rally</h1>
                    </div>
                </a>
            </div>

            <!-- Event 11 -->
            <div class="arcevent-col">
                <a href="{{ route('event-details') }}" rel="noopener noreferrer" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="press-imgwrap h-56 overflow-hidden relative">
                        <img src="{{ asset('assets/front/images/event/11.jpg') }}" alt="praava" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="card-textblock p-6">
                        <div class="text-header flex items-center gap-4 text-sm text-gray-500 mb-3 font-medium">
                            <time>Jul 16, 2018</time>
                            <span class="flex items-center gap-1 text-imperial-primary"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <h1 class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Health + Wellness Day</h1>
                    </div>
                </a>
            </div>

            <!-- Event 12 -->
            <div class="arcevent-col">
                <a href="{{ route('event-details') }}" rel="noopener noreferrer" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="press-imgwrap h-56 overflow-hidden relative">
                        <img src="{{ asset('assets/front/images/event/12.jpg') }}" alt="praava" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="card-textblock p-6">
                        <div class="text-header flex items-center gap-4 text-sm text-gray-500 mb-3 font-medium">
                            <time>Aug 03, 2018</time>
                            <span class="flex items-center gap-1 text-imperial-primary"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <h1 class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">BYLC Run: Running with Purpose</h1>
                    </div>
                </a>
            </div>

            <!-- Event 13 -->
            <div class="arcevent-col">
                <a href="{{ route('event-details') }}" rel="noopener noreferrer" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="press-imgwrap h-56 overflow-hidden relative">
                        <img src="{{ asset('assets/front/images/event/13.jpg') }}" alt="praava" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="card-textblock p-6">
                        <div class="text-header flex items-center gap-4 text-sm text-gray-500 mb-3 font-medium">
                            <time>Aug 04, 2018</time>
                            <span class="flex items-center gap-1 text-imperial-primary"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <h1 class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">CME: Noora Health</h1>
                    </div>
                </a>
            </div>

            <!-- Event 14 -->
            <div class="arcevent-col">
                <a href="{{ route('event-details') }}" rel="noopener noreferrer" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="press-imgwrap h-56 overflow-hidden relative">
                        <img src="{{ asset('assets/front/images/event/14.jpg') }}" alt="praava" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="card-textblock p-6">
                        <div class="text-header flex items-center gap-4 text-sm text-gray-500 mb-3 font-medium">
                            <time>Sep 12, 2018</time>
                            <span class="flex items-center gap-1 text-imperial-primary"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <h1 class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Career Fair at Bangladesh University of Professionals</h1>
                    </div>
                </a>
            </div>

            <!-- Event 15 -->
            <div class="arcevent-col">
                <a href="{{ route('event-details') }}" rel="noopener noreferrer" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="press-imgwrap h-56 overflow-hidden relative">
                        <img src="{{ asset('assets/front/images/event/15.jpg') }}" alt="praava" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="card-textblock p-6">
                        <div class="text-header flex items-center gap-4 text-sm text-gray-500 mb-3 font-medium">
                            <time>Sep 18, 2018</time>
                            <span class="flex items-center gap-1 text-imperial-primary"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <h1 class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Physiotherapy Presentation at AISD</h1>
                    </div>
                </a>
            </div>

            <!-- Event 16 -->
            <div class="arcevent-col">
                <a href="{{ route('event-details') }}" rel="noopener noreferrer" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="press-imgwrap h-56 overflow-hidden relative">
                        <img src="{{ asset('assets/front/images/event/16.jpg') }}" alt="praava" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="card-textblock p-6">
                        <div class="text-header flex items-center gap-4 text-sm text-gray-500 mb-3 font-medium">
                            <time>Sep 25, 2018</time>
                            <span class="flex items-center gap-1 text-imperial-primary"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <h1 class="text-lg font-bold text-imperial-text group-hover:text-imperial-primary transition leading-snug">Workplace Wellness Event at DAI</h1>
                    </div>
                </a>
            </div>

        </div>
    </div>
</section>
@endsection