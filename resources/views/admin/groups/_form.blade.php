{{-- ব্রাঞ্চ এবং পেশেন্ট তথ্যের শুরুতে ইউজার ডিফাইন করে নেওয়া --}}
@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="row text-center">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    {{__('ব্রাঞ্ছ সিলেক্ট করুন')}}
                </h5>
            </div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                          <i class="fas fa-map-marked-alt nav-icon"></i>
                      </span>
                    </div>

                    @if(isset($group))
                        <input type="hidden" value="{{$group['branch_id']}}" id="branch_id">
                    @endif

                    @if(isset($visit))
                        <input type="hidden" value="{{$visit['patient']['id']}}" patient_name="{{$visit['patient']['name']}}" id="visit_patient_id">
                    @endif

                    <select name="branch_id" id="branch" class="form-control" required>
                        <option value="" selected disabled>{{__('Select tests branch')}}</option>
                        @if(isset($group['branch'])&&!$branches->contains('id',$group['branch_id']))
                            <option value="{{$group['branch']['id']}}">{{$group['branch']['name']}}</option>
                        @endif
                        @foreach($branches as $branch)
                          <option value="{{$branch['id']}}">{{$branch['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            {{__('রোগীর তথ্য')}}
        </h3>
        {{-- নতুন রোগী এড করার পারমিশন চেক --}}
        @if($u && ($isSuper || $u->hasPermission('create_patient')))
            <button type="button" class="btn btn-warning btn-sm add_patient float-right"  data-toggle="modal" data-target="#patient_modal">
                <i class="fa fa-exclamation-triangle"></i>  {{__('রোগী এড করা নেই ?')}}
            </button>
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label>{{__('কোড')}}</label>
                    <select id="code" name="patient_id" class="form-control" required>
                        @if(isset($group)&&isset($group['patient']))
                            <option value="{{$group['patient']['id']}}" selected>{{$group['patient']['code']}}</option>
                        @endif
                    </select>
                </div> 
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>{{__('রোগীর নাম')}}</label>
                    <select id="name" name="patient_id" class="form-control" required>
                        @if(isset($group)&&isset($group['patient']))
                            <option value="{{$group['patient']['id']}}" selected>{{$group['patient']['name']}}</option>
                        @endif
                    </select>
                </div> 
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>{{__('জন্ম তারিখ')}}</label>
                    <input class="form-control" id="dob" @if(isset($group)&&isset($group['patient'])) value="{{$group['patient']['dob']}}" @endif readonly>
                </div> 
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>{{__('মোবাইল নাম্বার')}}</label>
                    <input class="form-control" id="phone" @if(isset($group)&&isset($group['patient'])) value="{{$group['patient']['phone']}}" @endif  readonly>
                </div> 
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>{{__('ইমেইল এড্রেস')}}</label>
                    <input class="form-control" id="email" @if(isset($group)&&isset($group['patient'])) value="{{$group['patient']['email']}}" @endif readonly>
                </div> 
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>{{__('লিঙ্গ')}}</label>
                    <input class="form-control" id="gender" @if(isset($group)&&isset($group['patient'])) value="{{$group['patient']['gender']}}" @endif readonly>
                </div> 
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>{{__('ঠিকানা')}}</label>
                    <input class="form-control" id="address" @if(isset($group)&&isset($group['patient'])) value="{{$group['patient']['address']}}" @endif readonly>
                </div> 
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>{{__('রেফারড বাই')}}</label> 
                    {{-- নতুন ডাক্তার এড করার পারমিশন চেক --}}
                    @if($u && ($isSuper || $u->hasPermission('create_doctor')))
                        <button type="button" class="btn btn-warning btn-sm float-right"  data-toggle="modal" data-target="#doctor_modal"><i class="fa fa-exclamation-triangle"></i> {{__('এড করা নেই ?')}}</button>
                    @endif
                    <select class="form-control" name="doctor_id" id="doctor">
                        @if(isset($group)&&isset($group['doctor']))
                            <option value="{{$group['doctor']['id']}}" selected>{{$group['doctor']['name']}}</option>
                        @endif
                    </select>
                </div> 
            </div>
        </div>
    </div>
</div>
{{-- টেস্ট এবং কালচার সেকশন আগের মতোই থাকবে কারণ ওখানে পারমিশন চেক নেই --}}