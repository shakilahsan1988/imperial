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
        //create new user
        $user=new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->save();

        //assign roles to user
        if($request->has('roles'))
        {
            foreach($request['roles'] as $role)
            {
                UserRole::firstOrCreate([
                    'user_id'=>$user['id'],
                    'role_id'=>$role
                ]);
                
            }
        }

        session()->flash('success',__('User created successfully'));

        return redirect()->route('admin.users.index');
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
        //update user
        $user=User::findOrFail($id);
        $user->name=$request->name;
        $user->email=$request->email;
       
        //optional updating password
        if(!empty($request['password']))
        {
            $user->password=bcrypt($request->password);
        }
        
        $user->save();

        //assign roles to user
        UserRole::where('user_id',$id)->delete();

        if($request->has('roles'))
        {
            foreach($request['roles'] as $role)
            {
                UserRole::firstOrCreate([
                    'user_id'=>$id,
                    'role_id'=>$role
                ]);

            }
        }

        session()->flash('success',__('User updated successfully'));

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::findorFail($id);
        
        //delete assigned roles
        UserRole::where('user_id',$id)->delete();

        //delete user finally
        $user->delete();

        session()->flash('success',__('User deleted successfully'));

        return redirect()->route('admin.users.index');
    }
}