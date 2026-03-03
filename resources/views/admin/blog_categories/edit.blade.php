@extends('layouts.app')
@section('title', 'Edit Blog Category')

@section('content')
<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Edit Blog Category</h3></div>
    <form method="POST" action="{{ route('admin.blog_categories.update', $category->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3">{{ $category->description }}</textarea>
            </div>
            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" class="form-control" min="0" value="{{ $category->sort_order }}">
            </div>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" {{ $category->status ? 'checked' : '' }}>
                <label class="custom-control-label" for="status">Active</label>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.blog_categories.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$('#blog_categories').addClass('active');
$('#blogs_module_link').addClass('active');
$('#blogs_module').addClass('menu-open');
</script>
@endpush
