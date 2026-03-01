@extends('layouts.app')

@section('title', __('admin.dashboard'))

@section('css')
    <link rel="stylesheet" href="{{url('plugins/swtich-netliva/css/netliva_switch.css')}}">
    <style>
        .small-box { border-radius: 15px !important; overflow: hidden; }
        .info-box { border-radius: 12px !important; }
    </style>
@endsection

@section('header')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark font-weight-bold">
            <i class="nav-icon fas fa-chart-line mr-2 text-primary"></i>
            {{__('admin.my_dashboard')}}
          </h1>
        </div>
      </div>
    </div>
</div>
@endsection

@section('content')
@if(auth()->guard('admin')->check())
<div class="row">
    {{-- Core Statistics --}}
    <div class="col-lg-3 col-6">
      <div class="small-box bg-info shadow-sm">
        <div class="inner p-4">
          <h3 class="font-weight-bold">{{$services_count ?? 0}}</h3>
          <p class="text-uppercase small font-weight-bold" style="letter-spacing: 1px;">Available Services</p>
        </div>
        <div class="icon"><i class="fas fa-flask"></i></div>
        <a href="{{route('admin.services.index')}}" class="small-box-footer py-2">View Services <i class="fas fa-arrow-circle-right ml-1"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="small-box bg-primary shadow-sm">
        <div class="inner p-4">
          <h3 class="font-weight-bold">{{$bookings_count ?? 0}}</h3>
          <p class="text-uppercase small font-weight-bold" style="letter-spacing: 1px;">Total Bookings</p>
        </div>
        <div class="icon"><i class="fas fa-calendar-check"></i></div>
        <a href="{{route('admin.bookings.index')}}" class="small-box-footer py-2">View Bookings <i class="fas fa-arrow-circle-right ml-1"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="small-box bg-success shadow-sm">
        <div class="inner p-4">
          <h3 class="font-weight-bold">{{$patients_count ?? 0}}</h3>
          <p class="text-uppercase small font-weight-bold" style="letter-spacing: 1px;">Registered Patients</p>
        </div>
        <div class="icon"><i class="fas fa-user-injured"></i></div>
        <a href="{{route('admin.patients.index')}}" class="small-box-footer py-2">Patient List <i class="fas fa-arrow-circle-right ml-1"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="small-box bg-warning shadow-sm">
        <div class="inner p-4">
          <h3 class="font-weight-bold text-white">{{$visits_count ?? 0}}</h3>
          <p class="text-uppercase small font-weight-bold text-white" style="letter-spacing: 1px;">Home Visits</p>
        </div>
        <div class="icon"><i class="fas fa-home"></i></div>
        <a href="{{route('admin.visits.index')}}" class="small-box-footer py-2 text-white">View Visits <i class="fas fa-arrow-circle-right ml-1"></i></a>
      </div>
    </div>
</div>

<div class="row mt-4">
    {{-- Financial Statistics --}}
    <div class="col-md-4">
      <div class="info-box shadow-sm border-0">
        <span class="info-box-icon bg-success-soft text-success"><i class="fas fa-hand-holding-usd"></i></span>
        <div class="info-box-content">
          <span class="info-box-text text-muted text-uppercase small font-weight-bold">{{__('admin.today_income')}}</span>
          <span class="info-box-number h4 font-weight-bold mb-0 text-dark">{{ get_currency() }} {{ number_format($today_paid, 2) }}</span>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="info-box shadow-sm border-0">
        <span class="info-box-icon bg-danger-soft text-danger"><i class="fas fa-file-invoice-dollar"></i></span>
        <div class="info-box-content">
          <span class="info-box-text text-muted text-uppercase small font-weight-bold">{{__('admin.today_expense')}}</span>
          <span class="info-box-number h4 font-weight-bold mb-0 text-dark">{{ get_currency() }} {{ number_format($today_total_expense, 2) }}</span>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="info-box shadow-sm border-0">
        <span class="info-box-icon bg-primary-soft text-primary"><i class="fas fa-wallet"></i></span>
        <div class="info-box-content">
          <span class="info-box-text text-muted text-uppercase small font-weight-bold">{{__('admin.today_profit')}}</span>
          <span class="info-box-number h4 font-weight-bold mb-0 text-dark">{{ get_currency() }} {{ number_format($today_profit, 2) }}</span>
        </div>
      </div>
    </div>
</div>

<div class="row mt-4">
    {{-- Diagnostic Status Section --}}
    <div class="col-lg-12">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="card-title font-weight-bold mb-0 text-primary">
                    <i class="fas fa-microscope mr-2"></i>Diagnostic Report Status
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-4 border-right">
                        <div class="text-center">
                            <h2 class="font-weight-bold text-dark mb-1">{{$group_tests_count}}</h2>
                            <p class="text-muted text-uppercase small mb-0">Total Test Entries</p>
                        </div>
                    </div>
                    <div class="col-md-4 border-right">
                        <div class="text-center">
                            <h2 class="font-weight-bold text-warning mb-1">{{$pending_tests_count}}</h2>
                            <p class="text-muted text-uppercase small mb-0">Pending Results</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h2 class="font-weight-bold text-success mb-1">{{$done_tests_count}}</h2>
                            <p class="text-muted text-uppercase small mb-0">Completed Reports</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    {{-- Active Users --}}
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title font-weight-bold mb-0 text-dark">
                    <i class="fas fa-users-cog mr-2 text-info"></i>Active Staff/Users ( <span class="online_count">0</span> )
                </h5>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2 online_list"></ul>
            </div>
        </div>
    </div>

    {{-- Today's Home Visits --}}
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title font-weight-bold mb-0 text-dark">
                    <i class="fas fa-truck mr-2 text-danger"></i>Today's Scheduled Home Visits ( {{count($today_visits)}} )
                </h5>
            </div>
            <div class="card-body p-0 table-responsive">
                @if(count($today_visits))
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 text-xs text-uppercase text-muted">Patient</th>
                            <th class="border-0 text-xs text-uppercase text-muted">Status</th>
                            <th class="border-0 text-xs text-uppercase text-muted text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($today_visits as $visit)
                        <tr>
                            <td class="py-3">
                                <span class="font-weight-600 text-dark">{{$visit['patient']['name'] ?? 'Unknown'}}</span><br>
                                <small class="text-muted">{{$visit['patient']['phone'] ?? ''}}</small>
                            </td>
                            <td class="py-3">
                                <input type="checkbox" id="change_status" visit-id="{{$visit['id']}}" {{ $visit['status'] ? 'checked' : '' }} netliva-switch data-active-text="{{__('admin.completed')}}" data-passive-text=" {{__('admin.pending')}}"/>
                            </td>
                            <td class="py-3 text-right">
                                <a href="{{route('admin.visits.show',$visit['id'])}}" class="btn btn-primary btn-sm rounded-circle"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else 
                <div class="p-5 text-center">
                    <i class="fas fa-calendar-day fa-3x text-muted mb-3 d-block opacity-2"></i>
                    <p class="text-muted mb-0">No home visits scheduled for today.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
  <script src="{{url('plugins/swtich-netliva/js/netliva_switch.js')}}"></script>
  <script src="{{url('js/admin/dashboard.js')}}"></script>
@endsection

@push('scripts')
<style>
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
    .bg-primary-soft { background-color: rgba(0, 123, 255, 0.1); }
    .font-weight-600 { font-weight: 600; }
    .text-xs { font-size: 0.75rem; }
    .opacity-2 { opacity: 0.2; }
</style>
@endpush
