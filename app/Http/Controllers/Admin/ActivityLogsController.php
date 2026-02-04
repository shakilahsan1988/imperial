<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables; 

class ActivityLogsController extends Controller
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

            // অ্যাক্টিভিটি লগ দেখার পারমিশন চেক
            if (in_array($action, ['index', 'ajax'])) {
                if (!$u->hasPermission('view_activity_log')) {
                    abort(403, 'আপনার অ্যাক্টিভিটি লগ দেখার অনুমতি নেই।');
                }
            }

            // অ্যাক্টিভিটি লগ ক্লিয়ার করার পারমিশন চেক
            if ($action == 'clear') {
                if (!$u->hasPermission('clear_activity_log')) {
                    abort(403, 'আপনার অ্যাক্টিভিটি লগ মুছে ফেলার অনুমতি নেই।');
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
        $users=User::all();
        return view('admin.activity_logs.index',compact('users'));
    }

     /**
     * datatable
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax(Request $request)
    {
        $model=Activity::with('causer')->orderBy('id','desc');

        if(!empty($request['filter_user']))
        {
            $model->where('causer_id',$request['filter_user']);
        }

        return DataTables::eloquent($model)
        ->editColumn('created_at',function($activity){
            return view('admin.activity_logs._created_at',compact('activity'));
        })
        ->addColumn('causer',function($activity){
            return view('admin.activity_logs._causer',compact('activity'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * clear activity logs
     *
     * @return \Illuminate\Http\Response
     */
    public function clear()
    {
        Activity::truncate();

        session()->flash('success',__('Activity log cleared successfully'));

        return redirect()->route('admin.activity_logs.index');
    }
}