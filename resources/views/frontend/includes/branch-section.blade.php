@if(isset($homeBranches) && $homeBranches->isNotEmpty())
@php
    $branchSection = $homeSettings['branches'] ?? [];
@endphp
<section class="border-y border-slate-100 bg-slate-50 py-16 md:py-20">
    <div class="container mx-auto px-5 sm:px-6 lg:px-8">
        <div class="mb-10 flex flex-col justify-between gap-5 md:mb-12 md:flex-row md:items-end">
            <div class="max-w-3xl">
                <p class="mb-3 text-xs font-black uppercase tracking-[0.18em] text-sky-600">{{ $branchSection['badge'] ?? 'Our Branches' }}</p>
                <h2 class="text-3xl font-black tracking-tight text-slate-950 sm:text-4xl md:text-5xl">
                    {!! $branchSection['title_html'] ?? 'Care Closer to <span class="text-sky-600">You</span>' !!}
                </h2>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-500 sm:text-base">
                    {{ $branchSection['description'] ?? 'Explore our branches and find the location that works best for your visit.' }}
                </p>
            </div>
            <a href="{{ route('branches') }}" class="inline-flex flex-shrink-0 items-center gap-2 text-sm font-bold text-sky-700 transition hover:text-sky-900">
                View all locations
                <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 gap-7 lg:grid-cols-2">
            @foreach($homeBranches as $branch)
                @php
                    $branchImage = asset($branch->feature_image ?: 'assets/front/images/about/reception.jpg');
                    $branchTitle = $branch->title ?: $branch->name;
                @endphp
                <article class="group overflow-hidden rounded-[2rem] border border-slate-200/80 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-sky-200 hover:shadow-2xl hover:shadow-slate-900/10">
                    <a href="{{ route('branch-details', $branch->slug) }}" class="relative block h-[28rem] overflow-hidden bg-slate-200 sm:h-[38rem] lg:h-[42rem] xl:h-[46rem]" aria-label="Explore {{ $branchTitle }}">
                        <img src="{{ $branchImage }}" alt="{{ $branchTitle }}" class="absolute inset-0 h-full w-full object-cover object-center transition-transform duration-700 group-hover:scale-[1.025]">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/20 via-transparent to-slate-950/5"></div>
                        <span class="absolute left-5 top-5 z-20 rounded-lg border border-white/70 bg-white/90 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.14em] text-sky-700 shadow-sm backdrop-blur">
                            {{ $branchSection['card_badge'] ?? 'Imperial Location' }}
                        </span>
                    </a>

                    <div class="p-6 sm:p-8">
                        <h3 class="text-xl font-black leading-snug tracking-tight text-slate-950 transition-colors group-hover:text-sky-700 sm:text-2xl">
                            <a href="{{ route('branch-details', $branch->slug) }}">{{ $branchTitle }}</a>
                        </h3>
                        <p class="mt-3 flex items-start gap-2 text-sm leading-6 text-slate-500">
                            <i class="fa-solid fa-location-dot mt-1 text-sky-600" aria-hidden="true"></i>
                            <span>{{ $branch->address }}</span>
                        </p>
                        @if(!empty($branch->description))
                            <p class="mt-4 text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags($branch->description), 130) }}</p>
                        @endif

                        <div class="mt-6 flex flex-wrap gap-2 border-t border-slate-100 pt-5">
                            <span class="rounded-lg bg-slate-50 px-3 py-2 text-xs font-bold text-slate-600">
                                <i class="fa-solid fa-user-doctor mr-1.5 text-sky-600" aria-hidden="true"></i>{{ $branch->doctors_count }} doctors
                            </span>
                            <span class="rounded-lg bg-slate-50 px-3 py-2 text-xs font-bold text-slate-600">
                                <i class="fa-solid fa-images mr-1.5 text-sky-600" aria-hidden="true"></i>{{ $branch->galleries_count }} photos
                            </span>
                        </div>

                        <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                            <a href="{{ route('branch-details', $branch->slug) }}" class="inline-flex flex-1 items-center justify-between rounded-xl bg-slate-950 px-5 py-3.5 text-sm font-bold text-white transition hover:bg-sky-600 focus:outline-none focus:ring-4 focus:ring-sky-100">
                                {{ $branchSection['details_button_text'] ?? 'Explore Branch' }}
                                <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                            </a>
                            @if(!empty($branch->google_map_location))
                                <a href="{{ $branch->google_map_location }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 px-5 py-3.5 text-sm font-bold text-slate-700 transition hover:border-sky-200 hover:bg-sky-50 hover:text-sky-700">
                                    {{ $branchSection['map_button_text'] ?? 'Open Map' }}
                                    <i class="fa-solid fa-arrow-up-right-from-square text-xs" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif
