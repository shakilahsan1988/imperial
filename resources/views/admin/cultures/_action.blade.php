@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="d-flex justify-content-center">
    {{-- Culture Edit Permission Check --}}
    @if($u && ($isSuper || $u->hasPermission('edit_culture')))
        <a href="{{route('admin.cultures.edit',$culture['id'])}}" class="btn btn-primary btn-sm mr-1">
            <i class="fa fa-edit"></i>
        </a>
    @endif

    {{-- Culture Delete Permission Check --}}
    @if($u && ($isSuper || $u->hasPermission('delete_culture')))
        <form method="POST" action="{{route('admin.cultures.destroy',$culture['id'])}}" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm delete_culture">
                <i class="fa fa-trash"></i>
            </button>
        </form>
    @endif
</div>