@foreach($role->permissions as $permission)
    <span class="badge badge-primary mr-1">
        {{$permission->name}}
    </span>
@endforeach
