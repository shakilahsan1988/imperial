{{-- ইউজারের পারমিশন চেক করার জন্য শুরুতে লজিক যোগ করা হলো --}}
@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="row select_patient">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="patient_id">{{__('Select Patient')}}</label>
            
            {{-- @can('create_patient') এর পরিবর্তে কাস্টম লজিক --}}
            @if($u && ($isSuper || $u->hasPermission('create_patient')))
                <button type="button" class="btn btn-warning btn-sm add_patient float-right"  data-toggle="modal" data-target="#patient_modal">
                    <i class="fa fa-exclamation-triangle"></i>  {{__('Not Listed ?')}}
                </button>
            @endif

            <select id="patient_id" name="patient_id" class="form-control" required>
                @if(isset($visit)&&isset($visit['patient']))
                    <option value="{{$visit['patient']['id']}}" selected>{{$visit['patient']['name']}}</option>
                @endif
            </select>
        </div>
    </div>
</div>

{{-- বাকি পেশেন্ট ইনফো, ম্যাপ এবং অ্যাটাচমেন্ট সেকশন আপনার আগের মতোই ঠিক থাকবে --}}
<div class="row patient_info">
    {{-- ... (আপনার আগের কোড) --}}
</div>