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
        $model = Role::query()->with('permissions');

        return DataTables::of($model)
            ->addColumn('permissions', function($role) {
                return view('admin.roles._permissions', compact('role'));
            })
            ->addColumn('action', function($role) {
                return view('admin.roles._action', compact('role'));
            })
            ->rawColumns(['permissions', 'action'])
            ->make(true);
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
        try {
            $role=Role::create($request->except('_token','permissions'));
            
            if($request->has('permissions'))
            {
                $role->permissions()->createMany($request['permissions']);
            }

            return redirect()->route('admin.roles.index')->with('success', __('Role created successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to create role: ') . $e->getMessage());
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
        $role = Role::with('permissions.permission')->findOrFail($id);
        return view('admin.roles.show', compact('role'));
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
        try {
            $role=Role::findOrFail($id);

            $role->update($request->except('_token','_method','permissions'));

            RolePermission::where('role_id',$id)->delete();
            
            if($request->has('permissions'))
            {
                $role->permissions()->createMany($request['permissions']);
            }
            
            return redirect()->route('admin.roles.index')->with('success', __('Role updated successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to update role: ') . $e->getMessage());
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
            $role=Role::findOrFail($id);
            $role->permissions()->delete();
            $role->delete();
            return redirect()->route('admin.roles.index')->with('success', __('Role deleted successfully'));
        } catch (\Exception $e) {
            return back()->with('error', __('Failed to delete role: ') . $e->getMessage());
        }
    }
}