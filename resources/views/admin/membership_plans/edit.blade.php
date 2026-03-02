@extends('layouts.app')
@section('title', 'Edit Membership Plan')

@section('content')
<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Edit Membership Plan</h3></div>
    <form method="POST" action="{{ route('admin.membership_plans.update', $plan->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            @include('admin.membership_plans._form')
        </div>
        <div class="card-footer">
            <button class="btn btn-primary">Update Plan</button>
            <a href="{{ route('admin.membership_plans.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$('#membership_plans').addClass('active');
$('#membership_module_link').addClass('active');
$('#membership_module').addClass('menu-open');
</script>
@endpush
