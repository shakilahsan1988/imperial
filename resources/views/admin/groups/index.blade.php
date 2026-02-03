@extends('layouts.app')

@section('title')
{{__('ইনভোয়েছ অ্যান্ড বিলিং')}}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="nav-icon fas fa-file-invoice"></i>
            {{__('ইনভোয়েছ অ্যান্ড বিলিং')}}
          </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('হোম')}}</a></li>
            <li class="breadcrumb-item active">{{__('ইনভোয়েছ সমূহ')}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
@endsection

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">{{__('ইনভোয়েছ টেস্ট টেবিল')}}</h3>
      <a href="{{route('admin.groups.create')}}" class="btn btn-primary btn-sm float-right">
       <i class="fa fa-plus"></i> {{__('ইনভোয়েছ ক্রিয়েট করুন')}} 
      </a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
    <!-- filter -->
      <div id="accordion">
        <div class="card card-info">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary collapsed" aria-expanded="false">
            <i class="fas fa-filter"></i> {{__('ফিল্টার')}}
          </a>
          <div id="collapseOne" class="panel-collapse in collapse">
            <div class="card-body">
              <div class="row justify-content-center">
                <div class="col-lg-3">
                  <div class="form-group">
                     <label for="filter_date">{{__('তারিখ')}}</label>
                     <input type="text" class="form-control datepickerrange" id="filter_date" placeholder="{{__('তারিখ')}}">
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="form-group">
                     <label for="filter_status">{{__('স্ট্যাটাস')}}</label>
                     <select name="filter_status" id="filter_status" class="form-control select2">
                        <option value="" selected>{{__('সকল')}}</option>
                        <option value="1">{{__('সম্পন্ন')}}</option>
                        <option value="0">{{__('পেন্ডিং')}}</option>
                     </select>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="form-group">
                     <label for="filter_barcode">{{__('বারকোড')}}</label>
                     <input type="text" class="form-control" id="filter_barcode" placeholder="{{__('বারকোড')}}">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- \filter -->
      <div class="row">
         <div class="col-lg-12 table-responsive">
            <table id="groups_table" class="table table-striped table-hover table-bordered" width="100%">
               <thead>
               <tr>
                 <th width="10px">#</th>
                 <th width="10px">{{__('বারকোড')}}</th>
                 <th width="100px">{{__('রোগীর কোড')}}</th>
                 <th>{{__('রোগীর নাম')}}</th>
                 <th width="100px">{{__('সাবটোটাল')}}</th>
                 <th width="100px">{{__('ডিস্কাউন্ট')}}</th>
                 <th width="100px">{{__('টোটাল')}}</th>
                 <th width="100px">{{__('পরিশোধ')}}</th>
                 <th width="100px">{{__('বকেয়া')}}</th>
                 <th width="100px">{{__('তারিখ')}}</th>
                 <th width="10px">{{__('স্ট্যাটাস')}}</th>
                 <th width="50px">{{__('একশন')}}</th>
               </tr>
               </thead>
               <tbody>
                 
               </tbody>
             </table>
         </div>
      </div>
    </div>
    <!-- /.card-body -->
  </div>

  @include('admin.groups.modals.print_barcode')

@endsection
@section('scripts')
   <script src="{{url('js/select2.js')}}"></script>
   <script src="{{url('js/admin/groups.js')}}"></script>
@endsection