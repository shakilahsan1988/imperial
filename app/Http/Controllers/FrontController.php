<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Patient;
use Carbon\Carbon;

class FrontController extends Controller
{
    public function index(){
       return view('frontend.index');
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
		return view('frontend.services.health-check');
    }

    public function package_details(Request $request, $id = null){
		return view('frontend.services.package-details', compact('id'));
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
            
    	return view('frontend.services.lab-test', compact('services'));
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
    	return view('frontend.doctor.doctors');
    }

    public function book_doctor(){
    	return view('frontend.doctor.book-doctor');
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
