@extends('layouts.app')
@section('title', 'Edit Dynamic Page')

@section('content')
<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Edit Dynamic Page</h3></div>
    <form method="POST" action="{{ route('admin.dynamic_pages.update', $page->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            @include('admin.dynamic_pages._form')
        </div>
        <div class="card-footer">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.dynamic_pages.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$('#pages_link').addClass('active');
$('#pages').addClass('menu-open');
$('#pages_dynamic_pages').addClass('active');

const slugInput = document.querySelector('input[name="slug"]');
const slugPreview = document.getElementById('slug-preview');
if (slugInput && slugPreview) {
    slugInput.addEventListener('input', function () {
        slugPreview.textContent = this.value || '';
    });
}
</script>
@endpush

