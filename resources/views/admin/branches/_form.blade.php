<div class="row">
    <div class="col-lg-8">
        <div class="form-group">
            <label>Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Branch title" name="title" id="title" value="{{ old('title', isset($branch) ? ($branch->title ?: $branch->name) : '') }}" required>
            @error('title')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label>Feature Image</label>
            <input type="file" class="form-control-file @error('feature_image') is-invalid @enderror" name="feature_image" id="feature_image" accept="image/*">
            @error('feature_image')
                <span class="text-danger small d-block">{{ $message }}</span>
            @enderror
            @if(isset($branch) && $branch->feature_image)
                <img src="{{ asset($branch->feature_image) }}" alt="{{ $branch->title ?: $branch->name }}" class="img-thumbnail mt-2" style="max-height: 120px;">
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label>Description <span class="text-danger">*</span></label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="4" required>{{ old('description', isset($branch) ? $branch->description : '') }}</textarea>
            @error('description')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label>Address <span class="text-danger">*</span></label>
            <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" rows="4" required>{{ old('address', isset($branch) ? $branch->address : '') }}</textarea>
            @error('address')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label>Contact Information <span class="text-danger">*</span></label>
            <textarea class="form-control @error('contact_information') is-invalid @enderror" name="contact_information" id="contact_information" rows="4" required>{{ old('contact_information', isset($branch) ? $branch->contact_information : '') }}</textarea>
            @error('contact_information')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label>Google Map Location <span class="text-danger">*</span></label>
            <textarea class="form-control @error('google_map_location') is-invalid @enderror" name="google_map_location" id="google_map_location" rows="3" required>{{ old('google_map_location', isset($branch) ? $branch->google_map_location : '') }}</textarea>
            @error('google_map_location')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label>Branch Gallery Images</label>
            <input type="file" class="form-control-file @error('gallery_images.*') is-invalid @enderror" name="gallery_images[]" multiple accept="image/*">
            @error('gallery_images')
                <span class="text-danger small d-block">{{ $message }}</span>
            @enderror
            @error('gallery_images.*')
                <span class="text-danger small d-block">{{ $message }}</span>
            @enderror
            <small class="text-muted">Upload multiple images for this branch gallery.</small>
        </div>
    </div>
</div>

@if(isset($branch) && $branch->galleries->isNotEmpty())
<div class="row">
    @foreach($branch->galleries as $gallery)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <img src="{{ asset($gallery->image) }}" alt="{{ $gallery->name }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                <div class="card-body">
                    <div class="form-group">
                        <label>Image Name</label>
                        <input type="text" name="existing_gallery_names[{{ $gallery->id }}]" class="form-control" value="{{ old('existing_gallery_names.'.$gallery->id, $gallery->name) }}">
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="delete_gallery_{{ $gallery->id }}" name="delete_gallery_ids[]" value="{{ $gallery->id }}">
                        <label class="custom-control-label text-danger" for="delete_gallery_{{ $gallery->id }}">Delete this image</label>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endif
