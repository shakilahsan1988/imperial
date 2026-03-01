@extends('layouts.app')
@section('title', 'Completed Results')

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-end mb-2">
            <div>
                {{-- Actions could go here if needed in future --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title font-weight-bold mb-0 text-primary">
                    <i class="fas fa-poll-h mr-2"></i>Results History
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="resultsTable" class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4 py-3 text-xs text-uppercase text-muted">Booking ID</th>
                                <th class="border-0 px-4 py-3 text-xs text-uppercase text-muted">Patient</th>
                                <th class="border-0 px-4 py-3 text-xs text-uppercase text-muted">Services</th>
                                <th class="border-0 px-4 py-3 text-xs text-uppercase text-muted">Completed At</th>
                                <th class="border-0 px-4 py-3 text-xs text-uppercase text-muted text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- DataTables content --}}
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
        $(document).ready(function() {
            var table = $('#resultsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.results.index') }}",
                columns: [
                    { data: 'booking_id', name: 'id', class: 'px-4 font-weight-bold text-dark' },
                    { data: 'patient_name', name: 'patient_name', class: 'px-4' },
                    { data: 'service', name: 'service', class: 'px-4', orderable: false },
                    { data: 'completed_at', name: 'updated_at', class: 'px-4' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, class: 'px-4 text-right' }
                ],
                order: [[3, 'desc']], // Order by completed_at
                language: {
                    paginate: {
                        next: '<i class="fas fa-chevron-right"></i>',
                        previous: '<i class="fas fa-chevron-left"></i>'
                    }
                }
            });
        });
    </script>
    <style>
        .text-xs { font-size: 0.75rem; }
        .font-weight-600 { font-weight: 600; }
        .table td { vertical-align: middle; }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.2rem 0.5rem;
            margin: 0 2px;
            border-radius: 4px;
        }
    </style>
@endpush
