@php
    // ডাটা-টেবিল এরর এড়াতে ব্লেড ফাইলের ভেতরেই ভেরিয়েবল ডিফাইন করা হলো
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1); // মো: শাকিল আহসান (সুপার এডমিন) চেক
@endphp

<div class="text-center">

    {{-- কন্ট্রাক্ট এডিট পারমিশন চেক --}}
    @if($u && ($isSuper || $u->hasPermission('edit_contract')))
        <a href="{{route('admin.contracts.edit',$contract['id'])}}" class="btn btn-primary btn-sm">
            <i class="fa fa-edit"></i>
        </a>
    @endif

    {{-- কন্ট্রাক্ট ডিলিট পারমিশন চেক --}}
    @if($u && ($isSuper || $u->hasPermission('delete_contract')))
        <form method="POST" action="{{route('admin.contracts.destroy',$contract['id'])}}" class="d-inline">
            @csrf
            <input type="hidden" name="_method" value="delete">
            <button type="submit" class="btn btn-danger btn-sm delete_contract">
                <i class="fa fa-trash"></i>
            </button>
        </form>
    @endif

</div>