@extends('layouts.app')
@section('title', 'Booking Details')

@section('header')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">Booking Details</h3>
        <div>
            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Booking #BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Patient Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $booking->patient_name }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $booking->patient_phone }}</td>
                                </tr>
                                @if($booking->patient_email)
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $booking->patient_email }}</td>
                                </tr>
                                @endif
                                @if($booking->patient_address)
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $booking->patient_address }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Service Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th>Service</th>
                                    <td>{{ $booking->service->name }}</td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td><span class="badge bg-primary">{{ ucfirst($booking->service->category) }}</span></td>
                                </tr>
                                <tr>
                                    <th>Booking Type</th>
                                    <td>
                                        @if($booking->booking_type == 'home_visit')
                                            <span class="badge bg-indigo">Home Visit</span>
                                        @else
                                            <span class="badge bg-success">Branch Visit</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Schedule</th>
                                    <td>
                                        {{ Carbon\Carbon::parse($booking->scheduled_date)->format('d M Y') }} 
                                        at {{ Carbon\Carbon::parse($booking->scheduled_time)->format('h:i A') }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Payment Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th>Total Amount</th>
                                    <td>{{ number_format($booking->total_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Type</th>
                                    <td>{{ $booking->payment_type == 'online' ? 'Online' : 'Pay at Branch' }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Status</th>
                                    <td>
                                        @if($booking->payment_status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($booking->payment_status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">{{ ucfirst($booking->payment_status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Status</h5>
                            <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label>Update Status</label>
                                    <select name="status" class="form-control">
                                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="sample_collected" {{ $booking->status == 'sample_collected' ? 'selected' : '' }}>Sample Collected</option>
                                        <option value="in_progress" {{ $booking->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="no_show" {{ $booking->status == 'no_show' ? 'selected' : '' }}>No Show</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Status</button>
                            </form>
                        </div>
                    </div>

                    @if($booking->booking_type == 'home_visit')
                    <hr>
                    <h5>Home Visit Assignment</h5>
                    <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Assign Technician</label>
                                    <select name="technician_id" class="form-control">
                                        <option value="">Select Technician</option>
                                        @foreach($technicians ?? [] as $tech)
                                            <option value="{{ $tech->id }}" {{ $booking->technician_id == $tech->id ? 'selected' : '' }}>
                                                {{ $tech->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary d-block">Assign Technician</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endif

                    @if($booking->notes || $booking->admin_notes)
                    <hr>
                    <h5>Notes</h5>
                    @if($booking->notes)
                    <p><strong>Patient Notes:</strong> {{ $booking->notes }}</p>
                    @endif
                    @if($booking->admin_notes)
                    <p><strong>Admin Notes:</strong> {{ $booking->admin_notes }}</p>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
