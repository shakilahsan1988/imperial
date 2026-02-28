@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="d-flex justify-content-center">
    {{-- Culture Option Edit Permission Check --}}
    @if($u && ($isSuper || $u->hasPermission('edit_culture_option')))
        <a href="{{route('admin.culture_options.edit',$culture_option['id'])}}" class="btn btn-primary btn-sm mr-1">
            <i class="fa fa-edit"></i>
        </a>
    @endif

    {{-- Culture Option Delete Permission Check --}}
    @if($u && ($isSuper || $u->hasPermission('delete_culture_option')))
        <form method="POST" action="{{route('admin.culture_options.destroy',$culture_option['id'])}}" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm delete_culture_option">
                <i class="fa fa-trash"></i>
            </button>
        </form>
    @endif
</div>