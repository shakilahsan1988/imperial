<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupTest;
use App\Models\Patient;
use Yajra\DataTables\Facades\DataTables;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $u = auth()->guard('admin')->user();
            $isSuper = ($u && $u->id == 1);
            $action = $request->route()->getActionMethod();

            if ($isSuper) return $next($request);

            if (in_array($action, ['index', 'show', 'ajax', 'pdf'])) {
                if (!$u->hasPermission('view_report')) abort(403, 'Denied');
            }
            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_report')) abort(403, 'Denied');
            }
            return $next($request);
        });
    }

    public function index()
    {
        return view('admin.reports.index');
    }

    public function ajax(Request $request)
    {
        $model = Group::query()->with(['patient', 'booking', 'tests.service']);

        if ($request['filter_barcode'] != null) {
            $model->where('barcode', $request['filter_barcode']);
        }

        if ($request['filter_date'] != null) {
            $date = explode('-', $request['filter_date']);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d 23:59:59', strtotime($date[1]));
            ($from == $to) ? $model->whereDate('created_at', $from) : $model->whereBetween('created_at', [$from, $to]);
        }
        
        return DataTables::eloquent($model)
            ->editColumn('patient.name', fn($g) => $g->patient->name)
            ->addColumn('action', fn($g) => view('admin.reports._action', ['group' => $g]))
            ->toJson();
    }

    /**
     * Show report (Read-only web view)
     */
    public function show($id)
    {
        $group = Group::with([
            'tests' => function($q) {
                return $q->with(['service', 'results.component']);
            },
            'booking.services',
            'patient'
        ])->findOrFail($id);

        return view('admin.reports.show', compact('group'));
    }

    /**
     * Generate PDF report
     */
    public function pdf($id)
    {
        $group = Group::with([
            'tests' => function($q) {
                return $q->with(['service', 'results.component']);
            },
            'patient'
        ])->findOrFail($id);

        $pdf_url = generate_pdf($group, 1);
        return redirect($pdf_url);
    }

    public function edit($id)
    {
        $group = Group::with([
            'tests' => function($q) {
                return $q->with('service');
            },
            'booking.services',
            'patient'
        ])->findOrFail($id);

        return view('admin.reports.edit', compact('group'));
    }

    public function update(Request $request, $id)
    {
        try {
            $group_test = GroupTest::findOrFail($id);
            
            // Handle sub-components if any
            if ($request->has('results')) {
                foreach ($request->results as $componentId => $resData) {
                    \App\Models\GroupTestResult::updateOrCreate(
                        [
                            'group_test_id' => $group_test->id,
                            'service_component_id' => $componentId
                        ],
                        [
                            'result' => $resData['result'],
                            'status' => $resData['status']
                        ]
                    );
                }
            }

            // Update main test record
            $group_test->update([
                'result' => $request->result,
                'status' => $request->status,
                'comment' => $request->comment,
                'done' => true
            ]);

            $group = Group::findOrFail($group_test->group_id);
            $group->update(['done' => check_group_done($group->id)]);

            return redirect()->back()->with('success', __('Result saved successfully'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
