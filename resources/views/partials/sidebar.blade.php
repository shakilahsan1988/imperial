@php
    $sidebarInfo = $info ?? setting('info') ?? [];
    $sidebarLogo = ! empty($sidebarInfo['logo'])
        ? asset('img/' . $sidebarInfo['logo'])
        : asset('img/logo.svg');
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center">
          <a href="{{ url('/') }}" aria-label="{{ config('app.name') }}">
            <img src="{{ $sidebarLogo }}" height="54" alt="{{ config('app.name') }} logo" style="max-width: 100%; width: auto;">
          </a>
        </div>

        @if(Auth::guard('admin')->check())
            @include('partials.admin_sidebar')
        
        @elseif(Auth::guard('patient')->check())
            @include('partials.patient_sidebar')
        @endif

      </div>
</aside>
