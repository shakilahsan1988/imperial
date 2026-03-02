<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\DoctorRequest;
use App\Http\Requests\Admin\ExcelImportRequest;
use App\Exports\DoctorExport;
use App\Imports\DoctorImport;
use App\Models\Doctor;
use App\Models\DoctorSpecialty;
use App\Models\DoctorDepartment;
use Yajra\DataTables\Facades\DataTables; 
use Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
        $model = Doctor::with(['specialty', 'department'])->select('doctors.*');

        return DataTables::of($model)
            ->addColumn('specialty', function($doctor) {
                return optional($doctor->specialty)->name ?: '-';
            })
            ->addColumn('department', function($doctor) {
                return optional($doctor->department)->name ?: '-';
            })
            ->addColumn('consultation_fee', function($doctor) {
                return formated_price($doctor->consultation_fee ?? 0);
            })
            ->addColumn('video_consultation_fee', function($doctor) {
                if (!$doctor->video_consultation_available) {
                    return '-';
                }
                return formated_price($doctor->video_consultation_fee ?? $doctor->consultation_fee ?? 0);
            })
            ->addColumn('video_consultation', function($doctor) {
                return $doctor->video_consultation_available
                    ? '<span class="badge bg-success">Yes</span>'
                    : '<span class="badge bg-secondary">No</span>';
            })
            ->editColumn('commission', function($doctor) {
                return $doctor->commission . '%';
            })
            ->editColumn('total', function($doctor) {
                return formated_price($doctor->total);
            })
            ->editColumn('paid', function($doctor) {
                return formated_price($doctor->paid);
            })
            ->editColumn('due', function($doctor) {
                return view('admin.doctors._due', compact('doctor'));
            })
            ->addColumn('action', function($doctor) {
                return view('admin.doctors._action', compact('doctor'));
            })
            ->rawColumns(['video_consultation', 'due', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specialties = DoctorSpecialty::where('status', true)->orderBy('sort_order')->orderBy('name')->get();
        $departments = DoctorDepartment::where('status', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.doctors.create', compact('specialties', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoctorRequest $request)
    {
        try {
            $data = $request->except('_token', '_method', 'image');
            $data['code'] = doctor_code();
            $data['slug'] = Str::slug($request->name) . '-' . time();
            $data['video_consultation_available'] = $request->boolean('video_consultation_available');
            $data['video_consultation_fee'] = $request->boolean('video_consultation_available')
                ? ($request->video_consultation_fee ?? $request->consultation_fee)
                : null;
            $data['status'] = $request->boolean('status', true);

            if ($request->hasFile('image')) {
                if (!File::isDirectory('uploads/doctors')) {
                    File::makeDirectory('uploads/doctors', 0755, true);
                }
                $image = $request->file('image');
                $imageName = 'doctor_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move('uploads/doctors', $imageName);
                $data['image'] = 'uploads/doctors/' . $imageName;
            }

            Doctor::create($data);
            return redirect()->route('admin.doctors.index')->with('success', __('Doctor created successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to create doctor: ') . $e->getMessage());
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
        $doctor = Doctor::findOrFail($id);
        return view('admin.doctors.show', compact('doctor'));
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
        $specialties = DoctorSpecialty::where('status', true)->orderBy('sort_order')->orderBy('name')->get();
        $departments = DoctorDepartment::where('status', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.doctors.edit',compact('doctor', 'specialties', 'departments'));
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
        try {
            $doctor=Doctor::findOrFail($id);
            $data = $request->except('_token', '_method', 'image');
            $data['slug'] = Str::slug($request->name) . '-' . $doctor->id;
            $data['video_consultation_available'] = $request->boolean('video_consultation_available');
            $data['video_consultation_fee'] = $request->boolean('video_consultation_available')
                ? ($request->video_consultation_fee ?? $request->consultation_fee)
                : null;
            $data['status'] = $request->boolean('status');

            if ($request->hasFile('image')) {
                if (!File::isDirectory('uploads/doctors')) {
                    File::makeDirectory('uploads/doctors', 0755, true);
                }
                $image = $request->file('image');
                $imageName = 'doctor_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move('uploads/doctors', $imageName);
                $data['image'] = 'uploads/doctors/' . $imageName;
            }

            $doctor->update($data);
            return redirect()->route('admin.doctors.index')->with('success', __('Doctor updated successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to update doctor: ') . $e->getMessage());
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
            $doctor=Doctor::findOrFail($id);
            $doctor->delete();
            return redirect()->route('admin.doctors.index')->with('success', __('Doctor deleted successfully'));
        } catch (\Exception $e) {
            return back()->with('error', __('Failed to delete doctor: ') . $e->getMessage());
        }
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
