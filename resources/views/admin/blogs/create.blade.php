@extends('layouts.app')
@section('title', 'Create Blog')

@section('content')
<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Create Blog</h3></div>
    <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Category</label>
                        <select name="blog_category_id" class="form-control">
                            <option value="">-- Select --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Excerpt</label>
                <textarea name="excerpt" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Content</label>
                <textarea name="content" class="form-control" rows="10" required></textarea>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Author Name</label>
                        <input type="text" name="author_name" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Published At</label>
                        <input type="datetime-local" name="published_at" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Featured Image</label>
                        <input type="file" name="featured_image_file" class="form-control-file" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Meta Title</label>
                        <input type="text" name="meta_title" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Meta Description</label>
                        <input type="text" name="meta_description" class="form-control">
                    </div>
                </div>
            </div>

            <div class="custom-control custom-switch mb-2">
                <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" checked>
                <label class="custom-control-label" for="status">Published</label>
            </div>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1">
                <label class="custom-control-label" for="is_featured">Featured</label>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary">Save</button>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$('#blogs').addClass('active');
$('#blogs_module_link').addClass('active');
$('#blogs_module').addClass('menu-open');
</script>
@endpush
