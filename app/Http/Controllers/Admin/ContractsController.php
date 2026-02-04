<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contract;
use App\Http\Requests\Admin\ContractRequest;
use Yajra\DataTables\Facades\DataTables; 

class ContractsController extends Controller
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

            // কন্ট্রাক্ট দেখার পারমিশন চেক
            if (in_array($action, ['index', 'show', 'ajax'])) {
                if (!$u->hasPermission('view_contract')) {
                    abort(403, 'আপনার কন্ট্রাক্ট তালিকা দেখার অনুমতি নেই।');
                }
            }

            // কন্ট্রাক্ট তৈরি করার পারমিশন চেক
            if (in_array($action, ['create', 'store'])) {
                if (!$u->hasPermission('create_contract')) {
                    abort(403, 'আপনার নতুন কন্ট্রাক্ট তৈরি করার অনুমতি নেই।');
                }
            }

            // কন্ট্রাক্ট এডিট করার পারমিশন চেক
            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_contract')) {
                    abort(403, 'আপনার কন্ট্রাক্ট এডিট করার অনুমতি নেই।');
                }
            }

            // কন্ট্রাক্ট ডিলিট করার পারমিশন চেক
            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_contract')) {
                    abort(403, 'আপনার কন্ট্রাক্ট ডিলিট করার অনুমতি নেই।');
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
        return view('admin.contracts.index');
    }

    /**
    * get contracts datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model=Contract::query();

        return DataTables::eloquent($model)
        ->editColumn('discount',function($contract){
            return $contract['discount'].' %';
        })
        ->addColumn('action',function($contract){
            return view('admin.contracts._action',compact('contract'));
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
        return view('admin.contracts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractRequest $request)
    {
       Contract::create($request->except('_token','_method','files'));

       session()->flash('success',__('Contract created successfully'));

       return redirect()->route('admin.contracts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contract=Contract::findOrFail($id);

        return view('admin.contracts.edit',compact('contract'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContractRequest $request, $id)
    {
       $contract=Contract::findOrFail($id);
       $contract->update($request->except('_token','_method','files'));

       session()->flash('success',__('Contract updated successfully'));

       return redirect()->route('admin.contracts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contract=Contract::findOrFail($id);
        $contract->delete();

        session()->flash('success',__('Contract deleted successfully'));

        return redirect()->route('admin.contracts.index');
    }
}