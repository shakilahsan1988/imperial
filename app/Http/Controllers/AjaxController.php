<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\PatientRequest;
use App\Http\Requests\Admin\DoctorRequest;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Group;
use App\Models\Option;
use App\Models\Role;
use App\Models\User;
use App\Models\Test;
use App\Models\Culture;
use App\Models\Antibiotic;
use App\Models\Chat;
use App\Models\Visit;
use App\Models\Branch;
use App\Models\Contract;
use App\Models\Expense;
use App\Models\Language;
use App\Models\TestOption;
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
        if(isset($request->term))
        {
            $tests=Test::where(function($q){
              return $q->where('parent_id',0)->orWhere('separated',true);
            })->where('name','like','%'.$request->term.'%')->take(20)->get();
        }
        else{
            $tests=Test::where(function($q){
                return $q->where('parent_id',0)->orWhere('separated',true);
              })->take(20)->get();
        }

        return response()->json($tests);
    }

    /**
    * get cultures select2
    *
    * @access public
    * @var  @Request $request
    */
    public function get_cultures(Request $request)
    {
        if(isset($request->term))
        {
            $cultures=Culture::where('name','like','%'.$request->term.'%')->take(20)->get();
        }
        else{
            $cultures=Culture::take(20)->get();
        }

        return response()->json($cultures);
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

    /**
    * delete test
    *
    * @access public
    * @var  @Request $request
    */
    public function delete_test($test_id)
    {
        $test=Test::find($test_id);

        if(isset($test))
        {
            $test->options()->delete();

            $test->delete();
        }

        return response()->json('success');
    }

    public function delete_option($option_id)
    {
        TestOption::where('id',$option_id)->delete();

        return response()->json('success');
    }


}



