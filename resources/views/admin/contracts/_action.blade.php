@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="d-flex justify-content-center">
    {{-- Contract Edit Permission Check --}}
    @if($u && ($isSuper || $u->hasPermission('edit_contract')))
        <a href="{{route('admin.contracts.edit',$contract['id'])}}" class="btn btn-primary btn-sm mr-1">
            <i class="fa fa-edit"></i>
        </a>
    @endif

    {{-- Contract Delete Permission Check --}}
    @if($u && ($isSuper || $u->hasPermission('delete_contract')))
        <form method="POST" action="{{route('admin.contracts.destroy',$contract['id'])}}" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm delete_contract">
                <i class="fa fa-trash"></i>
            </button>
        </form>
    @endif
</div>