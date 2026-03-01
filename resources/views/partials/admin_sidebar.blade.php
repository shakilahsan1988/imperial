@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      
      <li class="nav-item">
        <a href="{{route('admin.index')}}" class="nav-link" id="dashboard">
            <i class="nav-icon fas fa-th"></i>
            <p>{{__('admin.dashboard')}}</p>
        </a>
      </li>

      @if($u && ($isSuper || $u->hasPermission('view_service') || $u->hasPermission('view_service_category') || $u->hasPermission('view_service_sub_category')))
        <li class="nav-item has-treeview" id="service_management">
          <a href="#" class="nav-link" id="service_management_link">
            <i class="nav-icon fas fa-concierge-bell"></i>
            <p>
              {{__('admin.service_management')}}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @if($isSuper || $u->hasPermission('view_service_category'))
            <li class="nav-item">
              <a href="{{route('admin.service_categories.index')}}" class="nav-link" id="service_categories">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('admin.service_category')}}</p>
              </a>
            </li>
            @endif
            @if($isSuper || $u->hasPermission('view_service_sub_category'))
            <li class="nav-item">
              <a href="{{route('admin.service_sub_categories.index')}}" class="nav-link" id="service_sub_categories">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('admin.service_sub_category')}}</p>
              </a>
            </li>
            @endif
            @if($isSuper || $u->hasPermission('view_service'))
            <li class="nav-item">
              <a href="{{route('admin.services.index')}}" class="nav-link" id="services">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('admin.services')}}</p>
              </a>
            </li>
            @endif
          </ul>
        </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_booking')))
      <li class="nav-item">
        <a href="{{route('admin.bookings.index')}}" class="nav-link" id="bookings">
          <i class="nav-icon fas fa-calendar-check"></i>
          <p>{{__('Bookings')}}</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('admin.results.index')}}" class="nav-link" id="results">
          <i class="nav-icon fas fa-poll-h"></i>
          <p>{{__('Results')}}</p>
        </a>
      </li>
      @endif
    
      @if($u && ($isSuper || $u->hasPermission('view_patient')))
      <li class="nav-item">
        <a href="{{route('admin.patients.index')}}" class="nav-link" id="patients">
          <i class="nav-icon fas fa-user-injured"></i>
          <p>{{__('admin.patient_list')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_doctor')))
      <li class="nav-item">
        <a href="{{route('admin.doctors.index')}}" class="nav-link" id="doctors">
          <i class="nav-icon fa fa-user-md"></i>
          <p>{{__('admin.doctor_list')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_visit')))
      <li class="nav-item">
        <a href="{{route('admin.visits.index')}}" class="nav-link" id="visits">
          <i class="nav-icon fas fa-home"></i>
          <p>{{__('admin.home_visits')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_contract')))
      <li class="nav-item">
        <a href="{{route('admin.contracts.index')}}" class="nav-link" id="contracts">
          <i class="fas fa-file-contract nav-icon"></i>
          <p>{{__('admin.contract')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_branch')))
      <li class="nav-item">
        <a href="{{route('admin.branches.index')}}" class="nav-link" id="branches">
          <i class="fa fa-building nav-icon"></i>
          <p>{{__('admin.branches')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_accounting_reports') || $u->hasPermission('view_expense')))
      <li class="nav-item has-treeview" id="accounting">
        <a href="#" class="nav-link" id="accounting_link">
          <i class="nav-icon fas fa-calculator"></i>
          <p>
            {{__('admin.office_accounting')}}
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          @if($isSuper || $u->hasPermission('view_expense_category'))
          <li class="nav-item">
            <a href="{{route('admin.expense_categories.index')}}" class="nav-link" id="expense_categories">
              <i class="far fa-circle nav-icon"></i>
              <p>{{__('admin.expense_category')}}</p>
            </a>
          </li>
          @endif
          @if($isSuper || $u->hasPermission('view_expense'))
          <li class="nav-item">
            <a href="{{route('admin.expenses.index')}}" class="nav-link" id="expenses">
              <i class="far fa-circle nav-icon"></i>
              <p>{{__('admin.expenses')}}</p>
            </a>
          </li>
          @endif
          @if($isSuper || $u->hasPermission('view_accounting_reports'))
          <li class="nav-item">
            <a href="{{route('admin.accounting.index')}}" class="nav-link" id="accounting_reports">
              <i class="far fa-circle nav-icon"></i>
              <p>{{__('admin.accounting_report')}}</p>
            </a>
          </li>
          @endif
        </ul>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_user') || $u->hasPermission('view_role')))
        <li class="nav-item has-treeview" id="users_roles">
          <a href="#" class="nav-link" id="users_roles_link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              {{__('admin.users_and_roles')}}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @if($isSuper || $u->hasPermission('view_role'))
            <li class="nav-item">
              <a href="{{route('admin.roles.index')}}" class="nav-link" id="roles">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('admin.role_list')}}</p>
              </a>
            </li>
            @endif
            @if($isSuper || $u->hasPermission('view_user'))
            <li class="nav-item">
              <a href="{{route('admin.users.index')}}" class="nav-link" id="users">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('admin.user_list')}}</p>
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a href="{{route('admin.profile.edit')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('admin.change_password')}}</p>
              </a>
            </li>
          </ul>
        </li>
      @endif
      
      @if($u && ($isSuper || $u->hasPermission('view_setting')))
      <li class="nav-item">
        <a href="{{route('admin.settings.index')}}" class="nav-link" id="settings">
          <i class="fa fa-cogs nav-icon"></i>
          <p>{{__('admin.software_settings')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_activity_log')))
      <li class="nav-item">
        <a href="{{route('admin.activity_logs.index')}}" class="nav-link" id="activity_logs">
          <i class="fa fa-server nav-icon"></i>
          <p>{{__('admin.activity_log')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_backup')))
      <li class="nav-item">
        <a href="{{route('admin.backups.index')}}" class="nav-link" id="backups">
          <i class="fa fa-database nav-icon"></i>
          <p>{{__('admin.database_backup')}}</p>
        </a>
      </li>
      @endif

    </ul>
</nav>
