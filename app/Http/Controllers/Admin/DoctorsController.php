<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\DoctorRequest;
use App\Http\Requests\Admin\ExcelImportRequest;
use App\Exports\DoctorExport;
use App\Imports\DoctorImport;
use App\Models\Doctor;
use Yajra\DataTables\Facades\DataTables; 
use Excel;

class DoctorsController extends Controller
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

            // ডাক্তার তালিকা দেখার পারমিশন চেক
            if (in_array($action, ['index', 'show', 'ajax', 'export', 'download_template'])) {
                if (!$u->hasPermission('view_doctor')) {
                    abort(403, 'আপনার ডাক্তার তালিকা দেখার অনুমতি নেই।');
                }
            }

            // ডাক্তার তৈরি বা ইমপোর্ট করার পারমিশন চেক
            if (in_array($action, ['create', 'store', 'import'])) {
                if (!$u->hasPermission('create_doctor')) {
                    abort(403, 'আপনার নতুন ডাক্তার যুক্ত করার অনুমতি নেই।');
                }
            }

            // ডাক্তার এডিট করার পারমিশন চেক
            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_doctor')) {
                    abort(403, 'আপনার ডাক্তারের তথ্য এডিট করার অনুমতি নেই।');
                }
            }

            // ডাক্তার ডিলিট করার পারমিশন চেক
            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_doctor')) {
                    abort(403, 'আপনার ডাক্তারের তথ্য ডিলিট করার অনুমতি নেই।');
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
        return view('admin.doctors.index');
    }

    /**
    * get antibiotics datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model=Doctor::query();

        return DataTables::eloquent($model)
        ->editColumn('commission',function($doctor){
            return $doctor['commission'].'%';
        })
        ->editColumn('total',function($doctor){
            return formated_price($doctor['total']);
        })
        ->editColumn('paid',function($doctor){
            return formated_price($doctor['paid']);
        })
        ->editColumn('due',function($doctor){
            return view('admin.doctors._due',compact('doctor'));
        })
        ->addColumn('action',function($doctor){
            return view('admin.doctors._action',compact('doctor'));
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
        return view('admin.doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoctorRequest $request)
    {
        $request['code']=doctor_code();

        Doctor::create($request->except('_token','_method'));

        session()->flash('success',__('Doctor created successfully'));

        return redirect()->route('admin.doctors.index');
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
        $doctor=Doctor::findOrFail($id);

        return view('admin.doctors.edit',compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DoctorRequest $request, $id)
    {
        $doctor=Doctor::findOrFail($id);
        $doctor->update($request->except('_token','_method'));

        session()->flash('success',__('Doctor updated successfully'));

        return redirect()->route('admin.doctors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doctor=Doctor::findOrFail($id);
        $doctor->delete();

        session()->flash('success',__('Doctor deleted successfully'));

        return redirect()->route('admin.doctors.index');
    }

    /**
    * Export doctors
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new DoctorExport, 'doctors.xlsx');
    }

    /**
    * Import doctors
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function import(ExcelImportRequest $request)
    {
        if($request->hasFile('import'))
        {
            ob_end_clean(); // this
            ob_start(); // and this
            Excel::import(new DoctorImport, $request->file('import'));
        }

        session()->flash('success',__('Doctor imported successfully'));

        return redirect()->back();
    }

    /**
    * Download doctors template
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function download_template()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return response()->download(storage_path('app/public/doctors_template.xlsx'),'doctors_template.xlsx');
    }
}