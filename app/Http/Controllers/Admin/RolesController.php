<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\Module;
use App\Http\Requests\Admin\RoleRequest;
use Yajra\DataTables\Facades\DataTables; 
use Gate;

class RolesController extends Controller
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

            // রোল দেখার পারমিশন চেক
            if (in_array($action, ['index', 'show', 'ajax'])) {
                if (!$u->hasPermission('view_role')) {
                    abort(403, 'আপনার রোল তালিকা দেখার অনুমতি নেই।');
                }
            }

            // রোল তৈরি করার পারমিশন চেক
            if (in_array($action, ['create', 'store'])) {
                if (!$u->hasPermission('create_role')) {
                    abort(403, 'আপনার নতুন রোল তৈরি করার অনুমতি নেই।');
                }
            }

            // রোল এডিট করার পারমিশন চেক
            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_role')) {
                    abort(403, 'আপনার রোল এডিট করার অনুমতি নেই।');
                }
            }

            // রোল ডিলিট করার পারমিশন চেক
            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_role')) {
                    abort(403, 'আপনার রোল ডিলিট করার অনুমতি নেই।');
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
        return view('admin.roles.index');
    }

    /**
    * get roles datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model=Role::query()->with('permissions');

        return DataTables::eloquent($model)
        ->addColumn('permissions',function($role){
            return view('admin.roles._permissions',compact('role'));
        })
        ->addColumn('action',function($role){
            return view('admin.roles._action',compact('role'));
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
        $permissions=Permission::all();
        $modules=Module::all();
        return view('admin.roles.create',compact('permissions','modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role=Role::create($request->except('_token','permissions'));
        
        if($request->has('permissions'))
        {
            $role->permissions()->createMany($request['permissions']);
        }

        session()->flash('success',__('Role created successfully'));

        return redirect()->route('admin.roles.index');

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
        $role=Role::findOrFail($id);

        $permissions=Permission::all();

        $modules=Module::all();

        return view('admin.roles.edit',compact('role','permissions','modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $role=Role::findOrFail($id);

        $role->update($request->except('_token','_method','permissions'));

        RolePermission::where('role_id',$id)->delete();
        
        if($request->has('permissions'))
        {
            $role->permissions()->createMany($request['permissions']);
        }
        
        session()->flash('success',__('Role updated successfully'));

        return redirect()->route('admin.roles.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role=Role::findOrFail($id);

        $role->permissions()->delete();

        $role->delete();

        session()->flash('success',__('Role deleted successfully'));
        
        return redirect()->route('admin.roles.index');

    }
}