<a href="{{ route('admin.team_members.edit', $member->id) }}" class="btn btn-info btn-sm">
    <i class="fa fa-edit"></i>
</a>
<form method="POST" action="{{ route('admin.team_members.destroy', $member->id) }}" class="d-inline" onsubmit="return confirm('Delete this team member?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">
        <i class="fa fa-trash"></i>
    </button>
</form>
