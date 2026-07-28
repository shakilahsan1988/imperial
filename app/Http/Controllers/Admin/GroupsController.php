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
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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

            if (in_array($action, ['index', 'show', 'ajax', 'print_barcode'])) {
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

    public function create()
    {
        return view('admin.groups.create', $this->form_data());
    }

    public function store(Request $request)
    {
        $data = $this->validate_group($request);

        $group = Group::create($data['group']);

        $this->sync_tests($group, $data['tests']);
        $this->generate_barcode($group);

        return redirect()->route('admin.groups.index')->with('success', __('Invoice created successfully'));
    }

    public function edit($id)
    {
        $group = Group::with(['patient', 'doctor', 'branch', 'contract', 'tests'])->findOrFail($id);

        return view('admin.groups.edit', $this->form_data() + compact('group'));
    }

    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $data = $this->validate_group($request);

        $group->update($data['group']);
        $this->sync_tests($group, $data['tests']);

        return redirect()->route('admin.groups.index')->with('success', __('Invoice updated successfully'));
    }

    public function show($id)
    {
        $group = Group::with(['patient', 'branch', 'booking.services', 'tests.service'])->findOrFail($id);
        return view('admin.groups.show', compact('group'));
    }

    /**
     * Shared select options for the create/edit form.
     * Cultures are not a module in this installation, so an empty set is passed
     * to keep the shared _form partial working.
     */
    protected function form_data(): array
    {
        return [
            'branches' => Branch::orderBy('name')->get(),
            'contracts' => Contract::orderBy('title')->get(),
            'tests' => Service::active()->laboratory()->orderBy('name')->get(),
            'cultures' => collect(),
        ];
    }

    protected function validate_group(Request $request): array
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'contract_id' => 'nullable|exists:contracts,id',
            'subtotal' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'paid' => 'required|numeric|min:0',
            'due' => 'nullable|numeric',
            'tests' => 'required|array|min:1',
            'tests.*' => 'exists:services,id',
        ]);

        $tests = $validated['tests'];
        unset($validated['tests']);

        $validated['discount'] = $validated['discount'] ?? 0;
        $validated['due'] = $validated['due'] ?? ($validated['total'] - $validated['paid']);

        return ['group' => $validated, 'tests' => $tests];
    }

    /**
     * Replace the group's tests with the submitted services, preserving any
     * results already entered for services that are still selected.
     */
    protected function sync_tests(Group $group, array $serviceIds): void
    {
        GroupTest::where('group_id', $group->id)
            ->whereNotIn('service_id', $serviceIds)
            ->delete();

        $existing = GroupTest::where('group_id', $group->id)->pluck('service_id')->all();
        $prices = Service::whereIn('id', $serviceIds)->pluck('price', 'id');

        foreach ($serviceIds as $serviceId) {
            if (in_array($serviceId, $existing)) {
                continue;
            }

            GroupTest::create([
                'group_id' => $group->id,
                'service_id' => $serviceId,
                'price' => $prices[$serviceId] ?? 0,
            ]);
        }
    }

    public function print_barcode(Request $request, $group_id)
    {
        $request->validate(['number' => 'required|integer|min:1|max:50']);

        $group = Group::findOrFail($group_id);

        if (! $group->barcode) {
            $this->generate_barcode($group);
            $group->refresh();
        }

        // SVG rather than PNG: the QR PNG writer needs the Imagick PNG coder,
        // which is not guaranteed to be present. dompdf renders SVG natively.
        $barcode_image = base64_encode(
            QrCode::format('svg')->size(200)->margin(1)->generate($group->barcode)
        );

        return redirect(print_barcode($group, $request['number'], $barcode_image));
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
