@foreach($user->roles as $role)
    <span class="badge badge-primary mr-1">
        {{$role->name}}
    </span>
@endforeach