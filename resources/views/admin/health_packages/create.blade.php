@extends('layouts.app')
@section('title', 'Create Health Package')

@section('content')
<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Create Health Package</h3></div>
    <form action="{{ route('admin.health_packages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            @php($package = null)
            @include('admin.health_packages._form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.health_packages.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $('#health_packages').addClass('active');
    $('#health_check_link').addClass('active');
    $('#health_check').addClass('menu-open');
</script>
@endpush
