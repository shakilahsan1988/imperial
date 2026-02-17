<nav class="main-header navbar navbar-expand navbar-dark">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    @php
        $u = auth()->guard('admin')->user();
        $isSuper = ($u && $u->id == 1); // সুপার এডমিন চেক
    @endphp

    <ul class="navbar-nav ml-auto">
      
      {{-- Home visits notification --}}
      @if($u && ($isSuper || $u->hasPermission('view_visit')))
      <li class="nav-item dropdown visits_notification">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"> {{ __('নোটিফিকেশন') }}</i>
          <span class="badge badge-warning navbar-badge visits_count"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><span class="visits_count">0</span> {{__('New home visits')}}</span>
          <div class="dropdown-divider"></div>
          <div class="list_visits"></div>
        </div>
      </li>
      @endif

      {{-- Messages notifications --}}
      @if($u && ($isSuper || $u->hasPermission('view_chat')))
        <li class="nav-item dropdown show messages_notification">
          <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
            <i class="far fa-comments"> {{ __('ম্যাসেজ') }}</i>
            <span class="badge badge-danger navbar-badge unread_messages_count">0</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
            <span class="dropdown-item dropdown-header"><span class="unread_messages_count">0</span> {{__('New messages')}}</span>
            <div class="dropdown-divider"></div>
            <div class="list_unread_messages"></div>
          </div>
        </li>
      @endif

      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-globe"></i> {{ strtoupper(app()->getLocale()) }}
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="{{ route('change_locale', 'en') }}" class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}">
            🇺🇸 English
          </a>
          <a href="{{ route('change_locale', 'bn') }}" class="dropdown-item {{ app()->getLocale() == 'bn' ? 'active' : '' }}">
            🇧🇩 {{ __('বাংলা') }}
          </a>
        </div>
      </li>

      <li class="nav-item">
        <button type="button" class="btn btn-danger btn-sm" role="button" onclick="document.getElementById('sign_out').submit();">
          <i class="fa fa-power-off"></i>
        </button>
        <form id="sign_out" method="POST" action="{{ auth()->guard('admin')->check() ? route('admin.logout') : route('patient.logout') }}">
          @csrf
        </form>
      </li>
      </ul>
    </nav>