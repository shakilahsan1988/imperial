@extends('layouts.app')
@section('title', 'Edit Health Package')

@section('content')
<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Edit Health Package</h3></div>
    <form action="{{ route('admin.health_packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            @include('admin.health_packages._form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.health_packages.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $('#health_packages').addClass('active');
    $('#helth_check_link').addClass('active');
    $('#helth_check').addClass('menu-open');
</script>
@endpush
