@extends('layouts.app')

@section('title', 'Management Team')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header">
        <h3 class="card-title">
            <i class="nav-icon fa fa-users"></i> Management Team
        </h3>
        <div class="card-tools">
            <a href="{{ route('admin.team_members.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Add New Member
            </a>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover" id="team_members_table">
            <thead class="bg-light">
                <tr>
                    <th width="60">Image</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Sort Order</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($teamMembers as $member)
                <tr>
                    <td>
                        @if($member->image)
                            <img src="{{ asset($member->image) }}" alt="{{ $member->name }}" class="img-thumbnail" style="max-height: 50px; max-width: 50px;">
                        @else
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 4px;">
                                <i class="fa fa-user"></i>
                            </div>
                        @endif
                    </td>
                    <td><strong>{{ $member->name }}</strong></td>
                    <td>{{ $member->designation }}</td>
                    <td>{{ $member->sort_order }}</td>
                    <td>
                        @if($member->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.team_members.edit', $member->id) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.team_members.destroy', $member->id) }}" class="d-inline" onsubmit="return confirm('Delete this team member?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        No team members found. <a href="{{ route('admin.team_members.create') }}">Add one now</a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if($teamMembers->hasPages())
            <div class="mt-3">
                {{ $teamMembers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#team_members').addClass('active');
    $('#team_members_link').addClass('active');
    $('#team_members_module').addClass('menu-open');
</script>
@endpush
