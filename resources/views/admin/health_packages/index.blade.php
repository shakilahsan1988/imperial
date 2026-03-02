@extends('layouts.app')
@section('title', 'Health Packages')

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-end mb-2">
            <a href="{{ route('admin.health_packages.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus mr-1"></i> Create Package
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h3 class="card-title font-weight-bold mb-0">
            <i class="fas fa-notes-medical mr-2 text-primary"></i> Health Packages
        </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>Package</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Frontend</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($packages as $package)
                    <tr>
                        <td>
                            <strong>{{ $package->name }}</strong>
                            <div class="small text-muted">Page Name: {{ $package->page_name }}</div>
                        </td>
                        <td>{{ $package->category->name ?? '-' }}</td>
                        <td>{{ formated_price($package->price) }}</td>
                        <td>{!! $package->show_on_frontend ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>' !!}</td>
                        <td>{!! $package->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.health_packages.edit', $package->id) }}" class="btn btn-sm btn-info">Edit</a>
                            <form action="{{ route('admin.health_packages.destroy', $package->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this package?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">No packages found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $packages->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#health_packages').addClass('active');
    $('#health_check_link').addClass('active');
    $('#health_check').addClass('menu-open');
</script>
@endpush
