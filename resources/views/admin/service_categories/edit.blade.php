@extends('layouts.app')
@section('title', 'Edit Service Category')

@section('header')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">Edit Category</h3>
        <a href="{{ route('admin.service_categories.index') }}" class="btn btn-secondary">
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
                        <i class="fas fa-edit mr-2"></i>Category Information
                    </h3>
                </div>
                <form action="{{ route('admin.service_categories.update', $service_category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category Name *</label>
                                    <input type="text" name="name" class="form-control" value="{{ $service_category->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type *</label>
                                    <select name="type" class="form-control" required>
                                        <option value="">Select Type</option>
                                        <option value="laboratory" {{ $service_category->type == 'laboratory' ? 'selected' : '' }}>Laboratory</option>
                                        <option value="imaging" {{ $service_category->type == 'imaging' ? 'selected' : '' }}>Imaging</option>
                                        <option value="procedure" {{ $service_category->type == 'procedure' ? 'selected' : '' }}>Procedure</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ $service_category->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Icon (Font Awesome class)</label>
                            <input type="text" name="icon" class="form-control" value="{{ $service_category->icon }}" placeholder="e.g., fa-flask">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" {{ $service_category->status ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status">Active</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sort Order</label>
                                    <input type="number" name="sort_order" class="form-control" value="{{ $service_category->sort_order }}" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Update Category
                        </button>
                        <a href="{{ route('admin.service_categories.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
