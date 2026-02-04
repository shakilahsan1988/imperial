<?php
  define("BASE_URL","http://localhost");
 
  define("HOME", BASE_URL.'/');
  define("SIGNIN", BASE_URL.'/signin.php');
  define("SIGNUP", BASE_URL.'/signup.php');
  define("IMPERIALMD", BASE_URL.'/imperialmd.php');
  
  //PATHS
  define("COMM_PATH", HOME."community/");
  define("ABOUT_PATH", HOME."about/");
  define("DOCTOR_PATH", HOME."doctor/");
  define("SERVICE_PATH", HOME."services/");
  
  // SERVICES 
  define("SERVICES", SERVICE_PATH.'services.php');
  define("SERVICE_DETAILS", SERVICE_PATH.'service-details.php');
  define("HEALTH_CHECK", SERVICE_PATH.'health-check.php');
  define("MEMBERSHIP", SERVICE_PATH.'membership-plan.php');
  define("LAB_TEST", SERVICE_PATH.'lab-test.php');
  define("VIDEO_CONSULTATIONS", SERVICE_PATH.'video-consultation.php');
  
  //ABOUT
  define("ABOUT", ABOUT_PATH.'/about.php');
  define("ABOUT_DETAILS", ABOUT_PATH.'about-details.php');
  define("BILL_OF_RIGHT", ABOUT_PATH.'bill-of-right.php');
  define("CAREER", ABOUT_PATH.'career.php');
  define("CAREER_DETAILS", ABOUT_PATH.'career-details.php');
  define("CODE_ETHICS", ABOUT_PATH.'code-of-ethics.php');
  define("CONTACT", ABOUT_PATH.'contact.php');
  define("CLIENT", ABOUT_PATH.'corporate-clients.php');
  define("MANAGEMENT", ABOUT_PATH.'management.php');
  define("MANAGEMENT_DETAILS", ABOUT_PATH.'management-details.php');
  define("MISSION_VISION_VALUE", ABOUT_PATH.'mission-vision-values.php');
  define("PRIVACY_NOTICE", ABOUT_PATH.'privacy-notice.php');
  
  //DOCTOR
  define("DOCTOR", DOCTOR_PATH.'doctors.php');
  define("BOOK_DOCTOR", DOCTOR_PATH.'book-doctor.php');
  
  //community
    define("BLOG", COMM_PATH.'blog.php');
	define("BLOG_DETAILS", COMM_PATH.'blog-details.php');
	define("EVENT", COMM_PATH.'event.php');
	define("EVENT_DETAILS", COMM_PATH.'event-details.php');
	define("PRESS", COMM_PATH.'press.php');
	define("PRESS_DETAILS", COMM_PATH.'press-details.php');
?>