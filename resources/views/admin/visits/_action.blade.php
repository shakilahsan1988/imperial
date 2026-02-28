@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="dropdown">
    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-cog"></i> {{__('Action')}}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      
      {{-- View Visit Permission --}}
      @if($u && ($isSuper || $u->hasPermission('view_visit')))
          <a href="{{route('admin.visits.show',$visit['id'])}}" class="dropdown-item">
            <i class="fa fa-eye"></i> {{__('Show')}}
          </a>
      @endif

      {{-- Edit Visit Permission --}}
      @if($u && ($isSuper || $u->hasPermission('edit_visit')))
          <a href="{{route('admin.visits.edit',$visit['id'])}}" class="dropdown-item">
            <i class="fa fa-edit"></i> {{__('Edit')}}
          </a>
      @endif

      {{-- Delete Visit Permission --}}
      @if($u && ($isSuper || $u->hasPermission('delete_visit')))
          <form method="POST" action="{{route('admin.visits.destroy',$visit['id'])}}" class="d-inline">
            @csrf
            @method('delete')
            <button type="button" class="dropdown-item delete_visit">
              <i class="fa fa-trash"></i> {{__('Delete')}}
            </button>
          </form>
      @endif

      {{-- Create Group (Invoice) Permission --}}
      @if($u && ($isSuper || $u->hasPermission('create_group')))
          <a href="{{route('admin.visits.create_tests',$visit['id'])}}" class="dropdown-item">
            <i class="fa fa-flask"></i> {{__('Create group tests')}}
          </a>
      @endif

    </div>
</div>
