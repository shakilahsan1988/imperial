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
      <li class="nav-item has-treeview" id="manage_doctors">
        <a href="#" class="nav-link" id="manage_doctors_link">
          <i class="nav-icon fa fa-user-md"></i>
          <p>
            Manage Doctors
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('admin.doctors.index')}}" class="nav-link" id="doctors">
              <i class="far fa-circle nav-icon"></i>
              <p>{{__('admin.doctor_list')}}</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.doctor_specialties.index')}}" class="nav-link" id="doctor_specialties">
              <i class="far fa-circle nav-icon"></i>
              <p>Specialty</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.doctor_departments.index')}}" class="nav-link" id="doctor_departments">
              <i class="far fa-circle nav-icon"></i>
              <p>Department</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.doctor_consultation_slots.index')}}" class="nav-link" id="doctor_consultation_slots">
              <i class="far fa-circle nav-icon"></i>
              <p>Time Slots</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.doctor_consultation_bookings.index')}}" class="nav-link" id="doctor_consultation_bookings">
              <i class="far fa-circle nav-icon"></i>
              <p>Consultation Booking</p>
            </a>
          </li>
        </ul>
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
      <li class="nav-item has-treeview" id="pages">
        <a href="#" class="nav-link" id="pages_link">
          <i class="nav-icon fas fa-file-alt"></i>
          <p>
            Pages
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.pages.home_settings') }}" class="nav-link" id="pages_home_settings">
              <i class="far fa-circle nav-icon"></i>
              <p>Home Settings</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.pages.diagonostic_settings') }}" class="nav-link" id="pages_diagonostic">
              <i class="far fa-circle nav-icon"></i>
              <p>Diagonostic</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.pages.health_check_settings') }}" class="nav-link" id="pages_health_check">
              <i class="far fa-circle nav-icon"></i>
              <p>Health Check</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" id="pages_membership">
              <i class="far fa-circle nav-icon"></i>
              <p>Membership</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" id="pages_video_consultation">
              <i class="far fa-circle nav-icon"></i>
              <p>Video Consultation</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" id="pages_our_doctors">
              <i class="far fa-circle nav-icon"></i>
              <p>Our Doctors</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" id="pages_blog">
              <i class="far fa-circle nav-icon"></i>
              <p>Blog</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" id="pages_gallery">
              <i class="far fa-circle nav-icon"></i>
              <p>Gallery</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" id="pages_mission_vission">
              <i class="far fa-circle nav-icon"></i>
              <p>Mission &amp; Vission</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" id="pages_management">
              <i class="far fa-circle nav-icon"></i>
              <p>Management</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" id="pages_contact">
              <i class="far fa-circle nav-icon"></i>
              <p>Contact</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item has-treeview" id="helth_check">
        <a href="#" class="nav-link" id="helth_check_link">
          <i class="nav-icon fas fa-heartbeat"></i>
          <p>
            Helth Check
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.health_package_categories.index') }}" class="nav-link" id="health_package_categories">
              <i class="far fa-circle nav-icon"></i>
              <p>Package Category</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.health_packages.index') }}" class="nav-link" id="health_packages">
              <i class="far fa-circle nav-icon"></i>
              <p>Health Package</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.health_package_bookings.index') }}" class="nav-link" id="health_package_bookings">
              <i class="far fa-circle nav-icon"></i>
              <p>Package Booking</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item has-treeview" id="membership_module">
        <a href="#" class="nav-link" id="membership_module_link">
          <i class="nav-icon fas fa-id-card"></i>
          <p>
            Membership
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.membership_categories.index') }}" class="nav-link" id="membership_categories">
              <i class="far fa-circle nav-icon"></i>
              <p>Category</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.membership_plans.index') }}" class="nav-link" id="membership_plans">
              <i class="far fa-circle nav-icon"></i>
              <p>Create Plan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.membership_plan_bookings.index') }}" class="nav-link" id="membership_plan_bookings">
              <i class="far fa-circle nav-icon"></i>
              <p>Plan Booking</p>
            </a>
          </li>
        </ul>
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
