@extends('layouts.front')

@section('title', ($branch->title ?: $branch->name) . ' - Imperial Health Bangladesh')

@section('content')
<main class="bg-white font-sans overflow-hidden">
    <section class="relative py-24 md:py-36 bg-[#1E293B] overflow-hidden">
        <div class="absolute inset-0 opacity-25">
            <img src="{{ asset($branch->feature_image ?: 'assets/front/images/about/1.jpg') }}" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#1E293B] via-[#1E293B]/85 to-transparent"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl">
                <p class="text-xs md:text-sm text-indigo-300 uppercase tracking-[0.2em] font-black mb-4">Branch Details</p>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">{{ $branch->title ?: $branch->name }}</h1>
                <p class="text-xl text-slate-300 font-light leading-relaxed">{{ $branch->address }}</p>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div class="lg:col-span-2">
                    <div class="bg-slate-50 rounded-[32px] p-8 md:p-10 border border-slate-100 mb-10">
                        <h2 class="text-3xl font-extrabold text-slate-900 mb-6">About This Branch</h2>
                        <p class="text-slate-600 leading-relaxed whitespace-pre-line">{{ $branch->description }}</p>
                    </div>

                    @if($branch->galleries->isNotEmpty())
                    <div class="mb-10">
                        <h2 class="text-3xl font-extrabold text-slate-900 mb-6">Gallery</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($branch->galleries as $gallery)
                            <div class="overflow-hidden rounded-[28px] border border-slate-100 shadow-sm bg-white">
                                <img src="{{ asset($gallery->image) }}" alt="{{ $gallery->name }}" class="w-full h-60 object-cover">
                                @if($gallery->name)
                                <div class="p-4 text-sm font-medium text-slate-600">{{ $gallery->name }}</div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($branch->managementTeams->isNotEmpty())
                    <div class="mb-10">
                        <h2 class="text-3xl font-extrabold text-slate-900 mb-6">Management Team</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($branch->managementTeams as $member)
                            <div class="bg-white border border-slate-100 rounded-[28px] p-6 shadow-sm">
                                <div class="flex items-start gap-4">
                                    <img src="{{ asset($member->image ?: 'assets/front/images/management/1.jpg') }}" alt="{{ $member->name }}" class="w-24 h-24 rounded-2xl object-cover">
                                    <div>
                                        <h3 class="text-xl font-bold text-slate-900">{{ $member->name }}</h3>
                                        <p class="text-sm text-indigo-600 font-medium mb-3">{{ $member->designation }}</p>
                                        <p class="text-sm text-slate-600 leading-relaxed">{{ \Illuminate\Support\Str::limit(strip_tags($member->bio), 180, '...') }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($branch->doctors->isNotEmpty())
                    <div>
                        <h2 class="text-3xl font-extrabold text-slate-900 mb-6">Related Doctors</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($branch->doctors as $doctor)
                            <div class="group bg-white rounded-[28px] overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all">
                                <img src="{{ asset($doctor->image ?: 'assets/front/images/doctor/2.jpg') }}" alt="{{ $doctor->name }}" class="w-full h-64 object-cover">
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $doctor->name }}</h3>
                                    <p class="text-sm text-slate-500">{{ $doctor->designation ?: 'Consultant' }}</p>
                                    <p class="text-xs text-indigo-600 font-bold mt-2 mb-5">{{ optional($doctor->specialty)->name ?: 'Specialist' }}</p>
                                    <a href="{{ route('book-doctor', ['doctor' => $doctor->slug ?: $doctor->id]) }}" class="inline-flex items-center gap-2 text-sm font-bold text-indigo-600">
                                        Book Appointment <i class="fa-solid fa-arrow-right text-xs"></i>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-slate-900 rounded-[32px] p-8 text-white sticky top-10">
                        <h2 class="text-2xl font-extrabold mb-6">Contact & Visit</h2>
                        <div class="space-y-6">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-indigo-300 font-black mb-2">Address</p>
                                <p class="text-slate-300 leading-relaxed whitespace-pre-line">{{ $branch->address }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-indigo-300 font-black mb-2">Contact Information</p>
                                <p class="text-slate-300 leading-relaxed whitespace-pre-line">{{ $branch->contact_information }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-indigo-300 font-black mb-2">Google Map Location</p>
                                <a href="{{ $branch->google_map_location }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white text-slate-900 font-bold hover:bg-indigo-50 transition-all">
                                    Open Location <i class="fa-solid fa-location-arrow text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
