<footer class="bg-[#0F172A] text-slate-400 pt-20 pb-10">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 mb-16">
            
            <!-- Brand & Newsletter -->
            <div class="col-span-1 md:col-span-2 lg:col-span-1">
                <img src="{{ asset('assets/front/images/logo.png') }}" alt="Imperial Health" class="w-auto h-12 mb-8 filter brightness-0 invert" onerror="this.src='https://placehold.co/150x50/ffffff/333333?text=Imperial+Health'">
                
                <h4 class="text-white font-bold mb-4">Stay informed</h4>
                <p class="text-sm mb-6 leading-relaxed">Join our mailing list for the latest health insights and laboratory updates.</p>
                
                <form class="relative group" onsubmit="event.preventDefault(); alert('Thank you for subscribing!');">
                    <input type="email" placeholder="Your email address" class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-5 py-3.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all outline-none">
                    <button type="submit" class="absolute right-2 top-2 bottom-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 rounded-lg transition-all">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>
            </div>

            <!-- Services -->
            <div>
                <h4 class="text-white font-bold mb-6 tracking-tight uppercase text-xs">Our Services</h4>
                <ul class="space-y-4 text-sm font-medium">
                    <li><a href="{{ route('lab-test') }}" class="hover:text-indigo-400 transition-colors">Diagnostics & Lab</a></li>
                    <li><a href="{{ route('health-check') }}" class="hover:text-indigo-400 transition-colors">Health Packages</a></li>
                    <li><a href="{{ route('membership') }}" class="hover:text-indigo-400 transition-colors">Membership Plans</a></li>
                    <li><a href="{{ route('video-consultation') }}" class="hover:text-indigo-400 transition-colors">Virtual Consultations</a></li>
                </ul>
            </div>

            <!-- Resources -->
            <div>
                <h4 class="text-white font-bold mb-6 tracking-tight uppercase text-xs">Patient Resources</h4>
                <ul class="space-y-4 text-sm font-medium">
                    <li><a href="{{ route('doctor') }}" class="hover:text-indigo-400 transition-colors">Find a Specialist</a></li>
                    <li><a href="{{ route('blog') }}" class="hover:text-indigo-400 transition-colors">Health Blog</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-indigo-400 transition-colors">Support & FAQ</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-white font-bold mb-6 tracking-tight uppercase text-xs">Contact Us</h4>
                <ul class="space-y-5 text-sm">
                    <li class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center flex-shrink-0 text-indigo-400">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <span class="leading-relaxed">House 12, Road 11, Banani<br>Dhaka - 1213, Bangladesh</span>
                    </li>
                    <li class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center flex-shrink-0 text-indigo-400">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <a href="tel:10648" class="hover:text-white transition font-bold">10648 (Hotline)</a>
                    </li>
                </ul>
                <div class="flex gap-3 mt-8">
                    @foreach(['facebook-f', 'linkedin-in', 'youtube', 'instagram'] as $social)
                    <a href="#" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-800 hover:bg-indigo-600 text-white transition-all transform hover:-translate-y-1">
                        <i class="fa-brands fa-{{$social}} text-sm"></i>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs font-bold uppercase tracking-widest text-slate-500">
            <div class="flex gap-8 mb-6 md:mb-0">
                <a href="{{ route('privacy-notice') }}" class="hover:text-white transition">Privacy</a>
                <a href="{{ route('code-of-ethics') }}" class="hover:text-white transition">Ethics</a>
                <a href="{{ route('bill-of-right') }}" class="hover:text-white transition">Rights</a>
            </div>
            <p>&copy; {{ date('Y') }} Imperial Health Bangladesh Ltd.</p>
        </div>
    </div>
</footer>

<!-- Floating Book Appointment Button (Mobile) -->
<div class="fixed bottom-8 right-6 z-40 md:hidden">
    <a href="{{ route('book-doctor') }}" class="flex items-center justify-center bg-indigo-600 text-white w-16 h-16 rounded-2xl shadow-2xl shadow-indigo-500/50 hover:bg-indigo-700 transition-all animate-bounce">
        <i class="fa-solid fa-calendar-plus text-2xl"></i>
    </a>
</div>
