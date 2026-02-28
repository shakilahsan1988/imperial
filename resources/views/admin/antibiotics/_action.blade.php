@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="d-flex justify-content-center">
    @if($u && ($isSuper || $u->hasPermission('edit_antibiotic')))
    <a href="{{route('admin.antibiotics.edit',$antibiotic['id'])}}" class="btn btn-primary btn-sm mr-1">
      <i class="fa fa-edit"></i>
    </a>
    @endif

    @if($u && ($isSuper || $u->hasPermission('delete_antibiotic')))
    <form method="POST" action="{{route('admin.antibiotics.destroy',$antibiotic['id'])}}" class="d-inline">
      @csrf
      @method('delete')
      <button type="submit" class="btn btn-danger btn-sm delete_antibiotic">
          <i class="fa fa-trash"></i>
      </button>
    </form>
    @endif
</div>