<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Patient;
use App\Models\User;
use App\Models\Group;
use App\Models\GroupTest;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class BookingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $u = auth()->guard('admin')->user();
            $isSuper = ($u && $u->id == 1);

            $action = $request->route()->getActionMethod();

            if ($isSuper) {
                return $next($request);
            }

            if (in_array($action, ['index', 'show', 'ajax'])) {
                if (!$u->hasPermission('view_booking')) {
                    abort(403, 'You do not have permission to view bookings.');
                }
            }

            if (in_array($action, ['create', 'store'])) {
                if (!$u->hasPermission('create_booking')) {
                    abort(403, 'You do not have permission to create bookings.');
                }
            }

            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_booking')) {
                    abort(403, 'You do not have permission to edit bookings.');
                }
            }

            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_booking')) {
                    abort(403, 'You do not have permission to delete bookings.');
                }
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Booking::with(['patient', 'services', 'report'])
                ->select('bookings.*')
                ->orderBy('created_at', 'desc');

            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            if ($request->has('booking_type') && $request->booking_type) {
                $query->where('booking_type', $request->booking_type);
            }

            if ($request->has('date_from') && $request->date_from) {
                $query->whereDate('scheduled_date', '>=', $request->date_from);
            }

            if ($request->has('date_to') && $request->date_to) {
                $query->whereDate('scheduled_date', '<=', $request->date_to);
            }

            return DataTables::of($query)
                ->addColumn('booking_id', function ($booking) {
                    return 'BK-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT);
                })
                ->addColumn('patient_name', function ($booking) {
                    $name = $booking->patient ? $booking->patient->name : $booking->patient_name;
                    $phone = $booking->patient ? $booking->patient->phone : $booking->patient_phone;
                    return $name . '<br><small class="text-muted">' . $phone . '</small>';
                })
                ->addColumn('service', function ($booking) {
                    $services = $booking->services;
                    if ($services->count() > 1) {
                        return $services->first()->name . ' <span class="badge bg-info">+' . ($services->count() - 1) . ' more</span>';
                    } elseif ($services->count() == 1) {
                        return $services->first()->name;
                    }
                    return '<span class="text-danger">No service</span>';
                })
                ->editColumn('booking_type', function ($booking) {
                    return $booking->booking_type === 'home_visit'
                        ? '<span class="badge bg-indigo">Home Visit</span>'
                        : '<span class="badge bg-success">Branch Visit</span>';
                })
                ->addColumn('schedule', function ($booking) {
                    return Carbon::parse($booking->scheduled_date)->format('d M Y') . '<br><small class="text-muted">' . Carbon::parse($booking->scheduled_time)->format('h:i A') . '</small>';
                })
                ->editColumn('status', function ($booking) {
                    $badges = [
                        'pending' => 'bg-warning',
                        'confirmed' => 'bg-info',
                        'sample_collected' => 'bg-purple',
                        'in_progress' => 'bg-primary',
                        'completed' => 'bg-success',
                        'cancelled' => 'bg-danger',
                        'no_show' => 'bg-secondary',
                    ];
                    $badgeClass = $badges[$booking->status] ?? 'bg-secondary';
                    return '<span class="badge ' . $badgeClass . '">' . ucfirst(str_replace('_', ' ', $booking->status)) . '</span>';
                })
                ->editColumn('total', function ($booking) {
                    return get_currency() . ' ' . number_format($booking->total_amount, 2);
                })
                ->addColumn('report', function ($booking) {
                    if ($booking->report) {
                        return '<a href="' . url('admin/reports/' . $booking->report->id . '/edit') . '" class="btn btn-sm btn-success shadow-sm rounded-pill px-3">
                                    <i class="fas fa-file-medical mr-1"></i> Report Entry
                                </a>';
                    }
                    
                    $hasLaboratory = $booking->services->where('category', 'laboratory')->count() > 0;
                    if ($hasLaboratory) {
                        return '<a href="' . url('admin/bookings/' . $booking->id . '/create_report') . '" class="btn btn-sm btn-outline-primary shadow-sm rounded-pill px-3">
                                    <i class="fas fa-plus mr-1"></i> Create Report
                                </a>';
                    }
                    
                    return '<span class="text-muted small">Not Required</span>';
                })
                ->addColumn('actions', function ($booking) {
                    return view('admin.bookings._action', compact('booking'))->render();
                })
                ->rawColumns(['booking_id', 'patient_name', 'service', 'booking_type', 'schedule', 'status', 'total', 'report', 'actions'])
                ->make(true);
        }

        return view('admin.bookings.index');
    }

    public function ajax(Request $request)
    {
        return $this->index($request);
    }

    public function createReport(Booking $booking)
    {
        $report = Group::where('booking_id', $booking->id)->first();
        if ($report) {
            return redirect()->route('admin.reports.edit', $report->id);
        }

        try {
            $patientId = $booking->patient_id;
            if (!$patientId) {
                $patient = Patient::where('phone', $booking->patient_phone)->first();
                if (!$patient) {
                    $patient = Patient::create([
                        'code' => patient_code(),
                        'name' => $booking->patient_name,
                        'phone' => $booking->patient_phone,
                        'email' => $booking->patient_email,
                        'address' => $booking->patient_address,
                    ]);
                }
                $patientId = $patient->id;
                $booking->update(['patient_id' => $patientId]);
            }

            $group = Group::create([
                'booking_id' => $booking->id,
                'patient_id' => $patientId,
                'branch_id' => $booking->branch_id,
                'subtotal' => $booking->total_amount,
                'total' => $booking->total_amount - $booking->discount,
                'discount' => $booking->discount,
                'paid' => $booking->paid_amount,
                'due' => $booking->due_amount,
            ]);

            $labServices = $booking->services()->where('category', 'laboratory')->get();
            
            foreach ($labServices as $service) {
                GroupTest::create([
                    'group_id' => $group->id,
                    'service_id' => $service->id,
                    'price' => $service->price,
                ]);
            }

            $groupsController = new GroupsController();
            $groupsController->generate_barcode($group);

            return redirect()->route('admin.reports.edit', $group->id)
                ->with('success', 'Report created successfully with booked services.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create report: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $services = Service::active()->orderBy('category')->orderBy('name')->get();
        $patients = Patient::orderBy('name')->get();
        $technicians = User::where('is_technician', true)->orderBy('name')->get();
        $branches = \App\Models\Branch::orderBy('name')->get();

        return view('admin.bookings.create', compact('services', 'patients', 'technicians', 'branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:20',
            'patient_email' => 'nullable|email',
            'patient_address' => 'nullable|string',
            'service_id' => 'required|array|min:1',
            'service_id.*' => 'exists:services,id',
            'booking_type' => 'required|in:branch_visit,home_visit',
            'branch_id' => 'required_if:booking_type,branch_visit|nullable|exists:branches,id',
            'payment_type' => 'required|in:online,pay_at_branch',
            'paid_amount' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'scheduled_time' => 'required',
        ]);

        $selectedServices = Service::whereIn('id', $request->service_id)->get();
        $totalAmount = 0;
        $pivotData = [];

        foreach ($selectedServices as $service) {
            $price = $service->price;
            $totalAmount += $price;
            $pivotData[$service->id] = ['price' => $price];
        }

        $paidAmount = $request->paid_amount ?? 0;
        $discount = $request->discount ?? 0;
        $dueAmount = $totalAmount - $paidAmount - $discount;
        if ($dueAmount < 0) $dueAmount = 0;

        $paymentStatus = 'pending';
        if ($paidAmount >= ($totalAmount - $discount)) {
            $paymentStatus = 'paid';
        } elseif ($paidAmount > 0) {
            $paymentStatus = 'partial';
        }

        $booking = Booking::create([
            'patient_id' => $request->patient_id,
            'branch_id' => $request->booking_type === 'branch_visit' ? $request->branch_id : null,
            'patient_name' => $request->patient_name,
            'patient_phone' => $request->patient_phone,
            'patient_email' => $request->patient_email,
            'patient_address' => $request->patient_address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'booking_type' => $request->booking_type,
            'payment_type' => $request->payment_type,
            'payment_status' => $paymentStatus,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'discount' => $discount,
            'due_amount' => $dueAmount,
            'scheduled_date' => $request->scheduled_date,
            'scheduled_time' => $request->scheduled_time,
            'notes' => $request->notes,
            'created_by' => auth()->guard('admin')->id(),
        ]);

        $booking->services()->attach($pivotData);

        session()->flash('success', 'Booking created successfully.');

        return redirect()->route('admin.bookings.show', $booking->id);
    }

    public function show(Booking $booking)
    {
        $booking->load(['patient', 'technician', 'creator', 'services']);
        $technicians = User::where('is_technician', true)->orderBy('name')->get();
        return view('admin.bookings.show', compact('booking', 'technicians'));
    }

    public function edit(Booking $booking)
    {
        $services = Service::active()->orderBy('category')->orderBy('name')->get();
        $patients = Patient::orderBy('name')->get();
        $technicians = User::where('is_technician', true)->orderBy('name')->get();
        $branches = \App\Models\Branch::orderBy('name')->get();

        return view('admin.bookings.edit', compact('booking', 'services', 'patients', 'technicians', 'branches'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:20',
            'patient_email' => 'nullable|email',
            'service_id' => 'required|array|min:1',
            'service_id.*' => 'exists:services,id',
            'booking_type' => 'required|in:branch_visit,home_visit',
            'branch_id' => 'required_if:booking_type,branch_visit|nullable|exists:branches,id',
            'payment_type' => 'required|in:online,pay_at_branch',
            'paid_amount' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
        ]);

        $selectedServices = Service::whereIn('id', $request->service_id)->get();
        $totalAmount = 0;
        $pivotData = [];

        foreach ($selectedServices as $service) {
            $price = $service->price;
            $totalAmount += $price;
            $pivotData[$service->id] = ['price' => $price];
        }

        $paidAmount = $request->paid_amount ?? 0;
        $discount = $request->discount ?? 0;
        $dueAmount = $totalAmount - $paidAmount - $discount;
        if ($dueAmount < 0) $dueAmount = 0;

        $paymentStatus = 'pending';
        if ($paidAmount >= ($totalAmount - $discount)) {
            $paymentStatus = 'paid';
        } elseif ($paidAmount > 0) {
            $paymentStatus = 'partial';
        }

        $booking->update([
            'patient_id' => $request->patient_id,
            'branch_id' => $request->booking_type === 'branch_visit' ? $request->branch_id : null,
            'patient_name' => $request->patient_name,
            'patient_phone' => $request->patient_phone,
            'patient_email' => $request->patient_email,
            'patient_address' => $request->patient_address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'booking_type' => $request->booking_type,
            'payment_type' => $request->payment_type,
            'payment_status' => $paymentStatus,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'discount' => $discount,
            'due_amount' => $dueAmount,
            'scheduled_date' => $request->scheduled_date,
            'scheduled_time' => $request->scheduled_time,
            'notes' => $request->notes,
        ]);

        $booking->services()->sync($pivotData);

        session()->flash('success', 'Booking updated successfully.');

        return redirect()->route('admin.bookings.show', $booking->id);
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        if ($request->has('update_payment')) {
            $request->validate([
                'paid_amount' => 'required|numeric|min:0',
                'discount' => 'required|numeric|min:0',
            ]);

            $totalAmount = $booking->total_amount;
            $paidAmount = $request->paid_amount;
            $discount = $request->discount;
            $dueAmount = $totalAmount - $paidAmount - $discount;
            if ($dueAmount < 0) $dueAmount = 0;

            $paymentStatus = 'pending';
            if ($paidAmount >= ($totalAmount - $discount)) {
                $paymentStatus = 'paid';
            } elseif ($paidAmount > 0) {
                $paymentStatus = 'partial';
            }

            $booking->update([
                'paid_amount' => $paidAmount,
                'discount' => $discount,
                'due_amount' => $dueAmount,
                'payment_status' => $paymentStatus,
            ]);

            session()->flash('success', 'Payment information updated successfully.');
            return redirect()->back();
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,sample_collected,in_progress,completed,cancelled,no_show',
        ]);

        $booking->update(['status' => $request->status]);

        if ($request->has('technician_id')) {
            $booking->update(['technician_id' => $request->technician_id]);
        }

        if ($request->has('admin_notes')) {
            $booking->update(['admin_notes' => $request->admin_notes]);
        }

        session()->flash('success', 'Booking status updated successfully.');

        return redirect()->back();
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        session()->flash('success', 'Booking deleted successfully.');

        return redirect()->route('admin.bookings.index');
    }

    public function results(Request $request)
    {
        if ($request->ajax()) {
            $query = Booking::with(['patient', 'services', 'report'])
                ->select('bookings.*')
                ->where('status', 'completed')
                ->orderBy('updated_at', 'desc');

            return DataTables::of($query)
                ->addColumn('booking_id', function ($booking) {
                    return 'BK-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT);
                })
                ->addColumn('patient_name', function ($booking) {
                    $name = $booking->patient ? $booking->patient->name : $booking->patient_name;
                    $phone = $booking->patient ? $booking->patient->phone : $booking->patient_phone;
                    return $name . '<br><small class="text-muted">' . $phone . '</small>';
                })
                ->addColumn('service', function ($booking) {
                    $services = $booking->services;
                    if ($services->count() > 1) {
                        return $services->first()->name . ' <span class="badge bg-info">+' . ($services->count() - 1) . ' more</span>';
                    } elseif ($services->count() == 1) {
                        return $services->first()->name;
                    }
                    return '<span class="text-danger">No service</span>';
                })
                ->addColumn('completed_at', function ($booking) {
                    return $booking->updated_at->format('d M Y') . '<br><small class="text-muted">' . $booking->updated_at->format('h:i A') . '</small>';
                })
                ->addColumn('actions', function ($booking) {
                    $reportId = $booking->report ? $booking->report->id : null;
                    
                    $html = '<div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle shadow-sm rounded-pill px-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cog mr-1"></i> Actions
                                </button>
                                <div class="dropdown-menu dropdown-menu-right shadow border-0">';
                    
                    if ($reportId) {
                        $html .= '<a class="dropdown-item py-2" href="' . route('admin.reports.show', $reportId) . '">
                                    <i class="fas fa-eye mr-2 text-info"></i> View Report
                                  </a>';
                        $html .= '<a class="dropdown-item py-2" href="' . route('admin.reports.pdf', $reportId) . '" target="_blank">
                                    <i class="fas fa-print mr-2 text-success"></i> Print Report
                                  </a>';
                    } else {
                        $html .= '<span class="dropdown-item py-2 text-muted">No Report Available</span>';
                    }
                    
                    $html .= '</div></div>';
                    return $html;
                })
                ->rawColumns(['booking_id', 'patient_name', 'service', 'completed_at', 'actions'])
                ->make(true);
        }

        return view('admin.bookings.results');
    }

    public function getPatients(Request $request)
    {
        $search = $request->get('q');
        
        $patients = Patient::where('name', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%")
            ->orWhere('code', 'like', "%{$search}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'phone', 'email', 'address']);

        return response()->json($patients);
    }
}
