@extends('layouts.front')

@section('title', $homeSettings['seo']['page_title'] ?? 'Imperial Health - World Class Healthcare in Bangladesh')
@section('meta_description', $homeSettings['seo']['meta_description'] ?? ($homeSettings['about']['description'] ?? null))

@section('content')

    @foreach(($homeSettings['sections_order'] ?? []) as $section)
        @continue(empty($section['enabled']))
        @switch($section['key'] ?? null)
            @case('hero')
                @include('frontend.includes.slider')
                @break
            @case('branches')
                @include('frontend.includes.branch-section')
                @break
            @case('about_stats')
                @include('frontend.includes.home.about-stats')
                @break
            @case('doctor_carousel')
                @include('frontend.includes.doctor-carousel')
                @break
            @case('our_approach')
                @include('frontend.includes.home.our-approach')
                @break
            @case('lab_excellence')
                @include('frontend.includes.home.lab-excellence')
                @break
            @case('experience_imperial')
                @include('frontend.includes.home.experience-imperial')
                @break
            @case('membership_video_cta')
                @include('frontend.includes.home.membership-video-cta')
                @break
        @endswitch
    @endforeach

@endsection
