<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    /**
     * assign roles with custom permission logic
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $u = auth()->guard('admin')->user();
            $isSuper = ($u && $u->id == 1);

            $action = $request->route()->getActionMethod();

            if ($isSuper) {
                return $next($request);
            }

            if (in_array($action, ['index', 'show', 'ajax'])) {
                if (!$u->hasPermission('view_user')) {
                    abort(403, __('You don\'t have permission to view users list.'));
                }
            }

            if (in_array($action, ['create', 'store'])) {
                if (!$u->hasPermission('create_user')) {
                    abort(403, __('You don\'t have permission to create a new user.'));
                }
            }

            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_user')) {
                    abort(403, __('You don\'t have permission to edit a user.'));
                }
            }

            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_user')) {
                    abort(403, __('You don\'t have permission to delete a user.'));
                }
            }

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
    * get users datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model = User::query()->with('roles');

        return DataTables::of($model)
            ->addColumn('roles', function($user) {
                return view('admin.users._roles', compact('user'));
            })
            ->addColumn('action', function($user) {
                return view('admin.users._action', compact('user'));
            })
            ->rawColumns(['roles', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles=Role::all();
        return view('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            if ($request->has('roles')) {
                $user->roles()->sync($request->roles);
            }

            return to_route('admin.users.index')
                ->with('success', __('User created successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to create user: ') . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            $user->name = $request->name;
            $user->email = $request->email;
           
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }
            
            $user->save();

            if ($request->has('roles')) {
                $user->roles()->sync($request->roles);
            } else {
                $user->roles()->detach();
            }

            return to_route('admin.users.index')
                ->with('success', __('User updated successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to update user: ') . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->roles()->detach();
            $user->delete();

            return to_route('admin.users.index')
                ->with('success', __('User deleted successfully'));
        } catch (\Exception $e) {
            return back()->with('error', __('Failed to delete user: ') . $e->getMessage());
        }
    }
}
