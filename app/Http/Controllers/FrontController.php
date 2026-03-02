<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Patient;
use App\Models\HealthPackage;
use App\Models\HealthPackageBooking;
use App\Models\HealthPackageCategory;
use App\Models\Doctor;
use App\Models\DoctorSpecialty;
use App\Models\DoctorDepartment;
use App\Models\DoctorConsultationSlot;
use App\Models\DoctorConsultationBooking;
use App\Models\Branch;
use Carbon\Carbon;

class FrontController extends Controller
{
    public function index(){
        $homeSettings = home_page_settings();

        return view('frontend.index', compact('homeSettings'));
    }

    public function services(Request $request){
        $category = $request->category ?? $request->segment(2);
        $query = Service::active()->showOnFrontend();
        
        if ($category && in_array($category, ['laboratory', 'imaging', 'procedure'])) {
            $query->where('category', $category);
        }
        
        $services = $query->orderBy('category')->orderBy('name')->get();
        return view('frontend.services.services', compact('services', 'category'));
    }

    public function service_details(){
    	return view('frontend.services.service-details');
    }

    public function service_detail(Request $request, $id){
        $service = Service::with('components')->findOrFail($id);
        return view('frontend.services.service-detail', compact('service'));
    }

    public function store_booking(Request $request){
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:20',
            'patient_email' => 'nullable|email',
            'booking_type' => 'required|in:branch_visit,home_visit',
            'branch_id' => 'required_if:booking_type,branch_visit|nullable|exists:branches,id',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'scheduled_time' => 'required',
        ]);

        $cart = session()->get('cart', []);
        if (count($cart) == 0) {
            return redirect()->route('lab-test')->with('error', 'Your cart is empty.');
        }

        // Calculate totals and prepare services pivot data
        $totalAmount = 0;
        $pivotData = [];
        foreach ($cart as $id => $item) {
            $totalAmount += $item['price'];
            $pivotData[$id] = ['price' => $item['price']];
        }

        // Handle Home Visit Fee (Maximum fee among selected services)
        $extraFee = 0;
        if ($request->booking_type === 'home_visit') {
            foreach ($cart as $id => $item) {
                $service = Service::find($id);
                if ($service && $service->home_visit_available && $service->home_visit_price > $extraFee) {
                    $extraFee = $service->home_visit_price;
                }
            }
            $totalAmount += $extraFee;
        }
