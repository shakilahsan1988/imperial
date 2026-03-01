<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Patient;
use App\Models\User;
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
            $query = Booking::with(['patient', 'service', 'technician', 'creator'])
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
                    if ($booking->patient) {
                        return $booking->patient->name . '<br><small class="text-muted">' . $booking->patient->phone . '</small>';
                    }
                    return $booking->patient_name . '<br><small class="text-muted">' . $booking->patient_phone . '</small>';
                })
                ->addColumn('service', function ($booking) {
                    return $booking->service->name . '<br><small class="text-muted">' . ucfirst($booking->service->category) . '</small>';
                })
                ->addColumn('booking_type', function ($booking) {
                    return $booking->booking_type === 'home_visit'
                        ? '<span class="badge bg-indigo">Home Visit</span>'
                        : '<span class="badge bg-success">Branch Visit</span>';
                })
                ->addColumn('schedule', function ($booking) {
                    return Carbon::parse($booking->scheduled_date)->format('d M Y') . '<br><small class="text-muted">' . Carbon::parse($booking->scheduled_time)->format('h:i A') . '</small>';
                })
                ->addColumn('status', function ($booking) {
                    $badges = [
                        'pending' => 'bg-warning',
                        'confirmed' => 'bg-info',
                        'sample_collected' => 'bg-purple',
                        'in_progress' => 'bg-primary',
                        'completed' => 'bg-success',
                        'cancelled' => 'bg-danger',
                        'no_show' => 'bg-secondary',
                    ];
                    return '<span class="badge ' . ($badges[$booking->status] ?? 'bg-secondary') . '">' . ucfirst($booking->status) . '</span>';
                })
                ->addColumn('total', function ($booking) {
                    return number_format($booking->total_amount, 2);
                })
                ->addColumn('actions', function ($booking) {
                    return view('admin.bookings._action', compact('booking'))->render();
                })
                ->rawColumns(['booking_id', 'patient_name', 'service', 'booking_type', 'schedule', 'status', 'actions'])
                ->make(true);
        }

        return view('admin.bookings.index');
    }

    public function create()
    {
        $services = Service::active()->orderBy('category')->orderBy('name')->get();
        $patients = Patient::orderBy('name')->get();
        $technicians = User::where('is_technician', true)->orderBy('name')->get();

        return view('admin.bookings.create', compact('services', 'patients', 'technicians'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:20',
            'patient_email' => 'nullable|email',
            'patient_address' => 'nullable|string',
            'service_id' => 'required|exists:services,id',
            'booking_type' => 'required|in:branch_visit,home_visit',
            'payment_type' => 'required|in:online,pay_at_branch',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'scheduled_time' => 'required',
        ]);

        $service = Service::findOrFail($request->service_id);

        $totalAmount = $service->price;
        if ($request->booking_type === 'home_visit' && $service->home_visit_price) {
            $totalAmount += $service->home_visit_price;
        }

        $booking = Booking::create([
            'patient_id' => $request->patient_id,
            'service_id' => $request->service_id,
            'patient_name' => $request->patient_name,
            'patient_phone' => $request->patient_phone,
            'patient_email' => $request->patient_email,
            'patient_address' => $request->patient_address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'booking_type' => $request->booking_type,
            'payment_type' => $request->payment_type,
            'payment_status' => $request->payment_type === 'online' ? 'paid' : 'pending',
            'total_amount' => $totalAmount,
            'scheduled_date' => $request->scheduled_date,
            'scheduled_time' => $request->scheduled_time,
            'notes' => $request->notes,
            'created_by' => auth()->guard('admin')->id(),
        ]);

        session()->flash('success', 'Booking created successfully.');

        return redirect()->route('admin.bookings.show', $booking->id);
    }

    public function show(Booking $booking)
    {
        $booking->load(['patient', 'service', 'technician', 'creator']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $services = Service::active()->orderBy('category')->orderBy('name')->get();
        $patients = Patient::orderBy('name')->get();
        $technicians = User::where('is_technician', true)->orderBy('name')->get();

        return view('admin.bookings.edit', compact('booking', 'services', 'patients', 'technicians'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:20',
            'patient_email' => 'nullable|email',
            'service_id' => 'required|exists:services,id',
            'booking_type' => 'required|in:branch_visit,home_visit',
            'payment_type' => 'required|in:online,pay_at_branch',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
        ]);

        $service = Service::findOrFail($request->service_id);

        $totalAmount = $service->price;
        if ($request->booking_type === 'home_visit' && $service->home_visit_price) {
            $totalAmount += $service->home_visit_price;
        }

        $booking->update([
            'patient_id' => $request->patient_id,
            'service_id' => $request->service_id,
            'patient_name' => $request->patient_name,
            'patient_phone' => $request->patient_phone,
            'patient_email' => $request->patient_email,
            'patient_address' => $request->patient_address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'booking_type' => $request->booking_type,
            'payment_type' => $request->payment_type,
            'total_amount' => $totalAmount,
            'scheduled_date' => $request->scheduled_date,
            'scheduled_time' => $request->scheduled_time,
            'notes' => $request->notes,
        ]);

        session()->flash('success', 'Booking updated successfully.');

        return redirect()->route('admin.bookings.show', $booking->id);
    }

    public function updateStatus(Request $request, Booking $booking)
    {
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

    public function ajax(Request $request)
    {
        $query = Booking::with(['patient', 'service']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('scheduled_date', $request->date);
        }

        $bookings = $query->orderBy('scheduled_time')->get();

        return response()->json($bookings);
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
