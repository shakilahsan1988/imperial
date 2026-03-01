@extends('layouts.app')
@section('title', __('admin.services'))

@section('header')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">{{ __('admin.services') }}</h3>
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> {{ __('admin.create_service') }}
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-md-4">
                            <select id="categoryFilter" class="form-control">
                                <option value="">{{ __('admin.all') }} {{ __('admin.service_category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select id="subCategoryFilter" class="form-control" disabled>
                                <option value="">{{ __('admin.all') }} {{ __('admin.service_sub_category') }}</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end">
                            <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('admin.create_service') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="servicesTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="30"><input type="checkbox" id="selectAll"></th>
                                    <th>{{ __('admin.service_name') }}</th>
                                    <th>{{ __('admin.service_category') }}</th>
                                    <th>{{ __('admin.service_sub_category') }}</th>
                                    <th>{{ __('admin.price') }}</th>
                                    <th>{{ __('admin.home_visit') }}</th>
                                    <th>{{ __('admin.status') }}</th>
                                    <th width="100">{{ __('admin.actions') }}</th>
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
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                    { data: 'name', name: 'name', searchable: true },
                    { data: 'category', name: 'serviceCategory.name', searchable: true },
                    { data: 'sub_category', name: 'subCategory.name', searchable: true },
                    { data: 'price', name: 'price', searchable: false },
                    { data: 'home_visit', name: 'home_visit_available', searchable: false },
                    { data: 'status', name: 'status', searchable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
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
@endpush
