<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Imperial Health</title>
    
    <!-- Fonts: IBM Plex Sans & Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (via CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind Config (Consistent with previous files) -->
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
        /* Custom Styles */
        .input-group:focus-within label {
            color: #8A2061; /* imperial-primary */
        }
    </style>
</head>
<body class="font-sans antialiased text-imperial-text bg-gray-50 min-h-screen flex flex-col">

    <!-- Simple Header for Login Page -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="http://localhost/" class="flex-shrink-0">
                <img src="/assets/logo.jpg" alt="Imperial Health Logo" class="h-8 w-auto" onerror="this.src='https://placehold.co/150x50/8A2061/ffffff?text=imperial+Health'">
            </a>

            <!-- Create Profile Link -->
            <a href="signup.php" class="text-imperial-primary font-medium hover:text-imperial-dark transition">
                Create a new account
            </a>
        </div>
    </header>

    <!-- Main Content: Split Layout -->
    <main class="flex-grow flex items-center justify-center py-12 px-4">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row bg-white rounded-xl shadow-lg overflow-hidden max-w-5xl mx-auto min-h-[600px]">
                
                <!-- Left Side: Branding/Image -->
                <div class="w-full md:w-5/12 bg-gray-100 relative hidden md:flex flex-col justify-between">
                    <!-- Background Image -->
                    <img src="https://images.pexels.com/photos/8949911/pexels-photo-8949911.jpeg?_gl=1*1v8cbx4*_ga*MTQwMTA2MjU5NC4xNzY4OTY5ODkw*_ga_8JE65Q40S6*czE3Njg5NzA2MjgkbzEkZzEkdDE3Njg5NzA2NjIkajI2JGwwJGgw" 
                         alt="Doctor" 
                         class="absolute inset-0 w-full h-full object-cover">
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-imperial-dark/80 to-imperial-primary/60"></div>

                    <!-- Content -->
                    <div class="relative z-10 p-10 flex flex-col justify-between h-full text-white">
                        <div>
                            <h2 class="text-3xl font-bold mb-4">Welcome Back!</h2>
                            <p class="text-gray-100 leading-relaxed text-lg">
                                Access your health records, manage appointments, and connect with our doctors anytime, anywhere.
                            </p>
                        </div>

                        <div class="mt-auto">
                            <div class="flex items-center gap-4 mb-2">
                                <i class="fa-solid fa-lock text-2xl"></i>
                                <div>
                                    <h4 class="font-bold">Secure Login</h4>
                                    <p class="text-sm opacity-80">256-bit SSL encryption for your safety.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Form -->
                <div class="w-full md:w-7/12 p-8 md:p-12 overflow-y-auto">
                    
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-imperial-text mb-2">Login</h1>
                        <p class="text-gray-500">Enter your credentials to access your account.</p>
                    </div>

                    <form action="#" class="space-y-6">
                        
                        <!-- Mobile Number or Email -->
                        <div class="input-group">
                            <label class="block text-sm font-medium text-gray-700 mb-1 transition-colors">Mobile Number or Email</label>
                            <!-- APPLIED BORDER STYLE HERE -->
                            <input type="text" class="w-full border border-imperial-primary rounded px-4 py-3 focus:outline-none focus:ring-1 focus:ring-imperial-primary transition" placeholder="Enter registered mobile or email">
                        </div>

                        <!-- Password -->
                        <div class="input-group">
                            <div class="flex justify-between items-center mb-1">
                                <label class="block text-sm font-medium text-gray-700 transition-colors">Password</label>
                                <a href="#" class="text-sm text-imperial-primary hover:text-imperial-dark font-medium hover:underline">Forgot Password?</a>
                            </div>
                            <div class="relative">
                                <!-- APPLIED BORDER STYLE HERE -->
                                <input type="password" class="w-full border border-imperial-primary rounded px-4 py-3 focus:outline-none focus:ring-1 focus:ring-imperial-primary transition" placeholder="Enter your password">
                                <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-imperial-primary">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="flex items-center gap-3">
                            <!-- APPLIED BORDER STYLE TO CHECKBOX INPUT -->
                            <div class="relative flex items-center">
                                <input type="checkbox" class="h-4 w-4 cursor-pointer appearance-none rounded border border-imperial-primary checked:border-imperial-primary checked:bg-imperial-primary transition-all">
                                <i class="fa-solid fa-check absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-white text-[10px] opacity-0 pointer-events-none"></i>
                            </div>
                            <label class="text-sm text-gray-600">Remember me</label>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="w-full bg-imperial-primary text-white font-bold py-4 rounded hover:bg-imperial-dark transition shadow-md transform active:scale-95 duration-150">
                            Login
                        </button>

                        <!-- Divider -->
                        <div class="relative flex py-2 items-center">
                            <div class="flex-grow border-t border-gray-300"></div>
                            <span class="flex-shrink mx-4 text-gray-400 text-sm">Or login with</span>
                            <div class="flex-grow border-t border-gray-300"></div>
                        </div>

                        <!-- Social Buttons -->
                        <div class="grid grid-cols-2 gap-4">
                            <button type="button" class="flex items-center justify-center gap-2 border border-gray-300 py-3 rounded hover:bg-gray-50 transition text-sm font-medium text-gray-700">
                                <i class="fa-brands fa-google text-red-500"></i> Google
                            </button>
                            <button type="button" class="flex items-center justify-center gap-2 border border-gray-300 py-3 rounded hover:bg-gray-50 transition text-sm font-medium text-gray-700">
                                <i class="fa-brands fa-facebook text-blue-600"></i> Facebook
                            </button>
                        </div>

                        <!-- Create Account CTA -->
                        <div class="text-center pt-4">
                            <p class="text-gray-600">Don't have an account? <a href="signup.php" class="text-imperial-primary font-bold hover:text-imperial-dark hover:underline">Create Profile</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer (Simplified) -->
    <footer class="bg-gray-200 pt-8 pb-6 text-center">
        <div class="container mx-auto px-6">
            <div class="flex justify-center gap-6 mb-6">
                <a href="#" class="text-gray-600 hover:text-imperial-primary transition"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="text-gray-600 hover:text-imperial-primary transition"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#" class="text-gray-600 hover:text-imperial-primary transition"><i class="fa-brands fa-youtube"></i></a>
                <a href="#" class="text-gray-600 hover:text-imperial-primary transition"><i class="fa-brands fa-instagram"></i></a>
            </div>
            <p class="text-sm text-gray-600 mb-2">
                <a href="#" class="hover:text-imperial-primary underline">Privacy Notice</a> | 
                <a href="#" class="hover:text-imperial-primary underline">Code of Ethics</a> | 
                <a href="#" class="hover:text-imperial-primary underline">Patient Bill of Rights</a>
            </p>
            <p class="text-xs text-gray-500">&copy; 2019-2025 Imperial Health Bangladesh Limited.</p>
        </div>
    </footer>

    <!-- Checkbox Script (Simulated Logic) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Checkbox visual toggle logic
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(box => {
                box.addEventListener('change', (e) => {
                    const icon = e.target.parentElement.querySelector('.fa-check');
                    if(e.target.checked) {
                        icon.classList.remove('opacity-0');
                    } else {
                        icon.classList.add('opacity-0');
                    }
                });
            });
        });
    </script>
</body>
</html>