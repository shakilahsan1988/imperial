@extends('layouts.app')
@section('title', 'Membership Categories')

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('admin.membership_categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i> Create Category
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
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
                        <div class="small text-muted">{{ $category->description }}</div>
                    </td>
                    <td>{!! $category->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</td>
                    <td>{{ $category->sort_order }}</td>
                    <td class="text-right">
                        <a href="{{ route('admin.membership_categories.edit', $category->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form method="POST" action="{{ route('admin.membership_categories.destroy', $category->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">No membership categories found.</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $categories->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#membership_categories').addClass('active');
$('#membership_module_link').addClass('active');
$('#membership_module').addClass('menu-open');
</script>
@endpush
