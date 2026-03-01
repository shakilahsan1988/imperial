@extends('layouts.app')
@section('title', 'Service Sub Categories')

@section('header')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">Service Sub Categories</h3>
        <a href="{{ route('admin.service_sub_categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Sub Category
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-md-6">
                            <select id="categoryFilter" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="subCategoriesTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="50"><input type="checkbox" id="selectAll"></th>
                                    <th>Sub Category Name</th>
                                    <th>Category</th>
                                    <th>Services</th>
                                    <th>Status</th>
                                    <th width="150">Actions</th>
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
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'category', name: 'category.name' },
                    { data: 'services_count', name: 'services_count', searchable: false },
                    { data: 'status', name: 'status' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
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
@endpush
