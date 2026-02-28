@extends('layouts.front')

@section('title', 'Contact Us - Imperial Health Bangladesh')

@section('content')

    <main class="bg-white font-sans">
        <!-- MODERN HERO SECTION -->
        <section class="relative py-24 md:py-40 bg-[#1E293B] overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <img src="https://picsum.photos/id/4/1920/1080" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/80 to-transparent"></div>
            
            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-3xl">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">
                        We're Here to <span class="text-indigo-400">Help</span> You
                    </h1>
                    <p class="text-xl text-slate-300 font-light leading-relaxed max-w-2xl mb-12">
                        Whether you have a question about our services, need assistance with a booking, or want to provide feedback, our team is ready to listen.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 flex items-center gap-4 hover:bg-white/10 transition-all">
                            <div class="w-12 h-12 bg-indigo-500 text-white rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                                <i class="fa-solid fa-phone-volume text-xl"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-indigo-400">24/7 Hotline</p>
                                <p class="text-xl font-black text-white leading-none">10648</p>
                            </div>
                        </div>
                        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 flex items-center gap-4 hover:bg-white/10 transition-all">
                            <div class="w-12 h-12 bg-emerald-500 text-white rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                                <i class="fa-brands fa-whatsapp text-xl"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-emerald-400">WhatsApp</p>
                                <p class="text-xl font-black text-white leading-none">+880 18445 08402</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTACT & FORM SECTION -->
        <section class="py-24">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                    
                    <!-- Form Side -->
                    <div class="lg:col-span-7">
                        <div class="bg-slate-50 rounded-[40px] p-8 md:p-12 border border-slate-100">
                            <h2 class="text-3xl font-extrabold text-slate-900 mb-8 tracking-tight">Send us a message</h2>
                            
                            <form action="#" method="POST" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Full Name</label>
                                        <input type="text" placeholder="e.g. John Doe" class="w-full bg-white border border-slate-200 rounded-2xl py-4 px-6 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Phone Number</label>
                                        <input type="tel" placeholder="+880" class="w-full bg-white border border-slate-200 rounded-2xl py-4 px-6 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Email Address</label>
                                    <input type="email" placeholder="name@company.com" class="w-full bg-white border border-slate-200 rounded-2xl py-4 px-6 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700">
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Reason for Inquiry</label>
                                    <select class="w-full bg-white border border-slate-200 rounded-2xl py-4 px-6 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700 appearance-none">
                                        <option>General Inquiry</option>
                                        <option>Appointment Booking</option>
                                        <option>Laboratory Services</option>
                                        <option>Corporate Partnership</option>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Message</label>
                                    <textarea rows="4" placeholder="How can we help you?" class="w-full bg-white border border-slate-200 rounded-2xl py-4 px-6 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium text-slate-700"></textarea>
                                </div>

                                <button type="submit" class="w-full bg-slate-900 hover:bg-indigo-600 text-white py-5 rounded-2xl font-black uppercase tracking-widest text-sm shadow-xl transition-all transform active:scale-95 flex items-center justify-center gap-3">
                                    <span>Send Message</span>
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Info Side -->
                    <div class="lg:col-span-5 space-y-12 py-6">
                        <div>
                            <h3 class="text-2xl font-extrabold text-slate-900 mb-6 tracking-tight">Our Location</h3>
                            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 space-y-6">
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-map-location-dot"></i></div>
                                    <p class="text-slate-600 font-medium leading-relaxed">Plot 9, Road 17, Block C, Banani<br>Dhaka - 1213, Bangladesh</p>
                                </div>
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-envelope"></i></div>
                                    <p class="text-slate-600 font-medium">imperiallistens@imperialhealth.com</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-2xl font-extrabold text-slate-900 mb-6 tracking-tight">Operating Hours</h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <span class="text-sm font-bold text-slate-700">Saturday - Thursday</span>
                                    <span class="text-sm font-black text-indigo-600">8:00 AM - 10:00 PM</span>
                                </div>
                                <div class="flex justify-between items-center p-4 bg-white rounded-2xl border border-slate-100 shadow-sm">
                                    <span class="text-sm font-bold text-slate-700">Friday</span>
                                    <span class="text-sm font-black text-indigo-600">3:00 PM - 10:00 PM</span>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl overflow-hidden h-64 shadow-2xl border-4 border-white">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3648.389736832745!2d90.3983!3d23.7954!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c8c16e0e643b%3A0x6a466d658b8a5e0!2sBanani%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1620000000000!5m2!1sen!2sbd" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

@endsection