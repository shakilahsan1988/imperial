@extends('layouts.app')
@section('title', 'Membership Plans')

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-end mb-2">
            <a href="{{ route('admin.membership_plans.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus mr-1"></i> Create Plan
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h3 class="card-title font-weight-bold mb-0">
            <i class="fas fa-id-card mr-2 text-primary"></i> Membership Plans
        </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>Plan</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Frontend</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($plans as $plan)
                    <tr>
                        <td>
                            <strong>{{ $plan->name }}</strong>
                            <div class="small text-muted">Page Name: {{ $plan->page_name }}</div>
                        </td>
                        <td>{{ $plan->category->name ?? '-' }}</td>
                        <td>{{ formated_price($plan->price) }}</td>
                        <td>{!! $plan->show_on_frontend ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>' !!}</td>
                        <td>{!! $plan->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.membership_plans.edit', $plan->id) }}" class="btn btn-sm btn-info">Edit</a>
                            <form action="{{ route('admin.membership_plans.destroy', $plan->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this plan?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">No membership plans found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $plans->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#membership_plans').addClass('active');
$('#membership_module_link').addClass('active');
$('#membership_module').addClass('menu-open');
</script>
@endpush
