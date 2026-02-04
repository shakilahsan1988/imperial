<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Culture;
use App\Exports\TestPriceExport;
use App\Exports\CulturePriceExport;
use App\Imports\TestPriceImport;
use App\Imports\CulturePriceImport;
use App\Http\Requests\Admin\ExcelImportRequest;
use Excel;

class PricesController extends Controller
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

            // টেস্ট প্রাইস ভিউ এবং এক্সপোর্ট পারমিশন চেক
            if (in_array($action, ['tests', 'tests_prices_export'])) {
                if (!$u->hasPermission('view_test_prices')) {
                    abort(403, 'আপনার টেস্ট প্রাইস লিস্ট দেখার অনুমতি নেই।');
                }
            }

            // টেস্ট প্রাইস আপডেট এবং ইমপোর্ট পারমিশন চেক
            if (in_array($action, ['tests_submit', 'tests_prices_import'])) {
                if (!$u->hasPermission('update_test_prices')) {
                    abort(403, 'আপনার টেস্ট প্রাইস আপডেট করার অনুমতি নেই।');
                }
            }

            // কালচার প্রাইস ভিউ এবং এক্সপোর্ট পারমিশন চেক
            if (in_array($action, ['cultures', 'cultures_prices_export'])) {
                if (!$u->hasPermission('view_culture_prices')) {
                    abort(403, 'আপনার কালচার প্রাইস লিস্ট দেখার অনুমতি নেই।');
                }
            }

            // কালচার প্রাইস আপডেট এবং ইমপোর্ট পারমিশন চেক
            if (in_array($action, ['cultures_submit', 'cultures_prices_import'])) {
                if (!$u->hasPermission('update_culture_prices')) {
                    abort(403, 'আপনার কালচার প্রাইস আপডেট করার অনুমতি নেই।');
                }
            }

            return $next($request);
        });
    }

    /**
     * tests price list
     *
     * @return \Illuminate\Http\Response
     */
    public function tests()
    {
        $tests=Test::where('parent_id',0)->orWhere('separated',1)->get();

        return view('admin.prices.tests',compact('tests'));
    }

    /**
     * update tests prices
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tests_submit(Request $request)
    {        
        if($request->has('test'))
        {
            foreach($request['test'] as $key=>$value)
            {
                Test::where('id',$key)->update([
                    'price'=>$value
                ]);
            }
        }

        session()->flash('success',__('Tests prices updated successfully'));

        return redirect()->back();
    }

     /**
     * cultures price list
     *
     * @return \Illuminate\Http\Response
     */
    public function cultures()
    {
        $cultures=Culture::all();

        return view('admin.prices.cultures',compact('cultures'));
    }

     /**
     * update cultures prices
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cultures_submit(Request $request)
    {
        if($request->has('culture'))
        {
            foreach($request['culture'] as $key=>$value)
            {
                Culture::where('id',$key)->update([
                    'price'=>$value
                ]);
            }
        }

        session()->flash('success',__('Cultures prices updated successfully'));

        return redirect()->back();
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

    public function tests_prices_export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new TestPriceExport, 'tests_prices.xlsx');
    }

    public function cultures_prices_export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new CulturePriceExport, 'cultures_prices.xlsx');
    }


    /**
    * Import tests prices
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function tests_prices_import(ExcelImportRequest $request)
    {
        if($request->hasFile('import'))
        {
            ob_end_clean(); // this
            ob_start(); // and this

            session()->put('tests',[]);

            //import tests
            Excel::import(new TestPriceImport, $request->file('import'));        
        }

        session()->flash('success',__('Tests prices imported successfully'));

        return redirect()->back();
    }

    /**
    * Import cultures prices
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function cultures_prices_import(ExcelImportRequest $request)
    {
        if($request->hasFile('import'))
        {
            ob_end_clean(); // this
            ob_start(); // and this

            session()->put('tests',[]);

            //import tests
            Excel::import(new CulturePriceImport, $request->file('import'));        
        }

        session()->flash('success',__('Cultures prices imported successfully'));

        return redirect()->back();
    }
}