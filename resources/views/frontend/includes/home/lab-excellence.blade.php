    <!-- SECTION 2: IMAGE LEFT / TEXT RIGHT -->
    <section class="py-24 bg-white overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row-reverse gap-20 items-center">
                <div class="lg:w-1/2 reveal-right">
                    <span class="text-indigo-600 font-black uppercase tracking-[0.2em] text-[15px] mb-4 block">{{ $homeSettings['lab_excellence']['badge'] }}</span>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-8 tracking-tight">{!! $homeSettings['lab_excellence']['title_html'] !!}</h2>
                    <p class="text-lg text-slate-600 leading-relaxed mb-8 font-medium">{{ $homeSettings['lab_excellence']['description'] }}</p>

                    <div class="grid grid-cols-2 gap-6 mb-10">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-indigo-600"></i>
                            <span class="text-sm font-bold text-slate-700 uppercase tracking-tight">{{ $homeSettings['lab_excellence']['feature_1'] }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-indigo-600"></i>
                            <span class="text-sm font-bold text-slate-700 uppercase tracking-tight">{{ $homeSettings['lab_excellence']['feature_2'] }}</span>
                        </div>
                    </div>

                    <a href="{{ $homeSettings['lab_excellence']['button_url'] }}" class="btn-primary text-white px-10 py-4 rounded-2xl font-bold inline-flex items-center gap-3 shadow-xl shadow-indigo-200">
                        {{ $homeSettings['lab_excellence']['button_text'] }} <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <div class="lg:w-1/2 relative reveal-left">
                    <img src="{{ asset($homeSettings['lab_excellence']['image']) }}" class="rounded-[40px] shadow-2xl relative z-10 w-full hover:scale-[1.02] transition-transform duration-700">
                </div>
            </div>
        </div>
    </section>
