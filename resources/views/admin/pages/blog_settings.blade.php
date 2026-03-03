@extends('layouts.app')

@section('title')
Blog Settings
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fas fa-blog nav-icon"></i>
                    Blog Settings
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Blog Settings</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">/blog Page Settings</h3>
    </div>
    <form method="POST" action="{{ route('admin.pages.blog_settings_submit') }}" enctype="multipart/form-data">
        <div class="card-body">
            @csrf

            <h5>Hero Section</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Page Name</label>
                        <input type="text" name="page_name" class="form-control" value="{{ old('page_name', $settings['page_name']) }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Hero Title (HTML allowed)</label>
                        <textarea name="hero_title_html" class="form-control" rows="2" required>{{ old('hero_title_html', $settings['hero_title_html']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Hero Description</label>
                        <textarea name="hero_description" class="form-control" rows="3" required>{{ old('hero_description', $settings['hero_description']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Hero Image</label>
                        <input type="hidden" name="hero_image" value="{{ old('hero_image', $settings['hero_image']) }}">
                        <input type="file" name="hero_image_file" class="form-control-file" accept="image/*">
                        @if(!empty($settings['hero_image']))
                            <img src="{{ asset($settings['hero_image']) }}" class="img-thumbnail mt-2" style="max-height: 120px;">
                        @endif
                    </div>
                </div>
            </div>

            <hr>
            <h5>Founder Section</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Founder Badge</label>
                        <input type="text" name="founder_badge" class="form-control" value="{{ old('founder_badge', $settings['founder_badge']) }}" required>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Founder Title</label>
                        <input type="text" name="founder_title" class="form-control" value="{{ old('founder_title', $settings['founder_title']) }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Founder Description</label>
                        <textarea name="founder_description" class="form-control" rows="5" required>{{ old('founder_description', $settings['founder_description']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="founder_button_text" class="form-control" value="{{ old('founder_button_text', $settings['founder_button_text']) }}" required>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Button URL</label>
                        <input type="text" name="founder_button_url" class="form-control" value="{{ old('founder_button_url', $settings['founder_button_url']) }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Founder Image</label>
                        <input type="hidden" name="founder_image" value="{{ old('founder_image', $settings['founder_image']) }}">
                        <input type="file" name="founder_image_file" class="form-control-file" accept="image/*">
                        @if(!empty($settings['founder_image']))
                            <img src="{{ asset($settings['founder_image']) }}" class="img-thumbnail mt-2" style="max-height: 120px;">
                        @endif
                    </div>
                </div>
            </div>

            <hr>
            <h5>Blog List Section</h5>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Blog List Title</label>
                        <input type="text" name="blog_list_title" class="form-control" value="{{ old('blog_list_title', $settings['blog_list_title']) }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Blogs Per Page</label>
                        <input type="number" min="1" max="50" name="blogs_per_page" class="form-control" value="{{ old('blogs_per_page', $settings['blogs_per_page']) }}" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-check"></i> Save
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $('#pages_link').addClass('active');
    $('#pages').addClass('menu-open');
    $('#pages_blog').addClass('active');
</script>
@endpush
