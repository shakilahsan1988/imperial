@extends('layouts.app')

@section('title', $branch->title ?: $branch->name)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">{{ $branch->title ?: $branch->name }}</h3>
        <a href="{{ route('admin.branches.edit', $branch->id) }}" class="btn btn-primary btn-sm">
            <i class="fa fa-edit"></i> Edit Branch
        </a>
    </div>
    <div class="card-body">
        @if($branch->feature_image)
            <img src="{{ asset($branch->feature_image) }}" alt="{{ $branch->title ?: $branch->name }}" class="img-fluid rounded mb-4" style="max-height: 320px;">
        @endif

        <div class="row">
            <div class="col-md-8">
                <h4>Description</h4>
                <p>{!! nl2br(e($branch->description)) !!}</p>

                <h4>Address</h4>
                <p>{!! nl2br(e($branch->address)) !!}</p>

                <h4>Contact Information</h4>
                <p>{!! nl2br(e($branch->contact_information)) !!}</p>

                <h4>Google Map Location</h4>
                <p><a href="{{ $branch->google_map_location }}" target="_blank">{{ $branch->google_map_location }}</a></p>
            </div>
            <div class="col-md-4">
                <h4>Summary</h4>
                <p>Gallery Images: {{ $branch->galleries->count() }}</p>
                <p>Management Members: {{ $branch->managementTeams->count() }}</p>
                <p>Doctors: {{ $branch->doctors->count() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
