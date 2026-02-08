@php
    // ব্লেড ফাইলের ভেতরেই প্রয়োজনীয় ভেরিয়েবলগুলো ডিফাইন করা হলো যাতে ডাটা-টেবিল এরর না দেয়
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1); // (সুপার এডমিন) চেক
@endphp

{{-- পেশেন্ট এডিট পারমিশন চেক --}}
@if($u && ($isSuper || $u->hasPermission('edit_patient')))
    <a class="btn btn-primary btn-sm" href="{{route('admin.patients.edit',$patient['id'])}}">
        <i class="fa fa-edit" aria-hidden="true"></i>
    </a>
@endif

{{-- পেশেন্ট ডিলিট পারমিশন চেক --}}
@if($u && ($isSuper || $u->hasPermission('delete_patient')))
    <form method="POST" action="{{route('admin.patients.destroy',$patient['id'])}}" class="d-inline">
        @csrf
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_patient">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endif