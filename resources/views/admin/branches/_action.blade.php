@php
    // ডাটা-টেবিল এরর এড়াতে ব্লেড ফাইলের ভেতরেই ভেরিয়েবল ডিফাইন করা হলো
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1); // মো: শাকিল আহসান (সুপার এডমিন) চেক
@endphp

@if($u && ($isSuper || $u->hasPermission('edit_branch')))
<a href="{{route('admin.branches.edit',$branch['id'])}}" class="btn btn-primary btn-sm">
  <i class="fa fa-edit"></i>
</a>
@endif

@if($u && ($isSuper || $u->hasPermission('delete_branch')))
<form method="POST" action="{{route('admin.branches.destroy',$branch['id'])}}" class="d-inline">
  @csrf
  <input type="hidden" name="_method" value="delete">
  <button type="submit" class="btn btn-danger btn-sm delete_branch">
      <i class="fa fa-trash"></i>
  </button>
</form>
@endif