<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visit;
use App\Models\Patient;
use App\Models\Group;
use App\Models\Test;
use App\Models\Culture;
use App\Models\Branch;
use App\Models\Contract;
use App\Http\Requests\Admin\VisitRequest;
use Str;
use Yajra\DataTables\Facades\DataTables; 

class VisitsController extends Controller
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

            // হোম ভিজিট দেখার পারমিশন চেক
            if (in_array($action, ['index', 'show', 'ajax'])) {
                if (!$u->hasPermission('view_visit')) {
                    abort(403, __('You don\'t have permission to view home visits list.'));
                }
            }

            // হোম ভিজিট বুকিং করার পারমিশন চেক
            if (in_array($action, ['create', 'store'])) {
                if (!$u->hasPermission('create_visit')) {
                    abort(403, __('You don\'t have permission to book a home visit.'));
                }
            }

            // ভিজিট এডিট করার পারমিশন চেক
            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_visit')) {
                    abort(403, __('You don\'t have permission to edit home visit info.'));
                }
            }

            // ভিজিট ডিলিট করার পারমিশন চেক
            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_visit')) {
                    abort(403, __('You don\'t have permission to delete a home visit.'));
                }
            }

            // ভিজিট থেকে ইনভয়েস/গ্রুপ তৈরি করার পারমিশন চেক
            if ($action == 'create_tests') {
                if (!$u->hasPermission('create_group')) {
                    abort(403, __('You don\'t have permission to create tests from visit.'));
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
        return view('admin.visits.index');
    }

     /**
    * get visits datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model = Visit::with('patient');

        if($request['filter_read']!=null)
        {
            $model->where('read',$request['filter_read']);
        }

        if($request['filter_status']!=null)
        {
            $model->where('status',$request['filter_status']);
        }
        
        return DataTables::of($model)
            ->editColumn('read',function($visit){
                return view('admin.visits._read',compact('visit'));
            })
            ->editColumn('status',function($visit){
                return view('admin.visits._status',compact('visit'));
            })
            ->addColumn('action',function($visit){
                return view('admin.visits._action',compact('visit'));
            })
            ->rawColumns(['read', 'status', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.visits.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VisitRequest $request)
    {        
        try {
            if($request->has('patient_id'))
            {
                $patient=Patient::find($request['patient_id']);
            }
            else{
                $patient=Patient::create([
                 'code'=>time(),
                 'name'=>$request['name'],
                 'phone'=>$request['phone'],
                 'dob'=>$request['dob'],
                 'address'=>$request['address'],
                 'gender'=>$request['gender'],
                 'email'=>$request['email'],
                 'api_token'=>Str::random(32)
                ]);
            }

            $visit=Visit::create([
                'patient_id'=>$patient['id'],
                'lat'=>$request['lat'],
                'lng'=>$request['lng'],
                'zoom_level'=>$request['zoom_level'],
                'visit_date'=>$request['visit_date'],
            ]);

            if($request->has('attach'))
            {
                $attach=$request->file('attach');
                $name=time().'.'.$attach->getClientOriginalExtension();
                $attach->move('uploads/visits',$name);
                $visit->update(['attach'=>$name]);
            }

            return redirect()->route('admin.visits.index')->with('success', __('Visit saved successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to save visit: ') . $e->getMessage());
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
        $visit=Visit::findOrFail($id);

        $visit->update(['read'=>true]);

        return view('admin.visits.show',compact('visit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visit=Visit::findOrFail($id);

        $visit->update(['read'=>true]);

        return view('admin.visits.edit',compact('visit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VisitRequest $request, $id)
    {
        try {
            $visit=Visit::findOrFail($id);
            $visit->update($request->except('_token','_method','patient_type'));

            if($request->has('attach'))
            {
                $attach=$request->file('attach');
                $name=time().'.'.$attach->getClientOriginalExtension();
                $attach->move('uploads/visits',$name);
                $visit->update(['attach'=>$name]);
            }

            return redirect()->route('admin.visits.index')->with('success', __('Visit updated successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to update visit: ') . $e->getMessage());
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
            $visit=Visit::findOrFail($id);
            $visit->delete();
            return redirect()->route('admin.visits.index')->with('success', __('Visit deleted successfully'));
        } catch (\Exception $e) {
            return back()->with('error', __('Failed to delete visit: ') . $e->getMessage());
        }
    }

    /**
    * Create group (tests) from visit
    *
    * @param  int  $visit_id
    * @return \Illuminate\Http\Response
    */
    public function create_tests($visit_id)
    {
        $visit=Visit::findOrFail($visit_id);

        $visit->update([
            'read'=>true,
            'status'=>true,
        ]);

        $tests=Test::where('parent_id',0)->orWhere('separated',true)->get();
        $cultures=Culture::all();
        $branches=Branch::all();
        $contracts=Contract::all();

        return view('admin.groups.create',compact('visit','tests','cultures','branches','contracts'));
    }
}