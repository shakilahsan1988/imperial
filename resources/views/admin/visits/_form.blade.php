@php
    $u = auth()->guard('admin')->user();
    $isSuper = ($u && $u->id == 1);
@endphp

<div class="row select_patient">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="patient_id">{{__('Select Patient')}}</label>
            
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

<div class="row patient_info">
    <div class="col-lg-4">
        <div class="form-group">
         <div class="input-group mb-3">
             <div class="input-group-prepend">
               <span class="input-group-text" id="basic-addon1">
                   <i class="fa fa-user"></i>
               </span>
             </div>
             <input type="text" class="form-control" placeholder="{{__('Patient Name')}}" name="name" id="name" @if(isset($visit)&&isset($visit['patient'])) value="{{$visit['patient']['name']}}" @endif required readonly>
         </div>
        </div>
     </div>

     <div class="col-lg-4">
         <div class="form-group">
             <div class="input-group mb-3">
                 <div class="input-group-prepend">
                   <span class="input-group-text" id="basic-addon1">
                     <i class="fas fa-phone-alt"></i>
                   </span>
                 </div>
                 <input type="text" class="form-control" placeholder="{{__('Phone Number')}}" name="phone" id="phone" @if(isset($visit)&&isset($visit['patient'])) value="{{$visit['patient']['phone']}}" @endif required readonly>
             </div>
         </div>
     </div>

     <div class="col-lg-4">
         <div class="form-group">
             <div class="form-group">
                 <div class="input-group mb-3">
                     <div class="input-group-prepend">
                       <span class="input-group-text" id="basic-addon1">
                         <i class="fas fa-mars"></i>
                       </span>
                     </div>
                     <input type="text" class="form-control" placeholder="{{__('Gender')}}" name="gender" id="gender" @if(isset($visit)&&isset($visit['patient'])) value="{{$visit['patient']['gender']}}" @endif required readonly>
                 </div>
             </div>
         </div>
     </div>
     
     <div class="col-lg-4">
         <div class="form-group">
             <div class="form-group">
                 <div class="input-group mb-3">
                     <div class="input-group-prepend">
                       <span class="input-group-text" id="basic-addon1">
                         <i class="fas fa-map-marker-alt"></i>
                       </span>
                     </div>
                     <input type="text" class="form-control" placeholder="{{__('Address')}}" name="address" id="address" @if(isset($visit)&&isset($visit['patient'])) value="{{$visit['patient']['address']}}" @endif required readonly>
                 </div>
             </div>
         </div>
     </div>
     
     <div class="col-lg-4">
         <div class="form-group">
             <div class="form-group">
                 <div class="input-group mb-3">
                     <div class="input-group-prepend">
                       <span class="input-group-text" id="basic-addon1">
                         <i class="fas fa-envelope"></i>
                       </span>
                     </div>
                     <input type="email" class="form-control" placeholder="{{__('Email Address')}}" name="email" id="email" @if(isset($visit)&&isset($visit['patient'])) value="{{$visit['patient']['email']}}" @endif required readonly>
                 </div>
             </div>
         </div>
     </div>
 
     <div class="col-lg-4">
         <div class="form-group">
             <div class="form-group">
                 <div class="input-group mb-3">
                     <div class="input-group-prepend">
                       <span class="input-group-text" id="basic-addon1">
                         <i class="fas fa-baby"></i>
                       </span>
                     </div>
                     <input type="text" class="form-control datepicker" placeholder="{{__('Date of Birth')}}" name="dob" id="dob" @if(isset($visit)&&isset($visit['patient'])) value="{{$visit['patient']['dob']}}" @endif required readonly>
                 </div>
             </div>
         </div>
     </div>
 
     <div class="col-lg-4">
         <div class="form-group">
             <div class="form-group">
                 <div class="input-group mb-3">
                     <div class="input-group-prepend">
                       <span class="input-group-text" id="basic-addon1">
                         <i class="fas fa-clock"></i>
                       </span>
                     </div>
                     <input type="text" class="form-control datepicker" placeholder="{{__('Visit Date')}}" name="visit_date" id="visit_date" @if(isset($visit)) value="{{$visit['visit_date']}}" @endif required>
                 </div>
             </div>
         </div>
     </div>

     <div class="col-lg-4">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="custom-file">
                    <input type="file" name="attach" class="custom-file-input" id="attach">
                    <label class="custom-file-label" for="attach">{{__('Choose file')}}</label>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-12">
         <div class="card card-danger">
             <div class="card-header">
                 <h5 class="card-title">
                     <i  class="fas fa-map-marked-alt nav-icon"></i>
                     {{__('Location on map')}}
                 </h5>
             </div>
             <input type="hidden" name="lat" id="visit_lat" @if(isset($visit)) value="{{$visit['lat']}}" @endif required>
             <input type="hidden" name="lng" id="visit_lng" @if(isset($visit)) value="{{$visit['lng']}}" @endif required>
             <input type="hidden" name="zoom_level" id="zoom_level" @if(isset($visit)) value="{{$visit['zoom_level']}}" @endif required>
             <div class="card-body">
                 <div id="map" style="min-height:500px"></div>
             </div>
         </div>
    </div>
</div>
