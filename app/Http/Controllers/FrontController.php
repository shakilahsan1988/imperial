<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index(){
       return view('frontend.index');
    }
    public function services(){
		 return view('frontend.services.services');
    }
    public function service_details(){
    	return view('frontend.services.service-details');
    }
    public function health_check(){
		return view('frontend.services.health-check');
    }
    public function membership(){
    	return view('frontend.services.membership-plan');
    }
    public function lab_test(){
    	return view('frontend.services.lab-test');
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
