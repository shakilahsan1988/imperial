@extends('layouts.app')
@section('title', 'Edit Service')

@section('header')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">Edit Service</h3>
        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit mr-2"></i>Service Information
                    </h3>
                </div>
                <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        {{-- Section 1: Basic Info --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                                <i class="fas fa-info-circle mr-1"></i> Basic Information
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Service Name *</label>
                                        <input type="text" name="name" class="form-control" value="{{ $service->name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Short Name</label>
                                        <input type="text" name="short_name" class="form-control" value="{{ $service->short_name }}" placeholder="e.g., CBC">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category *</label>
                                        <select name="service_category_id" class="form-control" id="categorySelect" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $service->service_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sub Category</label>
                                        <select name="service_sub_category_id" class="form-control" id="subCategorySelect" {{ !$service->service_category_id ? 'disabled' : '' }}>
                                            <option value="">Select Sub Category</option>
                                            @if($service->service_category_id)
                                                @foreach($subCategories->where('service_category_id', $service->service_category_id) as $subCategory)
                                                    <option value="{{ $subCategory->id }}" {{ $service->service_sub_category_id == $subCategory->id ? 'selected' : '' }}>{{ $subCategory->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Details --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                                <i class="fas fa-list-alt mr-1"></i> Details
                            </h6>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ $service->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Preparation Instructions</label>
                                <textarea name="preparation" class="form-control" rows="2" placeholder="e.g., Fasting 8-12 hours required">{{ $service->preparation }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Specimen Type</label>
                                <input type="text" name="specimen_type" class="form-control" value="{{ $service->specimen_type }}" placeholder="e.g., Blood, Urine, Stool">
                            </div>
                        </div>

                        {{-- Section 3: Reference Values (Report Entry) --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                                <i class="fas fa-file-medical mr-1"></i> Reference Values (For Reports)
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Unit</label>
                                        <input type="text" name="unit" class="form-control" value="{{ $service->unit }}" placeholder="e.g., mg/dL, g/L, %">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Normal Reference Range</label>
                                        <input type="text" name="reference_range" class="form-control" value="{{ $service->reference_range }}" placeholder="e.g., 70 - 110, Negative, < 5.0">
                                        <small class="form-text text-muted">This will be displayed on the report result entry page.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 4: Service Components (For Profiles/Panels) --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-uppercase text-muted font-weight-bold mb-0" style="font-size: 0.75rem; letter-spacing: 1px;">
                                    <i class="fas fa-layer-group mr-1"></i> Service Components (For Profiles/Panels)
                                </h6>
                                <button type="button" id="addComponent" class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="fas fa-plus mr-1"></i> Add Parameter
                                </button>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="componentsTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Parameter Name</th>
                                            <th width="150">Unit</th>
                                            <th width="250">Reference Range</th>
                                            <th width="50"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="componentsBody">
                                        @foreach($service->components as $index => $component)
                                        <tr>
                                            <td>
                                                <input type="hidden" name="components[{{$index}}][id]" value="{{$component->id}}">
                                                <input type="text" name="components[{{$index}}][name]" class="form-control form-control-sm" value="{{$component->name}}" placeholder="e.g. S. Cholesterol" required>
                                            </td>
                                            <td>
                                                <input type="text" name="components[{{$index}}][unit]" class="form-control form-control-sm" value="{{$component->unit}}" placeholder="mg/dL">
                                            </td>
                                            <td>
                                                <input type="text" name="components[{{$index}}][reference_range]" class="form-control form-control-sm" value="{{$component->reference_range}}" placeholder="120-200">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-link text-danger remove-component p-0"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <small class="form-text text-muted">Leave this empty if the service is a single test. Add rows for profiles (like Lipid Profile, CBC, etc).</small>
                        </div>

                        {{-- Section 5: Pricing & Timing --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                                <i class="fas fa-dollar-sign mr-1"></i> Pricing & Timing
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Price (Branch Visit) *</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{{ get_currency() }}</span>
                                            </div>
                                            <input type="number" name="price" class="form-control" step="0.01" min="0" value="{{ $service->price }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Duration (Minutes)</label>
                                        <div class="input-group">
                                            <input type="number" name="duration_minutes" class="form-control" value="{{ $service->duration_minutes }}" min="1">
                                            <div class="input-group-append">
                                                <span class="input-group-text">min</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 4: Home Visit Options --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                                <i class="fas fa-home mr-1"></i> Home Visit Options
                            </h6>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="homeVisitAvailable" name="home_visit_available" {{ $service->home_visit_available ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="homeVisitAvailable">Available for Home Visit</label>
                                </div>
                            </div>
                            <div class="form-group" id="homeVisitPriceField" style="{{ $service->home_visit_available ? '' : 'display: none;' }}">
                                <label>Home Visit Additional Price</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ get_currency() }}</span>
                                    </div>
                                    <input type="number" name="home_visit_price" class="form-control" step="0.01" min="0" value="{{ $service->home_visit_price }}" placeholder="Extra fee for home visit">
                                </div>
                            </div>
                        </div>

                        {{-- Section 5: Settings --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                                <i class="fas fa-cog mr-1"></i> Settings
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="showOnFrontend" name="show_on_frontend" {{ $service->show_on_frontend ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="showOnFrontend">Show on Frontend</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" {{ $service->status ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="status">Active</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Sort Order</label>
                                        <input type="number" name="sort_order" class="form-control" value="{{ $service->sort_order }}" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Update Service
                        </button>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#homeVisitAvailable').change(function() {
            if ($(this).is(':checked')) {
                $('#homeVisitPriceField').slideDown();
            } else {
                $('#homeVisitPriceField').slideUp();
            }
        });

        // Sub-category dynamic loading
        var subCategories = @json($subCategories);
        
        $('#categorySelect').change(function() {
            var categoryId = $(this).val();
            var $subCategorySelect = $('#subCategorySelect');
            
            $subCategorySelect.empty().append('<option value="">Select Sub Category</option>');
            
            if (categoryId) {
                var filteredSubCats = subCategories.filter(function(sc) {
                    return sc.service_category_id == categoryId;
                });
                
                filteredSubCats.forEach(function(sc) {
                    $subCategorySelect.append('<option value="' + sc.id + '">' + sc.name + '</option>');
                });
                
                $subCategorySelect.prop('disabled', false);
            } else {
                $subCategorySelect.prop('disabled', true);
            }
        });

        // Component Management
        let componentIndex = {{ count($service->components) }};
        
        $('#addComponent').click(function() {
            let html = `
                <tr>
                    <td>
                        <input type="text" name="components[${componentIndex}][name]" class="form-control form-control-sm" placeholder="e.g. Parameter name" required>
                    </td>
                    <td>
                        <input type="text" name="components[${componentIndex}][unit]" class="form-control form-control-sm" placeholder="Unit">
                    </td>
                    <td>
                        <input type="text" name="components[${componentIndex}][reference_range]" class="form-control form-control-sm" placeholder="Reference Range">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-link text-danger remove-component p-0"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
            $('#componentsBody').append(html);
            componentIndex++;
        });

        $(document).on('click', '.remove-component', function() {
            $(this).closest('tr').remove();
        });
    </script>
@endpush
