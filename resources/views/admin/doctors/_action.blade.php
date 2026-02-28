@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="d-flex justify-content-center">
    {{-- Doctor Edit Permission Check --}}
    @if($u && ($isSuper || $u->hasPermission('edit_doctor')))
        <a href="{{route('admin.doctors.edit',$doctor['id'])}}" class="btn btn-primary btn-sm mr-1">
            <i class="fa fa-edit"></i>
        </a>
    @endif

    {{-- Doctor Delete Permission Check --}}
    @if($u && ($isSuper || $u->hasPermission('delete_doctor')))
        <form method="POST" action="{{route('admin.doctors.destroy',$doctor['id'])}}" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm delete_doctor">
                <i class="fa fa-trash"></i>
            </button>
        </form>
    @endif
</div>