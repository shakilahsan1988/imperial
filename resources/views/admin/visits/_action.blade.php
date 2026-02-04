{{-- ফাইলটির শুরুতে ইউজার ভেরিয়েবল চেক করে নিন যদি মেইন ফাইল থেকে না আসে --}}
@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-cog"></i> {{__('Action')}}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      
      {{-- ভিজিট দেখার পারমিশন --}}
      @if($u && ($isSuper || $u->hasPermission('view_visit')))
          <a href="{{route('admin.visits.show',$visit['id'])}}" class="dropdown-item">
            <i class="fa fa-eye"></i> {{__('Show')}}
          </a>
      @endif

      {{-- ভিজিট এডিট করার পারমিশন --}}
      @if($u && ($isSuper || $u->hasPermission('edit_visit')))
          <a href="{{route('admin.visits.edit',$visit['id'])}}" class="dropdown-item">
            <i class="fa fa-edit"></i> {{__('Edit')}}
          </a>
      @endif

      {{-- ভিজিট ডিলিট করার পারমিশন --}}
      @if($u && ($isSuper || $u->hasPermission('delete_visit')))
          <form method="POST" action="{{route('admin.visits.destroy',$visit['id'])}}" class="d-inline">
              @csrf
              <input type="hidden" name="_method" value="delete">
              <a href="#" class="dropdown-item delete_visit">
                <i class="fa fa-trash"></i>
                {{__('Delete')}}
              </a>
          </form>
      @endif

      {{-- টেস্ট গ্রুপ বা ইনভয়েস তৈরি করার পারমিশন --}}
      @if($u && ($isSuper || $u->hasPermission('create_group')))
          <a href="{{route('admin.visits.create_tests',$visit['id'])}}" class="dropdown-item">
            <i class="fa fa-flask"></i> {{__('Create group tests')}}
          </a>
      @endif
      
    </div>
</div>