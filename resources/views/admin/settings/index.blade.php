@extends('layouts.app')

@section('title')
{{__('Settings')}}
@endsection

@section('css')
  <!-- Colorpicker -->
  <link rel="stylesheet" href="{{url('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
  <!-- Switch -->
  <link rel="stylesheet" href="{{url('plugins/swtich-netliva/css/netliva_switch.css')}}">
  <style>
    /* WordPress-like Menu Builder Styles */
    .wp-menu-list {
        list-style: none;
        padding: 0;
        margin: 0;
        min-height: 10px;
    }
    .wp-menu-list .wp-menu-list {
        margin-left: 30px;
        border-left: 2px dashed #ddd;
        padding-left: 10px;
        min-height: 20px; /* Essential for dropping into empty children */
        padding-top: 5px;
    }
    .wp-menu-item {
        position: relative;
    }
    .wp-menu-item-handle {
        border: 1px solid #ddd !important;
        background: #f8f9fa !important;
        transition: all 0.2s;
        z-index: 10;
    }
    .wp-menu-item-handle:hover {
        background: #fff !important;
        border-color: #aaa !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
    }
    .transition-icon {
        transition: transform 0.3s;
    }
    .expanded .transition-icon {
        transform: rotate(180deg);
    }
    .max-h-200 { max-height: 200px; }
    .min-h-400 { min-height: 400px; }
    .ui-sortable-placeholder {
        border: 2px dashed #007bff !important;
        background: rgba(0, 123, 255, 0.05) !important;
        height: 45px !important;
        margin-bottom: 0.5rem !important;
        visibility: visible !important;
        width: 100% !important;
    }
    .ui-sortable-helper {
        width: 100% !important;
        height: auto !important;
    }
  </style>
@endsection

@section('breadcrumb')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">
          <i class="fa fa-cogs"></i>
          {{__('Settings')}}
        </h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('Settings')}}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

@endsection

