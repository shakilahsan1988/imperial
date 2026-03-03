@extends('layouts.app')

@section('title')
Services Settings
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fas fa-stethoscope nav-icon"></i>
                    Services Settings
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Services Settings</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">/services Page Settings</h3>
    </div>
    <form method="POST" action="{{ route('admin.pages.services_settings_submit') }}" enctype="multipart/form-data">
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
            <h5>Overview Section</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Section Badge</label>
                        <input type="text" name="section_badge" class="form-control" value="{{ old('section_badge', $settings['section_badge']) }}" required>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Section Title</label>
                        <input type="text" name="section_title" class="form-control" value="{{ old('section_title', $settings['section_title']) }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Section Description</label>
                        <textarea name="section_description" class="form-control" rows="3" required>{{ old('section_description', $settings['section_description']) }}</textarea>
                    </div>
                </div>
            </div>

            <hr>
            <h5>Content Block 1</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Badge</label>
                        <input type="text" name="block_1_badge" class="form-control" value="{{ old('block_1_badge', $settings['block_1_badge']) }}" required>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="block_1_title" class="form-control" value="{{ old('block_1_title', $settings['block_1_title']) }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="block_1_description" class="form-control" rows="3" required>{{ old('block_1_description', $settings['block_1_description']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="block_1_button_text" class="form-control" value="{{ old('block_1_button_text', $settings['block_1_button_text']) }}" required>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Button URL</label>
                        <input type="text" name="block_1_button_url" class="form-control" value="{{ old('block_1_button_url', $settings['block_1_button_url']) }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Block 1 Image</label>
                        <input type="hidden" name="block_1_image" value="{{ old('block_1_image', $settings['block_1_image']) }}">
                        <input type="file" name="block_1_image_file" class="form-control-file" accept="image/*">
                        @if(!empty($settings['block_1_image']))
                            <img src="{{ asset($settings['block_1_image']) }}" class="img-thumbnail mt-2" style="max-height: 120px;">
                        @endif
                    </div>
                </div>
            </div>

            <hr>
            <h5>Content Block 2</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Badge</label>
                        <input type="text" name="block_2_badge" class="form-control" value="{{ old('block_2_badge', $settings['block_2_badge']) }}" required>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="block_2_title" class="form-control" value="{{ old('block_2_title', $settings['block_2_title']) }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="block_2_description" class="form-control" rows="3" required>{{ old('block_2_description', $settings['block_2_description']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="block_2_button_text" class="form-control" value="{{ old('block_2_button_text', $settings['block_2_button_text']) }}" required>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Button URL</label>
                        <input type="text" name="block_2_button_url" class="form-control" value="{{ old('block_2_button_url', $settings['block_2_button_url']) }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Block 2 Image</label>
                        <input type="hidden" name="block_2_image" value="{{ old('block_2_image', $settings['block_2_image']) }}">
                        <input type="file" name="block_2_image_file" class="form-control-file" accept="image/*">
                        @if(!empty($settings['block_2_image']))
                            <img src="{{ asset($settings['block_2_image']) }}" class="img-thumbnail mt-2" style="max-height: 120px;">
                        @endif
                    </div>
                </div>
            </div>

            <hr>
            <h5>Services Catalog Section</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Catalog Title</label>
                        <input type="text" name="catalog_title" class="form-control" value="{{ old('catalog_title', $settings['catalog_title']) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Empty State Text</label>
                        <input type="text" name="empty_state_text" class="form-control" value="{{ old('empty_state_text', $settings['empty_state_text']) }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Catalog Description</label>
                        <textarea name="catalog_description" class="form-control" rows="3" required>{{ old('catalog_description', $settings['catalog_description']) }}</textarea>
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
    $('#pages_services').addClass('active');
</script>
@endpush
