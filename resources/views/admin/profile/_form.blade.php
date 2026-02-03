<div class="row">
    <div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="fa fa-user"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('আপনার নাম')}}" name="name" value="{{auth()->guard('admin')->user()->name}}" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="email" class="form-control" placeholder="{{__('ইমেইল এড্রেস')}}" name="email" value="{{auth()->guard('admin')->user()->email}}"  required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-key" aria-hidden="true"></i>
              </span>
            </div>
            <input type="password" class="form-control" placeholder="{{__('পাসওয়ার্ড')}}" name="password" id="password">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-key" aria-hidden="true"></i>
              </span>
            </div>
            <input type="password" class="form-control" placeholder="{{__('পাসওয়ার্ড কনফার্ম করুন')}}" name="password_confirmation" id="password_confirmation">
        </div>
    </div>
</div>

@can('sign_report')
<div class="row">
    <div class="col-lg-10">
            
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">
                      <i class="fas fa-signature" aria-hidden="true"></i>
                </span>
              </div>
            <div class="custom-file">
                <input type="file" accept="image/*" class="custom-file-input" id="exampleInputFile" name="signature">
                <label class="custom-file-label" for="exampleInputFile">{{__('আপনার সিগনেচার আপলোড করুন')}}</label>
            </div>
        </div>
            
    </div>
    <div class="col-lg-2">
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title" style="text-align: center!important;float: unset;">
                    {{__('সিগেচার')}}
                </h5>
            </div>
            <div class="card-body p-1">
                <img class="img-thumbnail" src="@if(!empty(auth()->guard('admin')->user()->signature)){{url('uploads/signature/'.auth()->guard('admin')->user()->signature)}} @else {{url('img/no-image.png')}} @endif" alt="{{__('সিগনেচার')}}">
            </div>
        </div>
    </div>
</div>
@endcan
