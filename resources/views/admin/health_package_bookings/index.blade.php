@extends('layouts.app')
@section('title', 'Package Bookings')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h3 class="card-title font-weight-bold mb-0">
            <i class="fas fa-calendar-check mr-2 text-primary"></i> Package Bookings
        </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>Date</th>
                        <th>Package</th>
                        <th>Patient</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td>{{ optional($booking->created_at)->format('Y-m-d H:i') }}</td>
                        <td>{{ $booking->package->name ?? '-' }}</td>
                        <td>{{ $booking->patient_name }}</td>
                        <td>{{ $booking->phone }}</td>
                        <td>
                            <form action="{{ route('admin.health_package_bookings.update', $booking->id) }}" method="POST" class="form-inline">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-control form-control-sm mr-2">
                                    @foreach(['pending','confirmed','completed','cancelled'] as $status)
                                        <option value="{{ $status }}" {{ $booking->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.health_package_bookings.show', $booking->id) }}" class="btn btn-sm btn-info">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">No bookings found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $bookings->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#health_package_bookings').addClass('active');
    $('#helth_check_link').addClass('active');
    $('#helth_check').addClass('menu-open');
</script>
@endpush
