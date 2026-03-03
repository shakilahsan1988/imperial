@extends('layouts.app')
@section('title', 'Edit Blog')

@section('content')
<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Edit Blog</h3></div>
    <form method="POST" action="{{ route('admin.blogs.update', $blog->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $blog->title }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Category</label>
                        <select name="blog_category_id" class="form-control">
                            <option value="">-- Select --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $blog->blog_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Excerpt</label>
                <textarea name="excerpt" class="form-control" rows="3">{{ $blog->excerpt }}</textarea>
            </div>

            <div class="form-group">
                <label>Content</label>
                <textarea name="content" class="form-control" rows="10" required>{{ $blog->content }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Author Name</label>
                        <input type="text" name="author_name" class="form-control" value="{{ $blog->author_name }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Published At</label>
                        <input type="datetime-local" name="published_at" class="form-control" value="{{ $blog->published_at ? $blog->published_at->format('Y-m-d\\TH:i') : '' }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Featured Image</label>
                        <input type="hidden" name="featured_image" value="{{ $blog->featured_image }}">
                        <input type="file" name="featured_image_file" class="form-control-file" accept="image/*">
                        @if(!empty($blog->featured_image))
                            <img src="{{ asset($blog->featured_image) }}" class="img-thumbnail mt-2" style="max-height: 80px;">
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ $blog->meta_title }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Meta Description</label>
                        <input type="text" name="meta_description" class="form-control" value="{{ $blog->meta_description }}">
                    </div>
                </div>
            </div>

            <div class="custom-control custom-switch mb-2">
                <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" {{ $blog->status ? 'checked' : '' }}>
                <label class="custom-control-label" for="status">Published</label>
            </div>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" {{ $blog->is_featured ? 'checked' : '' }}>
                <label class="custom-control-label" for="is_featured">Featured</label>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary">Update</button>
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
