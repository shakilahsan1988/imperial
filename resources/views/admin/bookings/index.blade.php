@extends('layouts.app')
@section('title', 'Bookings')

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-end mb-2">
            <div class="d-flex align-items-center">
                @php
                    $u = auth()->guard('admin')->user();
                    $isSuper = ($u && $u->id == 1);
                @endphp
                
                @if($u && ($isSuper || $u->hasPermission('create_booking')))
                <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus mr-1"></i> {{ __('Create Booking') }}
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
    {{-- Filter Section --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <div class="col-md-1 text-center border-right">
                    <i class="fas fa-filter text-muted fa-lg"></i>
                </div>
                <div class="col-md-2">
                    <select id="statusFilter" class="form-control form-control-sm select2">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="sample_collected">Sample Collected</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="bookingTypeFilter" class="form-control form-control-sm select2">
                        <option value="">All Types</option>
                        <option value="branch_visit">Branch Visit</option>
                        <option value="home_visit">Home Visit</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="input-group input-group-sm">
                        <input type="date" id="dateFrom" class="form-control" placeholder="From">
                        <div class="input-group-append">
                            <span class="input-group-text">to</span>
                        </div>
                        <input type="date" id="dateTo" class="form-control" placeholder="To">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h3 class="card-title font-weight-bold mb-0">
                        <i class="fas fa-table mr-2 text-primary"></i>{{ __('Bookings Table') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="bookingsTable" class="table table-hover align-middle" width="100%">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 text-xs text-uppercase text-muted">ID</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">Patient</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">Service</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">Type</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">Schedule</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">Total</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">Status</th>
                                    <th class="border-0 text-xs text-uppercase text-muted">Report</th>
                                    <th width="100" class="border-0 text-xs text-uppercase text-muted text-center">Actions</th>
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
                    { data: 'service', name: 'service', orderable: false },
                    { data: 'booking_type', name: 'booking_type' },
                    { data: 'schedule', name: 'scheduled_date' },
                    { data: 'total', name: 'total_amount' },
                    { data: 'status', name: 'status' },
                    { data: 'report', name: 'report', orderable: false, searchable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, class: 'text-center' }
                ]
            });

            $('#statusFilter, #bookingTypeFilter, #dateFrom, #dateTo').change(function() {
                table.draw();
            });
        });
    </script>
    <style>
        .text-xs { font-size: 0.75rem; }
        .table td { vertical-align: middle; }
    </style>
@endpush
