@extends('layouts.app')
@section('title', 'Create Package Category')

@section('content')
<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Create Package Category</h3></div>
    <form action="{{ route('admin.health_package_categories.store') }}" method="POST">
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
                <input type="number" name="sort_order" class="form-control" value="0" min="0">
            </div>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" checked>
                    <label class="custom-control-label" for="status">Active</label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.health_package_categories.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $('#health_package_categories').addClass('active');
    $('#helth_check_link').addClass('active');
    $('#helth_check').addClass('menu-open');
</script>
@endpush
