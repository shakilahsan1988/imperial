<div class="form-group">
    <label>Page Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', optional($page)->title) }}" required>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', optional($page)->slug) }}" required>
            <small class="text-muted">Frontend URL: {{ url('/') }}/<span id="slug-preview">{{ old('slug', optional($page)->slug) }}</span></small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', optional($page)->sort_order ?? 0) }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Meta Title</label>
            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', optional($page)->meta_title) }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Layout Type</label>
            <input type="text" name="layout_type" class="form-control" value="{{ old('layout_type', optional($page)->layout_type ?? 'default') }}">
        </div>
    </div>
</div>

<div class="form-group">
    <label>Meta Description</label>
    <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', optional($page)->meta_description) }}</textarea>
</div>

<hr>
<h5>Hero Section</h5>
<div class="form-group">
    <label>Hero Title (HTML allowed)</label>
    <textarea name="hero_title_html" class="form-control" rows="2">{{ old('hero_title_html', optional($page)->hero_title_html) }}</textarea>
</div>
<div class="form-group">
    <label>Hero Description</label>
    <textarea name="hero_description" class="form-control" rows="3">{{ old('hero_description', optional($page)->hero_description) }}</textarea>
</div>
<div class="form-group">
    <label>Hero Image</label>
    <input type="hidden" name="hero_image" value="{{ old('hero_image', optional($page)->hero_image) }}">
    <input type="file" name="hero_image_file" class="form-control-file" accept="image/*">
    @if(!empty(optional($page)->hero_image))
        <img src="{{ asset($page->hero_image) }}" class="img-thumbnail mt-2" style="max-height: 120px;">
    @endif
</div>

<hr>
<div class="form-group">
    <label>Page Text</label>
    <small class="form-text text-muted">Use plain text content for policy pages like privacy policy and terms of use.</small>
    <textarea name="body_html" class="form-control" rows="10">{{ old('body_html', optional($page)->body_html) }}</textarea>
</div>

<div class="form-group">
    <label>Advanced Settings JSON (optional)</label>
    <textarea name="settings_json" class="form-control" rows="4">{{ old('settings_json', isset($page) && is_array(optional($page)->settings_json) ? json_encode($page->settings_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '') }}</textarea>
</div>

<div class="custom-control custom-switch">
    <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" {{ old('status', isset($page) ? $page->status : true) ? 'checked' : '' }}>
    <label class="custom-control-label" for="status">Published</label>
</div>
