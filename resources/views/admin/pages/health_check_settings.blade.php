@extends('layouts.app')

@section('title')
Health Check Settings
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fas fa-heartbeat nav-icon"></i>
                    Health Check Settings
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Health Check Settings</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">/health-check Page Settings</h3>
    </div>
    <form method="POST" action="{{ route('admin.pages.health_check_settings_submit') }}" enctype="multipart/form-data">
        <div class="card-body">
            @csrf

            <h5>Page Basics</h5>
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
            <h5>Feature Cards</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Feature 1 Title</label>
                        <input type="text" name="feature_1_title" class="form-control" value="{{ old('feature_1_title', $settings['feature_1_title']) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Feature 1 Description</label>
                        <input type="text" name="feature_1_desc" class="form-control" value="{{ old('feature_1_desc', $settings['feature_1_desc']) }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Feature 2 Title</label>
                        <input type="text" name="feature_2_title" class="form-control" value="{{ old('feature_2_title', $settings['feature_2_title']) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Feature 2 Description</label>
                        <input type="text" name="feature_2_desc" class="form-control" value="{{ old('feature_2_desc', $settings['feature_2_desc']) }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Feature 3 Title</label>
                        <input type="text" name="feature_3_title" class="form-control" value="{{ old('feature_3_title', $settings['feature_3_title']) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Feature 3 Description</label>
                        <input type="text" name="feature_3_desc" class="form-control" value="{{ old('feature_3_desc', $settings['feature_3_desc']) }}" required>
                    </div>
                </div>
            </div>

            <hr>
            <h5>FAQ Section</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>FAQ Title</label>
                        <input type="text" name="faq_title" class="form-control" value="{{ old('faq_title', $settings['faq_title']) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>FAQ Subtitle</label>
                        <input type="text" name="faq_subtitle" class="form-control" value="{{ old('faq_subtitle', $settings['faq_subtitle']) }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>FAQ 1 Question</label>
                        <input type="text" name="faq_1_question" class="form-control" value="{{ old('faq_1_question', $settings['faq_1_question']) }}" required>
                    </div>
                    <div class="form-group">
                        <label>FAQ 1 Answer</label>
                        <textarea name="faq_1_answer" class="form-control" rows="4" required>{{ old('faq_1_answer', $settings['faq_1_answer']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>FAQ 2 Question</label>
                        <input type="text" name="faq_2_question" class="form-control" value="{{ old('faq_2_question', $settings['faq_2_question']) }}" required>
                    </div>
                    <div class="form-group">
                        <label>FAQ 2 Answer</label>
                        <textarea name="faq_2_answer" class="form-control" rows="4" required>{{ old('faq_2_answer', $settings['faq_2_answer']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>FAQ 3 Question</label>
                        <input type="text" name="faq_3_question" class="form-control" value="{{ old('faq_3_question', $settings['faq_3_question']) }}" required>
                    </div>
                    <div class="form-group">
                        <label>FAQ 3 Answer</label>
                        <textarea name="faq_3_answer" class="form-control" rows="4" required>{{ old('faq_3_answer', $settings['faq_3_answer']) }}</textarea>
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
