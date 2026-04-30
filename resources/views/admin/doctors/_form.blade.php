<div class="row">
  <div class="col-lg-4">
     <div class="form-group">
      <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="fa fa-layer-group"></i>
            </span>
          </div>
          <select class="form-control" name="doctor_specialty_id" required>
            <option value="">{{ __('Select Specialty') }}</option>
            @foreach($specialties as $specialty)
              <option value="{{ $specialty->id }}" @if(isset($doctor) && $doctor->doctor_specialty_id == $specialty->id) selected @endif>{{ $specialty->name }}</option>
            @endforeach
          </select>
      </div>
     </div>
  </div>

  <div class="col-lg-4">
      <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">
                <i class="fa fa-building"></i>
            </span>
          </div>
          <select class="form-control" name="doctor_department_id" required>
            <option value="">{{ __('Select Department') }}</option>
            @foreach($departments as $department)
              <option value="{{ $department->id }}" @if(isset($doctor) && $doctor->doctor_department_id == $department->id) selected @endif>{{ $department->name }}</option>
            @endforeach
          </select>
      </div>
     </div>
  </div>

  <div class="col-lg-4">
     <div class="form-group">
      <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">
                <i class="fa fa-user"></i>
            </span>
          </div>
          <input type="text" class="form-control" placeholder="{{__('Doctor Name')}}" name="name" id="name" @if(isset($doctor)) value="{{$doctor->name}}" @endif required>
      </div>
     </div>
  </div>

  <div class="col-lg-4">
      <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">
                  <i class="fas fa-envelope"></i>
                </span>
              </div>
              <input type="email" class="form-control" placeholder="{{__('Email Address')}}" name="email" id="email" @if(isset($doctor)) value="{{$doctor->email}}" @endif required>
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
            <input type="text" class="form-control" placeholder="{{__('Phone number')}}" name="phone" id="phone"  @if(isset($doctor)) value="{{$doctor->phone}}" @endif required>
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
                  <input type="text" class="form-control" placeholder="{{__('Address')}}" name="address" id="address" @if(isset($doctor)) value="{{$doctor->address}}" @endif required>
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
                    <i class="fas fa-percentage"></i>
                  </span>
                </div>
                <input type="number" class="form-control" placeholder="{{__('Commission')}}" name="commission" id="commission" @if(isset($doctor)) value="{{$doctor->commission}}" @endif min="0" max="100" required>
            </div>
        </div>
    </div>
  </div>

  <div class="col-lg-4">
      <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="fas fa-money-bill-wave"></i>
                  </span>
              </div>
              <input type="number" step="0.01" class="form-control" placeholder="{{__('In-Hub Consultation Fee')}}" name="consultation_fee" id="consultation_fee" @if(isset($doctor)) value="{{$doctor->consultation_fee}}" @endif min="0" required>
          </div>
      </div>
  </div>

  <div class="col-lg-4">
      <div class="form-group">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="fas fa-video"></i>
                  </span>
              </div>
              <input type="number" step="0.01" class="form-control" placeholder="{{__('Video Consultation Fee')}}" name="video_consultation_fee" id="video_consultation_fee" @if(isset($doctor)) value="{{$doctor->video_consultation_fee}}" @endif min="0">
          </div>
      </div>
  </div>

  <div class="col-lg-4">
    <div class="form-group">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
        </div>
        <input type="text" class="form-control" placeholder="{{__('Designation')}}" name="designation" id="designation" @if(isset($doctor)) value="{{$doctor->designation}}" @endif>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="form-group">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
        </div>
        <input type="text" class="form-control" placeholder="{{__('Qualification')}}" name="qualification" id="qualification" @if(isset($doctor)) value="{{$doctor->qualification}}" @endif>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="form-group">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-briefcase-medical"></i></span>
        </div>
        <input type="number" class="form-control" placeholder="{{__('Experience Years')}}" name="experience_years" id="experience_years" @if(isset($doctor)) value="{{$doctor->experience_years}}" @endif min="0">
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="form-group">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-image"></i></span>
        </div>
        <input type="file" class="form-control" name="image" id="image" accept="image/*">
      </div>
      @if(isset($doctor) && $doctor->image)
        <img src="{{ asset($doctor->image) }}" alt="Doctor Image" class="img-thumbnail" style="max-height:70px;">
      @endif
    </div>
  </div>

  <div class="col-lg-4">
      <div class="form-group mt-2">
          <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="video_consultation_available" name="video_consultation_available" value="1" @if(isset($doctor) ? $doctor->video_consultation_available : false) checked @endif>
              <label class="custom-control-label" for="video_consultation_available">{{ __('Video Consultation Available') }}</label>
          </div>
      </div>
      <div class="form-group mt-2">
          <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" @if(isset($doctor) ? $doctor->status : true) checked @endif>
              <label class="custom-control-label" for="status">{{ __('Active') }}</label>
          </div>
      </div>
  </div>

  <div class="col-lg-12">
      <div class="form-group">
          <textarea class="form-control" name="bio" rows="4" placeholder="{{__('Doctor Bio / Short Description')}}">@if(isset($doctor)){{$doctor->bio}}@endif</textarea>
      </div>
  </div>

  <div class="col-lg-12">
    <div class="card border">
      <div class="card-header bg-light">
        <strong>{{ __('Branch Schedules') }}</strong>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
                <th>{{ __('Enable') }}</th>
                <th>{{ __('Branch') }}</th>
                <th>{{ __('Consultant') }}</th>
                <th>{{ __('Schedule Days') }}</th>
                <th>{{ __('Schedule Time') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($branches as $index => $branch)
                @php
                  $savedSchedule = $doctorBranchSchedules[$branch->id] ?? null;
                  $oldRow = old("branch_schedules.$index", []);
                  $isEnabled = (bool) ($oldRow['enabled'] ?? $savedSchedule);
                @endphp
                <tr>
                  <td>
                    <input type="hidden" name="branch_schedules[{{ $index }}][branch_id]" value="{{ $branch->id }}">
                    <div class="custom-control custom-checkbox">
                      <input
                        type="checkbox"
                        class="custom-control-input"
                        id="branch_schedule_{{ $branch->id }}"
                        name="branch_schedules[{{ $index }}][enabled]"
                        value="1"
                        {{ $isEnabled ? 'checked' : '' }}
                      >
                      <label class="custom-control-label" for="branch_schedule_{{ $branch->id }}"></label>
                    </div>
                  </td>
                  <td>{{ $branch->title ?: $branch->name }}</td>
                  <td>
                    <input
                      type="text"
                      class="form-control"
                      name="branch_schedules[{{ $index }}][consultant]"
                      value="{{ $oldRow['consultant'] ?? ($savedSchedule->consultant ?? '') }}"
                      placeholder="{{ __('Consultant') }}"
                    >
                  </td>
                  <td>
                    <input
                      type="text"
                      class="form-control"
                      name="branch_schedules[{{ $index }}][schedule_days]"
                      value="{{ $oldRow['schedule_days'] ?? ($savedSchedule->schedule_days ?? '') }}"
                      placeholder="{{ __('Schedule Days') }}"
                    >
                  </td>
                  <td>
                    <input
                      type="text"
                      class="form-control"
                      name="branch_schedules[{{ $index }}][schedule_time]"
                      value="{{ $oldRow['schedule_time'] ?? ($savedSchedule->schedule_time ?? '') }}"
                      placeholder="{{ __('Schedule Time') }}"
                    >
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
