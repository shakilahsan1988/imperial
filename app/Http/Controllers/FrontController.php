<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Booking;
use App\Models\Branch;
use App\Models\Doctor;
use App\Models\DoctorConsultationBooking;
use App\Models\DoctorConsultationSlot;
use App\Models\DoctorDepartment;
use App\Models\GalleryGroup;
use App\Services\SslCommerzService;
use App\Models\HealthPackage;
use App\Models\HealthPackageBooking;
use App\Models\HealthPackageCategory;
use App\Models\MembershipCategory;
use App\Models\MembershipPlan;
use App\Models\MembershipPlanBooking;
use App\Models\Page;
use App\Models\Patient;
use App\Models\Service;
use App\Models\TeamMember;
use App\Support\DoctorScheduleDays;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $homeSettings = home_page_settings();
        $homeBranches = Branch::withCount(['galleries', 'doctors', 'managementTeams'])
            ->orderBy('id')
            ->take(2)
            ->get();
        $homeDoctors = Doctor::with(['specialty', 'branchSchedules.branch'])
            ->where('status', true)
            ->whereNotNull('image')
            ->whereNotNull('qualification')
            ->inRandomOrder()
            ->take(10)
            ->get();

        return view('frontend.index', compact('homeSettings', 'homeDoctors', 'homeBranches'));
    }

    public function services(Request $request)
    {
        $category = $request->category ?? $request->segment(2);
        $query = Service::active()->showOnFrontend();

        if ($category && in_array($category, ['laboratory', 'imaging', 'procedure'])) {
            $query->where('category', $category);
        }

        $services = $query->orderBy('category')->orderBy('name')->get();
        $pageSettings = services_page_settings();

        return view('frontend.services.services', compact('services', 'category', 'pageSettings'));
    }

    public function service_details()
    {
        return $this->managedPageOrView('service-details', 'frontend.services.service-details');
    }

    public function service_detail(Request $request, $id)
    {
        $service = Service::with('components')->findOrFail($id);

        return view('frontend.services.service-detail', compact('service'));
    }

    public function store_booking(Request $request)
    {
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
                ->when($request->patient_email, function ($q) use ($request) {
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

        $location = $booking->booking_type === 'home_visit'
            ? 'your home'
            : (optional($booking->branch)->title ?: optional($booking->branch)->name ?: 'our branch');

        $this->sendBookingSms($booking->patient_phone, sprintf(
            'Hi %s, your Imperial Health booking is confirmed for %s at %s (%s). Thank you for choosing Imperial Health.',
            $booking->patient_name,
            \Carbon\Carbon::parse($booking->scheduled_date)->format('d M Y'),
            $booking->scheduled_time,
            $location
        ));
        $this->sendPatientConfirmationEmail($booking->patient_email, new \App\Mail\BookingConfirmation($booking));
        $this->sendAdminBookingNotification('booking', $booking);

        // Clear Cart
        session()->forget('cart');

        return redirect()->route('bookings.confirmation', $booking->id)->with('success', 'Booking placed successfully!');
    }

    public function booking_confirmation(Request $request, $id)
    {
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

    public function my_bookings(Request $request)
    {
        $patientId = auth()->guard('patient')->id();
        $bookings = Booking::with('services')
            ->where('patient_id', $patientId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.booking.my-bookings', compact('bookings'));
    }

    public function health_check()
    {
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

    public function package_details(Request $request, $slug)
    {
        $package = HealthPackage::with('category')
            ->where('status', true)
            ->where('show_on_frontend', true)
            ->where('slug', $slug)
            ->first();

        if (! $package && ctype_digit((string) $slug)) {
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
        if (! $package && ctype_digit((string) $slug)) {
            $package = HealthPackage::findOrFail((int) $slug);
        }
        abort_unless($package, 404);

        $data = $request->validate([
            'patient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'age' => 'nullable|integer|min:0|max:150',
            'preferred_date' => 'nullable|date|after_or_equal:today',
            'notes' => 'nullable|string|max:2000',
        ]);

        $email = ! empty($data['email']) ? strtolower(trim($data['email'])) : null;
        $patient = $email ? Patient::where('email', $email)->first() : null;

        if ($email) {
            if (! $patient) {
                $patient = Patient::create([
                    'code' => patient_code(),
                    'name' => $data['patient_name'],
                    'gender' => 'male',
                    'email' => $email,
                    'phone' => $data['phone'],
                ]);
            } else {
                $patient->update([
                    'name' => $data['patient_name'],
                    'phone' => $data['phone'],
                ]);
            }
        }

        $data['health_package_id'] = $package->id;
        $data['patient_id'] = $patient?->id;
        $data['email'] = $email;
        $data['status'] = 'pending';
        $data['total_amount'] = $package->price;
        $data['paid_amount'] = 0;
        $data['due_amount'] = $package->price;
        $data['payment_status'] = 'pending';

        $booking = HealthPackageBooking::create($data);

        $this->sendBookingSms($data['phone'], sprintf(
            'Hi %s, your booking request for the "%s" health package has been received. Our team will contact you shortly to confirm your schedule. - Imperial Health',
            $data['patient_name'],
            $package->name
        ));
        $this->sendPatientConfirmationEmail($email, new \App\Mail\HealthPackageBookingConfirmation($booking));
        $this->sendAdminBookingNotification('health_package', $booking);

        return back()->with('success', 'Package booking request submitted successfully.');
    }

    public function membership()
    {
        $categories = MembershipCategory::where('status', true)
            ->with(['plans' => function ($q) {
                $q->where('status', true)->where('show_on_frontend', true);
            }])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $pageSettings = membership_page_settings();

        return view('frontend.services.membership-plan', compact('categories', 'pageSettings'));
    }

    public function membership_details(Request $request, $id = null)
    {
        abort_unless($id, 404);

        $plan = MembershipPlan::with('category')
            ->where('status', true)
            ->where('show_on_frontend', true)
            ->where('slug', $id)
            ->first();

        if (! $plan && ctype_digit((string) $id)) {
            $plan = MembershipPlan::with('category')
                ->where('status', true)
                ->where('show_on_frontend', true)
                ->findOrFail((int) $id);
        }

        abort_unless($plan, 404);

        $relatedPlans = MembershipPlan::where('status', true)
            ->where('show_on_frontend', true)
            ->where('id', '!=', $plan->id)
            ->where('membership_category_id', $plan->membership_category_id)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->take(3)
            ->get();

        return view('frontend.services.membership-details', compact('plan', 'relatedPlans'));
    }

    public function membership_plan_booking_submit(Request $request, $slug)
    {
        $plan = MembershipPlan::where('slug', $slug)->first();
        if (! $plan && ctype_digit((string) $slug)) {
            $plan = MembershipPlan::findOrFail((int) $slug);
        }
        abort_unless($plan, 404);

        $data = $request->validate([
            'patient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'age' => 'nullable|integer|min:0|max:150',
            'preferred_start_date' => 'nullable|date|after_or_equal:today',
            'notes' => 'nullable|string|max:2000',
        ]);

        $email = ! empty($data['email']) ? strtolower(trim($data['email'])) : null;
        $patient = $email ? Patient::where('email', $email)->first() : null;

        if ($email) {
            if (! $patient) {
                $patient = Patient::create([
                    'code' => patient_code(),
                    'name' => $data['patient_name'],
                    'gender' => 'male',
                    'email' => $email,
                    'phone' => $data['phone'],
                ]);
            } else {
                $patient->update([
                    'name' => $data['patient_name'],
                    'phone' => $data['phone'],
                ]);
            }
        }

        $booking = MembershipPlanBooking::create([
            'membership_plan_id' => $plan->id,
            'patient_id' => $patient?->id,
            'patient_name' => $data['patient_name'],
            'phone' => $data['phone'],
            'email' => $email,
            'age' => $data['age'] ?? null,
            'preferred_start_date' => $data['preferred_start_date'] ?? null,
            'notes' => $data['notes'] ?? null,
            'total_amount' => $plan->price,
            'paid_amount' => 0,
            'due_amount' => $plan->price,
            'payment_status' => 'pending',
            'status' => 'pending',
        ]);

        $this->sendBookingSms($data['phone'], sprintf(
            'Hi %s, your booking request for the "%s" membership plan has been received. Our team will contact you shortly to confirm. - Imperial Health',
            $data['patient_name'],
            $plan->name
        ));
        $this->sendPatientConfirmationEmail($email, new \App\Mail\MembershipPlanBookingConfirmation($booking));
        $this->sendAdminBookingNotification('membership_plan', $booking);

        return back()->with('success', 'Membership plan booking submitted successfully.');
    }

    public function lab_test()
    {
        $services = Service::active()
            ->showOnFrontend()
            ->with(['serviceCategory', 'subCategory', 'components'])
            ->orderByRaw("case
                when category = 'laboratory' then 1
                when category = 'imaging' then 2
                when category = 'procedure' then 3
                else 4
            end")
            ->orderBy('sub_category')
            ->orderBy('name')
            ->get();

        $diagSettings = diagonostic_page_settings();

        return view('frontend.services.lab-test', compact('services', 'diagSettings'));
    }

    public function video_consultation()
    {
        $plans = MembershipPlan::with('category')
            ->where('status', true)
            ->where('show_on_frontend', true)
            ->where('is_video_consultant', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $pageSettings = video_consultation_page_settings();

        return view('frontend.services.video-consultation', compact('plans', 'pageSettings'));
    }

    public function beauty()
    {
        return $this->managedPageOrView('beauty', 'frontend.services.beauty');
    }

    public function about()
    {
        $pageSettings = about_page_settings();
        $teamMembers = TeamMember::with('branch')->active()->ordered()->get();

        return view('frontend.about.about', compact('pageSettings', 'teamMembers'));
    }

    public function about_details()
    {
        // Temporarily unpublished: this page hardcoded a competitor's founder
        // bio/photo. Not linked from any nav or page. Restore once Imperial
        // has verified founder/leadership content to publish here.
        return $this->managedPageOrFail('about-details');
    }

    public function bill_of_rights()
    {
        return $this->managedPageOrView('bill-of-right', 'frontend.about.bill-of-right');
    }

    public function career()
    {
        return $this->managedPageOrView('career', 'frontend.about.career');
    }

    public function career_details()
    {
        return $this->managedPageOrView('career-details', 'frontend.about.career-details');
    }

    public function code_ethics()
    {
        return $this->managedPageOrView('code-of-ethics', 'frontend.about.code-of-ethics');
    }

    public function contact()
    {
        $pageSettings = contact_page_settings();
        $branches = Branch::orderBy('name')->get();

        return view('frontend.about.contact', compact('pageSettings', 'branches'));
    }

    public function client()
    {
        return $this->managedPageOrView('client', 'frontend.about.corporate-clients');
    }

    public function management()
    {
        $pageSettings = management_page_settings();
        $teamMembers = TeamMember::with('branch')->active()->ordered()->get();

        return view('frontend.about.management', compact('pageSettings', 'teamMembers'));
    }

    public function management_details($slug)
    {
        $member = TeamMember::with('branch')->where('slug', $slug)->firstOrFail();

        return view('frontend.about.management-details', compact('member'));
    }

    public function branches()
    {
        $branches = Branch::withCount(['galleries', 'doctors', 'managementTeams'])
            ->orderBy('id')
            ->get();

        return view('frontend.branches.index', compact('branches'));
    }

    public function branch_details($slug)
    {
        $branch = Branch::with([
            'galleries',
            'managementTeams' => function ($query) {
                $query->where('status', true)->orderBy('sort_order')->orderBy('id');
            },
            'doctors' => function ($query) {
                $query->with(['specialty', 'branchSchedules' => function ($scheduleQuery) {
                    $scheduleQuery->with('branch');
                }])->where('status', true)->orderBy('name');
            },
        ])->where('slug', $slug)->firstOrFail();

        return view('frontend.branches.details', compact('branch'));
    }

    public function mission_vision_value()
    {
        $pageSettings = mission_vision_page_settings();
        $homeSettings = home_page_settings();

        return view('frontend.about.mission-vision-values', compact('pageSettings', 'homeSettings'));
    }

    public function privacy_notice()
    {
        return $this->managedPageOrView('privacy-notice', 'frontend.about.privacy-notice');
    }

    public function doctor()
    {
        $query = Doctor::with(['specialty', 'department', 'branchSchedules.branch'])->where('status', true);

        if (request('department_id')) {
            $query->where('doctor_department_id', request('department_id'));
        }

        if (request('consultation_type') === 'video') {
            $query->where('video_consultation_available', true);
        }

        if (request('name')) {
            $query->where('name', 'like', '%'.request('name').'%');
        }

        $doctors = $query->orderByDesc('is_featured')->orderBy('name')->get();
        $departments = DoctorDepartment::where('status', true)->orderBy('sort_order')->orderBy('name')->get();

        $doctorsByDepartmentId = $doctors->groupBy(function ($doctor) {
            return optional($doctor->department)->id ?: 0;
        });

        $groupedDoctors = collect();
        foreach ($departments as $department) {
            if ($doctorsByDepartmentId->has($department->id)) {
                $groupedDoctors->put($department->name, $doctorsByDepartmentId->get($department->id));
            }
        }
        if ($doctorsByDepartmentId->has(0)) {
            $groupedDoctors->put('General', $doctorsByDepartmentId->get(0));
        }
        $pageSettings = doctors_page_settings();

        return view('frontend.doctor.doctors', compact('doctors', 'departments', 'groupedDoctors', 'pageSettings'));
    }

    public function book_doctor($doctor = null)
    {
        if ($doctor) {
            $model = Doctor::with(['specialty', 'department'])
                ->with(['branchSchedules.branch'])
                ->where('status', true)
                ->where(function ($q) use ($doctor) {
                    $q->where('slug', $doctor)->orWhere('id', $doctor);
                })
                ->firstOrFail();
        } else {
            $model = Doctor::with(['specialty', 'department', 'branchSchedules.branch'])->where('status', true)->firstOrFail();
        }

        $slots = DoctorConsultationSlot::where('status', true)->orderBy('sort_order')->orderBy('start_time')->get();
        $branches = $model->branches()->orderBy('name')->get();

        // Weekday sets the datepicker uses to grey out non-scheduled days, keyed
        // by branch id. Normalised here on the server so the browser never has to
        // re-parse the admin's free-text "Sun, Wed" schedule strings.
        $allowedWeekdaysByBranch = $model->branchSchedules
            ->mapWithKeys(fn ($schedule) => [
                $schedule->branch_id => DoctorScheduleDays::weekdayNumbers(
                    DoctorScheduleDays::forBranch($model, $schedule->branch_id)
                ),
            ])
            ->all();

        $videoWeekdays = DoctorScheduleDays::weekdayNumbers(DoctorScheduleDays::forVideo($model));

        return view('frontend.doctor.book-doctor', compact(
            'model', 'slots', 'branches', 'allowedWeekdaysByBranch', 'videoWeekdays'
        ));
    }

    public function submit_doctor_booking(Request $request, $doctor)
    {
        $doctorModel = Doctor::with('branchSchedules')->where('status', true)
            ->where(function ($q) use ($doctor) {
                $q->where('slug', $doctor)->orWhere('id', $doctor);
            })
            ->firstOrFail();

        $data = $request->validate([
            'patient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'age' => 'nullable|integer|min:0|max:150',
            'visit_type' => 'required|in:in_hub,video',
            'branch_id' => 'required_if:visit_type,in_hub|nullable|exists:branches,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'doctor_consultation_slot_id' => 'nullable|exists:doctor_consultation_slots,id',
            'notes' => 'nullable|string|max:2000',
        ]);

        if ($data['visit_type'] === 'video' && ! $doctorModel->video_consultation_available) {
            return back()->withInput()->withErrors([
                'visit_type' => 'Video consultation is not available for this doctor.',
            ]);
        }

        if (
            $data['visit_type'] === 'in_hub'
            && ! $doctorModel->branchSchedules->contains('branch_id', (int) $data['branch_id'])
        ) {
            return back()->withInput()->withErrors([
                'branch_id' => 'Selected branch is not available for this doctor.',
            ]);
        }

        // The datepicker already prevents picking an unscheduled day, but the
        // request is what actually has to hold - a crafted POST bypasses any
        // client-side check. Runs before the booking is created so a rejected date
        // never sends the confirmation SMS/email or the admin notification.
        $allowedDays = $data['visit_type'] === 'in_hub'
            ? DoctorScheduleDays::forBranch($doctorModel, (int) $data['branch_id'])
            : DoctorScheduleDays::forVideo($doctorModel);

        if (! DoctorScheduleDays::allowsDate($allowedDays, $data['appointment_date'])) {
            return back()->withInput()->withErrors([
                'appointment_date' => $data['visit_type'] === 'in_hub'
                    ? 'The selected date is not available for this doctor at this branch.'
                    : 'The selected date is not available for this doctor.',
            ]);
        }

        $consultationFee = $data['visit_type'] === 'video'
            ? ($doctorModel->video_consultation_fee ?? $doctorModel->consultation_fee)
            : $doctorModel->consultation_fee;

        // In-hub bookings use the doctor's schedule time for the chosen branch;
        // video bookings pick one of the doctor's branch schedule times. A
        // global slot is only used when the doctor has no schedule time set.
        $slot = null;
        if ($data['visit_type'] === 'in_hub') {
            $appointmentTime = trim((string) optional($doctorModel->branchSchedules->firstWhere('branch_id', (int) $data['branch_id']))->schedule_time);
        } else {
            $videoTimes = $doctorModel->scheduleTimes();
            $requestedTime = trim((string) $request->input('appointment_time'));
            $appointmentTime = in_array($requestedTime, $videoTimes, true)
                ? $requestedTime
                : (count($videoTimes) === 1 ? $videoTimes[0] : '');

            if ($appointmentTime === '' && $videoTimes !== []) {
                return back()->withInput()->withErrors([
                    'appointment_time' => 'Please select a time slot.',
                ]);
            }
        }

        if ($appointmentTime === '') {
            if (empty($data['doctor_consultation_slot_id'])) {
                return back()->withInput()->withErrors([
                    'doctor_consultation_slot_id' => 'Please select a time slot.',
                ]);
            }
            $slot = DoctorConsultationSlot::where('status', true)->findOrFail($data['doctor_consultation_slot_id']);
        }

        $email = ! empty($data['email']) ? strtolower(trim($data['email'])) : null;

        if (auth()->guard('patient')->check()) {
            $patient = auth()->guard('patient')->user();
            $data['patient_name'] = $patient->name ?: $data['patient_name'];
            $data['phone'] = $patient->phone ?: $data['phone'];
            $email = $patient->email ?: $email;
            $patient->update([
                'name' => $data['patient_name'],
                'phone' => $data['phone'],
            ]);
        } else {
            $patient = $email ? Patient::where('email', $email)->first() : null;
            if ($email) {
                if (! $patient) {
                    $patient = Patient::create([
                        'code' => patient_code(),
                        'name' => $data['patient_name'],
                        'gender' => 'male',
                        'email' => $email,
                        'phone' => $data['phone'],
                    ]);
                } else {
                    $patient->update([
                        'name' => $data['patient_name'],
                        'phone' => $data['phone'],
                    ]);
                }
            }
        }

        $booking = DoctorConsultationBooking::create([
            'consultation_fee' => $consultationFee,
            'doctor_id' => $doctorModel->id,
            'patient_id' => $patient->id ?? null,
            'doctor_consultation_slot_id' => $slot?->id,
            'appointment_time' => $appointmentTime !== '' ? $appointmentTime : null,
            'branch_id' => $data['visit_type'] === 'in_hub' ? $data['branch_id'] : null,
            'patient_name' => $data['patient_name'],
            'phone' => $data['phone'],
            'email' => $email,
            'age' => $data['age'] ?? null,
            'visit_type' => $data['visit_type'],
            'appointment_date' => $data['appointment_date'],
            'notes' => $data['notes'] ?? null,
            'commission_percentage' => $doctorModel->commission,
            'payment_method' => null,
            'payment_status' => 'unpaid',
            'currency' => 'BDT',
            'status' => 'pending',
        ]);

        if ($data['visit_type'] === 'video') {
            $location = 'Online Video Consultation';
        } else {
            $appointmentBranch = Branch::find($data['branch_id']);
            $location = optional($appointmentBranch)->title ?: optional($appointmentBranch)->name ?: 'our branch';
        }

        $this->sendBookingSms($data['phone'], sprintf(
            'Hi %s, your appointment with %s is confirmed for %s at %s (%s). Thank you for choosing Imperial Health.',
            $data['patient_name'],
            $doctorModel->name,
            \Carbon\Carbon::parse($data['appointment_date'])->format('d M Y'),
            $booking->time_label ?: '-',
            $location
        ));
        $this->sendPatientConfirmationEmail($email, new \App\Mail\DoctorConsultationBookingConfirmation($booking));
        $this->sendAdminBookingNotification('doctor_consultation', $booking);

        return redirect()->route('doctor-booking.confirm', $booking->id);
    }

    /**
     * Show booking confirmation / payment page after booking is created
     */
    public function doctorBookingConfirm($id)
    {
        $booking = DoctorConsultationBooking::with(['doctor.specialty', 'doctor.department', 'slot', 'branch'])
            ->whereIn('payment_status', ['unpaid', 'cancelled'])
            ->findOrFail($id);

        $sslcommerz = setting('sslcommerz');
        $sslEnabled = is_array($sslcommerz) && ($sslcommerz['enabled'] ?? false);

        return view('frontend.booking.doctor-booking-confirm', compact('booking', 'sslEnabled'));
    }

    /**
     * Confirm cash payment for an existing booking
     */
    public function confirmCashPayment(Request $request, $id)
    {
        $booking = DoctorConsultationBooking::whereIn('payment_status', ['unpaid', 'cancelled'])->findOrFail($id);
        $isVideo = $booking->visit_type === 'video';

        // A video patient is at home and can't pay cash: they pay online, or
        // (when online payment is off) confirm now and staff collect later.
        if ($isVideo && app(SslCommerzService::class)->isEnabled()) {
            return back()->with('error', 'Cash payment is not available for video consultation. Please pay online.');
        }

        // The booking is confirmed, but no money has been received yet, so the
        // payment stays pending until an admin marks it as paid.
        $booking->update([
            'status' => $booking->status === 'pending' ? 'confirmed' : $booking->status,
            'payment_method' => $isVideo ? 'pay_later' : 'cash',
            'payment_status' => 'unpaid',
        ]);

        $booking->load(['doctor.specialty', 'doctor.department', 'slot', 'branch']);

        return view('frontend.booking.doctor-booking-success', compact('booking'));
    }

    /**
     * Initiate SSLCommerz payment for an existing booking
     */
    public function doctorBookingPayOnline($id)
    {
        $booking = DoctorConsultationBooking::whereIn('payment_status', ['unpaid', 'cancelled'])->findOrFail($id);

        $sslService = app(SslCommerzService::class);

        if (!$sslService->isEnabled()) {
            return back()->with('error', 'Online payment is currently unavailable. Please select Cash Payment.');
        }

        $paymentResult = $sslService->initiatePayment($booking);

        if ($paymentResult['success']) {
            return redirect($paymentResult['gateway_url']);
        }

        return back()->with('error', $paymentResult['message'] ?? 'Payment initiation failed. Please try again or choose Cash Payment.');
    }

    public function blog(Request $request)
    {
        $pageSettings = blog_page_settings();
        $q = trim((string) $request->query('q', ''));
        $categorySlug = trim((string) $request->query('category', ''));

        $perPage = (int) ($pageSettings['blogs_per_page'] ?? 8);
        if ($perPage < 1 || $perPage > 50) {
            $perPage = 8;
        }

        $query = Blog::with('category')->published()->orderByDesc('published_at')->orderByDesc('created_at');

        if ($q !== '') {
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', '%'.$q.'%')
                    ->orWhere('excerpt', 'like', '%'.$q.'%')
                    ->orWhere('content', 'like', '%'.$q.'%');
            });
        }

        if ($categorySlug !== '') {
            $query->whereHas('category', function ($builder) use ($categorySlug) {
                $builder->where('slug', $categorySlug);
            });
        }

        $blogs = $query->paginate($perPage)->withQueryString();
        $categories = BlogCategory::where('status', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('frontend.community.blog', compact('pageSettings', 'blogs', 'q', 'categories', 'categorySlug'));
    }

    public function blog_details($slug = null)
    {
        $query = Blog::with('category')->published()->orderByDesc('published_at')->orderByDesc('created_at');

        if ($slug) {
            $blog = (clone $query)->where('slug', $slug)->firstOrFail();
        } else {
            $blog = (clone $query)->firstOrFail();
        }

        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->when($blog->blog_category_id, function ($builder) use ($blog) {
                $builder->where('blog_category_id', $blog->blog_category_id);
            })
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->take(4)
            ->get();

        return view('frontend.community.blog-details', compact('blog', 'relatedBlogs'));
    }

    public function event()
    {
        // Temporarily unpublished: hardcoded competitor's event history
        // (verbatim in 2 entries, unverified for the rest). Not linked from
        // any nav or page. Restore once Imperial has its own verified
        // community-event content.
        return $this->managedPageOrFail('event');
    }

    public function event_details()
    {
        // Temporarily unpublished: hardcoded a competitor's event write-up
        // naming their real staff and partner org. Not linked from any nav
        // or page. Restore once Imperial has its own verified content.
        return $this->managedPageOrFail('event-details');
    }

    public function press()
    {
        // Temporarily unpublished: hardcoded a competitor's press releases
        // and hotlinked their CDN images. Not linked from any nav or page.
        // Restore once Imperial has its own verified press content.
        return $this->managedPageOrFail('press');
    }

    public function press_details()
    {
        // Temporarily unpublished: hardcoded a competitor's press release
        // verbatim, naming real third parties unrelated to Imperial. Not
        // linked from any nav or page. Restore once Imperial has its own
        // verified press content.
        return $this->managedPageOrFail('press-details');
    }

    public function gallery()
    {
        $pageSettings = gallery_page_settings();
        $galleryGroups = GalleryGroup::with('images')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('frontend.community.gallery', compact('pageSettings', 'galleryGroups'));
    }

    /**
     * Let an active Dynamic Page override a legacy static frontend route while
     * retaining the existing Blade page until an administrator publishes one.
     */
    private function managedPageOrView(string $slug, string $fallbackView, array $data = [])
    {
        $page = Page::where('status', true)->where('slug', $slug)->first();

        return $page
            ? view('frontend.dynamic-page', compact('page'))
            : view($fallbackView, $data);
    }

    /**
     * Resolve formerly unpublished routes from Dynamic Pages only.
     */
    private function managedPageOrFail(string $slug)
    {
        $page = Page::where('status', true)->where('slug', $slug)->firstOrFail();

        return view('frontend.dynamic-page', compact('page'));
    }

    /**
     * Send a booking confirmation SMS. `send_sms()` already swallows its own
     * errors and no-ops when the SMS gateway isn't configured, so a booking never
     * fails because the SMS didn't go out.
     */
    private function sendBookingSms(?string $phone, string $message): void
    {
        $phone = trim((string) $phone);

        if ($phone !== '') {
            send_sms($phone, $message);
        }
    }

    /**
     * Send a booking confirmation email, only when the patient actually gave
     * one (email is optional on every booking form). A mail failure (bad SMTP
     * config, etc.) must never break the booking itself.
     */
    private function sendPatientConfirmationEmail(?string $email, \Illuminate\Mail\Mailable $mailable): void
    {
        $email = trim((string) $email);

        if ($email === '') {
            return;
        }

        try {
            \Illuminate\Support\Facades\Mail::to($email)->send($mailable);
        } catch (\Throwable $e) {
            // Swallow: a broken mail transport must not fail the booking.
        }
    }

    /**
     * Notify the configured admin recipients of every new booking, regardless of
     * whether the patient gave an email. Recipients come from
     * Admin > Software Settings > Booking Notifications.
     */
    private function sendAdminBookingNotification(string $type, $booking): void
    {
        $recipients = $this->bookingNotificationRecipients();

        if ($recipients === []) {
            return;
        }

        try {
            \Illuminate\Support\Facades\Mail::to($recipients)->send(
                new \App\Mail\AdminBookingNotification($type, $booking)
            );
        } catch (\Throwable $e) {
            // Swallow: a broken mail transport must not fail the booking.
        }
    }

    /**
     * Admin recipients for new-booking notifications.
     *
     * The two "no addresses" cases mean different things and are kept distinct:
     *  - row absent (never saved) -> fall back to the general contact email, so
     *    installs that never touched the new form behave exactly as before.
     *  - row saved as an empty list -> an admin deliberately turned these
     *    notifications off. This is the only way to disable them.
     */
    private function bookingNotificationRecipients(): array
    {
        $configured = setting('booking_notification_emails');

        if (is_array($configured)) {
            return array_values(array_filter(array_map(
                function ($email) {
                    return strtolower(trim((string) $email));
                },
                $configured
            )));
        }

        $fallback = trim((string) (setting('info')['email'] ?? ''));

        return $fallback === '' ? [] : [$fallback];
    }
}
