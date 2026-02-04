{{-- ইউজার এডিট পারমিশন চেক --}}
@if($u && ($isSuper || $u->hasPermission('edit_user')))
    <a href="{{route('admin.users.edit',$user['id'])}}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i>
    </a>
@endif

{{-- ইউজার ডিলিট পারমিশন চেক --}}
@if($u && ($isSuper || $u->hasPermission('delete_user')))
    {{-- নিজের আইডি যেন নিজে ডিলিট করতে না পারে সেই চেক (ঐচ্ছিক কিন্তু নিরাপদ) --}}
    @if($u->id != $user['id'])
        <form method="POST" action="{{route('admin.users.destroy',$user['id'])}}" class="d-inline">
            @csrf
            <input type="hidden" name="_method" value="delete">
            <button type="submit" class="btn btn-danger btn-sm delete_user">
                <i class="fa fa-trash"></i>
            </button>
        </form>
    @endif
@endif