// Get or Create Patient
$patientId = null;
if (auth()->guard('patient')->check()) {
    $patientId = auth()->guard('patient')->id();
} else {
    // Check by phone OR email
    $existingPatient = Patient::where('phone', $request->patient_phone)
        ->when($request->patient_email, function($q) use ($request) {
            return $q->orWhere('email', $request->patient_email);
        })
        ->first();

    if ($existingPatient) {
        $patientId = $existingPatient->id;
        // Optionally update their info if it was missing
        if (empty($existingPatient->email) && $request->patient_email) {
            $existingPatient->update(['email' => $request->patient_email]);
        }
    } else {
        $newPatient = Patient::create([
            'code' => patient_code(),
            'name' => $request->patient_name,
            'phone' => $request->patient_phone,
            'email' => $request->patient_email,
            'gender' => 'male',
        ]);
        $patientId = $newPatient->id;
    }
}

        $booking = Booking::create([
            'patient_id' => $patientId,
            'branch_id' => $request->booking_type === 'branch_visit' ? $request->branch_id : null,
            'patient_name' => $request->patient_name,
            'patient_phone' => $request->patient_phone,
            'patient_email' => $request->patient_email,
            'patient_address' => $request->patient_address,
            'booking_type' => $request->booking_type,
            'payment_type' => $request->payment_type ?? 'pay_at_branch',
            'payment_status' => 'pending',
            'total_amount' => $totalAmount,
            'due_amount' => $totalAmount,
            'scheduled_date' => $request->scheduled_date,
            'scheduled_time' => $request->scheduled_time,
            'notes' => $request->notes,
        ]);

        // Attach all services from cart
        $booking->services()->attach($pivotData);

        // Clear Cart
        session()->forget('cart');

        return redirect()->route('bookings.confirmation', $booking->id)->with('success', 'Booking placed successfully!');
    }

    public function booking_confirmation(Request $request, $id){
        $booking = Booking::with('services', 'patient', 'branch')->findOrFail($id);
        return view('frontend.booking.confirmation', compact('booking'));
    }

    public function booking_receipt($id)
    {
        $booking = Booking::with(['services', 'patient', 'branch'])->findOrFail($id);
        
        // We can reuse the generate_pdf helper or create a specific one for receipts
        // Since we want it professional, let's pass a specific type
        $pdf_url = generate_pdf($booking, 2); // Type 2 for Receipt/Invoice
        return redirect($pdf_url);
    }

    public function my_bookings(Request $request){
        $patientId = auth()->guard('patient')->id();
        $bookings = Booking::with('services')
            ->where('patient_id', $patientId)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('frontend.booking.my-bookings', compact('bookings'));
    }

    public function health_check(){
        $categories = HealthPackageCategory::where('status', true)
            ->with(['packages' => function ($q) {
                $q->where('status', true)->where('show_on_frontend', true);
            }])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $healthCheckSettings = health_check_page_settings();

		return view('frontend.services.health-check', compact('categories', 'healthCheckSettings'));
    }

    public function package_details(Request $request, $slug){
        $package = HealthPackage::with('category')
            ->where('status', true)
            ->where('show_on_frontend', true)
            ->where('slug', $slug)
            ->first();

        if (!$package && ctype_digit((string) $slug)) {
            $package = HealthPackage::with('category')
                ->where('status', true)
                ->where('show_on_frontend', true)
                ->findOrFail((int) $slug);

            return redirect()->route('package-details', ['slug' => $package->slug]);
        }

        abort_unless($package, 404);

		return view('frontend.services.package-details', compact('package'));
    }

    public function package_booking_submit(Request $request, $slug)
    {
        $package = HealthPackage::where('slug', $slug)->first();
        if (!$package && ctype_digit((string) $slug)) {
            $package = HealthPackage::findOrFail((int) $slug);
        }
        abort_unless($package, 404);

        $data = $request->validate([
            'patient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'required|email|max:255',
            'dob' => 'required|date',
            'preferred_date' => 'nullable|date|after_or_equal:today',
            'notes' => 'nullable|string|max:2000',
        ]);

        $email = strtolower(trim($data['email']));
        $patient = Patient::where('email', $email)->first();

        if (!$patient) {
            $patient = Patient::create([
                'code' => patient_code(),
                'name' => $data['patient_name'],
                'gender' => 'male',
                'dob' => $data['dob'],
                'email' => $email,
                'phone' => $data['phone'],
            ]);
        } else {
            $patient->update([
                'name' => $data['patient_name'],
                'phone' => $data['phone'],
                'dob' => $data['dob'],
            ]);
        }

        $data['health_package_id'] = $package->id;
        $data['patient_id'] = $patient->id;
        $data['email'] = $email;
        $data['status'] = 'pending';

        HealthPackageBooking::create($data);

        return back()->with('success', 'Package booking request submitted successfully.');
    }

    public function membership(){
     	return view('frontend.services.membership-plan');
    }

    public function membership_details(Request $request, $id = null){
		return view('frontend.services.membership-details', compact('id'));
    }

    public function lab_test(){
        $services = Service::active()
            ->showOnFrontend()
            ->with(['serviceCategory', 'subCategory', 'components'])
            ->orderBy('name')
            ->get();

        $diagSettings = diagonostic_page_settings();

    	return view('frontend.services.lab-test', compact('services', 'diagSettings'));
    }

    public function video_consultation(){
    	return view('frontend.services.video-consultation');
    }

    public function beauty(){
    	return view('frontend.services.beauty');
    }

    public function about(){
    	return view('frontend.about.about');
    }

    public function about_details(){
    	return view('frontend.about.about-details');
    }

    public function bill_of_rights(){
    	return view('frontend.about.bill-of-right');
    }

    public function career(){
    	return view('frontend.about.career');
    }

    public function career_details(){
    	return view('frontend.about.career-details');
    }

    public function code_ethics(){
    	return view('frontend.about.code-of-ethics');
    }

    public function contact(){
    	return view('frontend.about.contact');
    }

    public function client(){
    	return view('frontend.about.corporate-clients');
    }

    public function management(){
    	return view('frontend.about.management');
    }

    public function management_details(){
    	return view('frontend.about.management-details');
    }

    public function mission_vision_value(){
    	return view('frontend.about.mission-vision-values');
    }

    public function privacy_notice(){
    	return view('frontend.about.privacy-notice');
    }

    public function doctor(){
        $query = Doctor::with(['specialty', 'department'])->where('status', true);

        if (request('specialty_id')) {
            $query->where('doctor_specialty_id', request('specialty_id'));
        }

        if (request('department_id')) {
            $query->where('doctor_department_id', request('department_id'));
        }

        if (request('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }

        $doctors = $query->orderBy('name')->get();
        $specialties = DoctorSpecialty::where('status', true)->orderBy('sort_order')->orderBy('name')->get();
        $departments = DoctorDepartment::where('status', true)->orderBy('sort_order')->orderBy('name')->get();
        $groupedDoctors = $doctors->groupBy(function ($doctor) {
            return optional($doctor->department)->name ?: 'General';
        });

    	return view('frontend.doctor.doctors', compact('doctors', 'specialties', 'departments', 'groupedDoctors'));
    }

    public function book_doctor($doctor = null){
        if ($doctor) {
            $model = Doctor::with(['specialty', 'department'])
                ->where('status', true)
                ->where(function ($q) use ($doctor) {
                    $q->where('slug', $doctor)->orWhere('id', $doctor);
                })
                ->firstOrFail();
        } else {
            $model = Doctor::with(['specialty', 'department'])->where('status', true)->firstOrFail();
        }

        $slots = DoctorConsultationSlot::where('status', true)->orderBy('sort_order')->orderBy('start_time')->get();
        $branches = Branch::orderBy('name')->get();

    	return view('frontend.doctor.book-doctor', compact('model', 'slots', 'branches'));
    }

    public function submit_doctor_booking(Request $request, $doctor)
    {
        $doctorModel = Doctor::where('status', true)
            ->where(function ($q) use ($doctor) {
                $q->where('slug', $doctor)->orWhere('id', $doctor);
            })
            ->firstOrFail();

        $data = $request->validate([
            'patient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'required|email|max:255',
            'dob' => 'required|date',
            'visit_type' => 'required|in:in_hub,video',
            'branch_id' => 'required_if:visit_type,in_hub|nullable|exists:branches,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'doctor_consultation_slot_id' => 'required|exists:doctor_consultation_slots,id',
            'notes' => 'nullable|string|max:2000',
        ]);

        if ($data['visit_type'] === 'video' && !$doctorModel->video_consultation_available) {
            return back()->withInput()->withErrors([
                'visit_type' => 'Video consultation is not available for this doctor.',
            ]);
        }

        $slot = DoctorConsultationSlot::where('status', true)->findOrFail($data['doctor_consultation_slot_id']);
        $email = strtolower(trim($data['email']));

        if (auth()->guard('patient')->check()) {
            $patient = auth()->guard('patient')->user();
            $data['patient_name'] = $patient->name ?: $data['patient_name'];
            $data['phone'] = $patient->phone ?: $data['phone'];
            $email = $patient->email ?: $email;
            $data['dob'] = $patient->dob ?: $data['dob'];
            $patient->update([
                'name' => $data['patient_name'],
                'phone' => $data['phone'],
                'dob' => $data['dob'],
            ]);
        } else {
            $patient = Patient::where('email', $email)->first();
            if (!$patient) {
                $patient = Patient::create([
                    'code' => patient_code(),
                    'name' => $data['patient_name'],
                    'gender' => 'male',
                    'dob' => $data['dob'],
                    'email' => $email,
                    'phone' => $data['phone'],
                ]);
            } else {
                $patient->update([
                    'name' => $data['patient_name'],
                    'phone' => $data['phone'],
                    'dob' => $data['dob'],
                ]);
            }
        }

        DoctorConsultationBooking::create([
            'doctor_id' => $doctorModel->id,
            'patient_id' => $patient->id ?? null,
            'doctor_consultation_slot_id' => $slot->id,
            'branch_id' => $data['visit_type'] === 'in_hub' ? $data['branch_id'] : null,
            'patient_name' => $data['patient_name'],
            'phone' => $data['phone'],
            'email' => $email,
            'dob' => $data['dob'],
            'visit_type' => $data['visit_type'],
            'appointment_date' => $data['appointment_date'],
            'notes' => $data['notes'] ?? null,
            'consultation_fee' => $doctorModel->consultation_fee,
            'commission_percentage' => $doctorModel->commission,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Consultation booking request submitted successfully.');
    }

    public function blog(){
    	return view('frontend.community.blog');
    }

    public function blog_details(){
    	return view('frontend.community.blog-details');
    }

    public function event(){
    	return view('frontend.community.event');
    }

    public function event_details(){
    	return view('frontend.community.event-details');
    }

    public function press(){
    	return view('frontend.community.press');
    }

    public function press_details(){
    	return view('frontend.community.press-details');
    }

    public function gallery(){
    	return view('frontend.community.gallery');
    }
}
