@php
    $oldInput = session()->getOldInput();
@endphp

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label>Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', isset($team_member) ? $team_member->name : '') }}" 
                   placeholder="Enter member name" required>
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Designation <span class="text-danger">*</span></label>
            <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" 
                   value="{{ old('designation', isset($team_member) ? $team_member->designation : '') }}" 
                   placeholder="e.g., Chief Executive Officer" required>
            @error('designation')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Bio / Message</label>
            <textarea name="bio" class="form-control summernote @error('bio') is-invalid @enderror" 
                      rows="5" placeholder="Enter bio or message">{!! old('bio', isset($team_member) ? $team_member->bio : '') !!}</textarea>
            @error('bio')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <small class="text-muted">Optional. A brief biography or message from the team member.</small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" 
                   accept="image/*">
            @error('image')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <small class="text-muted">Max size: 5MB. Formats: JPG, PNG, WebP</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" 
                   value="{{ old('sort_order', isset($team_member) ? $team_member->sort_order : 0) }}" 
                   min="0">
            @error('sort_order')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <small class="text-muted">Lower numbers appear first</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Status</label>
            <div class="custom-control custom-switch mt-2">
                <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" 
                       {{ old('status', isset($team_member) ? $team_member->status : true) ? 'checked' : '' }}>
                <label class="custom-control-label" for="status">Active</label>
            </div>
        </div>
    </div>
</div>

@if(isset($team_member) && $team_member->image)
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Current Image</label>
            <div class="mt-2">
                <img src="{{ asset($team_member->image) }}" alt="{{ $team_member->name }}" 
                     class="img-thumbnail" style="max-height: 150px;">
            </div>
        </div>
    </div>
</div>
@endif
