    <!-- STATS SECTION -->
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-50 rounded-full blur-3xl opacity-50 -mr-48 -mt-48"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row gap-20 items-center">
                <div class="lg:w-5/12 reveal">
                    <span class="text-indigo-600 font-black uppercase tracking-[0.2em] text-[15px] mb-4 block">{{ $homeSettings['about']['badge'] }}</span>
                    <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">{!! $homeSettings['about']['title_html'] !!}</h2>
                    <p class="text-lg text-slate-500 leading-relaxed font-medium">{{ $homeSettings['about']['description'] }}</p>
                </div>

                <div class="lg:w-7/12 grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                        $stats = collect([
                            ['count' => $homeSettings['stats']['specialities_count'], 'label' => $homeSettings['stats']['specialities_label'], 'icon' => 'fa-stethoscope'],
                            ['count' => $homeSettings['stats']['doctors_count'], 'label' => $homeSettings['stats']['doctors_label'], 'icon' => 'fa-user-md'],
                            ['count' => $homeSettings['stats']['patients_count'] ?? '', 'label' => $homeSettings['stats']['patients_label'], 'icon' => 'fa-users'],
                        ])->filter(fn ($s) => trim((string) $s['count']) !== '');
                    @endphp
                    @foreach($stats as $s)
                    <div class="bg-slate-50 p-8 rounded-[32px] border border-slate-100 hover:bg-white hover:shadow-2xl hover:border-indigo-100 transition-all duration-500 group reveal">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-6 group-hover:scale-110 transition-transform">
                            <i class="fa-solid {{$s['icon']}} text-indigo-600 text-4xl"></i>
                        </div>
                        <h3 class="text-4xl font-black text-slate-900 mb-1 tracking-tighter">{{$s['count']}}</h3>
                        <p class="font-bold uppercase tracking-widest text-indigo-600 text-sm">{{$s['label']}}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
