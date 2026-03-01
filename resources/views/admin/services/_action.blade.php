<div class="btn-group">
    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
        <i class="fas fa-cog"></i>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('admin.services.show', $service->id) }}">
            <i class="fas fa-eye"></i> View
        </a>
        <a class="dropdown-item" href="{{ route('admin.services.edit', $service->id) }}">
            <i class="fas fa-edit"></i> Edit
        </a>
        <div class="dropdown-divider"></div>
        <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="d-inline delete-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="dropdown-item text-danger">
                <i class="fas fa-trash"></i> Delete
            </button>
        </form>
    </div>
</div>
