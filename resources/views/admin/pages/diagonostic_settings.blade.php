@extends('layouts.app')

@section('title')
Diagonostic Settings
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fas fa-flask nav-icon"></i>
                    Diagonostic Settings
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Diagonostic Settings</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">/lab-test Page Settings</h3>
    </div>
    <form method="POST" action="{{ route('admin.pages.diagonostic_settings_submit') }}" enctype="multipart/form-data">
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
            <h5>Search & Filter Labels</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Search Placeholder</label>
                        <input type="text" name="search_placeholder" class="form-control" value="{{ old('search_placeholder', $settings['search_placeholder']) }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>All Tests Label</label>
                        <input type="text" name="all_tests_label" class="form-control" value="{{ old('all_tests_label', $settings['all_tests_label']) }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Laboratory Label</label>
                        <input type="text" name="laboratory_label" class="form-control" value="{{ old('laboratory_label', $settings['laboratory_label']) }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Imaging Label</label>
                        <input type="text" name="imaging_label" class="form-control" value="{{ old('imaging_label', $settings['imaging_label']) }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Procedures Label</label>
                        <input type="text" name="procedures_label" class="form-control" value="{{ old('procedures_label', $settings['procedures_label']) }}" required>
                    </div>
                </div>
            </div>

            <hr>
            <h5>Catalog Footer</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Footer Prefix</label>
                        <input type="text" name="catalog_footer_prefix" class="form-control" value="{{ old('catalog_footer_prefix', $settings['catalog_footer_prefix']) }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Footer Suffix</label>
                        <input type="text" name="catalog_footer_suffix" class="form-control" value="{{ old('catalog_footer_suffix', $settings['catalog_footer_suffix']) }}" required>
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
