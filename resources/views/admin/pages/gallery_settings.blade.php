@extends('layouts.app')

@section('title')
{{ $title }}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fas fa-file-alt nav-icon"></i>
                    {{ $title }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@php
    $submittedGroups = old('gallery_groups');
    $formGroups = is_array($submittedGroups)
        ? collect($submittedGroups)->map(function ($group) {
            return [
                'id' => $group['id'] ?? null,
                'name' => $group['name'] ?? '',
                'images' => collect($group['existing_images'] ?? [])->map(function ($image) {
                    return [
                        'id' => $image['id'] ?? null,
                        'name' => $image['name'] ?? '',
                        'image' => $image['image'] ?? '',
                    ];
                })->values()->all(),
            ];
        })->values()
        : $galleryGroups->map(function ($group) {
            return [
                'id' => $group->id,
                'name' => $group->name,
                'images' => $group->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'name' => $image->name,
                        'image' => $image->image,
                    ];
                })->values()->all(),
            ];
        })->values();
@endphp

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $subtitle }}</h3>
    </div>
    <form method="POST" action="{{ route($submitRoute) }}" enctype="multipart/form-data">
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="mb-1">Gallery Groups</h5>
                    <p class="text-muted mb-0">Create groups like Doctor, Blood Donation Event 2026, or any custom event and upload multiple images inside each group.</p>
                </div>
                <button type="button" class="btn btn-outline-primary" id="add-gallery-group">
                    <i class="fa fa-plus"></i> Add Group
                </button>
            </div>

            <div id="gallery-groups">
                @foreach($formGroups as $groupIndex => $group)
                    <div class="card card-outline card-secondary gallery-group mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0">Gallery Group</h3>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-gallery-group">
                                <i class="fa fa-trash"></i> Remove Group
                            </button>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="gallery_groups[{{ $groupIndex }}][id]" value="{{ $group['id'] }}">

                            <div class="form-group">
                                <label>Group Name <span class="text-danger">*</span></label>
                                <input type="text" name="gallery_groups[{{ $groupIndex }}][name]" class="form-control" value="{{ $group['name'] }}" placeholder="Example: Doctors or Blood Donation Event 2026" required>
                            </div>

                            <div class="form-group">
                                <label>Upload New Images</label>
                                <input type="file" name="gallery_groups[{{ $groupIndex }}][new_images][]" class="form-control-file" accept="image/*" multiple>
                                <small class="form-text text-muted">You can select multiple images at once for this group.</small>
                            </div>

                            <div class="existing-gallery-images">
                                @if(!empty($group['images']))
                                    <label class="d-block">Existing Images</label>
                                    <div class="row">
                                        @foreach($group['images'] as $imageIndex => $image)
                                            <div class="col-md-4 mb-3 existing-gallery-image">
                                                <div class="card h-100">
                                                    <img src="{{ asset($image['image']) }}" alt="{{ $image['name'] ?: $group['name'] }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                                                    <div class="card-body">
                                                        <input type="hidden" name="gallery_groups[{{ $groupIndex }}][existing_images][{{ $imageIndex }}][id]" value="{{ $image['id'] }}">
                                                        <input type="hidden" name="gallery_groups[{{ $groupIndex }}][existing_images][{{ $imageIndex }}][image]" value="{{ $image['image'] }}">
                                                        <div class="form-group mb-2">
                                                            <label class="mb-1">Image Title</label>
                                                            <input type="text" name="gallery_groups[{{ $groupIndex }}][existing_images][{{ $imageIndex }}][name]" class="form-control" value="{{ $image['name'] }}">
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-existing-image">
                                                            <i class="fa fa-trash"></i> Remove Image
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-check"></i> Save
            </button>
        </div>
    </form>
</div>

<template id="gallery-group-template">
    <div class="card card-outline card-secondary gallery-group mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Gallery Group</h3>
            <button type="button" class="btn btn-sm btn-outline-danger remove-gallery-group">
                <i class="fa fa-trash"></i> Remove Group
            </button>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Group Name <span class="text-danger">*</span></label>
                <input type="text" name="gallery_groups[__INDEX__][name]" class="form-control" placeholder="Example: Doctors or Blood Donation Event 2026" required>
            </div>

            <div class="form-group mb-0">
                <label>Upload New Images</label>
                <input type="file" name="gallery_groups[__INDEX__][new_images][]" class="form-control-file" accept="image/*" multiple>
                <small class="form-text text-muted">You can select multiple images at once for this group.</small>
            </div>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script>
    (function () {
        $('#pages_link').addClass('active');
        $('#pages').addClass('menu-open');
        $('#{{ $activeMenuId }}').addClass('active');

        const container = document.getElementById('gallery-groups');
        const template = document.getElementById('gallery-group-template').innerHTML;
        let nextGroupIndex = {{ $formGroups->count() }};

        document.getElementById('add-gallery-group').addEventListener('click', function () {
            const markup = template.split('__INDEX__').join(String(nextGroupIndex));
            container.insertAdjacentHTML('beforeend', markup);
            nextGroupIndex += 1;
        });

        document.addEventListener('click', function (event) {
            const removeGroupButton = event.target.closest('.remove-gallery-group');
            if (removeGroupButton) {
                removeGroupButton.closest('.gallery-group').remove();
                return;
            }

            const removeImageButton = event.target.closest('.remove-existing-image');
            if (removeImageButton) {
                removeImageButton.closest('.existing-gallery-image').remove();
            }
        });
    })();
</script>
@endpush
