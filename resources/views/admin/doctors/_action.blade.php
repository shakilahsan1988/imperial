@php
    // ডাটা-টেবিল এরর এড়াতে ব্লেড ফাইলের ভেতরেই ভেরিয়েবল ডিফাইন করা হলো
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1); // (সুপার এডমিন) চেক
@endphp

{{-- ডাক্তার এডিট পারমিশন চেক --}}
@if($u && ($isSuper || $u->hasPermission('edit_doctor')))
    <a href="{{route('admin.doctors.edit',$doctor['id'])}}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i>
    </a>
@endif

{{-- ডাক্তার ডিলিট পারমিশন চেক --}}
@if($u && ($isSuper || $u->hasPermission('delete_doctor')))
    <form method="POST" action="{{route('admin.doctors.destroy',$doctor['id'])}}" class="d-inline">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger btn-sm delete_doctor">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endif