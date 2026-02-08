@php
    // ডাটা-টেবিল এরর এড়াতে ব্লেড ফাইলের ভেতরেই ভেরিয়েবল ডিফাইন করা হলো
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1); // মো: শাকিল আহসান (সুপার এডমিন) চেক
@endphp

{{-- রোল এডিট পারমিশন চেক --}}
@if($u && ($isSuper || $u->hasPermission('edit_role')))
    <a href="{{route('admin.roles.edit',$role['id'])}}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i>
    </a>
@endif

{{-- রোল ডিলিট পারমিশন চেক --}}
@if($u && ($isSuper || $u->hasPermission('delete_role')))
    <form method="POST" action="{{route('admin.roles.destroy',$role['id'])}}" class="d-inline">
        @csrf
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_role">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endif