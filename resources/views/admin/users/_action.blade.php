@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="d-flex justify-content-center">
    {{-- User Edit Permission Check --}}
    @if($u && ($isSuper || $u->hasPermission('edit_user')))
        <a href="{{route('admin.users.edit',$user['id'])}}" class="btn btn-primary btn-sm mr-1">
            <i class="fa fa-edit"></i>
        </a>
    @endif

    {{-- User Delete Permission Check --}}
    @if($u && ($isSuper || $u->hasPermission('delete_user')))
        {{-- Prevent user from deleting themselves --}}
        @if($u->id != $user['id'])
            <form method="POST" action="{{route('admin.users.destroy',$user['id'])}}" class="d-inline">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger btn-sm delete_user">
                    <i class="fa fa-trash"></i>
                </button>
            </form>
        @endif
    @endif
</div>