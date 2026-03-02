@extends('layouts.app')
@section('title', 'Create Consultation Slot')

@section('content')
<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Create Consultation Slot</h3></div>
    <form method="POST" action="{{ route('admin.doctor_consultation_slots.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Label</label>
                <input type="text" name="label" class="form-control" placeholder="Morning 09:00 AM - 09:30 AM" required>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="0" min="0">
            </div>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" checked>
                <label class="custom-control-label" for="status">Active</label>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary">Save</button>
            <a href="{{ route('admin.doctor_consultation_slots.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$('#doctor_consultation_slots').addClass('active');
$('#manage_doctors_link').addClass('active');
$('#manage_doctors').addClass('menu-open');
</script>
@endpush
