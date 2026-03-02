@extends('layouts.app')
@section('title', 'Edit Consultation Slot')

@section('content')
<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Edit Consultation Slot</h3></div>
    <form method="POST" action="{{ route('admin.doctor_consultation_slots.update', $slot->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>Label</label>
                <input type="text" name="label" class="form-control" value="{{ $slot->label }}" required>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="time" name="start_time" class="form-control" value="{{ $slot->start_time }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" name="end_time" class="form-control" value="{{ $slot->end_time }}" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ $slot->sort_order }}" min="0">
            </div>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" {{ $slot->status ? 'checked' : '' }}>
                <label class="custom-control-label" for="status">Active</label>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary">Update</button>
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
