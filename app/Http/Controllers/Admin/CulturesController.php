<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Culture;
use App\Http\Requests\Admin\CultureRequest;
use Yajra\DataTables\Facades\DataTables; 

class CulturesController extends Controller
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

            // কালচার দেখার পারমিশন চেক
            if (in_array($action, ['index', 'show', 'ajax'])) {
                if (!$u->hasPermission('view_culture')) {
                    abort(403, 'আপনার কালচার তালিকা দেখার অনুমতি নেই।');
                }
            }

            // কালচার তৈরি করার পারমিশন চেক
            if (in_array($action, ['create', 'store'])) {
                if (!$u->hasPermission('create_culture')) {
                    abort(403, 'আপনার নতুন কালচার তৈরি করার অনুমতি নেই।');
                }
            }

            // কালচার এডিট করার পারমিশন চেক
            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_culture')) {
                    abort(403, 'আপনার কালচার এডিট করার অনুমতি নেই।');
                }
            }

            // কালচার ডিলিট করার পারমিশন চেক
            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_culture')) {
                    abort(403, 'আপনার কালচার ডিলিট করার অনুমতি নেই।');
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
        $cultures=Culture::all();
        return view('admin.cultures.index',compact('cultures'));
    }

    /**
    * get cultures datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model=Culture::query();

        return DataTables::eloquent($model)
        ->editColumn('price',function($culture){
            return formated_price($culture['price']);
        })
        ->addColumn('action',function($culture){
            return view('admin.cultures._action',compact('culture'));
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
        return view('admin.cultures.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CultureRequest $request)
    {
        Culture::create($request->except('_token'));
        session()->flash('success','Culture saved successfully');
        return redirect()->route('admin.cultures.index');
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
        $culture=Culture::findOrFail($id);
        return view('admin.cultures.edit',compact('culture'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CultureRequest $request, $id)
    {
        $culture=Culture::findOrFail($id);
        $culture->update($request->except('_token','_method'));

        session()->flash('success','Culture updated successfully');
        return redirect()->route('admin.cultures.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $culture=Culture::findOrFail($id);
        $culture->delete();

        session()->flash('success','Culture deleted successfully');
        return redirect()->route('admin.cultures.index');
    }
}