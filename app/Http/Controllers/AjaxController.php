<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\PatientRequest;
use App\Http\Requests\Admin\DoctorRequest;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use App\Models\Service;
use App\Models\Visit;
use App\Models\Branch;
use App\Models\Contract;
use App\Models\Expense;
use App\Models\Language;
use App\Models\ExpenseCategory;
use Yajra\DataTables\Html\Button;
use App\Mail\PatientCode;
use Yajra\DataTables\Facades\DataTables; 
use Mail;
use Str;
use Illuminate\Validation\Rule;

class AjaxController extends Controller
{
    /**
    * get patient by code select2
    *
    * @access public
    * @var  @Request $request
    */
    public function get_patient_by_code(Request $request)
    {
        if(isset($request->term))
        {
            $patients=Patient::where('code','like','%'.$request->term.'%')->take(20)->get();
        }
        else{
            $patients=Patient::take(20)->get();
        }

        return response()->json($patients);

    }
    
    /**
    * get patient by name select2
    *
    * @access public
    * @var  @Request $request
    */
    public function get_patient_by_name(Request $request)
    {
        if(isset($request->term))
        {
            $patients=Patient::where('name','like','%'.$request->term.'%')->take(20)->get();
        }
        else{
            $patients=Patient::take(20)->get();
        }

        return response()->json($patients);

    }
    
    /**
    * create patient
    *
    * @access public
    * @var  @Request $request
    */
    public function create_patient(PatientRequest $request)
    {
        $request['code']=patient_code();

        $patient=Patient::create($request->except('_token'));

        send_notification('patient_code',$patient);

        return response()->json($patient);
    }

    /**
    * get doctors select2
    *
    * @access public
    * @var  @Request $request
    */
    public function get_doctors(Request $request)
    {
        if(isset($request->term))
        {
            $doctors=Doctor::where('name','like','%'.$request->term.'%')->take(20)->get();
        }
        else{
            $doctors=Doctor::take(20)->get();
        }

        return response()->json($doctors);
    }

    /**
    * get tests select2
    *
    * @access public
    * @var  @Request $request
    */
    public function get_tests(Request $request)
    {
        $tests=Service::active()->laboratory();

        if(isset($request->term))
        {
            $tests->where('name','like','%'.$request->term.'%');
        }

        return response()->json($tests->orderBy('name')->take(20)->get());
    }

    /**
    * get cultures select2
    *
    * Cultures are not a module in this installation; the endpoint is kept so the
    * select2 widgets that request it degrade to an empty list instead of erroring.
    *
    * @access public
    * @var  @Request $request
    */
    public function get_cultures(Request $request)
    {
        return response()->json([]);
    }

    

    /**
    * create doctor
    *
    * @access public
    * @var  @Request $request
    */

    public function create_doctor(Request $request)
    {
        $request->validate([
            'name'=>[
                'required',
                Rule::unique('doctors')->whereNull('deleted_at')
            ],
        ]);

        $request['code']=doctor_code();
        
        $doctor=Doctor::create($request->except('_token'));

        return response()->json($doctor);
    }


    /**
    * Change visit status
    *
    * @access public
    * @var  @Request $request
    */
    public function change_visit_status($id)
    {
        $visit=Visit::find($id);
        
        $visit->update([
            'read'=>true,
            'status'=>($visit['status'])?false:true,
        ]);

        return response()->json(__('Visit status updated successfully'));
    }

    /**
    * Change lang status
    *
    * @access public
    * @var  @Request $request
    */
    public function change_lang_status($id)
    {
        $lang=Language::find($id);
        
        $lang->update([
            'active'=>($lang['active'])?false:true,
        ]);

        return response()->json(__('Language status updated successfully'));
    }


    /**
    * create expenses category
    * 
    * @access public
    * @var  @Request $request
    */
    public function add_expense_category(Request $request)
    {
        $category=ExpenseCategory::create([
            'name'=>$request['name']
        ]);

        return response()->json($category);
    }

    /**
    * get new visits
    * 
    * @access public
    * @var  @Request $request
    */
    public function get_new_visits()
    {
        $visits=Visit::where('read',false)->orderBy('id','desc')->with('patient')->get();

        return response()->json($visits);

    }

    /**
    * get current patient
    * 
    * @access public
    * @var  @Request $request
    */
    public function get_current_patient()
    {
        $patient=Patient::where('id',auth()->guard('patient')->user()['id'])->first();
        
        return response()->json($patient);
    }


    /**
    * get patient
    *
    * @access public
    * @var  @Request $request
    */
    public function get_patient(Request $request)
    {
        $patient=Patient::find($request->id);

        return response()->json($patient);
    }

}



