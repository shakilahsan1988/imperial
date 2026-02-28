<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="name">{{__('Name')}}</label>
            <input type="text" class="form-control" placeholder="{{__('Name')}}" name="name" id="name" @if(isset($user)) value="{{$user['name']}}" @endif required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="email">{{__('Email Address')}}</label>
            <input type="email" class="form-control" placeholder="{{__('Email Address')}}" name="email" id="email" @if(isset($user)) value="{{$user['email']}}" @endif required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="password">{{__('Password')}}</label>
            <input type="password" class="form-control" placeholder="{{__('Password')}}" name="password" id="password" @if(!isset($user)) required @endif>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="roles_assign">{{__('Roles')}}</label>
            <select name="roles[]" id="roles_assign" placeholder="{{__('Roles')}}" class="form-control select2" multiple required>
                @foreach($roles as $role)
                    <option value="{{$role['id']}}" @if(isset($user)&&$user->hasRole($role['name'])) selected @endif>{{$role['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
