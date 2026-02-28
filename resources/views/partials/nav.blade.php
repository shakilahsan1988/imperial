<nav class="main-header navbar navbar-expand navbar-dark">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('admin.index')}}" class="nav-link">{{__('Dashboard')}}</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      @php
          $u = auth()->guard('admin')->user();
          $isSuper = ($u && $u->id == 1);
      @endphp

      @if($isSuper || ($u && $u->hasPermission('view_visit')))
      <li class="nav-item dropdown" id="visits_notification">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"> {{ __('admin.notifications') }}</i>
          <span class="badge badge-warning navbar-badge visits_count"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><span class="visits_count">0</span> {{__('admin.new_home_visits')}}</span>
          <div class="dropdown-divider"></div>
          <div id="visits_list">
            
          </div>
          <div class="dropdown-divider"></div>
          <a href="{{route('admin.visits.index')}}" class="dropdown-item dropdown-footer">{{__('admin.see_more')}}</a>
        </div>
      </li>
      @endif

      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            @if(app()->getLocale()=='bn')
            🇧🇩 {{ __('Bangla') }}
            @else
            🇺🇸 {{ __('English') }}
            @endif
        </a>
        <div class="dropdown-menu dropdown-menu-right p-0">
            @foreach($languages as $language)
                <a href="{{route('change_locale',$language->iso)}}" class="dropdown-item">
                    <i class="flag-icon flag-icon-{{$language->iso}} mr-2"></i> {{__($language->name)}}
                </a>
            @endforeach
        </div>
      </li>

      <li class="nav-item">
        <button type="button" class="btn btn-danger btn-sm sign_out">
          <i class="fas fa-sign-out-alt"></i>
       </button>
        <form id="sign_out" method="POST" action="{{ auth()->guard('admin')->check() ? route('admin.logout') : route('patient.logout') }}">
          @csrf
        </form>
      </li>
      </ul>
    </nav>
