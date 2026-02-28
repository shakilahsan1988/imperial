<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Test;
use App\Models\Culture;
use App\Models\GroupTest;
use App\Models\GroupCulture;
use App\Models\Branch;
use App\Models\Contract;
use App\Models\Setting;
use App\Models\Patient;
use App\Models\GroupTestResult;
use App\Models\GroupCultureResult;
use App\Models\CultureOption;
use App\Models\GroupCultureOption;
use App\Http\Requests\Admin\GroupRequest;
use Yajra\DataTables\Facades\DataTables; 
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class GroupsController extends Controller
{
    /**
     * assign roles with custom permission logic
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $u = auth()->guard('admin')->user();
            $isSuper = ($u && $u->id == 1); // Md. Shakil Ahsan (Super Admin) check

            $action = $request->route()->getActionMethod();

            if ($isSuper) {
                return $next($request);
            }

            if (in_array($action, ['index', 'show', 'ajax'])) {
                if (!$u->hasPermission('view_group')) {
                    abort(403, __('You don\'t have permission to view this page.'));
                }
            }

            if (in_array($action, ['create', 'store'])) {
                if (!$u->hasPermission('create_group')) {
                    abort(403, __('You don\'t have permission to create a new invoice.'));
                }
            }

            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_group')) {
                    abort(403, __('You don\'t have permission to edit an invoice.'));
                }
            }

            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_group')) {
                    abort(403, __('You don\'t have permission to delete an invoice.'));
                }
            }

            return $next($request);
        });
    }

    public function index()
    {
        return view('admin.groups.index');
    }

    public function ajax(Request $request)
    {
        $model = Group::query()->with('patient');

        if ($request['filter_status'] != null) {
            $model->where('done', $request['filter_status']);
        }

        if ($request['filter_barcode'] != null) {
            $model->where('barcode', $request['filter_barcode']);
        }

        if ($request['filter_date'] != null) {
            $date = explode('-', $request['filter_date']);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d 23:59:59', strtotime($date[1]));

            ($from == $to) ? $model->whereDate('created_at', $from) : $model->whereBetween('created_at', [$from, $to]);
        }
        
        return DataTables::of($model)
            ->editColumn('subtotal', function($group) {
                return formated_price($group->subtotal);
            })
            ->editColumn('discount', function($group) {
                return formated_price($group->discount);
            })
            ->editColumn('total', function($group) {
                return formated_price($group->total);
            })
            ->editColumn('paid', function($group) {
                return formated_price($group->paid);
            })
            ->editColumn('due', function($group) {
                return view('admin.groups._due', compact('group'));
            })
            ->editColumn('done', function($group) {
                return view('admin.groups._status', compact('group'));
            })
            ->addColumn('action', function($group) {
                return view('admin.groups._action', compact('group'));
            })
            ->rawColumns(['due', 'done', 'action'])
            ->make(true);
    }

    public function create()
    {
        $tests = Test::where('parent_id', 0)->orWhere('separated', true)->get();
        $cultures = Culture::all();
        $branches = Branch::all();
        $contracts = Contract::all();

        return view('admin.groups.create', compact('tests', 'cultures', 'branches', 'contracts'));
    }

    public function store(GroupRequest $request)
    {
        try {
            $group = Group::create($request->only('branch_id', 'patient_id', 'doctor_id', 'subtotal', 'discount', 'total', 'paid', 'due', 'contract_id'));
            
            if ($request->has('tests')) {
                foreach ($request['tests'] as $test) {
                    $price = Test::find($test)['price'];
                    GroupTest::create([
                        'group_id' => $group->id,
                        'test_id' => $test,
                        'price' => $price
                    ]);
                }
            }

            $culture_options = CultureOption::where('parent_id', 0)->get();
            if ($request->has('cultures')) {
                 foreach ($request['cultures'] as $culture) {
                     $price = Culture::find($culture)['price'];
                     $group_culture = GroupCulture::create([
                         'group_id' => $group->id,
                         'culture_id' => $culture,
                         'price' => $price
                     ]);

                     foreach ($culture_options as $culture_option) {
                         GroupCultureOption::create([
                             'group_culture_id' => $group_culture['id'],
                             'culture_option_id' => $culture_option['id'],
                         ]);
                     }
                 }
            }

            $this->generate_barcode($group);
            $this->assign_tests_report($group['id']);
            group_test_calculations($group['id']);

            $pdf = generate_pdf($group, 2);
            if (isset($pdf)) {
               $group->update(['receipt_pdf' => $pdf]);
            }

            $patient = Patient::find($group['patient_id']);
            send_notification('patient_code', $patient);

            return redirect()->route('admin.groups.show', $group['id'])->with('success', __('Group saved successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to create invoice: ') . $e->getMessage());
        }
    }

    public function show($id)
    {
        $group = Group::with(['patient', 'doctor', 'branch', 'contract', 'tests.test.components', 'cultures.culture', 'cultures.options.culture_option'])->findOrFail($id);
        return view('admin.groups.show', compact('group'));
    }

    public function edit($id)
    {
        $group = Group::with(['tests', 'cultures'])->findOrFail($id);
        $tests = Test::where('parent_id', 0)->orWhere('separated', true)->get();
        $cultures = Culture::all();
        $branches = Branch::all();
        $contracts = Contract::all();

        return view('admin.groups.edit', compact('group', 'tests', 'cultures', 'branches', 'contracts'));
    }

    public function update(GroupRequest $request, $id)
    {
        try {
            $group = Group::findOrFail($id);
            $group->update($request->only('branch_id', 'patient_id', 'doctor_id', 'subtotal', 'discount', 'total', 'paid', 'due', 'contract_id'));
            
            $group_tests = $group->tests->pluck('test_id')->toArray();
            $group_cultures = $group->cultures->pluck('culture_id')->toArray();

            if ($request->has('tests')) {
                GroupTest::where('group_id', $id)->whereNotIn('test_id', $request['tests'])->delete(); 
                $group_update_tests = GroupTest::where('group_id', $id)->whereIn('test_id', $request['tests'])->get();
                foreach ($group_update_tests as $group_test) {
                    $test = Test::find($group_test['test_id']);
                    $group_test->update(['price' => $test['price']]);
                }
            } else {
                GroupTest::where('group_id', $id)->delete();
            }

            if ($request->has('cultures')) {
                GroupCulture::where('group_id', $id)->whereNotIn('culture_id', $request['cultures'])->delete();
                $group_update_cultures = GroupCulture::where('group_id', $id)->whereIn('culture_id', $request['cultures'])->get();
                foreach ($group_update_cultures as $group_culture) {
                    $culture = Culture::find($group_culture['culture_id']);
                    $group_culture->update(['price' => $culture['price']]);
                }
            } else {
                GroupCulture::where('group_id', $id)->delete();
            }

            if ($request->has('tests')) {
                foreach ($request['tests'] as $test) {
                    if (!in_array($test, $group_tests)) {
                        GroupTest::create([
                            'group_id' => $group->id,
                            'test_id' => $test,
                            'price' => Test::find($test)['price']
                        ]);
                    }
                }
            }

            if ($request->has('cultures')) {
                $culture_options = CultureOption::where('parent_id', 0)->get();
                foreach ($request['cultures'] as $culture) {
                    if (!in_array($culture, $group_cultures)) {
                        $group_culture = GroupCulture::create([
                            'group_id' => $group->id,
                            'culture_id' => $culture,
                            'price' => Culture::find($culture)['price']
                        ]);
                        foreach ($culture_options as $culture_option) {
                            GroupCultureOption::create([
                                'group_culture_id' => $group_culture['id'],
                                'culture_option_id' => $culture_option['id'],
                            ]);
                        }
                    }
                }
            }

            $this->assign_tests_report($id);
            group_test_calculations($id);

            $pdf = generate_pdf($group, 2);
            if (isset($pdf)) {
                $group->update(['receipt_pdf' => $pdf]);
            }

            return redirect()->route('admin.groups.show', $id)->with('success', __('Group updated successfully'));
        } catch (\Exception $e) {
            return back()->with('error', __('Failed to update invoice.'));
        }
    }

    public function destroy($id)
    {
        try {
            $group = Group::findOrFail($id);
            
            // Delete related records manually due to lack of DB level cascading
            foreach ($group->tests as $test) {
                GroupTestResult::where('group_test_id', $test->id)->delete();
                $test->delete();
            }

            foreach ($group->cultures as $culture) {
                GroupCultureResult::where('group_culture_id', $culture->id)->delete();
                GroupCultureOption::where('group_culture_id', $culture->id)->delete();
                $culture->delete();
            }

            $group->delete();

            return redirect()->route('admin.groups.index')->with('success', __('Group deleted successfully'));
        } catch (\Exception $e) {
            return back()->with('error', __('Failed to delete invoice.'));
        }
    }

    public function generate_barcode($group)
    {
        $barcode = mt_rand(100000000000, 999999999999);
        $exist = Group::where('barcode', $barcode)->first();

        if ($exist) {
            return $this->generate_barcode($group);
        }

        Group::where('id', $group['id'])->update(['barcode' => $barcode]);
    }

    public function assign_tests_report($id)
    {
        $group = Group::with('tests.test.components')->where('id', $id)->first();
        foreach ($group['tests'] as $test) {
            if (!$test->has_results) {
                $test->update(['has_results' => true]);
                $separated = Test::find($test['test_id']);
                if ($separated && $separated['separated']) {
                    GroupTestResult::create([
                        'group_test_id' => $test['id'],
                        'test_id' => $test['test_id'],
                    ]);
                }
                foreach ($test['test']['components'] as $component) {
                    GroupTestResult::create([
                        'group_test_id' => $test['id'],
                        'test_id' => $component['id'],
                    ]);
                }
            }
        }
    }

    public function print_barcode(Request $request, $id)
    {
        $request->validate(['number' => 'required|numeric|min:1']);
        $group = Group::findOrFail($id);
        $barcode = new BarcodeGenerator();
        $barcode->setText($group['barcode']);
        $barcode->setType(BarcodeGenerator::Ean13);
        $barcode->setScale(2);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_base64 = $barcode->generate();

        $pdf = print_barcode($group, $request['number'], $barcode_base64);
        return redirect($pdf);
    }
}