@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h5 class="card-title">
            {{__('Settings')}}
        </h5>
    </div>
    <div class="card-body pt-2">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
              <div class="nav flex-column nav-tabs  h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active"  data-toggle="pill" href="#general_settings" role="tab" aria-controls="general_settingse" aria-selected="true"><i class="fas fa-cog"></i> {{__('General Settings')}}</a>
                <a class="nav-link"  data-toggle="pill" href="#emails_settings" role="tab" aria-controls="emails_settings" aria-selected="true"><i class="fas fa-envelope"></i> {{__('Email Settings')}}</a>
                <a class="nav-link"  data-toggle="pill" href="#reports_settings" role="tab" aria-controls="reports_settings" aria-selected="true"><i class="fas fa-file-alt"></i> {{__('Reports Settings')}}</a>
                <a class="nav-link"  data-toggle="pill" href="#menu_settings" role="tab" aria-controls="menu_settings" aria-selected="true"><i class="fas fa-bars"></i> {{__('Menu Settings')}}</a>

              </div>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
              <div class="tab-content" id="vert-tabs-tabContent">
                
                <!-- General Settings -->
                <div class="tab-pane text-left fade show active" id="general_settings" role="tabpanel" aria-labelledby="general_settings">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h5 class="card-title">{{__('General Settings')}}</h5>
                            </div>
                            <form action="{{route('admin.settings.info_submit')}}" method="POST" enctype="multipart/form-data">
                              @csrf
                            <div class="card-body">
                                <div class="card card-primary card-tabs">

                                    <div class="card-header p-0 pt-1">
                                      <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                          <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#general" role="tab" aria-controls="general" aria-selected="false">{{__('General')}}</a>
                                        </li>
                                        <li class="nav-item">
                                          <a class="nav-link" id="social-tab" data-toggle="pill" href="#social" role="tab" aria-controls="social" aria-selected="false">{{__('Social')}}</a>
                                        </li>
                                        <li class="nav-item">
                                          <a class="nav-link" id="logos-tab" data-toggle="pill" href="#logos" role="tab" aria-controls="logos" aria-selected="true">{{__('Logos')}}</a>
                                        </li>
                                      </ul>
                                    </div>
                                    
                                    <div class="card-body">
                                      <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane active fade show" id="general" role="tabpanel" aria-labelledby="general-tab">
                                          <div class="row">
                                            <div class="col-lg-6">
                                              <div class="input-group form-group mb-3">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text">
                                                    <i class="fas fa-file-signature"></i>
                                                  </span>
                                                </div>
                                                <input type="text" name="name" id="name" class="form-control" value="{{$settings['name']}}" required>
                                              </div>
                                            </div>
                                            <div class="col-lg-6">
                                              <div class="input-group form-group mb-3">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text">
                                                    ট
                                                  </span>
                                                </div>
                                                <select name="currency" id="currency" class="form-control select2">
                                                    @foreach($currencies as $currency)
                                                      <option value="{{$currency['iso']}}" @if($settings["currency"]==$currency['iso']) selected @endif>{{$currency['name']}}</option>
                                                    @endforeach
                                                </select>   
                                              </div>
                                            </div>
                                            <div class="col-lg-6">
                                              <div class="input-group form-group mb-3">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text">
                                                    <i class="fas fa-search-location"></i>
                                                  </span>
                                                </div>
                                                <input type="text" name="address" id="address" class="form-control" value="{{$settings['address']}}" required>
                                              </div>
                                            </div>
                                            <div class="col-lg-6">
                                              <div class="input-group form-group mb-3">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text">
                                                    <i class="fas fa-phone-square-alt"></i>
                                                  </span>
                                                </div>
                                                <input type="text" name="phone" id="phone" class="form-control" value="{{$settings['phone']}}" required>
                                              </div>
                                            </div>
                                            <div class="col-lg-6">
                                              <div class="input-group form-group mb-3">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text">
                                                    <i class="fas fa-envelope-square"></i>
                                                  </span>
                                                </div>
                                                <input type="email" name="email" id="email" class="form-control" value="{{$settings['email']}}" required>
                                              </div>
                                            </div>
                                            <div class="col-lg-6">
                                              <div class="input-group form-group mb-3">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text">
                                                    <i class="fas fa-globe"></i>
                                                  </span>
                                                </div>
                                                <input type="text" name="website" id="website" class="form-control" value="{{$settings['website']}}" required>
                                              </div>
                                            </div>
                                            <div class="col-lg-12">
                                              <div class="form-group">
                                                <div class="input-group form-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="fa fa-copyright"></i>
                                                    </span>
                                                  </div>
                                                  <input type="text" name="footer" id="footer" placeholder="{{__('Footer')}}" class="form-control" value="{{$settings['footer']}}" required>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        
                                        <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                                          <div class="row">
                                              <div class="col-lg-6">
                                                <div class="input-group form-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="fab fa-facebook"></i>
                                                    </span>
                                                  </div>
                                                  <input type="text" name="facebook" id="facebook" class="form-control" value="{{$settings['socials']['facebook']}}">
                                                </div>
                                              </div>
                                              <div class="col-lg-6">
                                                <div class="input-group form-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="fab fa-twitter"></i>
                                                    </span>
                                                  </div>
                                                  <input type="text" name="twitter" id="twitter" class="form-control" value="{{$settings['socials']['twitter']}}">
                                                </div>
                                              </div>
                                              <div class="col-lg-6">
                                                <div class="input-group form-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="fab fa-instagram"></i>
                                                    </span>
                                                  </div>
                                                  <input type="text" name="instagram" id="instagram" class="form-control" value="{{$settings['socials']['instagram']}}">
                                                </div>
                                              </div>
                                              <div class="col-lg-6">
                                                <div class="input-group form-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="fab fa-youtube"></i>
                                                    </span>
                                                  </div>
                                                  <input type="text" name="youtube" id="youtube" class="form-control" value="{{$settings['socials']['youtube']}}">
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                        
                                        <div class="tab-pane fade" id="logos" role="tabpanel" aria-labelledby="logos-tab">
                                          <div class="row">
                                              <div class="col-lg-12">
                                                <div class="form-group">
                                                  <label>{{__('Report Logo')}}</label>
                                                  <div class="input-group">
                                                    <div class="custom-file">
                                                      <input type="file" name="reports_logo" class="custom-file-input" id="reports_logo">
                                                      <label class="custom-file-label" for="reports_logo">{{__('Choose Report Logo')}}</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                      <span class="input-group-text p-1" id="">
                                                        <a href="{{ !empty($settings['reports_logo']) ? 'data:image/png;base64,'.$settings['reports_logo'] : url('img/reports_logo.png') }}" data-toggle="lightbox" data-title="Reports logo">
                                                          <img src="{{ !empty($settings['reports_logo']) ? 'data:image/png;base64,'.$settings['reports_logo'] : url('img/reports_logo.png') }}" style="max-height: 30px; max-width: 50px;" alt="Reports logo">
                                                        </a>
                                                      </span>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-lg-12">
                                                <div class="form-group">
                                                  <label>{{__('Logo')}}</label>
                                                  <div class="input-group">
                                                    <div class="custom-file">
                                                      <input type="file" name="logo" class="custom-file-input" id="logo">
                                                      <label class="custom-file-label" for="logo">{{__('Choose Logo')}}</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                      <span class="input-group-text p-1" id="">
                                                        <a href="{{url('img/'.($settings['logo'] ?? 'logo.png'))}}"  data-toggle="lightbox" data-title="Logo">
                                                          <img src="{{url('img/'.($settings['logo'] ?? 'logo.png'))}}" style="max-height: 30px; max-width: 50px;" alt="Logo">
                                                        </a>
                                                      </span>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-lg-12">
                                                <div class="form-group">
                                                  <label>{{__('Favicon')}}</label>
                                                  <div class="input-group">
                                                    <div class="custom-file">
                                                      <input type="file" name="favicon" class="custom-file-input" id="favicon">
                                                      <label class="custom-file-label" for="favicon">{{__('Choose Favicon')}}</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                      <span class="input-group-text p-1" id="">
                                                        <a href="{{url('img/'.($settings['favicon'] ?? 'favicon.png'))}}"  data-toggle="lightbox" data-title="Favicon">
                                                          <img src="{{url('img/'.($settings['favicon'] ?? 'favicon.png'))}}" style="max-height: 30px; max-width: 50px;" alt="Favicon">
                                                        </a>
                                                      </span>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                      
                                    <!-- /.card -->
                                </div>
                            </div>
                            <div class="card-footer">
                              <button type="submit" class="btn btn-primary"> <i class="fa fa-check"></i> {{__('Save')}}</button>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
                <!-- \General Settings -->

                <!-- Email settings -->
                <div class="tab-pane text-left fade show" id="emails_settings" role="tabpanel" aria-labelledby="emails_settings">
                    <div class="card card-primary">
                        <div class="card-header">
                          <h3 class="card-title">{{__('Email Settings')}}</h3>
                        </div>
                        <form action="{{route('admin.settings.emails_submit')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                              <div class="row">
                                <div class="col-lg-3">
                                  <div class="form-group">
                                      <label for="host">{{__('Host')}}</label>
                                      <input type="text" name="host" id="host" value="{{$emails_settings['host']}}" class="form-control" required>
                                  </div>
                                </div>
                                <div class="col-lg-2">
                                  <div class="form-group">
                                    <label for="port">{{__('Port')}}</label>
                                    <input type="text" name="port" id="port" value="{{$emails_settings['port']}}" class="form-control" required>
                                  </div>
                                </div>
                                <div class="col-lg-3">
                                 <div class="form-group">
                                  <label for="username">{{__('Username')}}</label>
                                  <input type="text" name="username" id="username" value="{{$emails_settings['username']}}" class="form-control" required>
                                 </div>
                                </div>
                                <div class="col-lg-3">
                                  <div class="form-group">
                                    <label for="password">{{__('Password')}}</label>
                                    <input type="text" name="password" id="password" value="{{$emails_settings['password']}}" class="form-control" required>
                                  </div>
                                </div>
                                <div class="col-lg-1">
                                  <div class="form-group">
                                    <label for="encryption">{{__('Encryption')}}</label>
                                    <input type="text" name="encryption" id="encryption" value="{{$emails_settings['encryption']}}" class="form-control" required>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                  <div class="col-lg-3">
                                    <div class="form-group">
                                      <label for="from_address">{{__('From Address')}}</label>
                                      <input type="email" name="from_address" id="from_address" value="{{$emails_settings['from_address']}}" class="form-control" required>
                                    </div>
                                  </div>
                                  <div class="col-lg-3">
                                    <div class="form-group">
                                      <label for="from_name">{{__('From Name')}}</label>
                                      <input type="text" name="from_name" id="from_name" value="{{$emails_settings['from_name']}}" class="form-control" required>
                                    </div>
                                  </div>
                                  <div class="col-lg-3">
                                     <div class="form-group">
                                        <label for="header_color">{{__('Header background color')}}</label>
                                        <div class="input-group">
                                            <input id="header_color" type="text" class="form-control" name="header_color" value="{{$emails_settings['header_color']}}" required>
                                            <div class="input-group-append header_color">
                                                <span class="input-group-text"><i class="fas fa-square" style="color: {{$emails_settings['header_color']}}"></i></span>
                                            </div>
                                        </div>
                                     </div>
                                  </div>
                                  <div class="col-lg-3">
                                      <div class="form-group">
                                        <label for="footer_color">{{__('Footer background color')}}</label>
                                        <div class="input-group">
                                            <input id="footer_color" type="text" class="form-control" name="footer_color" value="{{$emails_settings['footer_color']}}" required>
                                            <div class="input-group-append footer_color">
                                                <span class="input-group-text"><i class="fas fa-square" style="color:{{$emails_settings['footer_color']}}"></i></span>
                                            </div>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                              <br>
                              <div class="row">
                                  <div class="col-lg-12">
                                      <div class="card card-primary card-tabs">
                                      <div class="card-header p-0 pt-1">
                                          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                          <li class="nav-item">
                                              <a class="nav-link active" id="patient_code_tab" data-toggle="pill" href="#patient_code" role="tab" aria-controls="patient_code" aria-selected="true">
                                              {{__('Patient Code')}}
                                              </a>
                                          </li>
                                          <li class="nav-item">
                                              <a class="nav-link" id="resetting_password_tab" data-toggle="pill" href="#resetting_password" role="tab" aria-controls="resetting_password" aria-selected="true">
                                              {{__('Resetting Password')}}
                                              </a>
                                          </li>
                                          <li class="nav-item">
                                              <a class="nav-link" id="tests_notification_tab" data-toggle="pill" href="#tests_notification" role="tab" aria-controls="tests_notification" aria-selected="true">
                                              {{__('Tests Notification')}}
                                              </a>
                                          </li>
                                          
                                          </ul>
                                      </div>
                                      <div class="card-body">
                                          <div class="tab-content" id="custom-tabs-one-tabContent">
                                            <div class="tab-pane fade show active" id="patient_code" role="tabpanel" aria-labelledby="patient_code_tab">
                                              <div class="row">
                                                <div class="form-group">
                                                  <input name="patient_code[active]" type="checkbox" @if(!empty($emails_settings['patient_code'])&&$emails_settings['patient_code']['active']) checked @endif netliva-switch data-active-text="{{__('Active')}}" data-passive-text=" {{__('Deactive')}}"/>
                                                </div>
                                              </div>
                                              <div class="row">
                                                <p class="text-danger">{{__('Do not change variables')}}:<br>{patient_code} <br> {patient_name}</p>
                                              </div>
                                              <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="patient_code_subject">{{__('Subject')}}</label>
                                                        <input type="text" id="patient_code_subject" class="form-control" name="patient_code[subject]" value="{{$emails_settings['patient_code']['subject']}}" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="patient_code_body">{{__('Message')}}</label>
                                                        <textarea class="form-control summernote" name="patient_code[body]" id="patient_code_body" cols="30" rows="10" required>{{$emails_settings['patient_code']['body']}}</textarea>
                                                    </div>
                                                </div>
                                            </div>                  
                                            </div>
                                            <div class="tab-pane fade" id="resetting_password" role="tabpanel" aria-labelledby="resetting_password">
                                              <div class="row">
                                                <div class="form-group">
                                                  <input name="reset_password[active]" type="checkbox" @if(!empty($emails_settings['reset_password'])&&$emails_settings['reset_password']['active']) checked @endif netliva-switch data-active-text="{{__('Active')}}" data-passive-text=" {{__('Deactive')}}"/>
                                                </div>
                                              </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="reset_password_subject">{{__('Subject')}}</label>
                                                            <input type="text" id="reset_password_subject" class="form-control" name="reset_password[subject]" value="{{$emails_settings['reset_password']['subject']}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="reset_password_body">{{__('Message')}}</label>
                                                            <textarea class="form-control summernote" name="reset_password[body]" id="reset_password_body" cols="30" rows="10" required>{{$emails_settings['reset_password']['body']}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tests_notification" role="tabpanel" aria-labelledby="tests_notification">
                                              <div class="row">
                                                <div class="form-group">
                                                  <input name="tests_notification[active]" type="checkbox" @if(!empty($emails_settings['tests_notification'])&&$emails_settings['tests_notification']['active']) checked @endif netliva-switch data-active-text="{{__('Active')}}" data-passive-text=" {{__('Deactive')}}"/>
                                                </div>
                                              </div>
                                              <div class="row">
                                                <p class="text-danger">{{__('Do not change variables')}}:<br>{patient_code} <br> {patient_name}</p>
                                              </div>
                                              <div class="row">
                                                  <div class="col-lg-12">
                                                      <div class="form-group">
                                                          <label for="tests_notification_subject">{{__('Subject')}}</label>
                                                          <input type="text" id="tests_notification_subject" class="form-control" name="tests_notification[subject]" value="{{$emails_settings['tests_notification']['subject']}}" required>
                                                      </div>
                                                  </div>
                                                  <div class="col-lg-12">
                                                      <div class="form-group">
                                                          <label for="tests_notification_body">{{__('Message')}}</label>
                                                          <textarea class="form-control summernote" name="tests_notification[body]" id="tests_notification_body" cols="30" rows="10" required>{{$emails_settings['tests_notification']['body']}}</textarea>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          </div>
                                      </div>
                                      <!-- /.card -->
                                      </div>
                                  
                                  </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                            <button class="btn btn-primary"> <i class="fa fa-check"></i> {{__('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- \Email Settings -->

                <!-- Reports settings -->
                <div class="tab-pane text-left fade show" id="reports_settings" role="tabpanel" aria-labelledby="reports_settings">
                    <div class="card card-primary">
                        <div class="card-header">
                          <h3 class="card-title">{{__('Reports Settings')}}</h3>
                        </div>
                        <form action="{{route('admin.settings.reports_submit')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <input type="checkbox" name="show_header" id="show_header" @if($reports_settings['show_header']) checked @endif>
                                            <label for="show_header"><i class="fa fa-arrow-up"></i> {{__('Show Header')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <input type="checkbox" name="show_footer" id="show_footer" @if($reports_settings['show_footer']) checked @endif>
                                            <label for="show_footer"><i class="fas fa-arrow-down"></i> {{__('Show Footer')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <input type="checkbox" name="show_signature" id="show_signature" @if($reports_settings['show_signature']) checked @endif>
                                            <label for="show_signature"><i class="fas fa-signature"></i> {{__('Show Signature')}}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-lg-3">
                                        <label for="margin-top"><i class="fa fa-arrow-up"></i> {{__('Margin top')}}</label>
                                        <input type="number" min="0"  id="margin-top" name="margin-top"class="form-control" value="{{$reports_settings['margin-top']}}" required>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="margin-right"><i class="fa fa-arrow-right"></i> {{__('Margin right')}}</label>
                                        <input type="number" min="0" id="margin-right" name="margin-right"  class="form-control" value="{{$reports_settings['margin-right']}}"  required>                                        
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="margin-bottom"><i class="fa fa-arrow-down"></i> {{__('Margin bottom')}}</label>
                                        <input type="number" min="0" name="margin-bottom" id="margin-bottom" class="form-control" value="{{$reports_settings['margin-bottom']}}"  required>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="margin-left"><i class="fa fa-arrow-left"></i> {{__('Margin left')}}</label>
                                        <input type="number" min="0"  id="margin-left" name="margin-left" class="form-control" value="{{$reports_settings['margin-left']}}"  required>
                                    </div>

                                </div>

                                <div class="row mt-3">

                                  <div class="col-lg-3">
                                    <label for="content-margin-top"><i class="fa fa-arrow-up"></i> {{__('Content margin top')}}</label>
                                    <input type="number" min="0"  id="content-margin-top" name="content-margin-top" class="form-control" value="{{$reports_settings['content-margin-top']}}"  required>
                                  </div>

                                  <div class="col-lg-3">
                                      <label for="content-margin-bottom"><i class="fa fa-arrow-down"></i> {{__('Content margin bottom')}}</label>
                                      <input type="number" min="0"  id="content-margin-bottom" name="content-margin-bottom" class="form-control" value="{{$reports_settings['content-margin-bottom']}}"  required>
                                  </div>

                                </div>



                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                          {{__('Report Header')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-12">
                                            <label for="reports_show_header_image">{{__('Show Header Image')}}</label>
                                            <br>
                                            <label class="switch">
                                              <input type="checkbox" name="show_header_image" id="reports_show_header_image" @if($reports_settings['show_header_image']) checked @endif>
                                              <span class="slider round"></span>
                                            </label>
                                          </div>
                                          <div class="col-lg-12">
                                            <div class="form-group">
                                              <label for="">{{__('Upload Header Image')}} ( {{__('Extension')}}: jpg )</label>
                                              <div class="input-group">
                                                <div class="custom-file">
                                                  <input type="file" name="report_header_image" class="custom-file-input" id="report_header_image">
                                                  <label class="custom-file-label" for="report_header_image">{{__('Select report header')}}</label>
                                                </div>
                                                <div class="input-group-append">
                                                  <span class="input-group-text" id="">
                                                    <a href="{{url('img/report_header.jpg')}}" data-toggle="lightbox" data-title="Report header">
                                                      <i class="fa fa-image"></i>
                                                    </a>
                                                  </span>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                          {{__('Watermark')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-12">
                                            <label for="reports_show_background_image">{{__('Show Watermark')}}</label>
                                            <br>
                                            <label class="switch">
                                              <input type="checkbox" name="show_background_image" id="reports_show_background_image" @if($reports_settings['show_background_image']) checked @endif>
                                              <span class="slider round"></span>
                                            </label>
                                          </div>
                                          <div class="col-lg-12">
                                            <div class="form-group">
                                              <label for="">{{__('Upload Watermark')}} ( {{__('Extension')}}: png )</label>
                                              <div class="input-group">
                                                <div class="custom-file">
                                                  <input type="file" name="report_background_image" class="custom-file-input" id="report_background_image">
                                                  <label class="custom-file-label" for="report_background_image">{{__('Select report background')}}</label>
                                                </div>
                                                <div class="input-group-append">
                                                  <span class="input-group-text" id="">
                                                    <a href="{{url('img/report_background.png')}}" data-toggle="lightbox" data-title="Report background">
                                                      <i class="fa fa-image"></i>
                                                    </a>
                                                  </span>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                          {{__('Report Footer')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-12">
                                            <label for="reports_show_footer_image">{{__('Show Footer Image')}}</label>
                                            <br>
                                            <label class="switch">
                                              <input type="checkbox" name="show_footer_image" id="reports_show_footer_image" @if($reports_settings['show_footer_image']) checked @endif>
                                              <span class="slider round"></span>
                                            </label>
                                          </div>
                                          <div class="col-lg-12">
                                            <div class="form-group">
                                              <label for="">{{__('Upload Footer Image')}} ( {{__('Extension')}}: .jpg )</label>
                                              <div class="input-group">
                                                <div class="custom-file">
                                                  <input type="file" name="report_footer_image" class="custom-file-input" id="report_footer_image">
                                                  <label class="custom-file-label" for="report_footer_image">{{__('Select report footer')}}</label>
                                                </div>
                                                <div class="input-group-append">
                                                  <span class="input-group-text" id="">
                                                    <a href="{{url('img/report_footer.jpg')}}" data-toggle="lightbox" data-title="Report footer">
                                                      <i class="fa fa-image"></i>
                                                    </a>
                                                  </span>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>







                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                            {{__('Branch Name')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-4">
                                            <div class="form-group">
                                              <label for="branch_name_color">{{__('Color')}}</label>
                                              <div class="input-group">
                                                  <input id="branch_name_color" type="text" class="form-control color_input" name="branch_name[color]" value="{{$reports_settings['branch_name']['color']}}" required>
                                                  <div class="input-group-append color_tool">
                                                      <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['branch_name']['color']}}"></i></span>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-lg-4">
                                            <label for="branch_name_font_family">{{__('Font type')}}</label>
                                            <select class="form-control" name="branch_name[font-family]" id="branch_name_font_family" required>
                                              @include('admin.settings.fonts')
                                            </select>
                                          </div>

                                          <div class="col-lg-4">
                                            <label for="branch_name_font_size">{{__('Font size')}}</label>
                                            <input type="number" class="form-control" name="branch_name[font-size]" id="branch_name_font_size" min="1" value="{{$reports_settings['branch_name']['font-size']}}" required>
                                          </div>

                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                </div>

                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                            {{__('Branch Info')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-4">
                                            <div class="form-group">
                                              <label for="branch_info_color">{{__('Color')}}</label>
                                              <div class="input-group">
                                                  <input id="branch_info_color" type="text" class="form-control color_input" name="branch_info[color]" value="{{$reports_settings['branch_info']['color']}}" required>
                                                  <div class="input-group-append color_tool">
                                                      <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['branch_info']['color']}}"></i></span>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-lg-4">
                                            <label for="branch_info_font_family">{{__('Font type')}}</label>
                                            <select class="form-control" name="branch_info[font-family]" id="branch_info_font_family" required>
                                              @include('admin.settings.fonts')
                                            </select>
                                          </div>

                                          <div class="col-lg-4">
                                            <label for="branch_info_font_size">{{__('Font size')}}</label>
                                            <input type="number" class="form-control" name="branch_info[font-size]" id="branch_info_font_size" min="1" value="{{$reports_settings['branch_info']['font-size']}}" required>
                                          </div>

                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                </div>

                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                            {{__('Patient Title')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-4">
                                            <div class="form-group">
                                              <label for="patient_title_color">{{__('Color')}}</label>
                                              <div class="input-group">
                                                  <input id="patient_title_color" type="text" class="form-control color_input" name="patient_title[color]" value="{{$reports_settings['patient_title']['color']}}" required>
                                                  <div class="input-group-append color_tool">
                                                      <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['patient_title']['color']}}"></i></span>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-lg-4">
                                            <label for="patient_title_font_family">{{__('Font type')}}</label>
                                            <select class="form-control" name="patient_title[font-family]" id="patient_title_font_family" required>
                                                @include('admin.settings.fonts')
                                            </select>
                                          </div>

                                          <div class="col-lg-4">
                                            <label for="patient_title_font_size">{{__('Font size')}}</label>
                                            <input type="number" class="form-control" name="patient_title[font-size]" id="patient_title_font_size" min="1" value="{{$reports_settings['patient_title']['font-size']}}" required>
                                          </div>

                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                </div>

                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                            {{__('Patient Info')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-4">
                                            <div class="form-group">
                                              <label for="patient_data_color">{{__('Color')}}</label>
                                              <div class="input-group">
                                                  <input id="patient_data_color" type="text" class="form-control color_input" name="patient_data[color]" value="{{$reports_settings['patient_data']['color']}}" required>
                                                  <div class="input-group-append color_tool">
                                                      <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['patient_data']['color']}}"></i></span>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="patient_data_font_family">{{__('Font type')}}</label>
                                            <select class="form-control" name="patient_data[font-family]" id="patient_data_font_family" required>
                                              @include('admin.settings.fonts')
                                            </select>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="patient_data_font_size">{{__('Font size')}}</label>
                                            <input type="number" class="form-control" name="patient_data[font-size]" id="patient_data_font_size" min="1" value="{{$reports_settings['patient_data']['font-size']}}" required>
                                          </div>
                              
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              
                                </div>

                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                            {{__('Test Title')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-4">
                                            <div class="form-group">
                                              <label for="test_title_color">{{__('Color')}}</label>
                                              <div class="input-group">
                                                  <input id="test_title_color" type="text" class="form-control color_input" name="test_title[color]" value="{{$reports_settings['test_title']['color']}}" required>
                                                  <div class="input-group-append color_tool">
                                                      <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['test_title']['color']}}"></i></span>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="test_title_font_family">{{__('Font type')}}</label>
                                            <select class="form-control" name="test_title[font-family]" id="test_title_font_family" required>
                                              @include('admin.settings.fonts')
                                            </select>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="test_title_font_size">{{__('Font size')}}</label>
                                            <input type="number" class="form-control" name="test_title[font-size]" id="test_title_font_size" min="1" value="{{$reports_settings['test_title']['font-size']}}" required>
                                          </div>
                              
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              
                                </div>

                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                            {{__('Test Name')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-4">
                                            <div class="form-group">
                                              <label for="test_name_color">{{__('Color')}}</label>
                                              <div class="input-group">
                                                  <input id="test_name_color" type="text" class="form-control color_input" name="test_name[color]" value="{{$reports_settings['test_name']['color']}}" required>
                                                  <div class="input-group-append color_tool">
                                                      <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['test_name']['color']}}"></i></span>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="test_name_font_family">{{__('Font type')}}</label>
                                            <select class="form-control" name="test_name[font-family]" id="test_name_font_family" required>
                                              @include('admin.settings.fonts')
                                            </select>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="test_name_font_size">{{__('Font size')}}</label>
                                            <input type="number" class="form-control" name="test_name[font-size]" id="test_name_font_size" min="1" value="{{$reports_settings['test_name']['font-size']}}" required>
                                          </div>
                              
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              
                                </div>

                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                            {{__('Test Head')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-4">
                                            <div class="form-group">
                                              <label for="test_head_color">{{__('Color')}}</label>
                                              <div class="input-group">
                                                  <input id="test_head_color" type="text" class="form-control color_input" name="test_head[color]" value="{{$reports_settings['test_head']['color']}}" required>
                                                  <div class="input-group-append color_tool">
                                                      <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['test_head']['color']}}"></i></span>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="test_head_font_family">{{__('Font type')}}</label>
                                            <select class="form-control" name="test_head[font-family]" id="test_head_font_family" required>
                                              @include('admin.settings.fonts')
                                            </select>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="test_head_font_size">{{__('Font size')}}</label>
                                            <input type="number" class="form-control" name="test_head[font-size]" id="test_head_font_size" min="1" value="{{$reports_settings['test_head']['font-size']}}" required>
                                          </div>
                              
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              
                                </div>

                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                            {{__('Result')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-4">
                                            <div class="form-group">
                                              <label for="result_color">{{__('Color')}}</label>
                                              <div class="input-group">
                                                  <input id="result_color" type="text" class="form-control color_input" name="result[color]" value="{{$reports_settings['result']['color']}}" required>
                                                  <div class="input-group-append color_tool">
                                                      <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['result']['color']}}"></i></span>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="result_font_family">{{__('Font type')}}</label>
                                            <select class="form-control" name="result[font-family]" id="result_font_family" required>
                                              @include('admin.settings.fonts')
                                            </select>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="result_font_size">{{__('Font size')}}</label>
                                            <input type="number" class="form-control" name="result[font-size]" id="result_font_size" min="1" value="{{$reports_settings['result']['font-size']}}" required>
                                          </div>
                              
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              
                                </div>

                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                            {{__('Unit')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-4">
                                            <div class="form-group">
                                              <label for="unit_color">{{__('Color')}}</label>
                                              <div class="input-group">
                                                  <input id="unit_color" type="text" class="form-control color_input" name="unit[color]" value="{{$reports_settings['unit']['color']}}" required>
                                                  <div class="input-group-append color_tool">
                                                      <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['unit']['color']}}"></i></span>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="unit_font_family">{{__('Font type')}}</label>
                                            <select class="form-control" name="unit[font-family]" id="unit_font_family" required>
                                              @include('admin.settings.fonts')
                                            </select>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="unit_font_size">{{__('Font size')}}</label>
                                            <input type="number" class="form-control" name="unit[font-size]" id="unit_font_size" min="1" value="{{$reports_settings['unit']['font-size']}}" required>
                                          </div>
                              
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              
                                </div>

                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                            {{__('Reference Range')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-4">
                                            <div class="form-group">
                                              <label for="reference_range_color">{{__('Color')}}</label>
                                              <div class="input-group">
                                                  <input id="reference_range_color" type="text" class="form-control color_input" name="reference_range[color]" value="{{$reports_settings['reference_range']['color']}}" required>
                                                  <div class="input-group-append reference_range_color">
                                                      <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['reference_range']['color']}}"></i></span>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="reference_range_font_family">{{__('Font type')}}</label>
                                            <select class="form-control" name="reference_range[font-family]" id="reference_range_font_family" required>
                                              @include('admin.settings.fonts')
                                            </select>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="reference_range_font_size">{{__('Font size')}}</label>
                                            <input type="number" class="form-control" name="reference_range[font-size]" id="reference_range_font_size" min="1" value="{{$reports_settings['reference_range']['font-size']}}" required>
                                          </div>
                              
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              
                                </div>

                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                            {{__('Status')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-4">
                                            <div class="form-group">
                                              <label for="status_color">{{__('Color')}}</label>
                                              <div class="input-group">
                                                  <input id="status_color" type="text" class="form-control color_input" name="status[color]" value="{{$reports_settings['status']['color']}}" required>
                                                  <div class="input-group-append status_color">
                                                      <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['status']['color']}}"></i></span>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="status_font_family">{{__('Font type')}}</label>
                                            <select class="form-control" name="status[font-family]" id="status_font_family" required>
                                              @include('admin.settings.fonts')
                                            </select>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="status_font_size">{{__('Font size')}}</label>
                                            <input type="number" class="form-control" name="status[font-size]" id="status_font_size" min="1" value="{{$reports_settings['status']['font-size']}}" required>
                                          </div>
                              
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              
                                </div>

                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                            {{__('Comment')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-4">
                                            <div class="form-group">
                                              <label for="comment_color">{{__('Color')}}</label>
                                              <div class="input-group">
                                                  <input id="comment_color" type="text" class="form-control color_input" name="comment[color]" value="{{$reports_settings['comment']['color']}}" required>
                                                  <div class="input-group-append comment_color">
                                                      <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['comment']['color']}}"></i></span>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="comment_font_family">{{__('Font type')}}</label>
                                            <select class="form-control" name="comment[font-family]" id="comment_font_family" required>
                                              @include('admin.settings.fonts')
                                            </select>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="comment_font_size">{{__('Font size')}}</label>
                                            <input type="number" class="form-control" name="comment[font-size]" id="comment_font_size" min="1" value="{{$reports_settings['comment']['font-size']}}" required>
                                          </div>
                              
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              
                                </div>

                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                            {{__('Signature')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-4">
                                            <div class="form-group">
                                              <label for="signature_color">{{__('Color')}}</label>
                                              <div class="input-group">
                                                  <input id="signature_color" type="text" class="form-control color_input" name="signature[color]" value="{{$reports_settings['signature']['color']}}" required>
                                                  <div class="input-group-append signature_color">
                                                      <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['signature']['color']}}"></i></span>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="signature_font_family">{{__('Font type')}}</label>
                                            <select class="form-control" name="signature[font-family]" id="signature_font_family" required>
                                              @include('admin.settings.fonts')
                                            </select>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="signature_font_size">{{__('Font size')}}</label>
                                            <input type="number" class="form-control" name="signature[font-size]" id="signature_font_size" min="1" value="{{$reports_settings['signature']['font-size']}}" required>
                                          </div>
                              
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              
                                </div>

                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                            {{__('Antibiotic Name')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-4">
                                            <div class="form-group">
                                              <label for="antibiotic_name_color">{{__('Color')}}</label>
                                              <div class="input-group">
                                                  <input id="antibiotic_name_color" type="text" class="form-control color_input" name="antibiotic_name[color]" value="{{$reports_settings['antibiotic_name']['color']}}" required>
                                                  <div class="input-group-append antibiotic_name_color">
                                                      <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['antibiotic_name']['color']}}"></i></span>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="antibiotic_name_font_family">{{__('Font type')}}</label>
                                            <select class="form-control" name="antibiotic_name[font-family]" id="antibiotic_name_font_family" required>
                                              @include('admin.settings.fonts')
                                            </select>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="antibiotic_name_font_size">{{__('Font size')}}</label>
                                            <input type="number" class="form-control" name="antibiotic_name[font-size]" id="antibiotic_name_font_size" min="1" value="{{$reports_settings['antibiotic_name']['font-size']}}" required>
                                          </div>
                              
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              
                                </div>

                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                            {{__('Sensitivity')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-4">
                                            <div class="form-group">
                                              <label for="sensitivity_color">{{__('Color')}}</label>
                                              <div class="input-group">
                                                  <input id="sensitivity_color" type="text" class="form-control color_input" name="sensitivity[color]" value="{{$reports_settings['sensitivity']['color']}}" required>
                                                  <div class="input-group-append sensitivity_color">
                                                      <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['sensitivity']['color']}}"></i></span>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="sensitivity_font_family">{{__('Font type')}}</label>
                                            <select class="form-control" name="sensitivity[font-family]" id="sensitivity_font_family" required>
                                              @include('admin.settings.fonts')
                                            </select>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="sensitivity_font_size">{{__('Font size')}}</label>
                                            <input type="number" class="form-control" name="sensitivity[font-size]" id="sensitivity_font_size" min="1" value="{{$reports_settings['sensitivity']['font-size']}}" required>
                                          </div>
                              
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              
                                </div>
                                
                                <div class="row mt-3">
                                  <div class="col-lg-12">
                                    <div class="card card-primary">
                                      <div class="card-header">
                                        <h5 class="card-title">
                                            {{__('Commercial Name')}}
                                        </h5>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                          <div class="col-lg-4">
                                            <div class="form-group">
                                              <label for="commercial_name_color">{{__('Color')}}</label>
                                              <div class="input-group">
                                                  <input id="commercial_name_color" type="text" class="form-control color_input" name="commercial_name[color]" value="{{$reports_settings['commercial_name']['color']}}" required>
                                                  <div class="input-group-append commercial_name_color">
                                                      <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['commercial_name']['color']}}"></i></span>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="commercial_name_font_family">{{__('Font type')}}</label>
                                            <select class="form-control" name="commercial_name[font-family]" id="commercial_name_font_family" required>
                                              @include('admin.settings.fonts')
                                            </select>
                                          </div>
                              
                                          <div class="col-lg-4">
                                            <label for="commercial_name_font_size">{{__('Font size')}}</label>
                                            <input type="number" class="form-control" name="commercial_name[font-size]" id="commercial_name_font_size" min="1" value="{{$reports_settings['commercial_name']['font-size']}}" required>
                                          </div>
                              
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 mt-3">
                                      <div class="card card-primary">
                                        <div class="card-header">
                                          <h5 class="card-title">
                                            <label for="report_footer">{{__('Footer')}}</label>
                                          </h5>
                                        </div>
                                        <div class="card-body">
                                          <div class="row">

                                              <div class="col-lg-12">
                                                
                                                <div class="row">

                                                  <div class="col-lg-3">
                                                    <div class="form-group">
                                                      <label for="report_footer_color">{{__('Color')}}</label>
                                                      <div class="input-group">
                                                          <input id="report_footer_color" type="text" class="form-control color_input" name="report_footer[color]" value="{{$reports_settings['report_footer']['color']}}" required>
                                                          <div class="input-group-append report_footer_color">
                                                              <span class="input-group-text"><i class="fas fa-square" style="color: {{$reports_settings['report_footer']['color']}}"></i></span>
                                                          </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                      
                                                  <div class="col-lg-3">
                                                    <label for="report_footer_font_family">{{__('Font type')}}</label>
                                                    <select class="form-control" name="report_footer[font-family]" id="report_footer_font_family" required>
                                                      @include('admin.settings.fonts')
                                                    </select>
                                                  </div>
                                      
                                                  <div class="col-lg-3">
                                                    <label for="report_footer_font_size">{{__('Font size')}}</label>
                                                    <input type="number" class="form-control" name="report_footer[font-size]" id="report_footer_font_size" min="1" value="{{$reports_settings['report_footer']['font-size']}}" required>
                                                  </div>

                                                  <div class="col-lg-3">
                                                    <label for="report_footer_text_align">{{__('Align')}}</label>
                                                    <select class="form-control" name="report_footer[text-align]" id="report_footer_text_align" required>
                                                      <option value="center" @if($reports_settings['report_footer']['text-align']=='center') selected @endif>{{__('Center')}}</option>
                                                      <option value="left" @if($reports_settings['report_footer']['text-align']=='left') selected @endif>{{__('Left')}}</option>
                                                      <option value="right" @if($reports_settings['report_footer']['text-align']=='right') selected @endif>{{__('Right')}}</option>
                                                    </select>
                                                  </div>
                                                </div>

                                              </div>

                                              <div class="col-lg-12">
                                                <div class="form-group">
                                                  <textarea name="footer" id="report_footer" cols="30" rows="5" class="form-control">{{$reports_settings['footer']}}</textarea>
                                                </div>
                                              </div>

                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                        
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button class="btn btn-primary"> <i class="fa fa-check"></i> {{__('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- \Reports Settings -->

                <!-- Menu Settings -->
                <div class="tab-pane text-left fade show" id="menu_settings" role="tabpanel" aria-labelledby="menu_settings">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-bars mr-1"></i> {{__('Menu Settings')}}</h3>
                        </div>
                        <form action="{{ route('admin.settings.menus_submit') }}" method="POST" id="menu-settings-form">
                            @csrf
                            <div class="card-body p-3">
                                <div class="alert alert-info py-2 small mb-3">
                                    <i class="fas fa-info-circle mr-1"></i> {{__('Drag and drop items to reorder and nest them. Expand items to edit details.')}}
                                </div>

                                <div class="row">
                                    <!-- Sidebar: Add Items -->
                                    <div class="col-lg-4">
                                        <div id="menu-sidebar-accordion">
                                            <!-- Custom Links -->
                                            <div class="card card-outline card-secondary mb-2">
                                                <div class="card-header p-2" id="headingCustom">
                                                    <h6 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left p-0 font-weight-bold text-dark" type="button" data-toggle="collapse" data-target="#collapseCustom" aria-expanded="true">
                                                            {{__('Custom Links')}} <i class="fas fa-chevron-down float-right mt-1 small"></i>
                                                        </button>
                                                    </h6>
                                                </div>
                                                <div id="collapseCustom" class="collapse show" data-parent="#menu-sidebar-accordion">
                                                    <div class="card-body p-2">
                                                        <div class="form-group mb-2">
                                                            <label class="small">{{__('URL')}}</label>
                                                            <input type="text" id="custom-url" class="form-control form-control-sm" placeholder="https://...">
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label class="small">{{__('Label')}}</label>
                                                            <input type="text" id="custom-label" class="form-control form-control-sm" placeholder="{{__('Menu Item')}}">
                                                        </div>
                                                        <button type="button" class="btn btn-xs btn-primary float-right add-to-menu" data-type="custom">{{__('Add to Menu')}}</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Pages -->
                                            <div class="card card-outline card-secondary mb-2">
                                                <div class="card-header p-2" id="headingPages">
                                                    <h6 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left p-0 font-weight-bold text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapsePages">
                                                            {{__('Pages')}} <i class="fas fa-chevron-down float-right mt-1 small"></i>
                                                        </button>
                                                    </h6>
                                                </div>
                                                <div id="collapsePages" class="collapse" data-parent="#menu-sidebar-accordion">
                                                    <div class="card-body p-2 max-h-200 overflow-auto">
                                                        @foreach($pages as $page)
                                                        <div class="custom-control custom-checkbox mb-1">
                                                            <input class="custom-control-input sidebar-check" type="checkbox" id="page-{{$page->id}}" data-label="{{$page->title}}" data-url="/page/{{$page->slug}}">
                                                            <label for="page-{{$page->id}}" class="custom-control-label small font-weight-normal">{{$page->title}}</label>
                                                        </div>
                                                        @endforeach
                                                        <hr class="my-2">
                                                        <button type="button" class="btn btn-xs btn-primary float-right add-to-menu" data-type="pages">{{__('Add to Menu')}}</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Services -->
                                            <div class="card card-outline card-secondary mb-2">
                                                <div class="card-header p-2" id="headingServices">
                                                    <h6 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left p-0 font-weight-bold text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapseServices">
                                                            {{__('Services')}} <i class="fas fa-chevron-down float-right mt-1 small"></i>
                                                        </button>
                                                    </h6>
                                                </div>
                                                <div id="collapseServices" class="collapse" data-parent="#menu-sidebar-accordion">
                                                    <div class="card-body p-2 max-h-200 overflow-auto">
                                                        @foreach($services as $service)
                                                        <div class="custom-control custom-checkbox mb-1">
                                                            <input class="custom-control-input sidebar-check" type="checkbox" id="service-{{$service->id}}" data-label="{{$service->name}}" data-url="/services/{{$service->id}}">
                                                            <label for="service-{{$service->id}}" class="custom-control-label small font-weight-normal">{{$service->name}}</label>
                                                        </div>
                                                        @endforeach
                                                        <hr class="my-2">
                                                        <button type="button" class="btn btn-xs btn-primary float-right add-to-menu" data-type="services">{{__('Add to Menu')}}</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Doctors -->
                                            <div class="card card-outline card-secondary mb-2">
                                                <div class="card-header p-2">
                                                    <h6 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left p-0 font-weight-bold text-dark collapsed" type="button" data-toggle="collapse" data-target="#collapseDoctors">
                                                            {{__('Doctors')}} <i class="fas fa-chevron-down float-right mt-1 small"></i>
                                                        </button>
                                                    </h6>
                                                </div>
                                                <div id="collapseDoctors" class="collapse" data-parent="#menu-sidebar-accordion">
                                                    <div class="card-body p-2 max-h-200 overflow-auto">
                                                        @foreach($doctors as $doctor)
                                                        <div class="custom-control custom-checkbox mb-1">
                                                            <input class="custom-control-input sidebar-check" type="checkbox" id="doctor-{{$doctor->id}}" data-label="{{$doctor->name}}" data-url="/doctor/{{$doctor->id}}">
                                                            <label for="doctor-{{$doctor->id}}" class="custom-control-label small font-weight-normal">{{$doctor->name}}</label>
                                                        </div>
                                                        @endforeach
                                                        <hr class="my-2">
                                                        <button type="button" class="btn btn-xs btn-primary float-right add-to-menu" data-type="doctors">{{__('Add to Menu')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Main: Menu Structure -->
                                    <div class="col-lg-8">
                                        <div class="card card-outline card-primary">
                                            <div class="card-header py-2 px-3">
                                                <h6 class="card-title font-weight-bold small text-uppercase">{{__('Menu Structure')}}</h6>
                                            </div>
                                            <div class="card-body p-3 bg-light min-h-400">
                                                <ul class="wp-menu-list sortable-list" id="main-menu-builder" data-prefix="main_menu">
                                                    @foreach(($menu_settings['main_menu'] ?? []) as $item)
                                                        @include('admin.settings.partials.menu_item', ['item' => $item, 'prefix' => 'main_menu', 'is_child' => false])
                                                    @endforeach
                                                </ul>
                                                
                                                <div class="mt-4 pt-3 border-top">
                                                    <h6 class="font-weight-bold small text-uppercase">{{__('Footer Menu')}} ({{__('Single Level')}})</h6>
                                                    <ul class="wp-menu-list sortable-list no-nesting" id="footer-menu-builder" data-prefix="footer_menu">
                                                        @foreach(($menu_settings['footer_menu'] ?? []) as $item)
                                                            @include('admin.settings.partials.menu_item', ['item' => $item, 'prefix' => 'footer_menu', 'is_child' => false, 'no_nesting' => true])
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary float-right"><i class="fa fa-check mr-1"></i> {{__('Save Menu Changes')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- \Menu Settings -->

            </div>
          </div>
    </div>
</div>

@endsection

@section('scripts')
    <!-- Colorpicker -->
    <script src="{{url('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{url('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- Switch -->
    <script src="{{url('plugins/swtich-netliva/js/netliva_switch.js')}}"></script>
    <script src="{{url('js/admin/settings.js')}}"></script>
    <script src="{{url('plugins/ekko-lightbox/ekko-lightbox.js')}}"></script>
    <!-- jQuery UI is already included in partials.scripts -->

    <script>
      (function ($) {
        "use strict";

        $(function () {
          // Initialize Sortable with nesting support
          function initSortable() {
            $(".sortable-list").each(function() {
                if ($(this).data('ui-sortable')) {
                    $(this).sortable('refresh');
                } else {
                    $(this).sortable({
                        connectWith: ".sortable-list",
                        handle: ".wp-menu-item-handle",
                        placeholder: "ui-sortable-placeholder",
                        tolerance: "pointer",
                        cursor: "move",
                        opacity: 0.7,
                        receive: function(event, ui) {
                            // Prevent nesting in footer
                            if ($(this).hasClass('no-nesting') && ui.item.find('ul li').length > 0) {
                                $(ui.sender).sortable('cancel');
                                if (typeof toastr_error === 'function') toastr_error("{{__('Nesting is not allowed in Footer Menu')}}");
                            }
                        }
                    });
                }
            });
          }

          initSortable();

          // Toggle Details
          $(document).on('click', '.toggle-menu-details', function(e) {
            e.preventDefault();
            var $item = $(this).closest('.wp-menu-item');
            $item.find('.wp-menu-item-details').first().slideToggle(200);
            $(this).toggleClass('expanded');
          });

          // Live update labels
          $(document).on('input', '.edit-menu-label', function() {
            var $item = $(this).closest('.wp-menu-item');
            var val = $(this).val() || "{{__('Menu Item')}}";
            $item.find('.menu-item-title').first().text(val);
            $item.data('label', $(this).val());
          });

          $(document).on('change', '.edit-menu-url', function() {
            $(this).closest('.wp-menu-item').data('url', $(this).val());
          });

          $(document).on('change', '.edit-menu-new-tab', function() {
            $(this).closest('.wp-menu-item').data('new-tab', this.checked ? "1" : "0");
          });

          // Remove Item
          $(document).on('click', '.remove-menu-item', function() {
            var $item = $(this).closest('.wp-menu-item');
            $item.fadeOut(200, function() { $(this).remove(); });
          });

          // Add to Menu
          $('.add-to-menu').on('click', function() {
            var type = $(this).data('type');
            var $target = $('#main-menu-builder');
            
            if (type === 'custom') {
              var label = $('#custom-label').val();
              var url = $('#custom-url').val();
              if (!label || !url) {
                  if (typeof toastr_error === 'function') toastr_error("{{__('Label and URL are required')}}");
                  return;
              }
              addItemToMenu($target, label, url);
              $('#custom-label, #custom-url').val('');
            } else {
              var $checks = $(this).closest('.collapse').find('.sidebar-check:checked');
              if ($checks.length === 0) {
                  if (typeof toastr_error === 'function') toastr_error("{{__('Select at least one item')}}");
                  return;
              }
              
              $checks.each(function() {
                addItemToMenu($target, $(this).data('label'), $(this).data('url'));
                $(this).prop('checked', false);
              });
            }
          });

          function addItemToMenu($list, label, url) {
            var id = 'new_' + Math.random().toString(36).substr(2, 9);
            var html = `
              <li class="wp-menu-item mb-2" data-label="${label}" data-url="${url}" data-new-tab="0">
                <div class="wp-menu-item-handle d-flex align-items-center justify-content-between p-2 bg-white border rounded shadow-sm" style="cursor: move;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-arrows-alt text-muted mr-2 handle-icon"></i>
                        <span class="menu-item-title font-weight-bold small">${label}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge badge-light text-muted border mr-2 small font-weight-normal"></span>
                        <button type="button" class="btn btn-xs btn-link p-0 text-dark toggle-menu-details">
                            <i class="fas fa-chevron-down transition-icon"></i>
                        </button>
                    </div>
                </div>
                <div class="wp-menu-item-details bg-white border border-top-0 rounded-bottom p-3 shadow-sm" style="display: none;">
                    <div class="form-group mb-2">
                        <label class="small mb-1">{{ __('Navigation Label') }}</label>
                        <input type="text" class="form-control form-control-sm edit-menu-label" value="${label}">
                    </div>
                    <div class="form-group mb-2">
                        <label class="small mb-1">{{ __('URL') }}</label>
                        <input type="text" class="form-control form-control-sm edit-menu-url" value="${url}">
                    </div>
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input edit-menu-new-tab" id="tab-${id}">
                        <label class="custom-control-label small font-weight-normal" for="tab-${id}">{{ __('Open link in a new tab') }}</label>
                    </div>
                    <div class="d-flex justify-content-between border-top pt-2">
                        <button type="button" class="btn btn-xs btn-link text-danger p-0 remove-menu-item">{{ __('Remove') }}</button>
                        <button type="button" class="btn btn-xs btn-link text-primary p-0 toggle-menu-details">{{ __('Cancel') }}</button>
                    </div>
                </div>
                <ul class="wp-menu-list sortable-list mt-2 ml-4"></ul>
              </li>`;
            
            var $newItem = $(html).hide();
            $list.append($newItem);
            $newItem.fadeIn(300);
            initSortable();
          }

          // Form Submission - Serialization
          $('#menu-settings-form').on('submit', function (e) {
            e.preventDefault();
            var form = this;
            
            // Clean old hidden inputs
            $(form).find('input[type="hidden"]').not('[name="_token"]').remove();

            // Serialize Main Menu
            $('#main-menu-builder > .wp-menu-item').each(function(index) {
                var $item = $(this);
                $(form).append(`<input type="hidden" name="main_menu[${index}][label]" value="${$item.data('label')}">`);
                $(form).append(`<input type="hidden" name="main_menu[${index}][url]" value="${$item.data('url')}">`);
                $(form).append(`<input type="hidden" name="main_menu[${index}][new_tab]" value="${$item.data('new-tab')}">`);
                
                // Children
                $item.find('> ul > .wp-menu-item').each(function(cIndex) {
                    var $child = $(this);
                    $(form).append(`<input type="hidden" name="main_menu[${index}][children][${cIndex}][label]" value="${$child.data('label')}">`);
                    $(form).append(`<input type="hidden" name="main_menu[${index}][children][${cIndex}][url]" value="${$child.data('url')}">`);
                    $(form).append(`<input type="hidden" name="main_menu[${index}][children][${cIndex}][new_tab]" value="${$child.data('new-tab')}">`);
                });
            });

            // Serialize Footer Menu
            $('#footer-menu-builder > .wp-menu-item').each(function(index) {
                var $item = $(this);
                $(form).append(`<input type="hidden" name="footer_menu[${index}][label]" value="${$item.data('label')}">`);
                $(form).append(`<input type="hidden" name="footer_menu[${index}][url]" value="${$item.data('url')}">`);
                $(form).append(`<input type="hidden" name="footer_menu[${index}][new_tab]" value="${$item.data('new-tab')}">`);
            });

            form.submit();
          });
        });
      })(jQuery);
    </script>
@endsection
