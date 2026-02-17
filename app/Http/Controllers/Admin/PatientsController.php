<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Http\Requests\Admin\PatientRequest;
use App\Http\Requests\Admin\ExcelImportRequest;
use App\Exports\PatientExport;
use App\Imports\PatientImport;
use Str;
use Yajra\DataTables\Facades\DataTables; 
use Excel;

class PatientsController extends Controller
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

            // রোগী দেখার পারমিশন চেক
            if (in_array($action, ['index', 'show', 'ajax', 'export', 'download_template'])) {
                if (!$u->hasPermission('view_patient')) {
                    abort(403, 'আপনার রোগী তালিকা দেখার অনুমতি নেই।');
                }
            }

            // রোগী তৈরি বা ইমপোর্ট করার পারমিশন চেক
            if (in_array($action, ['create', 'store', 'import'])) {
                if (!$u->hasPermission('create_patient')) {
                    abort(403, 'আপনার নতুন রোগী যুক্ত করার অনুমতি নেই।');
                }
            }

            // রোগী এডিট করার পারমিশন চেক
            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_patient')) {
                    abort(403, 'আপনার রোগীর তথ্য এডিট করার অনুমতি নেই।');
                }
            }

            // রোগী ডিলিট করার পারমিশন চেক
            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_patient')) {
                    abort(403, 'আপনার রোগীর তথ্য মুছে ফেলার অনুমতি নেই।');
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
        $patients=Patient::all();
        return view('admin.patients.index',compact('patients'));
    }

    /**
    * get patients datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model=Patient::query();

        return DataTables::eloquent($model)
        ->editColumn('total',function($patient){
            return formated_price($patient['total']);
        })
        ->editColumn('paid',function($patient){
            return formated_price($patient['paid']);
        })
        ->editColumn('due',function($patient){
            return view('admin.patients._due',compact('patient'));
        })
        ->addColumn('action',function($patient){
            return view('admin.patients._action',compact('patient'));
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
        return view('admin.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientRequest $request)
    {
        try {
            $patient = Patient::create([
                'code' => patient_code(),
                'name' => $request->name,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            send_notification('patient_code', $patient);

            return to_route('admin.patients.index')
                ->with('success', __('Patient created successfully'));
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->with('error', __('Failed to create patient. Please try again.'));
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
        $patient=Patient::findOrFail($id);
        return view('admin.patients.edit',compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatientRequest $request, $id)
    {
        try {
            $patient = Patient::findOrFail($id);
            
            $patient->update([
                'name' => $request->name,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            $patient = Patient::find($id);
            send_notification('patient_code', $patient);

            return to_route('admin.patients.index')
                ->with('success', __('Patient updated successfully'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', __('Patient not found.'));
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->with('error', __('Failed to update patient. Please try again.'));
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
            $patient = Patient::findOrFail($id);
            $patient->groups()->delete();
            $patient->delete();

            return to_route('admin.patients.index')
                ->with('success', __('Patient deleted successfully'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', __('Patient not found.'));
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', __('Failed to delete patient. Please try again.'));
        }
    }

    /**
    * Export patients
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new PatientExport, 'patients.xlsx');
    }

    /**
    * Import patients
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function import(ExcelImportRequest $request)
    {
        try {
            if ($request->hasFile('import')) {
                ob_end_clean();
                ob_start();
                Excel::import(new PatientImport, $request->file('import'));
            }

            return back()->with('success', __('Patients imported successfully'));
        } catch (\Exception $e) {
            return back()->with('error', __('Failed to import patients. Please check the file format.'));
        }
    }

    /**
    * Download patients template
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function download_template()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return response()->download(storage_path('app/public/patients_template.xlsx'),'patients_template.xlsx');
    }
}