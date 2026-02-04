@if($u && ($isSuper || $u->hasPermission('edit_expense')))
    <a href="{{route('admin.expenses.edit',$expense['id'])}}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i>
    </a>
@endif

@if($u && ($isSuper || $u->hasPermission('delete_expense')))
    <form method="POST" action="{{route('admin.expenses.destroy',$expense['id'])}}" class="d-inline">
        @csrf
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_expense">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endif