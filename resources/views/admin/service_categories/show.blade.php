@extends('layouts.app')
@section('title', __('admin.service_category'))

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-end mb-2">
            <div>
                <a href="{{ route('admin.service_categories.index') }}" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left mr-1"></i> {{ __('admin.back') }}
                </a>
                <a href="{{ route('admin.service_categories.edit', $service_category->id) }}" class="btn btn-primary shadow-sm ml-2">
                    <i class="fas fa-edit mr-1"></i> {{ __('admin.edit') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        {{-- Category Info Card --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title font-weight-bold mb-0 text-primary">
                        <i class="fas fa-info-circle mr-2"></i>Category Details
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="p-4 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary-soft rounded-lg d-flex align-items-center justify-content-center mr-3" style="width: 45px; height: 45px;">
                                <i class="fas fa-tag text-primary"></i>
                            </div>
                            <div>
                                <small class="text-xs text-uppercase text-muted font-weight-bold d-block mb-1">{{ __('Category Name') }}</small>
                                <h6 class="font-weight-bold text-dark mb-0">{{ $service_category->name }}</h6>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 border-bottom bg-slate-50">
                        <div class="d-flex align-items-center">
                            <div class="bg-info-soft rounded-lg d-flex align-items-center justify-content-center mr-3" style="width: 45px; height: 45px;">
                                <i class="fas fa-microscope text-info"></i>
                            </div>
                            <div>
                                <small class="text-xs text-uppercase text-muted font-weight-bold d-block mb-1">{{ __('Test Type') }}</small>
                                <span class="badge bg-white border text-primary px-3 py-1 shadow-sm">{{ ucfirst($service_category->type) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-success-soft rounded-lg d-flex align-items-center justify-content-center mr-3" style="width: 45px; height: 45px;">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                            <div>
                                <small class="text-xs text-uppercase text-muted font-weight-bold d-block mb-1">{{ __('Current Status') }}</small>
                                @if($service_category->status)
                                    <span class="badge bg-success text-white px-3 py-1">Active</span>
                                @else
                                    <span class="badge bg-danger text-white px-3 py-1">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Associated Content --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white p-0">
                    <ul class="nav nav-tabs border-0" id="categoryTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active px-4 py-3" id="subcats-tab" data-toggle="tab" href="#subcats" role="tab">
                                <i class="fas fa-sitemap mr-2"></i>Sub Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-4 py-3" id="tests-tab" data-toggle="tab" href="#tests" role="tab">
                                <i class="fas fa-flask mr-2"></i>Tests List
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="categoryTabContent">
                        {{-- Sub Categories Tab --}}
                        <div class="tab-pane fade show active" id="subcats" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0 text-xs text-uppercase text-muted">Sub Category Name</th>
                                            <th class="border-0 text-xs text-uppercase text-muted text-center">Tests</th>
                                            <th class="border-0 text-xs text-uppercase text-muted text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($service_category->subCategories as $sub)
                                        <tr>
                                            <td class="font-weight-600">{{ $sub->name }}</td>
                                            <td class="text-center">{{ $sub->services_count }}</td>
                                            <td class="text-center">
                                                @if($sub->status)
                                                    <span class="text-success"><i class="fas fa-check-circle"></i></span>
                                                @else
                                                    <span class="text-danger"><i class="fas fa-times-circle"></i></span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted small italic">No sub-categories found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Tests Tab --}}
                        <div class="tab-pane fade" id="tests" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0 text-xs text-uppercase text-muted">Test Name</th>
                                            <th class="border-0 text-xs text-uppercase text-muted">Sub Category</th>
                                            <th class="border-0 text-xs text-uppercase text-muted text-right">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($service_category->services as $test)
                                        <tr>
                                            <td class="font-weight-600">{{ $test->name }}</td>
                                            <td><small class="text-muted">{{ $test->subCategory->name ?? '-' }}</small></td>
                                            <td class="text-right font-weight-bold text-dark">{{ get_currency() }} {{ number_format($test->price, 2) }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted small italic">No tests found in this category.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<style>
    .bg-primary-soft { background-color: rgba(0, 124, 170, 0.1); }
    .bg-info-soft { background-color: rgba(14, 165, 233, 0.1); }
    .bg-success-soft { background-color: rgba(16, 185, 129, 0.1); }
    .bg-danger-soft { background-color: rgba(239, 68, 68, 0.1); }
    .rounded-lg { border-radius: 12px !important; }
    .text-xs { font-size: 0.75rem; }
    .font-weight-600 { font-weight: 600; }
</style>
@endpush
