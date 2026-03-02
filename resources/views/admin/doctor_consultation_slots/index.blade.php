@extends('layouts.app')
@section('title', 'Consultation Time Slots')

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('admin.doctor_consultation_slots.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i> Create Slot
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
                    <th>Label</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Status</th>
                    <th>Sort</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($slots as $slot)
                <tr>
                    <td>{{ $slot->label }}</td>
                    <td>{{ $slot->start_time }}</td>
                    <td>{{ $slot->end_time }}</td>
                    <td>{!! $slot->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</td>
                    <td>{{ $slot->sort_order }}</td>
                    <td class="text-right">
                        <a href="{{ route('admin.doctor_consultation_slots.edit', $slot->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form method="POST" action="{{ route('admin.doctor_consultation_slots.destroy', $slot->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this slot?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">No consultation slots found.</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $slots->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#doctor_consultation_slots').addClass('active');
$('#manage_doctors_link').addClass('active');
$('#manage_doctors').addClass('menu-open');
</script>
@endpush
