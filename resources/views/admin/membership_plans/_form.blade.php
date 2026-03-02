<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Page Name *</label>
            <input type="text" name="page_name" class="form-control" value="{{ old('page_name', $plan->page_name ?? 'Membership Details') }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Membership Category *</label>
            <select name="membership_category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('membership_category_id', $plan->membership_category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Plan Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $plan->name ?? '') }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Subtitle</label>
            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $plan->subtitle ?? '') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Badge Text</label>
            <input type="text" name="badge_text" class="form-control" value="{{ old('badge_text', $plan->badge_text ?? '') }}">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Price *</label>
            <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price', $plan->price ?? 0) }}" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Old Price</label>
            <input type="number" step="0.01" min="0" name="old_price" class="form-control" value="{{ old('old_price', $plan->old_price ?? '') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Discount Label</label>
            <input type="text" name="discount_text" class="form-control" value="{{ old('discount_text', $plan->discount_text ?? '') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Duration</label>
            <input type="text" name="duration" class="form-control" value="{{ old('duration', $plan->duration ?? '') }}" placeholder="e.g., 12 Months">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Doctor Visits</label>
            <input type="text" name="doctor_visits" class="form-control" value="{{ old('doctor_visits', $plan->doctor_visits ?? '') }}" placeholder="e.g., Unlimited">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Service Discount</label>
            <input type="text" name="service_discount" class="form-control" value="{{ old('service_discount', $plan->service_discount ?? '') }}" placeholder="e.g., 15% Off">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Image</label>
            <input type="hidden" name="existing_image" value="{{ old('existing_image', $plan->image ?? '') }}">
            <input type="file" name="image" class="form-control-file" accept="image/*">
            @if(!empty($plan->image))
                <img src="{{ asset($plan->image) }}" class="img-thumbnail mt-2" style="max-height:90px;">
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $plan->description ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Key Features (one line per item)</label>
            <textarea name="key_features" class="form-control" rows="7">{{ old('key_features', $plan->key_features ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Inclusions (one line per item)</label>
            <textarea name="inclusions" class="form-control" rows="7">{{ old('inclusions', $plan->inclusions ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Exclusions (one line per item)</label>
            <textarea name="exclusions" class="form-control" rows="7">{{ old('exclusions', $plan->exclusions ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Important Notes (one line per item)</label>
            <textarea name="important_notes" class="form-control" rows="7">{{ old('important_notes', $plan->important_notes ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>FAQ 1 Question</label>
            <input type="text" name="faq_1_question" class="form-control" value="{{ old('faq_1_question', $plan->faq_1_question ?? '') }}">
        </div>
        <div class="form-group">
            <label>FAQ 1 Answer</label>
            <textarea name="faq_1_answer" class="form-control" rows="3">{{ old('faq_1_answer', $plan->faq_1_answer ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>FAQ 2 Question</label>
            <input type="text" name="faq_2_question" class="form-control" value="{{ old('faq_2_question', $plan->faq_2_question ?? '') }}">
        </div>
        <div class="form-group">
            <label>FAQ 2 Answer</label>
            <textarea name="faq_2_answer" class="form-control" rows="3">{{ old('faq_2_answer', $plan->faq_2_answer ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>FAQ 3 Question</label>
            <input type="text" name="faq_3_question" class="form-control" value="{{ old('faq_3_question', $plan->faq_3_question ?? '') }}">
        </div>
        <div class="form-group">
            <label>FAQ 3 Answer</label>
            <textarea name="faq_3_answer" class="form-control" rows="3">{{ old('faq_3_answer', $plan->faq_3_answer ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $plan->sort_order ?? 0) }}">
        </div>
    </div>
    <div class="col-md-9">
        <div class="form-group mt-4">
            <div class="custom-control custom-checkbox d-inline-block mr-3">
                <input type="checkbox" class="custom-control-input" id="show_on_frontend" name="show_on_frontend" value="1" {{ old('show_on_frontend', $plan->show_on_frontend ?? true) ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_on_frontend">Show on Frontend</label>
            </div>
            <div class="custom-control custom-checkbox d-inline-block">
                <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" {{ old('status', $plan->status ?? true) ? 'checked' : '' }}>
                <label class="custom-control-label" for="status">Active</label>
            </div>
        </div>
    </div>
</div>
