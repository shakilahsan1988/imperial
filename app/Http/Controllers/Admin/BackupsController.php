<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use Artisan;

class BackupsController extends Controller
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

            // ব্যাকআপ দেখা এবং ডাউনলোড করার পারমিশন চেক
            if (in_array($action, ['index', 'show'])) {
                if (!$u->hasPermission('view_backup')) {
                    abort(403, 'আপনার ব্যাকআপ তালিকা দেখার অনুমতি নেই।');
                }
            }

            // নতুন ব্যাকআপ তৈরি করার পারমিশন চেক
            if (in_array($action, ['create', 'store'])) {
                if (!$u->hasPermission('create_backup')) {
                    abort(403, 'আপনার নতুন ব্যাকআপ তৈরি করার অনুমতি নেই।');
                }
            }

            // ব্যাকআপ মুছে ফেলার পারমিশন চেক
            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_backup')) {
                    abort(403, 'আপনার ব্যাকআপ ডিলিট করার অনুমতি নেই।');
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
        $backups = File::allFiles(storage_path('app/public/'.config('app.name')));
        
        return view('admin.backups.index',compact('backups'));
         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $result=Artisan::call('backup:run',[
                '--only-db'=>true
            ]);
            session()->flash('success',__('Database backup created successfully'));
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('success',__('Something went wrong'));
            return redirect()->back();
        }
        return redirect()->route('admin.backups.index');
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
        ob_end_clean(); // this
        ob_start(); // and this
        return response()->download(storage_path('app/public/'.config('app.name').'/'.$id));
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
       File::delete(storage_path('app/public/'.config('app.name').'/'.$id));

       session()->flash('success',__('Backup deleted successfully'));

       return redirect()->route('admin.backups.index');
    }
}