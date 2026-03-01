<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Imperial Health Bangladesh')</title>
    
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
        /* Global Brand Color Overrides - Catch all Tailwind Indigo shades */
        .text-indigo-400 { color: #38bdf8 !important; }
        .text-indigo-500 { color: #0ea5e9 !important; }
        .text-indigo-600 { color: #007caa !important; }
        .text-indigo-700 { color: #0066a1 !important; }
        
        .bg-indigo-50  { background-color: #f0f9ff !important; }
        .bg-indigo-100 { background-color: #e0f2fe !important; }
        .bg-indigo-400 { background-color: #38bdf8 !important; }
        .bg-indigo-500 { background-color: #0ea5e9 !important; }
        .bg-indigo-600 { background-color: #007caa !important; }
        .bg-indigo-700 { background-color: #0066a1 !important; }
        
        .hover\:bg-indigo-500:hover { background-color: #0ea5e9 !important; }
        .hover\:bg-indigo-600:hover { background-color: #007caa !important; }
        .hover\:bg-indigo-700:hover { background-color: #0066a1 !important; }
        .border-indigo-600 { border-color: #007caa !important; }
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