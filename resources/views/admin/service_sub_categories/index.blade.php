@extends('layouts.app')
@section('title', __('admin.service_sub_category'))

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-end mb-2">
            <div class="d-flex align-items-center">
                @php
                    $u = auth()->guard('admin')->user();
                    $isSuper = ($u && $u->id == 1);
                @endphp
                
                @if($u && ($isSuper || $u->hasPermission('create_service_sub_category')))
                <a href="{{ route('admin.service_sub_categories.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus mr-1"></i> {{ __('admin.create') }} {{ __('admin.service_sub_category') }}
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
                        <label class="text-xs text-uppercase text-muted font-weight-bold mb-1">{{ __('admin.filter') }} {{ __('admin.service_category') }}</label>
                        <select id="categoryFilter" class="form-control form-control-sm select2">
                            <option value="">{{ __('admin.all') }} {{ __('admin.service_category') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
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
                        <i class="fas fa-table mr-2 text-primary"></i>{{ __('admin.service_sub_category') }} {{ __('admin.actions') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="subCategoriesTable" class="table table-hover align-middle" width="100%">
                            <thead class="bg-light">
                                <tr>
                                    <th width="50" class="border-0 px-4 py-3"><input type="checkbox" id="selectAll"></th>
                                    <th class="border-0 text-xs text-uppercase text-muted py-3">{{ __('admin.name') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted py-3">{{ __('admin.service_category') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted py-3">{{ __('admin.services') }}</th>
                                    <th class="border-0 text-xs text-uppercase text-muted py-3">{{ __('admin.status') }}</th>
                                    <th width="150" class="border-0 text-xs text-uppercase text-muted text-center py-3">{{ __('admin.actions') }}</th>
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
            $('#service_sub_categories').addClass('active');
            $('#service_management_link').addClass('active');
            $('#service_management').addClass('menu-open');

            var table = $('#subCategoriesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.service_sub_categories.index') }}",
                    data: function(d) {
                        d.category_id = $('#categoryFilter').val();
                    }
                },
                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false, class: 'px-4' },
                    { data: 'name', name: 'name' },
                    { data: 'category', name: 'category.name' },
                    { data: 'services_count', name: 'services_count', searchable: false },
                    { data: 'status', name: 'status' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, class: 'text-center' }
                ]
            });

            $('#categoryFilter').change(function() {
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
