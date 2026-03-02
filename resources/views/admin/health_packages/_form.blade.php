<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Page Name *</label>
            <input type="text" name="page_name" class="form-control" value="{{ old('page_name', $package->page_name ?? 'Package Details') }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Package Category *</label>
            <select name="health_package_category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('health_package_category_id', $package->health_package_category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Package Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $package->name ?? '') }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Subtitle</label>
            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $package->subtitle ?? '') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Badge Text</label>
            <input type="text" name="badge_text" class="form-control" value="{{ old('badge_text', $package->badge_text ?? 'Comprehensive Screening') }}">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Price *</label>
            <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price', $package->price ?? 0) }}" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Old Price</label>
            <input type="number" step="0.01" min="0" name="old_price" class="form-control" value="{{ old('old_price', $package->old_price ?? '') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Discount Label</label>
            <input type="text" name="discount_text" class="form-control" value="{{ old('discount_text', $package->discount_text ?? '') }}" placeholder="e.g., Save 23%">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Duration</label>
            <input type="text" name="duration" class="form-control" value="{{ old('duration', $package->duration ?? '4-6 Hours') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Turnaround</label>
            <input type="text" name="turnaround" class="form-control" value="{{ old('turnaround', $package->turnaround ?? '24-48 Hours') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Fasting</label>
            <input type="text" name="fasting" class="form-control" value="{{ old('fasting', $package->fasting ?? '10-12 Hours') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Image</label>
            <input type="hidden" name="existing_image" value="{{ old('existing_image', $package->image ?? '') }}">
            <input type="file" name="image" class="form-control-file" accept="image/*">
            @if(!empty($package->image))
                <img src="{{ asset($package->image) }}" class="img-thumbnail mt-2" style="max-height:90px;">
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $package->description ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Inclusions (one line per item)</label>
            <textarea name="inclusions" class="form-control" rows="8">{{ old('inclusions', $package->inclusions ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Preparation Steps (one line per step)</label>
            <textarea name="preparation_steps" class="form-control" rows="8">{{ old('preparation_steps', $package->preparation_steps ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>FAQ 1 Question</label>
            <input type="text" name="faq_1_question" class="form-control" value="{{ old('faq_1_question', $package->faq_1_question ?? '') }}">
        </div>
        <div class="form-group">
            <label>FAQ 1 Answer</label>
            <textarea name="faq_1_answer" class="form-control" rows="3">{{ old('faq_1_answer', $package->faq_1_answer ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>FAQ 2 Question</label>
            <input type="text" name="faq_2_question" class="form-control" value="{{ old('faq_2_question', $package->faq_2_question ?? '') }}">
        </div>
        <div class="form-group">
            <label>FAQ 2 Answer</label>
            <textarea name="faq_2_answer" class="form-control" rows="3">{{ old('faq_2_answer', $package->faq_2_answer ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $package->sort_order ?? 0) }}">
        </div>
    </div>
    <div class="col-md-9">
        <div class="form-group mt-4">
            <div class="custom-control custom-checkbox d-inline-block mr-3">
                <input type="checkbox" class="custom-control-input" id="recommended" name="recommended" value="1" {{ old('recommended', $package->recommended ?? false) ? 'checked' : '' }}>
                <label class="custom-control-label" for="recommended">Recommended</label>
            </div>
            <div class="custom-control custom-checkbox d-inline-block mr-3">
                <input type="checkbox" class="custom-control-input" id="immediate_availability" name="immediate_availability" value="1" {{ old('immediate_availability', $package->immediate_availability ?? true) ? 'checked' : '' }}>
                <label class="custom-control-label" for="immediate_availability">Immediate Availability</label>
            </div>
            <div class="custom-control custom-checkbox d-inline-block mr-3">
                <input type="checkbox" class="custom-control-input" id="show_on_frontend" name="show_on_frontend" value="1" {{ old('show_on_frontend', $package->show_on_frontend ?? true) ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_on_frontend">Show on Frontend</label>
            </div>
            <div class="custom-control custom-checkbox d-inline-block">
                <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" {{ old('status', $package->status ?? true) ? 'checked' : '' }}>
                <label class="custom-control-label" for="status">Active</label>
            </div>
        </div>
    </div>
</div>
