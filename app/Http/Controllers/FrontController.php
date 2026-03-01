<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Patient;
use Carbon\Carbon;

class FrontController extends Controller
{
    //
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
        $service = Service::findOrFail($id);
        return view('frontend.services.service-detail', compact('service'));
    }
    public function store_booking(Request $request){
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:20',
            'patient_email' => 'nullable|email',
            'booking_type' => 'required|in:branch_visit,home_visit',
            'payment_type' => 'required|in:online,pay_at_branch',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'scheduled_time' => 'required',
        ]);

        $service = Service::findOrFail($request->service_id);

        // Check if home visit is available
        if ($request->booking_type === 'home_visit' && !$service->home_visit_available) {
            return back()->with('error', 'Home visit is not available for this service.')->withInput();
        }

        // Calculate total amount
        $totalAmount = $service->price;
        if ($request->booking_type === 'home_visit' && $service->home_visit_price) {
            $totalAmount += $service->home_visit_price;
        }

        // Get or Create Patient
        $patientId = null;
        if (auth()->guard('patient')->check()) {
            $patientId = auth()->guard('patient')->id();
        } else {
            // Check by phone
            $existingPatient = Patient::where('phone', $request->patient_phone)->first();
            if ($existingPatient) {
                $patientId = $existingPatient->id;
            } else {
                $newPatient = Patient::create([
                    'code' => patient_code(),
                    'name' => $request->patient_name,
                    'phone' => $request->patient_phone,
                    'email' => $request->patient_email,
                    'gender' => 'male', // Default
                ]);
                $patientId = $newPatient->id;
            }
        }

        $booking = Booking::create([
            'patient_id' => $patientId,
            'service_id' => $service->id, // Keep for legacy compatibility if needed
            'patient_name' => $request->patient_name,
            'patient_phone' => $request->patient_phone,
            'patient_email' => $request->patient_email,
            'patient_address' => $request->patient_address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'booking_type' => $request->booking_type,
            'payment_type' => $request->payment_type,
            'payment_status' => 'pending',
            'total_amount' => $totalAmount,
            'due_amount' => $totalAmount, // Initially all is due
            'scheduled_date' => $request->scheduled_date,
            'scheduled_time' => $request->scheduled_time,
            'notes' => $request->notes,
        ]);

        // Attach to pivot table for the new architecture
        $booking->services()->attach($service->id, ['price' => $service->price]);

        // TODO: Send email notification

        return redirect()->route('bookings.confirmation', $booking->id);
    }
    public function booking_confirmation(Request $request, $id){
        $booking = Booking::with('service')->findOrFail($id);
        return view('frontend.booking.confirmation', compact('booking'));
    }
    public function my_bookings(Request $request){
        $patientId = auth()->guard('patient')->id();
        $bookings = Booking::with('service')
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
            ->with(['serviceCategory', 'subCategory'])
            ->orderBy('name')
            ->paginate(15);
            
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
