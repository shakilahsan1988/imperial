{{-- কালচার এডিট পারমিশন চেক --}}
@if($u && ($isSuper || $u->hasPermission('edit_culture')))
    <a href="{{route('admin.cultures.edit',$culture['id'])}}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i>
    </a>
@endif

{{-- কালচার ডিলিট পারমিশন চেক --}}
@if($u && ($isSuper || $u->hasPermission('delete_culture')))
    <form method="POST" action="{{route('admin.cultures.destroy',$culture['id'])}}" class="d-inline">
        @csrf
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_culture">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endif