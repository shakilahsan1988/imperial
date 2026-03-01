@extends('layouts.app')
@section('title', 'Booking Details')

@section('header')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-0 text-dark font-weight-bold">Booking Details</h3>
            <p class="text-muted mb-0">Booking #BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>
        <div>
            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-edit mr-1"></i> Edit Booking
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary shadow-sm ml-2">
                <i class="fas fa-arrow-left mr-1"></i> Back to List
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        {{-- Left Column: Booking Info --}}
        <div class="col-lg-8">
            {{-- Patient & Service Cards Grid --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                            <h5 class="card-title font-weight-bold text-primary">
                                <i class="fas fa-user-circle mr-2"></i>Patient Info
                            </h5>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div class="mb-3">
                                <label class="text-xs text-uppercase text-muted mb-1 d-block">Full Name</label>
                                <p class="font-weight-600 mb-0 text-dark">{{ $booking->patient_name }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-xs text-uppercase text-muted mb-1 d-block">Phone Number</label>
                                <p class="mb-0 text-dark">{{ $booking->patient_phone }}</p>
                            </div>
                            @if($booking->patient_email)
                            <div class="mb-3">
                                <label class="text-xs text-uppercase text-muted mb-1 d-block">Email Address</label>
                                <p class="mb-0 text-dark">{{ $booking->patient_email }}</p>
                            </div>
                            @endif
                            @if($booking->patient_address)
                            <div class="mb-0">
                                <label class="text-xs text-uppercase text-muted mb-1 d-block">Address</label>
                                <p class="mb-0 text-dark">{{ $booking->patient_address }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                            <h5 class="card-title font-weight-bold text-primary">
                                <i class="fas fa-calendar-check mr-2"></i>Schedule Details
                            </h5>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div class="mb-3">
                                <label class="text-xs text-uppercase text-muted mb-1 d-block">Booking Type</label>
                                <div>
                                    @if($booking->booking_type == 'home_visit')
                                        <span class="badge bg-indigo-100 text-indigo-800 px-3 py-2 rounded-pill">
                                            <i class="fas fa-home mr-1"></i> Home Visit
                                        </span>
                                    @else
                                        <span class="badge bg-emerald-100 text-emerald-800 px-3 py-2 rounded-pill">
                                            <i class="fas fa-building mr-1"></i> Branch Visit
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if($booking->booking_type == 'branch_visit' && $booking->branch)
                            <div class="mb-3">
                                <label class="text-xs text-uppercase text-muted mb-1 d-block">Selected Branch</label>
                                <p class="font-weight-600 mb-0 text-dark">{{ $booking->branch->name }}</p>
                                <small class="text-muted">{{ $booking->branch->address }}</small>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-6">
                                    <label class="text-xs text-uppercase text-muted mb-1 d-block">Date</label>
                                    <p class="font-weight-600 mb-0 text-dark">{{ Carbon\Carbon::parse($booking->scheduled_date)->format('d M, Y') }}</p>
                                </div>
                                <div class="col-6">
                                    <label class="text-xs text-uppercase text-muted mb-1 d-block">Time</label>
                                    <p class="font-weight-600 mb-0 text-dark">{{ Carbon\Carbon::parse($booking->scheduled_time)->format('h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Services Table Card --}}
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h5 class="card-title font-weight-bold text-primary">
                        <i class="fas fa-microscope mr-2"></i>Selected Services
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-4 py-3 text-xs text-uppercase text-muted">Service Name</th>
                                    <th class="border-0 px-4 py-3 text-xs text-uppercase text-muted">Category</th>
                                    <th class="border-0 px-4 py-3 text-xs text-uppercase text-muted text-right">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking->services as $service)
                                <tr>
                                    <td class="px-4 py-3 font-weight-600 text-dark">{{ $service->name }}</td>
                                    <td class="px-4 py-3">
                                        <span class="badge badge-light border text-muted">{{ ucfirst($service->category) }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-weight-bold text-dark">{{ get_currency() }} {{ number_format($service->pivot->price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-slate-50">
                                <tr>
                                    <td colspan="2" class="px-4 py-3 text-right font-weight-bold text-muted">Subtotal</td>
                                    <td class="px-4 py-3 text-right font-weight-bold text-dark">{{ get_currency() }} {{ number_format($booking->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Notes Section --}}
            @if($booking->notes || $booking->admin_notes)
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h5 class="card-title font-weight-bold text-primary">
                        <i class="fas fa-sticky-note mr-2"></i>Notes & Comments
                    </h5>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    @if($booking->notes)
                    <div class="p-3 bg-light rounded border-left border-primary mb-3">
                        <label class="text-xs text-uppercase text-muted mb-1 d-block font-weight-bold">Patient / User Notes</label>
                        <p class="mb-0 text-slate-700 italic">"{{ $booking->notes }}"</p>
                    </div>
                    @endif
                    @if($booking->admin_notes)
                    <div class="p-3 bg-slate-50 rounded border-left border-secondary">
                        <label class="text-xs text-uppercase text-muted mb-1 d-block font-weight-bold">Internal Admin Notes</label>
                        <p class="mb-0 text-slate-700">{{ $booking->admin_notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- Right Column: Status & Payment --}}
        <div class="col-lg-4">
            {{-- Status Management Card --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h5 class="card-title font-weight-bold text-primary">
                        <i class="fas fa-tasks mr-2"></i>Booking Status
                    </h5>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    <div class="mb-4">
                        <label class="text-xs text-uppercase text-muted mb-2 d-block">Current Status</label>
                        @php
                            $status_colors = [
                                'pending' => 'bg-warning',
                                'confirmed' => 'bg-info',
                                'sample_collected' => 'bg-purple',
                                'in_progress' => 'bg-primary',
                                'completed' => 'bg-success',
                                'cancelled' => 'bg-danger',
                                'no_show' => 'bg-secondary',
                            ];
                        @endphp
                        <span class="badge {{ $status_colors[$booking->status] ?? 'bg-secondary' }} px-3 py-2 rounded shadow-sm text-sm d-block text-center text-white">
                            {{ strtoupper($booking->status) }}
                        </span>
                    </div>

                    <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group mb-3">
                            <label class="text-xs text-uppercase text-muted mb-1">Update Booking Status</label>
                            <select name="status" class="form-control form-control-sm select2">
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="sample_collected" {{ $booking->status == 'sample_collected' ? 'selected' : '' }}>Sample Collected</option>
                                <option value="in_progress" {{ $booking->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="no_show" {{ $booking->status == 'no_show' ? 'selected' : '' }}>No Show</option>
                            </select>
                        </div>

                        @if($booking->booking_type == 'home_visit')
                        <div class="form-group mb-3">
                            <label class="text-xs text-uppercase text-muted mb-1">Assign Technician</label>
                            <select name="technician_id" class="form-control form-control-sm select2">
                                <option value="">Not Assigned</option>
                                @foreach($technicians ?? [] as $tech)
                                    <option value="{{ $tech->id }}" {{ $booking->technician_id == $tech->id ? 'selected' : '' }}>
                                        {{ $tech->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="form-group mb-3">
                            <label class="text-xs text-uppercase text-muted mb-1">Admin Notes (Internal)</label>
                            <textarea name="admin_notes" class="form-control text-sm" rows="2" placeholder="Update internal notes...">{{ $booking->admin_notes }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block shadow-sm">
                            <i class="fas fa-sync-alt mr-1"></i> Update Booking
                        </button>
                    </form>
                </div>
            </div>

            {{-- Payment Summary Card --}}
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="card-title font-weight-bold text-primary mb-0">
                        <i class="fas fa-receipt mr-2"></i>Payment Summary
                    </h5>
                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" data-toggle="modal" data-target="#updatePaymentModal">
                        <i class="fas fa-edit mr-1"></i> Update
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="px-4 py-3 bg-slate-50 d-flex justify-content-between align-items-center border-bottom">
                        <span class="text-muted font-weight-600">Payment Status</span>
                        @if($booking->payment_status == 'paid')
                            <span class="badge bg-success-soft text-success px-2 py-1 rounded border border-success">
                                <i class="fas fa-check-circle mr-1"></i> FULLY PAID
                            </span>
                        @elseif($booking->payment_status == 'partial')
                            <span class="badge bg-info-soft text-info px-2 py-1 rounded border border-info">
                                <i class="fas fa-adjust mr-1"></i> PARTIAL
                            </span>
                        @else
                            <span class="badge bg-warning-soft text-warning px-2 py-1 rounded border border-warning">
                                <i class="fas fa-exclamation-circle mr-1"></i> UNPAID
                            </span>
                        @endif
                    </div>
                    
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal Amount</span>
                            <span class="text-dark font-weight-600">{{ get_currency() }} {{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Discount Allowed</span>
                            <span class="text-info font-weight-600">- {{ get_currency() }} {{ number_format($booking->discount, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Amount Paid</span>
                            <span class="text-success font-weight-600">{{ get_currency() }} {{ number_format($booking->paid_amount, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-3 mt-1">
                            <span class="text-dark font-weight-700">Net Due</span>
                            <span class="text-danger font-weight-800" style="font-size: 1.25rem;">{{ get_currency() }} {{ number_format($booking->due_amount, 2) }}</span>
                        </div>
                    </div>

                    <div class="px-4 py-3 bg-light border-top text-xs text-muted">
                        <div class="row">
                            <div class="col-6">Method: <strong>{{ strtoupper($booking->payment_type) }}</strong></div>
                            <div class="col-6 text-right">Created by: <strong>{{ $booking->creator->name ?? 'System' }}</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Update Payment Modal --}}
    <div class="modal fade" id="updatePaymentModal" tabindex="-1" role="dialog" aria-labelledby="updatePaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title font-weight-bold" id="updatePaymentModalLabel">
                        <i class="fas fa-money-bill-wave mr-2"></i>Update Payment Info
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="update_payment" value="1">
                    <div class="modal-body p-4">
                        <div class="mb-4 p-3 bg-light rounded text-center">
                            <span class="text-muted d-block text-xs text-uppercase mb-1">Total Bill</span>
                            <h3 class="font-weight-800 text-dark mb-0">{{ get_currency() }} {{ number_format($booking->total_amount, 2) }}</h3>
                        </div>

                        <div class="form-group mb-3">
                            <label class="text-xs text-uppercase text-muted font-weight-bold">Paid Amount</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-cash-register text-success"></i></span>
                                </div>
                                <input type="number" name="paid_amount" id="modalPaidAmount" class="form-control border-left-0 pl-0" value="{{ $booking->paid_amount }}" step="0.01" min="0">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="text-xs text-uppercase text-muted font-weight-bold">Discount (Flat)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-tag text-info"></i></span>
                                </div>
                                <input type="number" name="discount" id="modalDiscount" class="form-control border-left-0 pl-0" value="{{ $booking->discount }}" step="0.01" min="0">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white border-left-0">{{ get_currency() }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 bg-danger-soft rounded d-flex justify-content-between align-items-center">
                            <span class="text-danger font-weight-bold text-xs text-uppercase">Balance Due</span>
                            <h4 class="mb-0 text-danger font-weight-800" id="modalDueAmount">{{ get_currency() }} {{ number_format($booking->due_amount, 2) }}</h4>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-secondary shadow-sm px-4" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary shadow-sm px-4">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<style>
    .bg-success-soft { background-color: rgba(16, 185, 129, 0.1); }
    .bg-info-soft { background-color: rgba(14, 165, 233, 0.1); }
    .bg-warning-soft { background-color: rgba(245, 158, 11, 0.1); }
    .bg-danger-soft { background-color: rgba(239, 68, 68, 0.1); }
    .text-xs { font-size: 0.75rem; }
    .font-weight-600 { font-weight: 600; }
    .font-weight-700 { font-weight: 700; }
    .font-weight-800 { font-weight: 800; }
    .italic { font-style: italic; }
</style>
<script>
    $(document).ready(function() {
        if ($.fn.select2) {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });
        }

        var totalBill = {{ $booking->total_amount }};

        function updateModalDue() {
            var paid = parseFloat($('#modalPaidAmount').val()) || 0;
            var discount = parseFloat($('#modalDiscount').val()) || 0;
            var due = totalBill - paid - discount;
            if (due < 0) due = 0;
            $('#modalDueAmount').text('{{ get_currency() }} ' + due.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        }

        $('#modalPaidAmount, #modalDiscount').on('input', function() {
            updateModalDue();
        });
    });
</script>
@endpush
