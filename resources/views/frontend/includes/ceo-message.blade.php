@if(!empty($homeSettings['ceo_message']['enabled']))
<section class="py-24 bg-indigo-50 overflow-hidden">
    <div class="container mx-auto px-6">
        <div class="flex flex-col lg:flex-row gap-16 lg:gap-20 items-center">
            <div class="lg:w-5/12 relative reveal-left">
                <div class="relative">
                    <img src="{{ asset($homeSettings['ceo_message']['image']) }}"
                         alt="{{ $homeSettings['ceo_message']['name'] }}"
                         class="w-full max-w-md mx-auto lg:mx-0 rounded-[40px] shadow-2xl object-cover aspect-[4/5]">
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-indigo-100 rounded-full -z-10"></div>
                    <div class="absolute -top-6 -left-6 w-24 h-24 bg-indigo-50 rounded-full -z-10"></div>
                </div>
            </div>

            <div class="lg:w-7/12 reveal-right">
                <span class="text-indigo-600 font-black uppercase tracking-[0.2em] text-[10px] mb-4 block">{{ $homeSettings['ceo_message']['badge'] }}</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-8 tracking-tight leading-tight">{!! $homeSettings['ceo_message']['title_html'] !!}</h2>
                <p class="text-lg text-slate-600 leading-relaxed mb-8">{{ $homeSettings['ceo_message']['message'] }}</p>
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-indigo-600 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-quote-left text-white text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-slate-900">{{ $homeSettings['ceo_message']['name'] }}</h4>
                        <p class="text-sm text-indigo-600 font-medium">{{ $homeSettings['ceo_message']['designation'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
