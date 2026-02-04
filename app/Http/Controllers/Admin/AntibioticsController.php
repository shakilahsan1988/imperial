<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Antibiotic;
use App\Http\Requests\Admin\AntibioticRequest;
use Yajra\DataTables\Facades\DataTables; 

class AntibioticsController extends Controller
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

            // Antibiotic দেখার পারমিশন চেক
            if (in_array($action, ['index', 'show', 'ajax'])) {
                if (!$u->hasPermission('view_antibiotic')) {
                    abort(403, 'আপনার এন্টিবায়োটিক তালিকা দেখার অনুমতি নেই।');
                }
            }

            // Antibiotic তৈরি করার পারমিশন চেক
            if (in_array($action, ['create', 'store'])) {
                if (!$u->hasPermission('create_antibiotic')) {
                    abort(403, 'আপনার নতুন এন্টিবায়োটিক তৈরি করার অনুমতি নেই।');
                }
            }

            // Antibiotic এডিট করার পারমিশন চেক
            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_antibiotic')) {
                    abort(403, 'আপনার এন্টিবায়োটিক এডিট করার অনুমতি নেই।');
                }
            }

            // Antibiotic ডিলিট করার পারমিশন চেক
            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_antibiotic')) {
                    abort(403, 'আপনার এন্টিবায়োটিক ডিলিট করার অনুমতি নেই।');
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
        return view('admin.antibiotics.index');
    }

    /**
    * get antibiotics datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model=Antibiotic::query();

        return DataTables::eloquent($model)
        ->addColumn('action',function($antibiotic){
            return view('admin.antibiotics._action',compact('antibiotic'));
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
        return view('admin.antibiotics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AntibioticRequest $request)
    {
        Antibiotic::create($request->except('_token'));
        session()->flash('success','Antibiotic saved successfully');
        return redirect()->route('admin.antibiotics.index');
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
        $antibiotic=Antibiotic::findOrFail($id);
        return view('admin.antibiotics.edit',compact('antibiotic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AntibioticRequest $request, $id)
    {
        $antibiotic=Antibiotic::findOrFail($id);
        $antibiotic->update($request->except('_token','_method'));
        session()->flash('success','Antibiotic updated successfully');
        return redirect()->route('admin.antibiotics.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $antibiotic=Antibiotic::findOrFail($id);
        $antibiotic->delete();
        session()->flash('success','Antibiotic deleted successfully');
        return redirect()->route('admin.antibiotics.index');
    }
}