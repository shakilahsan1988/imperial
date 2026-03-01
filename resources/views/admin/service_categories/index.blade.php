@extends('layouts.app')
@section('title', 'Service Categories')

@section('header')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">Service Categories</h3>
        <a href="{{ route('admin.service_categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Category
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="categoriesTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="50"><input type="checkbox" id="selectAll"></th>
                                    <th>Category Name</th>
                                    <th>Type</th>
                                    <th>Services</th>
                                    <th>Sub Categories</th>
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
            var table = $('#categoriesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.service_categories.index') }}",
                },
                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'type', name: 'type' },
                    { data: 'services_count', name: 'services_count', searchable: false },
                    { data: 'sub_categories_count', name: 'sub_categories_count', searchable: false },
                    { data: 'status', name: 'status' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
            });

            $('#selectAll').change(function() {
                $('.delete-checkbox').prop('checked', $(this).prop('checked'));
            });
        });
    </script>
@endpush
