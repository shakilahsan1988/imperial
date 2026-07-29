<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\DoctorRequest;
use App\Http\Requests\Admin\ExcelImportRequest;
use App\Exports\DoctorExport;
use App\Imports\DoctorImport;
use App\Models\Branch;
use App\Models\Doctor;
use App\Models\DoctorSpecialty;
use App\Models\DoctorDepartment;
use App\Services\DoctorImageService;
use App\Support\DoctorBookingGuard;
use Yajra\DataTables\Facades\DataTables;
use Excel;
use Illuminate\Support\Str;

class DoctorsController extends Controller
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

            // ডাক্তার তালিকা দেখার পারমিশন চেক
            if (in_array($action, ['index', 'show', 'ajax', 'export', 'download_template'])) {
                if (!$u->hasPermission('view_doctor')) {
                    abort(403, 'আপনার ডাক্তার তালিকা দেখার অনুমতি নেই।');
                }
            }

            // ডাক্তার তৈরি বা ইমপোর্ট করার পারমিশন চেক
            if (in_array($action, ['create', 'store', 'import'])) {
                if (!$u->hasPermission('create_doctor')) {
                    abort(403, 'আপনার নতুন ডাক্তার যুক্ত করার অনুমতি নেই।');
                }
            }

            // ডাক্তার এডিট করার পারমিশন চেক
            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_doctor')) {
                    abort(403, 'আপনার ডাক্তারের তথ্য এডিট করার অনুমতি নেই।');
                }
            }

            // ডাক্তার ডিলিট করার পারমিশন চেক
            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_doctor')) {
                    abort(403, 'আপনার ডাক্তারের তথ্য ডিলিট করার অনুমতি নেই।');
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
        return view('admin.doctors.index');
    }

    /**
    * get antibiotics datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model = Doctor::with(['specialty', 'department', 'branchSchedules.branch'])->select('doctors.*');

        return DataTables::of($model)
            ->addColumn('specialty', function($doctor) {
                return optional($doctor->specialty)->name ?: '-';
            })
            ->addColumn('department', function($doctor) {
                return optional($doctor->department)->name ?: '-';
            })
            ->addColumn('schedule', function($doctor) {
                $schedules = $doctor->branchSchedules->map(function ($schedule) {
                    $parts = array_filter([
                        optional($schedule->branch)->title ?: optional($schedule->branch)->name,
                        $schedule->schedule_days,
                        $schedule->schedule_time,
                    ]);

                    return implode(' | ', $parts);
                })->filter()->values();

                return $schedules->isNotEmpty() ? e($schedules->implode(' || ')) : '-';
            })
            ->addColumn('consultation_fee', function($doctor) {
                return formated_price($doctor->consultation_fee ?? 0);
            })
            ->addColumn('video_consultation_fee', function($doctor) {
                if (!$doctor->video_consultation_available) {
                    return '-';
                }
                return formated_price($doctor->video_consultation_fee ?? $doctor->consultation_fee ?? 0);
            })
            ->addColumn('video_consultation', function($doctor) {
                return $doctor->video_consultation_available
                    ? '<span class="badge bg-success">Yes</span>'
                    : '<span class="badge bg-secondary">No</span>';
            })
            ->editColumn('commission', function($doctor) {
                return $doctor->commission . '%';
            })
            ->editColumn('total', function($doctor) {
                return formated_price($doctor->total);
            })
            ->editColumn('paid', function($doctor) {
                return formated_price($doctor->paid);
            })
            ->editColumn('due', function($doctor) {
                return view('admin.doctors._due', compact('doctor'));
            })
            ->addColumn('action', function($doctor) {
                return view('admin.doctors._action', compact('doctor'));
            })
            ->rawColumns(['video_consultation', 'due', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specialties = DoctorSpecialty::where('status', true)->orderBy('sort_order')->orderBy('name')->get();
        $departments = DoctorDepartment::where('status', true)->orderBy('sort_order')->orderBy('name')->get();
        $branches = Branch::orderByRaw('coalesce(title, name)')->get();
        $doctorBranchSchedules = [];

        return view('admin.doctors.create', compact('specialties', 'departments', 'branches', 'doctorBranchSchedules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoctorRequest $request, DoctorImageService $images)
    {
        try {
            $data = $request->except('_token', '_method', 'image', 'remove_image', 'branch_schedules', 'branch_id', 'schedule_branch', 'schedule_consultant', 'schedule_days', 'schedule_time');
            $data['code'] = doctor_code();
            $data['slug'] = Str::slug($request->name) . '-' . time();
            $data['video_consultation_available'] = $request->boolean('video_consultation_available');
            $data['video_consultation_fee'] = $request->boolean('video_consultation_available')
                ? ($request->video_consultation_fee ?? $request->consultation_fee)
                : null;
            $data['status'] = $request->boolean('status', true);
            $data['branch_id'] = null;
            $data['schedule_branch'] = null;
            $data['schedule_consultant'] = null;
            $data['schedule_days'] = null;
            $data['schedule_time'] = null;

            // The image is attached after the row exists, because the storage
            // path is scoped by doctor id.
            $doctor = Doctor::create($data);

            if ($request->hasFile('image')) {
                $images->store($doctor, $request->file('image'));
            }

            $protected = $this->syncBranchSchedules($doctor, $request->input('branch_schedules', []));

            return redirect()->route('admin.doctors.index')
                ->with('success', __('Doctor created successfully'))
                ->with('warning', $this->protectedScheduleWarning($protected));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to create doctor: ') . $e->getMessage());
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
        $doctor = Doctor::with(['specialty', 'department', 'branchSchedules.branch'])->findOrFail($id);
        return view('admin.doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doctor=Doctor::with('branchSchedules')->findOrFail($id);
        $specialties = DoctorSpecialty::where('status', true)->orderBy('sort_order')->orderBy('name')->get();
        $departments = DoctorDepartment::where('status', true)->orderBy('sort_order')->orderBy('name')->get();
        $branches = Branch::orderByRaw('coalesce(title, name)')->get();
        $doctorBranchSchedules = $doctor->branchSchedules->keyBy('branch_id');

        return view('admin.doctors.edit', compact('doctor', 'specialties', 'departments', 'branches', 'doctorBranchSchedules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DoctorRequest $request, $id, DoctorImageService $images)
    {
        try {
            $doctor=Doctor::findOrFail($id);
            $data = $request->except('_token', '_method', 'image', 'remove_image', 'branch_schedules', 'branch_id', 'schedule_branch', 'schedule_consultant', 'schedule_days', 'schedule_time');
            $data['slug'] = Str::slug($request->name) . '-' . $doctor->id;
            $data['video_consultation_available'] = $request->boolean('video_consultation_available');
            $data['video_consultation_fee'] = $request->boolean('video_consultation_available')
                ? ($request->video_consultation_fee ?? $request->consultation_fee)
                : null;
            $data['status'] = $request->boolean('status');
            $data['branch_id'] = null;
            $data['schedule_branch'] = null;
            $data['schedule_consultant'] = null;
            $data['schedule_days'] = null;
            $data['schedule_time'] = null;

            $doctor->update($data);

            // A new upload wins over the remove checkbox; both are handled by
            // the image service so that ownership and cleanup stay in one place.
            if ($request->hasFile('image')) {
                $images->store($doctor, $request->file('image'));
            } elseif ($request->boolean('remove_image')) {
                $images->remove($doctor);
            }

            $protected = $this->syncBranchSchedules($doctor, $request->input('branch_schedules', []));

            return redirect()->route('admin.doctors.index')
                ->with('success', __('Doctor updated successfully'))
                ->with('warning', $this->protectedScheduleWarning($protected));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to update doctor: ') . $e->getMessage());
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
            $doctor=Doctor::findOrFail($id);
            $doctor->delete();
            return redirect()->route('admin.doctors.index')->with('success', __('Doctor deleted successfully'));
        } catch (\Exception $e) {
            return back()->with('error', __('Failed to delete doctor: ') . $e->getMessage());
        }
    }

    /**
    * Export doctors
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new DoctorExport, 'doctors.xlsx');
    }

    /**
    * Import doctors
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function import(ExcelImportRequest $request)
    {
        if($request->hasFile('import'))
        {
            ob_end_clean(); // this
            ob_start(); // and this
            Excel::import(new DoctorImport, $request->file('import'));
        }

        session()->flash('success',__('Doctor imported successfully'));

        return redirect()->back();
    }

    /**
    * Download doctors template
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function download_template()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return response()->download(storage_path('app/public/doctors_template.xlsx'),'doctors_template.xlsx');
    }

    /**
     * Apply the branch schedule rows submitted with the form.
     *
     * A bare sync() would silently detach any branch missing from the payload.
     * That is destructive in two ways: it removes the doctor from that branch's
     * public listing, and it makes the branch ineligible for booking, because
     * FrontController::submit_doctor_booking checks branchSchedules for the
     * selected branch. So two protections apply here:
     *
     *  1. Branches the form did not offer at all - a soft-deleted branch, for
     *     instance - are preserved rather than detached.
     *
     *  2. A branch the admin unchecked is still preserved if the doctor has
     *     upcoming bookings there. Editing the schedule text is left alone,
     *     since that text is display-only; it is the detach that loses data.
     *
     * @return array<int, string> names of branches that were protected
     */
    protected function syncBranchSchedules(Doctor $doctor, array $branchSchedules): array
    {
        $payload = collect($branchSchedules)
            ->filter(fn ($row) => (bool) ($row['enabled'] ?? false) && ! empty($row['branch_id']))
            ->mapWithKeys(function ($row) {
                return [
                    (int) $row['branch_id'] => [
                        'consultant' => trim((string) ($row['consultant'] ?? '')) ?: null,
                        'schedule_days' => trim((string) ($row['schedule_days'] ?? '')) ?: null,
                        'schedule_time' => trim((string) ($row['schedule_time'] ?? '')) ?: null,
                    ],
                ];
            })
            ->all();

        $offered = collect($branchSchedules)
            ->pluck('branch_id')
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->all();

        $protected = [];

        foreach ($doctor->branchSchedules()->get() as $schedule) {
            $branchId = (int) $schedule->branch_id;

            if (array_key_exists($branchId, $payload)) {
                continue;
            }

            $wasOffered = in_array($branchId, $offered, true);
            $hasBookings = $this->blockingBookingCount($doctor, $branchId) > 0;

            if ($wasOffered && ! $hasBookings) {
                continue; // Deliberately unchecked and safe to detach.
            }

            // Preserve the existing row untouched.
            $payload[$branchId] = [
                'consultant' => $schedule->consultant,
                'schedule_days' => $schedule->schedule_days,
                'schedule_time' => $schedule->schedule_time,
            ];

            if ($wasOffered && $hasBookings) {
                $protected[] = optional($schedule->branch)->title
                    ?: optional($schedule->branch)->name
                    ?: ('#'.$branchId);
            }
        }

        $doctor->branches()->sync($payload);

        return $protected;
    }

    /**
     * Count bookings that make a branch schedule unsafe to remove.
     *
     * Delegates to DoctorBookingGuard, which is also used by the read-only
     * audit, so both places agree on what "protected" means.
     */
    protected function blockingBookingCount(Doctor $doctor, int $branchId): int
    {
        return DoctorBookingGuard::blockingBookingCount($doctor->getKey(), $branchId);
    }

    /**
     * Human-readable notice for schedules that were kept despite being unchecked.
     */
    protected function protectedScheduleWarning(array $protectedBranches): ?string
    {
        if (empty($protectedBranches)) {
            return null;
        }

        return __('These branch schedules were kept because the doctor has upcoming appointments there: ')
            .implode(', ', $protectedBranches);
    }
}
