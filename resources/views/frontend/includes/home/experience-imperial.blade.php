    <!-- FACILITY TOUR -->
    <section class="py-24 px-6">
        <div class="container mx-auto bg-slate-900 rounded-[48px] overflow-hidden shadow-2xl relative group">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 h-[400px] lg:h-[600px] overflow-hidden">
                    <img src="{{ asset($homeSettings['experience_imperial']['image']) }}" class="w-full h-full object-cover transition-transform duration-[10s] group-hover:scale-110">
                </div>
                <div class="lg:w-1/2 p-12 lg:p-20">
                    <span class="text-indigo-600 font-black uppercase tracking-[0.2em] text-[15px] mb-4 block">{{ $homeSettings['experience_imperial']['badge'] }}</span>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-8 tracking-tight">{!! $homeSettings['experience_imperial']['title_html'] !!}</h2>
                    <p class="text-lg text-slate-400 leading-relaxed mb-12">{{ $homeSettings['experience_imperial']['description'] }}</p>
                    <a href="{{ $homeSettings['experience_imperial']['button_url'] }}" class="inline-block bg-white text-slate-900 px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-indigo-50 transition-all transform active:scale-95 shadow-xl">{{ $homeSettings['experience_imperial']['button_text'] }}</a>
                </div>
            </div>
        </div>
    </section>
