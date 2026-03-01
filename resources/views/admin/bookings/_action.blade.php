<div class="btn-group">
    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
        <i class="fas fa-cog"></i>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('admin.bookings.show', $booking->id) }}">
            <i class="fas fa-eye"></i> View Details
        </a>
        <a class="dropdown-item" href="{{ route('admin.bookings.edit', $booking->id) }}">
            <i class="fas fa-edit"></i> Edit
        </a>
        <div class="dropdown-divider"></div>
        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="d-inline delete-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="dropdown-item text-danger">
                <i class="fas fa-trash"></i> Delete
            </button>
        </form>
    </div>
</div>
