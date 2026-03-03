@extends('layouts.app')

@section('title')
About Us Settings
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fas fa-info-circle nav-icon"></i>
                    About Us Settings
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">About Us Settings</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">/about Page Settings</h3>
    </div>
    <form method="POST" action="{{ route('admin.pages.about_settings_submit') }}" enctype="multipart/form-data">
        <div class="card-body">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Page Name <span class="text-danger">*</span></label>
                        <input type="text" name="page_name" class="form-control" value="{{ old('page_name', $settings['page_name']) }}" required>
                    </div>
                </div>
            </div>

            <hr>
            <h5>Hero Section</h5>
            <div class="row">
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
            <h5>Intro Section</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Intro Title</label>
                        <input type="text" name="intro_title" class="form-control" value="{{ old('intro_title', $settings['intro_title']) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Intro Image</label>
                        <input type="hidden" name="intro_image" value="{{ old('intro_image', $settings['intro_image']) }}">
                        <input type="file" name="intro_image_file" class="form-control-file" accept="image/*">
                        @if(!empty($settings['intro_image']))
                            <img src="{{ asset($settings['intro_image']) }}" class="img-thumbnail mt-2" style="max-height: 120px;">
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Intro Description</label>
                        <textarea name="intro_description" class="form-control" rows="3" required>{{ old('intro_description', $settings['intro_description']) }}</textarea>
                    </div>
                </div>
            </div>

            <hr>
            <h5>Feature Blocks</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Feature 1 Title</label>
                        <input type="text" name="feature_1_title" class="form-control" value="{{ old('feature_1_title', $settings['feature_1_title']) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Feature 1 Description</label>
                        <textarea name="feature_1_desc" class="form-control" rows="5" required>{{ old('feature_1_desc', $settings['feature_1_desc']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Feature 2 Title</label>
                        <input type="text" name="feature_2_title" class="form-control" value="{{ old('feature_2_title', $settings['feature_2_title']) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Feature 2 Description</label>
                        <textarea name="feature_2_desc" class="form-control" rows="5" required>{{ old('feature_2_desc', $settings['feature_2_desc']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Feature 3 Title</label>
                        <input type="text" name="feature_3_title" class="form-control" value="{{ old('feature_3_title', $settings['feature_3_title']) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Feature 3 Description</label>
                        <textarea name="feature_3_desc" class="form-control" rows="5" required>{{ old('feature_3_desc', $settings['feature_3_desc']) }}</textarea>
                    </div>
                </div>
            </div>

            <hr>
            <h5>Leadership and Partners Section</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Leadership Title</label>
                        <input type="text" name="leadership_title" class="form-control" value="{{ old('leadership_title', $settings['leadership_title']) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Partners Title</label>
                        <input type="text" name="partners_title" class="form-control" value="{{ old('partners_title', $settings['partners_title']) }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Leadership Description</label>
                        <textarea name="leadership_description" class="form-control" rows="3" required>{{ old('leadership_description', $settings['leadership_description']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Partners Subtitle</label>
                        <input type="text" name="partners_subtitle" class="form-control" value="{{ old('partners_subtitle', $settings['partners_subtitle']) }}" required>
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
    $('#pages_about').addClass('active');
</script>
@endpush
