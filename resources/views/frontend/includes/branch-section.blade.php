@if(isset($homeBranches) && $homeBranches->isNotEmpty())
<section class="py-24 bg-white overflow-hidden">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl mb-12">
            <span class="text-indigo-600 font-black uppercase tracking-[0.2em] text-[10px] mb-4 block">Our Branches</span>
            <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">Explore Imperial <span class="text-indigo-600">Locations</span></h2>
            <p class="text-lg text-slate-600 leading-relaxed">Discover our branches, facilities, key contact information, and the teams available at each location.</p>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            @foreach($homeBranches as $branch)
            <article class="group bg-slate-50 rounded-[36px] overflow-hidden border border-slate-100 hover:bg-white hover:shadow-2xl transition-all duration-500">
                <a href="{{ route('branch-details', $branch->slug) }}" class="block aspect-[16/10] overflow-hidden bg-slate-200">
                    <img src="{{ asset($branch->feature_image ?: 'assets/front/images/about/1.jpg') }}" alt="{{ $branch->title ?: $branch->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                </a>
                <div class="p-8">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-indigo-600 mb-3">Branch Tour</p>
                    <a href="{{ route('branch-details', $branch->slug) }}" class="block">
                        <h3 class="text-2xl font-extrabold text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors">{{ $branch->title ?: $branch->name }}</h3>
                    </a>
                    <p class="text-sm text-slate-500 mb-4">{{ $branch->address }}</p>
                    <p class="text-slate-600 leading-relaxed mb-8">{{ \Illuminate\Support\Str::limit($branch->description, 50, '...') }}</p>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <a href="{{ route('branch-details', $branch->slug) }}" class="inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl bg-slate-900 text-white font-bold hover:bg-indigo-600 transition-all">
                            Start The Tour <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                        <a href="{{ $branch->google_map_location }}" target="_blank" class="inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl border border-slate-300 text-slate-900 font-bold hover:border-indigo-600 hover:text-indigo-600 transition-all">
                            Open Location <i class="fa-solid fa-location-arrow text-xs"></i>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
