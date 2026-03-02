@extends('layouts.app')
@section('title', 'Dynamic Pages')

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('admin.dynamic_pages.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i> Create Page
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
        <table class="table table-hover">
            <thead class="bg-light">
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Sort</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($pages as $page)
                <tr>
                    <td>
                        <strong>{{ $page->title }}</strong>
                        <div class="small text-muted">{{ $page->meta_title }}</div>
                    </td>
                    <td>
                        <code>/{{ $page->slug }}</code>
                        <div class="small"><a href="{{ url('/' . $page->slug) }}" target="_blank">Open page</a></div>
                    </td>
                    <td>{!! $page->status ? '<span class="badge bg-success">Published</span>' : '<span class="badge bg-secondary">Draft</span>' !!}</td>
                    <td>{{ $page->sort_order }}</td>
                    <td class="text-right">
                        <a href="{{ route('admin.dynamic_pages.edit', $page->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form method="POST" action="{{ route('admin.dynamic_pages.destroy', $page->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this page?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">No pages found.</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $pages->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#pages_link').addClass('active');
$('#pages').addClass('menu-open');
$('#pages_dynamic_pages').addClass('active');
</script>
@endpush

