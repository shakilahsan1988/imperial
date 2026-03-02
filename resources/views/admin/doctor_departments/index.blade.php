@extends('layouts.app')
@section('title', 'Doctor Departments')

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('admin.doctor_departments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i> Create Department
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
            @forelse($departments as $department)
                <tr>
                    <td>
                        <strong>{{ $department->name }}</strong>
                        <div class="small text-muted">{{ $department->description }}</div>
                    </td>
                    <td>{!! $department->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</td>
                    <td>{{ $department->sort_order }}</td>
                    <td class="text-right">
                        <a href="{{ route('admin.doctor_departments.edit', $department->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form method="POST" action="{{ route('admin.doctor_departments.destroy', $department->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this department?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">No departments found.</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $departments->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#doctor_departments').addClass('active');
$('#manage_doctors_link').addClass('active');
$('#manage_doctors').addClass('menu-open');
</script>
@endpush
