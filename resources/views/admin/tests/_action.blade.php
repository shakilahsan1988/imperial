@php
    // Include the variable into bladefile to avoid the error
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1); // Super Admin check
@endphp

{{-- Test Edit Permission Check --}}
@if($u && ($isSuper || $u->hasPermission('edit_test')))
    @if($test['parent_id'])
        <a href="{{route('admin.tests.edit',$test['parent_id'])}}" class="btn btn-primary btn-sm">
            <i class="fa fa-edit"></i>
        </a>
    @else 
        <a href="{{route('admin.tests.edit',$test['id'])}}" class="btn btn-primary btn-sm">
            <i class="fa fa-edit"></i>
        </a>
    @endif
@endif

{{-- Test Delete Permission Check --}}
@if($u && ($isSuper || $u->hasPermission('delete_test')))
    <form method="POST" action="{{route('admin.tests.destroy',$test['id'])}}" class="d-inline">
        @csrf
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_test">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endif