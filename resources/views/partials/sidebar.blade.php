<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{url('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">
              @if(Auth::guard('admin')->check())
                {{Auth::guard('admin')->user()->name}}
              @elseif(Auth::guard('patient')->check())
                {{Auth::guard('patient')->user()->name}}<br>
                {{__('Code')}}: {{Auth::guard('patient')->user()->code}}
              @endif
            </a>
          </div>
        </div>

        @if(Auth::guard('admin')->check())
            @include('partials.admin_sidebar')
        
        @elseif(Auth::guard('patient')->check())
            @include('partials.patient_sidebar')
        @endif

      </div>
</aside>