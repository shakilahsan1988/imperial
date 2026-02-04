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
                    abort(403, 'আপনার হোম ভিজিট তালিকা দেখার অনুমতি নেই।');
                }
            }

            // হোম ভিজিট বুকিং করার পারমিশন চেক
            if (in_array($action, ['create', 'store'])) {
                if (!$u->hasPermission('create_visit')) {
                    abort(403, 'আপনার হোম ভিজিট বুকিং করার অনুমতি নেই।');
                }
            }

            // ভিজিট এডিট করার পারমিশন চেক
            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_visit')) {
                    abort(403, 'আপনার হোম ভিজিটের তথ্য পরিবর্তন করার অনুমতি নেই।');
                }
            }

            // ভিজিট ডিলিট করার পারমিশন চেক
            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_visit')) {
                    abort(403, 'আপনার হোম ভিজিট মুছে ফেলার অনুমতি নেই।');
                }
            }

            // ভিজিট থেকে ইনভয়েস/গ্রুপ তৈরি করার পারমিশন চেক
            if ($action == 'create_tests') {
                if (!$u->hasPermission('create_group')) {
                    abort(403, 'আপনার ভিজিট থেকে টেস্ট তৈরি করার অনুমতি নেই।');
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
        $model=Visit::with('patient')->orderBy('id','desc');

        if($request['filter_read']!=null)
        {
            $model->where('read',$request['filter_read']);
        }

        if($request['filter_status']!=null)
        {
            $model->where('status',$request['filter_status']);
        }
        
        return DataTables::eloquent($model)

        ->editColumn('read',function($visit){
            return view('admin.visits._read',compact('visit'));
        })
        ->editColumn('status',function($visit){
            return view('admin.visits._status',compact('visit'));
        })
        ->addColumn('action',function($visit){
            return view('admin.visits._action',compact('visit'));
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

        session()->flash('success',__('Visit saved successfully'));
        
        return redirect()->route('admin.visits.index');
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
        $visit=Visit::findOrFail($id);
        $visit->update($request->except('_token','_method','patient_type'));

        if($request->has('attach'))
        {
            $attach=$request->file('attach');
            $name=time().'.'.$attach->getClientOriginalExtension();
            $attach->move('uploads/visits',$name);
            $visit->update(['attach'=>$name]);
        }

        session()->flash('success',__('Visit updated successfully'));

        return redirect()->route('admin.visits.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $visit=Visit::findOrFail($id);
        $visit->delete();

        session()->flash('success',__('Visit deleted successfully'));
        
        return redirect()->route('admin.visits.index');

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