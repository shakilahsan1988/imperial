@extends('layouts.app')
@section('title', 'Bookings')

@section('header')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">Bookings</h3>
        <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Booking
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <select id="statusFilter" class="form-control">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="sample_collected">Sample Collected</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="bookingTypeFilter" class="form-control">
                                <option value="">All Types</option>
                                <option value="branch_visit">Branch Visit</option>
                                <option value="home_visit">Home Visit</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" id="dateFrom" class="form-control" placeholder="Date From">
                        </div>
                        <div class="col-md-2">
                            <input type="date" id="dateTo" class="form-control" placeholder="Date To">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="bookingsTable" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Patient</th>
                                    <th>Service</th>
                                    <th>Type</th>
                                    <th>Schedule</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            var table = $('#bookingsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.bookings.index') }}",
                    data: function(d) {
                        d.status = $('#statusFilter').val();
                        d.booking_type = $('#bookingTypeFilter').val();
                        d.date_from = $('#dateFrom').val();
                        d.date_to = $('#dateTo').val();
                    }
                },
                columns: [
                    { data: 'booking_id', name: 'id' },
                    { data: 'patient_name', name: 'patient_name' },
                    { data: 'service', name: 'service.name' },
                    { data: 'booking_type', name: 'booking_type' },
                    { data: 'schedule', name: 'scheduled_date' },
                    { data: 'total', name: 'total_amount' },
                    { data: 'status', name: 'status' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
            });

            $('#statusFilter, #bookingTypeFilter, #dateFrom, #dateTo').change(function() {
                table.draw();
            });
        });
    </script>
@endpush
