@extends('layouts.app')
@section('title', 'Create Membership Plan')

@section('content')
<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Create Membership Plan</h3></div>
    <form method="POST" action="{{ route('admin.membership_plans.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            @include('admin.membership_plans._form')
        </div>
        <div class="card-footer">
            <button class="btn btn-primary">Save Plan</button>
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
