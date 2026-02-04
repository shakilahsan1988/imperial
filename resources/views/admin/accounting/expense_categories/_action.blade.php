@if($u && ($isSuper || $u->hasPermission('edit_expense_category')))
    <a href="{{route('admin.expense_categories.edit',$expense_category['id'])}}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i>
    </a>
@endif

@if($u && ($isSuper || $u->hasPermission('delete_expense_category')))
    <form method="POST" action="{{route('admin.expense_categories.destroy',$expense_category['id'])}}" class="d-inline">
        @csrf
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_expense_category">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endif