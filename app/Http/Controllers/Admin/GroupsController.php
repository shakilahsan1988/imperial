<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Branch;
use App\Models\Contract;
use App\Models\Patient;
use App\Models\GroupTest;
use Yajra\DataTables\Facades\DataTables; 

class GroupsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $u = auth()->guard('admin')->user();
            $isSuper = ($u && $u->id == 1);

            $action = $request->route()->getActionMethod();

            if ($isSuper) return $next($request);

            if (in_array($action, ['index', 'show', 'ajax'])) {
                if (!$u->hasPermission('view_group')) abort(403, __('Access Denied'));
            }
            if (in_array($action, ['create', 'store'])) {
                if (!$u->hasPermission('create_group')) abort(403, __('Access Denied'));
            }
            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_group')) abort(403, __('Access Denied'));
            }
            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_group')) abort(403, __('Access Denied'));
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
        $model = Group::query()->with(['patient', 'booking']);

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
            ->editColumn('total', fn($g) => formated_price($g->total))
            ->editColumn('paid', fn($g) => formated_price($g->paid))
            ->editColumn('due', fn($g) => view('admin.groups._due', ['group' => $g]))
            ->addColumn('action', fn($g) => view('admin.groups._action', ['group' => $g]))
            ->rawColumns(['due', 'action'])
            ->make(true);
    }

    public function show($id)
    {
        $group = Group::with(['patient', 'branch', 'booking.services', 'tests.service'])->findOrFail($id);
        return view('admin.groups.show', compact('group'));
    }

    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        GroupTest::where('group_id', $id)->delete();
        $group->delete();
        return redirect()->route('admin.groups.index')->with('success', __('Invoice deleted successfully'));
    }

    public function generate_barcode($group)
    {
        $barcode = mt_rand(100000000000, 999999999999);
        if (Group::where('barcode', $barcode)->exists()) return $this->generate_barcode($group);
        $group->update(['barcode' => $barcode]);
    }
}
