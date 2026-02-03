<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imperial Health Bangladesh</title>
    
    <!-- Fonts: IBM Plex Sans & Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (via CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        imperial: {
                            primary: '#007caa', /* The primary blue */
                            dark: '#690E46',
                            light: '#4bb7db',/* The primary light blue */
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
    </script>

    <style>
        /* Custom Styles for things Tailwind can't easily do inline */
        .slide {
            display: none;
            animation: fadeIn 0.5s ease-in-out;
        }
        .slide.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Pulse animation for mobile FAB */
        @keyframes pulse-ring {
            0% { transform: scale(0.8); box-shadow: 0 0 0 0 rgba(138, 32, 97, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 15px rgba(138, 32, 97, 0); }
            100% { transform: scale(0.8); box-shadow: 0 0 0 0 rgba(138, 32, 97, 0); }
        }
        .fab-pulse {
            animation: pulse-ring 2s infinite;
        }

        /* Smooth height transition for FAQ */
        .faq-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
            opacity: 0;
        }
        .faq-item.active .faq-content {
            opacity: 1;
        }
        .faq-item.active .faq-icon {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="font-sans antialiased overflow-x-hidden bg-white">

    <!-- Top Bar (Phone, Email, Cart) -->
    <div class="bg-white border-b border-gray-200 hidden md:block text-sm py-2 relative z-40">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex gap-6 text-imperial-gray">
                <span class="flex items-center gap-2"><i class="fa-solid fa-phone text-imperial-primary"></i> <a href="tel:10648" class="hover:text-imperial-primary transition">10648</a></span>
                <span class="flex items-center gap-2"><i class="fa-solid fa-envelope text-imperial-primary"></i> <a href="mailto:imperiallistens@imperialhealth.com" class="hover:text-imperial-primary transition">imperiallistens@imperialhealth.com</a></span>
            </div>
            <div class="flex gap-6 items-center text-imperial-gray">
                <div class="flex items-center gap-2 cursor-pointer hover:text-imperial-primary">
                    <i class="fa-solid fa-cart-shopping"></i> <span>Cart</span>
                </div>
                
                <!-- MY ACCOUNT DROPDOWN (Click to open) -->
                <div class="relative h-full flex items-center py-2" id="account-wrapper">
                    <div id="account-trigger" class="flex items-center gap-2 cursor-pointer hover:text-imperial-primary transition select-none">
                        <i class="fa-regular fa-user"></i> <span>My Account</span>
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </div>
                    <!-- Dropdown Content (Hidden by default) -->
                    <!-- z-[100] ensures it appears above header -->
                    <div id="account-dropdown" class="hidden absolute top-full right-0 w-48 bg-white text-gray-800 shadow-xl rounded-b-lg border border-gray-100 z-[100] overflow-hidden mt-2">
                        <a href="signin.php" class="block px-4 py-3 hover:bg-imperial-light hover:text-imperial-primary transition font-medium border-b border-gray-50">Sign In</a>
                        <a href="signup.php" class="block px-4 py-3 hover:bg-imperial-light hover:text-imperial-primary transition font-medium">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'nav.php'; ?>
    <?php require_once 'search-tray.php' ?>
