@extends('layouts.front')

@section('title', 'About Us - Imperial Health Bangladesh')

@section('content')

<!-- Press Release Detail -->
<article class="w-full bg-white">
    <section class="py-16 lg:py-24">
        <div class="container mx-auto px-6">
            
            <!-- Header Row: Title & Intro (Span 12) -->
            <div class="mb-12 lg:mb-16 max-w-5xl">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-imperial-text mb-8 font-sans leading-tight">
                    Praava Health appoints 4 new industry experts to Global Advisory Council
                </h1>
                <div class="richtext-intro">
                    <p class="text-lg md:text-xl text-gray-700 leading-loose font-light">
                        Healthcare brand Praava Health recently announced addition of four new members to its Global Advisory Council bringing the membership number to 28. The new members include are Dr Omar Ishrak, chair of Board of Directors at Intel Corporation and former chairman &amp; CEO of Medtronic; Robert Berg, founding member of Iridescent Data; Fredrik Debong, co-founder and chief compliance officer at hi.health and cofounder of mySugr.com and pioneers.io; and Lorraine Marchand, executive managing director at Enterprise Solutions and Strategic Partnerships, Merative (formerly IBM Watson Health) and Adjunct Professor, Columbia Business School.
                    </p>
                </div>
            </div>

            <!-- Content Row: Image (9 Cols) + Sidebar (3 Cols) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                
                <!-- Left Column: Press Image (Span 9) -->
                <div class="lg:col-span-9 order-1 lg:order-1">
                    <div class="rounded-lg overflow-hidden shadow-xl">
                        <img 
                            src="https://www.praavahealth.com/media-images/51TnLK3YKg-NPzx1g0g0hSKVW0c=/407/fill-1188x670-c0/praava_health_logo.png" 
                            alt="Praava Health Logo" 
                            class="w-full h-auto object-cover block"
                            loading="lazy"
                        >
                    </div>
                </div>

                <!-- Right Column: Sidebar Details (Span 3) -->
                <div class="lg:col-span-3 order-2 lg:order-2">
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-100 h-full">
                        <div class="text-card">
                            <div class="richtext-sidebar">
                                <p class="text-base text-gray-700 leading-relaxed font-medium">
                                    The new members comprising industry experts and entrepreneurs have deep expertise within fields of healthcare and technology, reads a press release.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
</article>
@endsection