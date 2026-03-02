@extends('layouts.app')
@section('title', 'Consultation Bookings')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h3 class="card-title font-weight-bold mb-0">
            <i class="fas fa-calendar-check mr-2 text-primary"></i> Consultation Bookings
        </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>Date</th>
                        <th>Doctor</th>
                        <th>Patient</th>
                        <th>Visit</th>
                        <th>Slot</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td>{{ optional($booking->appointment_date)->format('Y-m-d') }}</td>
                        <td>
                            {{ $booking->doctor->name ?? '-' }}
                            <div class="small text-muted">{{ optional($booking->doctor->department)->name }}</div>
                        </td>
                        <td>
                            {{ $booking->patient_name }}
                            <div class="small text-muted">{{ $booking->email }}</div>
                        </td>
                        <td>
                            {{ $booking->visit_type === 'in_hub' ? 'In-Hub Visit' : 'Video Consult' }}
                            @if($booking->branch)
                              <div class="small text-muted">{{ $booking->branch->name }}</div>
                            @endif
                        </td>
                        <td>{{ optional($booking->slot)->label }}</td>
                        <td>
                            <form action="{{ route('admin.doctor_consultation_bookings.update', $booking->id) }}" method="POST" class="form-inline">
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
                            <a href="{{ route('admin.doctor_consultation_bookings.show', $booking->id) }}" class="btn btn-sm btn-info">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">No consultation bookings found.</td></tr>
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
$('#doctor_consultation_bookings').addClass('active');
$('#manage_doctors_link').addClass('active');
$('#manage_doctors').addClass('menu-open');
</script>
@endpush
