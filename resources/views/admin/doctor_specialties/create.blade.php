@extends('layouts.app')
@section('title', 'Create Specialty')

@section('content')
<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Create Specialty</h3></div>
    <form method="POST" action="{{ route('admin.doctor_specialties.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" class="form-control" min="0" value="0">
            </div>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" checked>
                <label class="custom-control-label" for="status">Active</label>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary">Save</button>
            <a href="{{ route('admin.doctor_specialties.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$('#doctor_specialties').addClass('active');
$('#manage_doctors_link').addClass('active');
$('#manage_doctors').addClass('menu-open');
</script>
@endpush
