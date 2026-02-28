@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="d-flex justify-content-center">
    {{-- Patient Edit Permission Check --}}
    @if($u && ($isSuper || $u->hasPermission('edit_patient')))
        <a class="btn btn-primary btn-sm mr-1" href="{{route('admin.patients.edit',$patient['id'])}}">
            <i class="fa fa-edit" aria-hidden="true"></i>
        </a>
    @endif

    {{-- Patient Delete Permission Check --}}
    @if($u && ($isSuper || $u->hasPermission('delete_patient')))
        <form method="POST" action="{{route('admin.patients.destroy',$patient['id'])}}" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm delete_patient">
                <i class="fa fa-trash"></i>
            </button>
        </form>
    @endif
</div>