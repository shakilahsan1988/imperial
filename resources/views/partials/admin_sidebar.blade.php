@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      
      <li class="nav-item">
        <a href="{{route('admin.index')}}" class="nav-link" id="dashboard">
            <i class="nav-icon fas fa-th"></i>
            <p>{{__('ড্যাশবোর্ড')}}</p>
        </a>
      </li>

      @if($u && ($isSuper || $u->hasPermission('view_group')))
      <li class="nav-item">
        <a href="{{route('admin.groups.index')}}" class="nav-link" id="groups">
          <i class="nav-icon fas fa-file-invoice"></i>
          <p>{{__('ইনভোয়েছ অ্যান্ড বিলিং')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_report')))
      <li class="nav-item">
        <a href="{{route('admin.reports.index')}}" class="nav-link" id="reports">
          <i class="nav-icon fas fa-flag"></i>
          <p>{{__('রিপোর্ট এন্ট্রি')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_test')))
      <li class="nav-item">
        <a href="{{route('admin.tests.index')}}" class="nav-link" id="tests">
          <i class="nav-icon fas fa-flask"></i>
          <p>{{__('টেস্ট এর মূল্য ও ফর্মেট ')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_culture')))
      <li class="nav-item">
        <a href="{{route('admin.cultures.index')}}" class="nav-link" id="cultures">
          <i class="nav-icon fas fa-vial"></i>
          <p>{{__('কালচার এর মূল্য ও ফর্মেট')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_culture_option')))
      <li class="nav-item">
        <a href="{{route('admin.culture_options.index')}}" class="nav-link" id="culture_options">
          <i class="nav-icon fas fa-vial"></i>
          <p>{{__('কালচার এর অপশন')}}</p>
        </a>
      </li>
      @endif
    
      @if($u && ($isSuper || $u->hasPermission('view_test_prices') || $u->hasPermission('view_culture_prices')))
        <li class="nav-item has-treeview" id="prices">
          <a href="#" class="nav-link" id="prices_link">
            <i class="nav-icon fas fa-list"></i>
            <p>
              {{__('মূল্য তালিকা')}}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @if($isSuper || $u->hasPermission('view_test_prices'))
            <li class="nav-item">
              <a href="{{route('admin.prices.tests')}}" class="nav-link" id="tests_prices">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('টেস্ট সমূহ')}}</p>
              </a>
            </li>
            @endif
            @if($isSuper || $u->hasPermission('view_culture_prices'))
            <li class="nav-item">
              <a href="{{route('admin.prices.cultures')}}" class="nav-link" id="cultures_prices">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('কালচার সমূহ')}}</p>
              </a>
            </li>
            @endif
          </ul>
        </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_antibiotic')))
      <li class="nav-item">
        <a href="{{route('admin.antibiotics.index')}}" class="nav-link" id="antibiotics">
          <i class="nav-icon fas fa-capsules"></i>
          <p>{{__('ঔষধ সমূহ')}}</p>
        </a>
      </li>
      @endif
    
      @if($u && ($isSuper || $u->hasPermission('view_patient')))
      <li class="nav-item">
        <a href="{{route('admin.patients.index')}}" class="nav-link" id="patients">
          <i class="nav-icon fas fa-user-injured"></i>
          <p>{{__('রোগীর তালিকা')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_doctor')))
      <li class="nav-item">
        <a href="{{route('admin.doctors.index')}}" class="nav-link" id="doctors">
          <i class="nav-icon fa fa-user-md"></i>
          <p>{{__('ডাক্তারদের তালিকা')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_visit')))
      <li class="nav-item">
        <a href="{{route('admin.visits.index')}}" class="nav-link" id="visits">
          <i class="nav-icon fas fa-home"></i>
          <p>{{__('হোম ভিজিট সমূহ')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_contract')))
      <li class="nav-item">
        <a href="{{route('admin.contracts.index')}}" class="nav-link" id="contracts">
          <i class="fas fa-file-contract nav-icon"></i>
          <p>{{__('কন্ট্রাক্ট')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_chat')))
      <li class="nav-item">
        <a href="{{route('admin.chat.index')}}" class="nav-link" id="chat">
          <i class="nav-icon far fa-comment-dots"></i>
          <p>{{__('লাইভ চ্যাট')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_branch')))
      <li class="nav-item">
        <a href="{{route('admin.branches.index')}}" class="nav-link" id="branches">
          <i class="fa fa-building nav-icon"></i>
          <p>{{__('ব্রাঞ্ছ সমূহ')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_accounting_reports') || $u->hasPermission('view_expense')))
      <li class="nav-item has-treeview" id="accounting">
        <a href="#" class="nav-link" id="accounting_link">
          <i class="nav-icon fas fa-calculator"></i>
          <p>
            {{__('অফিস একাউন্টিং')}}
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          @if($isSuper || $u->hasPermission('view_expense_category'))
          <li class="nav-item">
            <a href="{{route('admin.expense_categories.index')}}" class="nav-link" id="expense_categories">
              <i class="far fa-circle nav-icon"></i>
              <p>{{__('খরচের ক্যাটাগরি')}}</p>
            </a>
          </li>
          @endif
          @if($isSuper || $u->hasPermission('view_expense'))
          <li class="nav-item">
            <a href="{{route('admin.expenses.index')}}" class="nav-link" id="expenses">
              <i class="far fa-circle nav-icon"></i>
              <p>{{__('খরচ সমূহ')}}</p>
            </a>
          </li>
          @endif
          @if($isSuper || $u->hasPermission('view_accounting_reports'))
          <li class="nav-item">
            <a href="{{route('admin.accounting.index')}}" class="nav-link" id="accounting_reports">
              <i class="far fa-circle nav-icon"></i>
              <p>{{__('একাউন্টিং রিপোর্ট')}}</p>
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
              {{__('ইউজার ও পদবী')}}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @if($isSuper || $u->hasPermission('view_role'))
            <li class="nav-item">
              <a href="{{route('admin.roles.index')}}" class="nav-link" id="roles">
                <i class="fa fa-window-maximize nav-icon"></i>
                <p>{{__('পদবী লিস্ট')}}</p>
              </a>
            </li>
            @endif
            @if($isSuper || $u->hasPermission('view_user'))
            <li class="nav-item">
              <a href="{{route('admin.users.index')}}" class="nav-link" id="users">
                <i class="fa fa-users nav-icon"></i>
                <p>{{__('ইউজার লিস্ট')}}</p>
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a href="{{route('admin.profile.edit')}}" class="nav-link">
                <i class="fa fa-key nav-icon"></i>
                <p>{{__('পাসওয়ার্ড পরিবর্তন')}}</p>
              </a>
            </li>
          </ul>
        </li>
      @endif
      
      @if($u && ($isSuper || $u->hasPermission('view_setting')))
      <li class="nav-item">
        <a href="{{route('admin.settings.index')}}" class="nav-link" id="settings">
          <i class="fa fa-cogs nav-icon"></i>
          <p>{{__('সফটওয়্যার সেটিং')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_activity_log')))
      <li class="nav-item">
        <a href="{{route('admin.activity_logs.index')}}" class="nav-link" id="activity_logs">
          <i class="fa fa-server nav-icon"></i>
          <p>{{__('এক্টিভিটি লগ')}}</p>
        </a>
      </li>
      @endif

      @if($u && ($isSuper || $u->hasPermission('view_backup')))
      <li class="nav-item">
        <a href="{{route('admin.backups.index')}}" class="nav-link" id="backups">
          <i class="fa fa-database nav-icon"></i>
          <p>{{__('ডাটাবেইস ব্যাক নিন')}}</p>
        </a>
      </li>
      @endif

    </ul>
</nav>