@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="d-flex justify-content-center">
    @if($u && ($isSuper || $u->hasPermission('edit_expense_category')))
        <a href="{{route('admin.expense_categories.edit',$expense_category['id'])}}" class="btn btn-primary btn-sm mr-1">
            <i class="fa fa-edit"></i>
        </a>
    @endif

    @if($u && ($isSuper || $u->hasPermission('delete_expense_category')))
        <form method="POST" action="{{route('admin.expense_categories.destroy',$expense_category['id'])}}" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm delete_expense_category">
                <i class="fa fa-trash"></i>
            </button>
        </form>
    @endif
</div>