@extends('layouts.app')
@section('title', 'Package Categories')

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-end mb-2">
            <a href="{{ route('admin.health_package_categories.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus mr-1"></i> Create Category
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h3 class="card-title font-weight-bold mb-0">
            <i class="fas fa-layer-group mr-2 text-primary"></i> Package Categories
        </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Sort</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>
                            <strong>{{ $category->name }}</strong>
                            @if($category->description)
                                <div class="text-muted small">{{ $category->description }}</div>
                            @endif
                        </td>
                        <td>{!! $category->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</td>
                        <td>{{ $category->sort_order }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.health_package_categories.edit', $category->id) }}" class="btn btn-sm btn-info">Edit</a>
                            <form action="{{ route('admin.health_package_categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted">No categories found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $categories->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#health_package_categories').addClass('active');
    $('#helth_check_link').addClass('active');
    $('#helth_check').addClass('menu-open');
</script>
@endpush
