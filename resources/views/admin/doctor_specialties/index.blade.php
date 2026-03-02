@extends('layouts.app')
@section('title', 'Doctor Specialties')

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('admin.doctor_specialties.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i> Create Specialty
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
            @forelse($specialties as $specialty)
                <tr>
                    <td>
                        <strong>{{ $specialty->name }}</strong>
                        <div class="small text-muted">{{ $specialty->description }}</div>
                    </td>
                    <td>{!! $specialty->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</td>
                    <td>{{ $specialty->sort_order }}</td>
                    <td class="text-right">
                        <a href="{{ route('admin.doctor_specialties.edit', $specialty->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form method="POST" action="{{ route('admin.doctor_specialties.destroy', $specialty->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this specialty?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">No specialties found.</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $specialties->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#doctor_specialties').addClass('active');
$('#manage_doctors_link').addClass('active');
$('#manage_doctors').addClass('menu-open');
</script>
@endpush
