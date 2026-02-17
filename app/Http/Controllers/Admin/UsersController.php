<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
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
            $isSuper = ($u && $u->id == 1); // Md. Shakil Ahsan (Super Admin) check

            // বর্তমান রাউটের অ্যাকশন অনুযায়ী পারমিশন চেক
            $action = $request->route()->getActionMethod();

            if ($isSuper) {
                return $next($request);
            }

            // ইউজার তালিকা দেখার পারমিশন চেক
            if (in_array($action, ['index', 'show', 'ajax'])) {
                if (!$u->hasPermission('view_user')) {
                    abort(403, 'আপনার ইউজার তালিকা দেখার অনুমতি নেই।');
                }
            }

            // নতুন ইউজার তৈরি করার পারমিশন চেক
            if (in_array($action, ['create', 'store'])) {
                if (!$u->hasPermission('create_user')) {
                    abort(403, 'আপনার নতুন ইউজার তৈরি করার অনুমতি নেই।');
                }
            }

            // ইউজার এডিট করার পারমিশন চেক
            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_user')) {
                    abort(403, 'আপনার ইউজারের তথ্য পরিবর্তন করার অনুমতি নেই।');
                }
            }

            // ইউজার ডিলিট করার পারমিশন চেক
            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_user')) {
                    abort(403, 'আপনার ইউজার মুছে ফেলার অনুমতি নেই।');
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
        $model=User::query()->with('roles');

        return DataTables::eloquent($model)
        ->addColumn('roles',function($user){
            return view('admin.users._roles',compact('user'));
        })
        ->addColumn('action',function($user){
            return view('admin.users._action',compact('user'));
        })
        ->toJson();
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
                foreach ($request->roles as $role) {
                    UserRole::firstOrCreate([
                        'user_id' => $user->id,
                        'role_id' => $role,
                    ]);
                }
            }

            return to_route('admin.users.index')
                ->with('success', __('User created successfully'));
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->with('error', __('Failed to create user. Please try again.'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::findOrFail($id);
        $roles=Role::all();

        return view('admin.users.edit',compact('user','roles'));
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

            UserRole::where('user_id', $id)->delete();

            if ($request->has('roles')) {
                foreach ($request->roles as $role) {
                    UserRole::firstOrCreate([
                        'user_id' => $id,
                        'role_id' => $role,
                    ]);
                }
            }

            return to_route('admin.users.index')
                ->with('success', __('User updated successfully'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', __('User not found.'));
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->with('error', __('Failed to update user. Please try again.'));
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
            
            UserRole::where('user_id', $id)->delete();
            $user->delete();

            return to_route('admin.users.index')
                ->with('success', __('User deleted successfully'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', __('User not found.'));
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', __('Failed to delete user. Please try again.'));
        }
    }
}