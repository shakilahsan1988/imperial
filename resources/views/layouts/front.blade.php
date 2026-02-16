<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Imperial Health Bangladesh')</title>
    
    <!-- Fonts: IBM Plex Sans & Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (via CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
    <!-- Tailwind Config -->



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

    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <script type="text/javascript" src="{{ asset('assets/front/js/custom.js') }}"></script>

    @stack('scripts')
</body>
</html>