@php
    // ব্লেড ফাইলের ভেতরেই প্রয়োজনীয় ভেরিয়েবলগুলো ডিফাইন করা হলো যাতে ডাটা-টেবিল এরর না দেয়
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1); // (সুপার এডমিন) চেক
@endphp

{{-- কালচার অপশন এডিট পারমিশন চেক --}}
@if($u && ($isSuper || $u->hasPermission('edit_culture_option')))
    <a href="{{route('admin.culture_options.edit',$culture_option['id'])}}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i>
    </a>
@endif

{{-- কালচার অপশন ডিলিট পারমিশন চেক --}}
@if($u && ($isSuper || $u->hasPermission('delete_culture_option')))
    <form method="POST" action="{{route('admin.culture_options.destroy',$culture_option['id'])}}" class="d-inline">
        @csrf
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_culture_option">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endif