<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use App\Http\Requests\Admin\ExpenseRequest;
use Yajra\DataTables\Facades\DataTables; 

class ExpensesController extends Controller
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

            // খরচ দেখার পারমিশন চেক
            if (in_array($action, ['index', 'show', 'ajax'])) {
                if (!$u->hasPermission('view_expense')) {
                    abort(403, 'আপনার খরচ তালিকা দেখার অনুমতি নেই।');
                }
            }

            // খরচ তৈরি করার পারমিশন চেক
            if (in_array($action, ['create', 'store'])) {
                if (!$u->hasPermission('create_expense')) {
                    abort(403, 'আপনার নতুন খরচ যুক্ত করার অনুমতি নেই।');
                }
            }

            // খরচ এডিট করার পারমিশন চেক
            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_expense')) {
                    abort(403, 'আপনার খরচের তথ্য এডিট করার অনুমতি নেই।');
                }
            }

            // খরচ ডিলিট করার পারমিশন চেক
            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_expense')) {
                    abort(403, 'আপনার খরচের তথ্য মুছে ফেলার অনুমতি নেই।');
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
        return view('admin.accounting.expenses.index');
    }

    /**
    * get analyses datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model = Expense::query()->with('category');

        return DataTables::of($model)
            ->editColumn('amount', function($expense) {
                return formated_price($expense->amount);
            })
            ->addColumn('action', function($expense) {
                return view('admin.accounting.expenses._action', compact('expense'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expense_categories=ExpenseCategory::all();
        return view('admin.accounting.expenses.create',compact('expense_categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        try {
            $request['date']=\Carbon\Carbon::parse($request['date']);
            Expense::create($request->except('_token','_method','files'));
            return redirect()->route('admin.expenses.index')->with('success', __('Expense created successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to create expense: ') . $e->getMessage());
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
        $expense = Expense::with('category')->findOrFail($id);
        return view('admin.accounting.expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense_categories=ExpenseCategory::all();
        $expense=Expense::findOrFail($id);
        return view('admin.accounting.expenses.edit',compact('expense_categories','expense'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseRequest $request, $id)
    {
        try {
            $request['date']=\Carbon\Carbon::parse($request['date']);
            $expense=Expense::findOrFail($id);
            $expense->update($request->except('_token','_method','files'));
            return redirect()->route('admin.expenses.index')->with('success', __('Expense updated successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to update expense: ') . $e->getMessage());
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
            $expense=Expense::findOrFail($id);
            $expense->delete();
            return redirect()->route('admin.expenses.index')->with('success', __('Expense deleted successfully'));
        } catch (\Exception $e) {
            return back()->with('error', __('Failed to delete expense: ') . $e->getMessage());
        }
    }
}