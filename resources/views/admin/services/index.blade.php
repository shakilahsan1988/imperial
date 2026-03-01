@extends('layouts.app')
@section('title', __('admin.services'))

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-end mb-2">
            <div class="d-flex align-items-center">
                @php
                    $u = auth()->guard('admin')->user();
                    $isSuper = ($u && $u->id == 1);
                @endphp
                
                @if($u && ($isSuper || $u->hasPermission('create_service')))
                <a href="{{ route('admin.services.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus mr-1"></i> {{ __('admin.create_service') }}
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
    {{-- Filter Section --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <div class="col-md-1 text-center border-right">
                    <i class="fas fa-filter text-muted fa-lg"></i>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label class="text-xs text-uppercase text-muted font-weight-bold mb-1">{{ __('Filter by Category') }}</label>
                        <select id="categoryFilter" class="form-control form-control-sm select2">
                            <option value="">{{ __('All Categories') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label class="text-xs text-uppercase text-muted font-weight-bold mb-1">{{ __('Filter by Sub Category') }}</label>
                        <select id="subCategoryFilter" class="form-control form-control-sm select2" disabled>
                            <option value="">{{ __('All Sub Categories') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h3 class="card-title font-weight-bold mb-0">
                        <i class="fas fa-table mr-2 text-primary"></i>{{ __('admin.test_list') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="servicesTable" class="table table-hover align-middle" width="100%">
                            <thead class="bg-light">
                                <tr>
                                    <th width="30" class="border-0 px-4 py-3"><input type="checkbox" id="selectAll"></th>
                                    <th class="border-0 text-xs text-uppercase text-muted py-3">{{ __('admin.test_name') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted py-3">{{ __('admin.service_category') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted py-3">{{ __('admin.service_sub_category') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted py-3">{{ __('admin.price') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted py-3">{{ __('admin.home_visit') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted py-3">{{ __('admin.status') }}</th>
                                    <th width="100" class="border-0 text-xs text-uppercase text-muted text-center py-3">{{ __('admin.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            // Sidebar Active Logic
            $('#services').addClass('active');
            $('#service_management_link').addClass('active');
            $('#service_management').addClass('menu-open');

            var table = $('#servicesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.services.index') }}",
                    data: function(d) {
                        d.service_category_id = $('#categoryFilter').val();
                        d.service_sub_category_id = $('#subCategoryFilter').val();
                    }
                },
                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false, class: 'px-4' },
                    { data: 'name', name: 'name', searchable: true },
                    { data: 'category', name: 'serviceCategory.name', searchable: true },
                    { data: 'sub_category', name: 'subCategory.name', searchable: true },
                    { data: 'price', name: 'price', searchable: false },
                    { data: 'home_visit', name: 'home_visit_available', searchable: false },
                    { data: 'status', name: 'status', searchable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, class: 'text-center' }
                ]
            });

            $('#categoryFilter').change(function() {
                var categoryId = $(this).val();
                var $subCategoryFilter = $('#subCategoryFilter');
                
                $subCategoryFilter.empty().append('<option value="">All Sub Categories</option>');
                
                if (categoryId) {
                    $.ajax({
                        url: "{{ route('admin.service_sub_categories.ajax') }}",
                        data: { category_id: categoryId },
                        success: function(data) {
                            data.forEach(function(sc) {
                                $subCategoryFilter.append('<option value="' + sc.id + '">' + sc.name + '</option>');
                            });
                            $subCategoryFilter.prop('disabled', false);
                        }
                    });
                } else {
                    $subCategoryFilter.prop('disabled', true);
                }
                table.draw();
            });

            $('#subCategoryFilter').change(function() {
                table.draw();
            });

            $('#selectAll').change(function() {
                $('.delete-checkbox').prop('checked', $(this).prop('checked'));
            });
        });
    </script>
    <style>
        .text-xs { font-size: 0.75rem; }
        .table td { vertical-align: middle; }
    </style>
@endpush
