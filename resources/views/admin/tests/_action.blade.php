@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="d-flex justify-content-center">
    {{-- Test Edit Permission Check --}}
    @if($u && ($isSuper || $u->hasPermission('edit_test')))
        @if($test['parent_id'])
            <a href="{{route('admin.tests.edit',$test['parent_id'])}}" class="btn btn-primary btn-sm mr-1">
                <i class="fa fa-edit"></i>
            </a>
        @else 
            <a href="{{route('admin.tests.edit',$test['id'])}}" class="btn btn-primary btn-sm mr-1">
                <i class="fa fa-edit"></i>
            </a>
        @endif
    @endif

    {{-- Test Delete Permission Check --}}
    @if($u && ($isSuper || $u->hasPermission('delete_test')))
        <form method="POST" action="{{route('admin.tests.destroy',$test['id'])}}" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm delete_test">
                <i class="fa fa-trash"></i>
            </button>
        </form>
    @endif
</div>