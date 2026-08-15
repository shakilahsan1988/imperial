@extends('layouts.front')

@section('title', 'Management Team - Imperial Health Bangladesh')

@section('content')

    {{-- Unpublished as part of copyright remediation (2026): this page --}}
    {{-- previously hardcoded a competitor's founder bio, quote, and photo. --}}
    {{-- The route now returns 404 (see FrontController::about_details()). --}}
    {{-- Restore with verified Imperial leadership content once available. --}}
    <main class="min-h-screen bg-white font-sans text-imperial-text pb-12">
        <section class="py-24">
            <div class="container mx-auto px-4 text-center">
                <p class="text-gray-500">This page is temporarily unavailable.</p>
                <a href="{{ route('management') }}" class="text-imperial-primary font-bold">Back to Management Team</a>
            </div>
        </section>
    </main>

@endsection
