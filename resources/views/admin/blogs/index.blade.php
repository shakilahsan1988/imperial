@extends('layouts.app')
@section('title', 'Blogs')

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i> Create Blog
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
                    <th>Blog</th>
                    <th>Category</th>
                    <th>Published</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($blogs as $blog)
                <tr>
                    <td>
                        <strong>{{ $blog->title }}</strong>
                        <div class="small text-muted">{{ \Illuminate\Support\Str::limit(strip_tags((string) $blog->excerpt), 80) }}</div>
                    </td>
                    <td>{{ optional($blog->category)->name ?? '-' }}</td>
                    <td>{{ optional($blog->published_at)->format('Y-m-d H:i') ?? '-' }}</td>
                    <td>
                        {!! $blog->status ? '<span class="badge bg-success">Published</span>' : '<span class="badge bg-secondary">Draft</span>' !!}
                        @if($blog->is_featured)
                            <span class="badge bg-info">Featured</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form method="POST" action="{{ route('admin.blogs.destroy', $blog->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this blog?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">No blogs found.</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $blogs->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#blogs').addClass('active');
$('#blogs_module_link').addClass('active');
$('#blogs_module').addClass('menu-open');
</script>
@endpush
