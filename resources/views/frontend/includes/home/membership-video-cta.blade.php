    <!-- CTA: MEMBERSHIP & VIDEO CONSULTATION -->
    <section class="py-24 bg-slate-50 overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                <!-- Membership Plan -->
                <div class="relative group reveal-left">
                    <div class="bg-white p-10 md:p-16 rounded-[48px] shadow-xl border border-slate-100 h-full flex flex-col justify-between hover:shadow-2xl transition-all duration-500 overflow-hidden">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-50 rounded-full blur-3xl group-hover:bg-indigo-100 transition-colors"></div>
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-8 shadow-sm">
                                <i class="fa-solid fa-id-card-clip text-2xl"></i>
                            </div>
                            <h3 class="text-3xl font-extrabold text-slate-900 mb-6 tracking-tight">{!! $homeSettings['continuous_care']['title_html'] !!}</h3>
                            <p class="text-slate-500 leading-relaxed mb-10 font-medium text-lg">{{ $homeSettings['continuous_care']['description'] }}</p>
                        </div>
                        <a href="{{ $homeSettings['continuous_care']['button_url'] }}" class="btn-primary text-white px-10 py-4 rounded-2xl font-bold inline-flex items-center justify-center gap-3 shadow-xl shadow-indigo-200 w-fit">
                            {{ $homeSettings['continuous_care']['button_text'] }} <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Video Consultation -->
                <div class="relative group reveal-right">
                    <div class="bg-[#1E293B] p-10 md:p-16 rounded-[48px] shadow-xl h-full flex flex-col justify-between hover:shadow-2xl transition-all duration-500 overflow-hidden">
                        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/5 rounded-full blur-3xl group-hover:bg-white/10 transition-colors"></div>
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-white/10 text-indigo-400 rounded-2xl flex items-center justify-center mb-8 shadow-sm">
                                <i class="fa-solid fa-video text-2xl"></i>
                            </div>
                            <h3 class="text-3xl font-extrabold text-white mb-6 tracking-tight">{!! $homeSettings['expert_advice']['title_html'] !!}</h3>
                            <p class="text-slate-400 leading-relaxed mb-10 font-medium text-lg">{{ $homeSettings['expert_advice']['description'] }}</p>
                        </div>
                        <a href="{{ $homeSettings['expert_advice']['button_url'] }}" class="bg-white text-slate-900 hover:bg-indigo-50 px-10 py-4 rounded-2xl font-bold inline-flex items-center justify-center gap-3 shadow-xl w-fit transition-all transform active:scale-95">
                            {{ $homeSettings['expert_advice']['button_text'] }} <i class="fa-solid fa-video text-xs"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
