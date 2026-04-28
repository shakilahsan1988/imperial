@extends('layouts.app')

@section('title')
Home Settings
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fas fa-file-alt nav-icon"></i>
                    Home Settings
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Home Settings</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
@php
    $slides = $homeSettings['hero']['slides'] ?? [];
@endphp

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Homepage Content Settings</h3>
    </div>
    <form method="POST" action="{{ route('admin.pages.home_settings_submit') }}" enctype="multipart/form-data">
        <div class="card-body">
            @csrf

            <h5>Hero Section (Dynamic Slider)</h5>
            <p class="text-muted">Add/remove slides. If no slides exist, hero section will not render on homepage.</p>
            <div id="hero-slides-wrapper">
                @foreach($slides as $index => $slide)
                <div class="card mb-3 hero-slide-item" data-index="{{ $index }}">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>Slide #<span class="slide-number">{{ $index + 1 }}</span></strong>
                        <button type="button" class="btn btn-sm btn-danger remove-slide">Remove</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Badge</label>
                                    <input type="text" name="hero_badge[]" class="form-control" value="{{ $slide['badge'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Title (HTML allowed)</label>
                                    <textarea name="hero_title_html[]" class="form-control" rows="2">{{ $slide['title_html'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="hero_description[]" class="form-control" rows="2">{{ $slide['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Button Text</label>
                                    <input type="text" name="hero_button_text[]" class="form-control" value="{{ $slide['button_text'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Button URL</label>
                                    <input type="text" name="hero_button_url[]" class="form-control" value="{{ $slide['button_url'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Slide Image</label>
                                    <input type="hidden" name="hero_existing_image[]" value="{{ $slide['image'] ?? '' }}">
                                    <input type="file" name="hero_image[]" class="form-control-file" accept="image/*">
                                    @if(!empty($slide['image']))
                                        <img src="{{ asset($slide['image']) }}" alt="Slide Image" class="img-thumbnail mt-2" style="max-height: 90px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-outline-primary mb-4" id="add-slide-btn">
                <i class="fa fa-plus"></i> Add Slide
            </button>

            <hr>
            <h5>About + Stats</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>About Badge</label>
                        <input type="text" name="about[badge]" class="form-control" value="{{ old('about.badge', $homeSettings['about']['badge']) }}" required>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>About Title (HTML allowed)</label>
                        <textarea name="about[title_html]" class="form-control" rows="2" required>{{ old('about.title_html', $homeSettings['about']['title_html']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>About Description</label>
                        <textarea name="about[description]" class="form-control" rows="3" required>{{ old('about.description', $homeSettings['about']['description']) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Specialities Count</label>
                        <input type="text" name="stats[specialities_count]" class="form-control" value="{{ old('stats.specialities_count', $homeSettings['stats']['specialities_count']) }}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Specialities Label</label>
                        <input type="text" name="stats[specialities_label]" class="form-control" value="{{ old('stats.specialities_label', $homeSettings['stats']['specialities_label']) }}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Doctors Count</label>
                        <input type="text" name="stats[doctors_count]" class="form-control" value="{{ old('stats.doctors_count', $homeSettings['stats']['doctors_count']) }}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Doctors Label</label>
                        <input type="text" name="stats[doctors_label]" class="form-control" value="{{ old('stats.doctors_label', $homeSettings['stats']['doctors_label']) }}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Patients Count</label>
                        <input type="text" name="stats[patients_count]" class="form-control" value="{{ old('stats.patients_count', $homeSettings['stats']['patients_count']) }}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Patients Label</label>
                        <input type="text" name="stats[patients_label]" class="form-control" value="{{ old('stats.patients_label', $homeSettings['stats']['patients_label']) }}" required>
                    </div>
                </div>
            </div>

            <hr>
            <h5>Doctor Carousel Section</h5>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="doctor_carousel_enabled" name="doctor_carousel[enabled]" value="1" {{ old('doctor_carousel.enabled', $homeSettings['doctor_carousel']['enabled'] ?? true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="doctor_carousel_enabled">Enable this section</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Badge</label>
                        <input type="text" name="doctor_carousel[badge]" class="form-control" value="{{ old('doctor_carousel.badge', $homeSettings['doctor_carousel']['badge']) }}" required>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Title (HTML allowed)</label>
                        <textarea name="doctor_carousel[title_html]" class="form-control" rows="2" required>{{ old('doctor_carousel.title_html', $homeSettings['doctor_carousel']['title_html']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="doctor_carousel[description]" class="form-control" rows="4" required>{{ old('doctor_carousel.description', $homeSettings['doctor_carousel']['description']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="doctor_carousel[button_text]" class="form-control" value="{{ old('doctor_carousel.button_text', $homeSettings['doctor_carousel']['button_text']) }}" required>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Button URL</label>
                        <input type="text" name="doctor_carousel[button_url]" class="form-control" value="{{ old('doctor_carousel.button_url', $homeSettings['doctor_carousel']['button_url']) }}" required>
                    </div>
                </div>
            </div>

            <hr>
            <h5>Our Approach Section</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Badge</label>
                        <input type="text" name="our_approach[badge]" class="form-control" value="{{ old('our_approach.badge', $homeSettings['our_approach']['badge']) }}" required>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Title (HTML allowed)</label>
                        <textarea name="our_approach[title_html]" class="form-control" rows="2" required>{{ old('our_approach.title_html', $homeSettings['our_approach']['title_html']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Description 1</label>
                        <textarea name="our_approach[description_1]" class="form-control" rows="3" required>{{ old('our_approach.description_1', $homeSettings['our_approach']['description_1']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Description 2</label>
                        <textarea name="our_approach[description_2]" class="form-control" rows="3" required>{{ old('our_approach.description_2', $homeSettings['our_approach']['description_2']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="our_approach[button_text]" class="form-control" value="{{ old('our_approach.button_text', $homeSettings['our_approach']['button_text']) }}" required>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Button URL</label>
                        <input type="text" name="our_approach[button_url]" class="form-control" value="{{ old('our_approach.button_url', $homeSettings['our_approach']['button_url']) }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Section Image</label>
                        <input type="hidden" name="our_approach[image]" value="{{ old('our_approach.image', $homeSettings['our_approach']['image']) }}">
                        <input type="file" name="our_approach_image" class="form-control-file" accept="image/*">
                        @if(!empty($homeSettings['our_approach']['image']))
                            <img src="{{ asset($homeSettings['our_approach']['image']) }}" alt="Our Approach Image" class="img-thumbnail mt-2" style="max-height: 120px;">
                        @endif
                    </div>
                </div>
            </div>

            <hr>
            <h5>Lab Excellence Section</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Badge</label>
                        <input type="text" name="lab_excellence[badge]" class="form-control" value="{{ old('lab_excellence.badge', $homeSettings['lab_excellence']['badge']) }}" required>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Title (HTML allowed)</label>
                        <textarea name="lab_excellence[title_html]" class="form-control" rows="2" required>{{ old('lab_excellence.title_html', $homeSettings['lab_excellence']['title_html']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="lab_excellence[description]" class="form-control" rows="3" required>{{ old('lab_excellence.description', $homeSettings['lab_excellence']['description']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Feature 1</label>
                        <input type="text" name="lab_excellence[feature_1]" class="form-control" value="{{ old('lab_excellence.feature_1', $homeSettings['lab_excellence']['feature_1']) }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Feature 2</label>
                        <input type="text" name="lab_excellence[feature_2]" class="form-control" value="{{ old('lab_excellence.feature_2', $homeSettings['lab_excellence']['feature_2']) }}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="lab_excellence[button_text]" class="form-control" value="{{ old('lab_excellence.button_text', $homeSettings['lab_excellence']['button_text']) }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Button URL</label>
                        <input type="text" name="lab_excellence[button_url]" class="form-control" value="{{ old('lab_excellence.button_url', $homeSettings['lab_excellence']['button_url']) }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Section Image</label>
                        <input type="hidden" name="lab_excellence[image]" value="{{ old('lab_excellence.image', $homeSettings['lab_excellence']['image']) }}">
                        <input type="file" name="lab_excellence_image" class="form-control-file" accept="image/*">
                        @if(!empty($homeSettings['lab_excellence']['image']))
                            <img src="{{ asset($homeSettings['lab_excellence']['image']) }}" alt="Lab Excellence Image" class="img-thumbnail mt-2" style="max-height: 120px;">
                        @endif
                    </div>
                </div>
            </div>

            <hr>
            <h5>Experience Imperial Section</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Badge</label>
                        <input type="text" name="experience_imperial[badge]" class="form-control" value="{{ old('experience_imperial.badge', $homeSettings['experience_imperial']['badge']) }}" required>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Title (HTML allowed)</label>
                        <textarea name="experience_imperial[title_html]" class="form-control" rows="2" required>{{ old('experience_imperial.title_html', $homeSettings['experience_imperial']['title_html']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="experience_imperial[description]" class="form-control" rows="3" required>{{ old('experience_imperial.description', $homeSettings['experience_imperial']['description']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="experience_imperial[button_text]" class="form-control" value="{{ old('experience_imperial.button_text', $homeSettings['experience_imperial']['button_text']) }}" required>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Button URL</label>
                        <input type="text" name="experience_imperial[button_url]" class="form-control" value="{{ old('experience_imperial.button_url', $homeSettings['experience_imperial']['button_url']) }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Section Image</label>
                        <input type="hidden" name="experience_imperial[image]" value="{{ old('experience_imperial.image', $homeSettings['experience_imperial']['image']) }}">
                        <input type="file" name="experience_imperial_image" class="form-control-file" accept="image/*">
                        @if(!empty($homeSettings['experience_imperial']['image']))
                            <img src="{{ asset($homeSettings['experience_imperial']['image']) }}" alt="Experience Imperial Image" class="img-thumbnail mt-2" style="max-height: 120px;">
                        @endif
                    </div>
                </div>
            </div>

            <hr>
            <h5>Continuous Care Section</h5>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Title (HTML allowed)</label>
                        <textarea name="continuous_care[title_html]" class="form-control" rows="2" required>{{ old('continuous_care.title_html', $homeSettings['continuous_care']['title_html']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="continuous_care[description]" class="form-control" rows="3" required>{{ old('continuous_care.description', $homeSettings['continuous_care']['description']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="continuous_care[button_text]" class="form-control" value="{{ old('continuous_care.button_text', $homeSettings['continuous_care']['button_text']) }}" required>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Button URL</label>
                        <input type="text" name="continuous_care[button_url]" class="form-control" value="{{ old('continuous_care.button_url', $homeSettings['continuous_care']['button_url']) }}" required>
                    </div>
                </div>
            </div>

            <hr>
            <h5>Expert Advice Section</h5>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Title (HTML allowed)</label>
                        <textarea name="expert_advice[title_html]" class="form-control" rows="2" required>{{ old('expert_advice.title_html', $homeSettings['expert_advice']['title_html']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="expert_advice[description]" class="form-control" rows="3" required>{{ old('expert_advice.description', $homeSettings['expert_advice']['description']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="expert_advice[button_text]" class="form-control" value="{{ old('expert_advice.button_text', $homeSettings['expert_advice']['button_text']) }}" required>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Button URL</label>
                        <input type="text" name="expert_advice[button_url]" class="form-control" value="{{ old('expert_advice.button_url', $homeSettings['expert_advice']['button_url']) }}" required>
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

<template id="hero-slide-template">
    <div class="card mb-3 hero-slide-item">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Slide #<span class="slide-number"></span></strong>
            <button type="button" class="btn btn-sm btn-danger remove-slide">Remove</button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Badge</label>
                        <input type="text" name="hero_badge[]" class="form-control">
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Title (HTML allowed)</label>
                        <textarea name="hero_title_html[]" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="hero_description[]" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="hero_button_text[]" class="form-control">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Button URL</label>
                        <input type="text" name="hero_button_url[]" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Slide Image</label>
                        <input type="hidden" name="hero_existing_image[]" value="">
                        <input type="file" name="hero_image[]" class="form-control-file" accept="image/*">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
@endsection

@section('scripts')
<script>
    function refreshSlideNumbers() {
        document.querySelectorAll('.hero-slide-item').forEach((item, i) => {
            const n = item.querySelector('.slide-number');
            if (n) n.textContent = i + 1;
        });
    }

    document.addEventListener('click', function (e) {
        if (e.target.matches('#add-slide-btn')) {
            const tpl = document.getElementById('hero-slide-template');
            const node = tpl.content.cloneNode(true);
            document.getElementById('hero-slides-wrapper').appendChild(node);
            refreshSlideNumbers();
        }

        if (e.target.classList.contains('remove-slide')) {
            const card = e.target.closest('.hero-slide-item');
            if (card) {
                card.remove();
                refreshSlideNumbers();
            }
        }
    });

    refreshSlideNumbers();
</script>
@endsection
