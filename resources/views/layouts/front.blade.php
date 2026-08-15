<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    @php
        $infoSettings = setting('info') ?? [];
        // Blade's inline `@section('name', $value)` form already runs $value
        // through e() (see Illuminate\View\Concerns\ManagesLayouts::startSection),
        // so these are pre-escaped (or, on fallback, a safe hardcoded string).
        // They must be echoed raw ({!! !!}) below - {{ }} would escape twice.
        $pageTitle = trim($__env->yieldContent('title')) ?: 'Imperial Health Bangladesh';
        $defaultMetaDescription = e('Imperial Health is a multi-specialty healthcare provider in Dhaka, Bangladesh, offering doctor consultations, diagnostic lab tests, health check packages, and home sample collection.');
        // trim(...) ?: $default (not @yield's own default) so a section that
        // was defined but rendered empty (e.g. a model with no description)
        // still falls back, rather than emitting an empty meta tag.
        $metaDescription = trim($__env->yieldContent('meta_description')) ?: $defaultMetaDescription;
        $canonicalUrl = trim($__env->yieldContent('canonical')) ?: e(url()->current());
        $ogImageDefault = e(!empty($infoSettings['logo']) ? asset('img/' . $infoSettings['logo']) : asset('assets/front/images/logo.png'));
        $ogImage = trim($__env->yieldContent('og_image')) ?: $ogImageDefault;
        $ogType = trim($__env->yieldContent('og_type')) ?: 'website';
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{!! $pageTitle !!}</title>
    <meta name="description" content="{!! $metaDescription !!}">
    <link rel="canonical" href="{!! $canonicalUrl !!}">

    <!-- Open Graph -->
    <meta property="og:site_name" content="{{ $infoSettings['name'] ?? 'Imperial Health' }}">
    <meta property="og:type" content="{!! $ogType !!}">
    <meta property="og:title" content="{!! $pageTitle !!}">
    <meta property="og:description" content="{!! $metaDescription !!}">
    <meta property="og:url" content="{!! $canonicalUrl !!}">
    <meta property="og:image" content="{!! $ogImage !!}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{!! $pageTitle !!}">
    <meta name="twitter:description" content="{!! $metaDescription !!}">
    <meta name="twitter:image" content="{!! $ogImage !!}">

    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-icon-180x180.png') }}">
    <link rel="manifest" href="{{ asset('img/manifest.json') }}">

    <!-- Organization structured data -->
    {!! \App\Support\SchemaBuilder::script(\App\Support\SchemaBuilder::organization($infoSettings)) !!}

    @stack('schema')

    <!-- Fonts: Inter & Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind Config & Script -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
          theme: {
            extend: {
              colors: {
                indigo: {
                  50: '#e0f2fe',
                  100: '#bae6fd',
                  200: '#7dd3fc',
                  300: '#38bdf8',
                  400: '#0ea5e9',
                  500: '#0284c7',
                  600: '#007caa', /* Brand Teal */
                  700: '#0066a1',
                  800: '#075985',
                  900: '#0c4a6e',
                },
              }
            }
          }
        }
    </script>
    
    <style>
        /* Global Brand Color Overrides - Catch all Tailwind Indigo shades.
           Values here must match tailwind.config's indigo scale above (300:
           #38bdf8, 400: #0ea5e9, 500: #0284c7, 600: #007caa "Brand Teal",
           700: #0066a1) - previously text/bg-indigo-400 and -500 were
           swapped/off-by-one against the config, and no hover:* variant
           existed for 400/500 at all, so classes like hover:text-indigo-400
           silently fell through to the Tailwind CDN's own JIT-generated
           value instead of a value declared here. */
        .text-indigo-400 { color: #0ea5e9 !important; }
        .text-indigo-500 { color: #0284c7 !important; }
        .text-indigo-600 { color: #007caa !important; }
        .text-indigo-700 { color: #0066a1 !important; }

        .bg-indigo-50  { background-color: #f0f9ff !important; }
        .bg-indigo-100 { background-color: #e0f2fe !important; }
        .bg-indigo-400 { background-color: #0ea5e9 !important; }
        .bg-indigo-500 { background-color: #0284c7 !important; }
        .bg-indigo-600 { background-color: #007caa !important; }
        .bg-indigo-700 { background-color: #0066a1 !important; }

        .hover\:text-indigo-400:hover { color: #0ea5e9 !important; }
        .hover\:text-indigo-500:hover { color: #0284c7 !important; }
        .hover\:text-indigo-600:hover { color: #007caa !important; }
        .hover\:bg-indigo-400:hover { background-color: #0ea5e9 !important; }
        .hover\:bg-indigo-500:hover { background-color: #0284c7 !important; }
        .hover\:bg-indigo-600:hover { background-color: #007caa !important; }
        .hover\:bg-indigo-700:hover { background-color: #0066a1 !important; }
        .border-indigo-500 { border-color: #0284c7 !important; }
        .border-indigo-600 { border-color: #007caa !important; }
        .hover\:border-indigo-500:hover { border-color: #0284c7 !important; }
        .focus\:ring-indigo-500:focus { --tw-ring-color: #007caa !important; }

        /* Ensure header is always visible on mobile */
        @media (max-width: 1023px) {
            #main-header {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            .hidden.lg\:flex {
                display: none !important;
            }
        }
    </style>

    <!-- Modern UI Styles -->
    <link rel="stylesheet" href="{{ asset('css/modern.css') }}">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">

    @stack('styles')
</head>
<body class="font-sans antialiased overflow-x-hidden bg-white">

    <!-- INCLUDE HEADER -->
    @include('frontend.includes.header')

    <!-- MAIN CONTENT AREA -->
    <main>
        @yield('content')
    </main>

    <!-- INCLUDE FOOTER -->
    @include('frontend.includes.footer')

    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script type="text/javascript" src="{{ asset('assets/front/js/custom.js') }}"></script>

    @stack('scripts')
</body>
</html>