<?php

use App\Mail\PatientCode;
use App\Mail\TestsNotification;
use App\Models\Doctor;
use App\Models\Group;
use App\Models\Patient;
use App\Models\Setting;
use Twilio\Rest\Client;

// get system currency
if (! function_exists('get_currency')) {
    function get_currency()
    {
        if (cache()->has('currency')) {
            $currency = cache('currency');
        } else {
            $setting = setting('info');
            $currency = $setting['currency'];
            cache()->put('currency', $currency);
        }

        return $currency;
    }

}

// get formated price of things
if (! function_exists('formated_price')) {
    function formated_price($price)
    {
        $currency = get_currency();

        return $currency.' '.number_format($price, 2);
    }

}

// send sms
if (! function_exists('send_sms')) {
    function send_sms($to, $message)
    {
        $sms_setting = setting('sms');

        if (! empty($sms_setting['sid']) && ! empty($sms_setting['token']) && ! empty($sms_setting['from'])) {
            // Your Account SID and Auth Token from twilio.com/console
            $sid = $sms_setting['sid'];
            $token = $sms_setting['token'];
            $client = new Client($sid, $token);

            // Use the client to do fun stuff like send text messages!
            try {
                $client->messages->create(
                    // the number you'd like to send the message to
                    $to,
                    [
                        // A Twilio phone number you purchased at twilio.com/console
                        'from' => $sms_setting['from'],
                        // the body of the text message you'd like to send
                        'body' => $message,
                    ]
                );
            } catch (\Exception $e) {
                // error
            }
        }

    }
}

// send notifications via mail and sms
if (! function_exists('send_notification')) {
    function send_notification($type, $patient)
    {
        // send mail notification
        $email_settings = setting('emails');

        if ($email_settings[$type]['active'] == true) {
            if (! empty($patient['email'])) {
                if ($type == 'patient_code') {
                    try {
                        \Mail::to($patient['email'])->send(new PatientCode($patient));
                    } catch (\Exception $e) {
                        //
                    }
                } elseif ($type == 'tests_notification') {
                    try {
                        \Mail::to($patient['email'])->send(new TestsNotification($patient));
                    } catch (\Exception $e) {
                        //
                    }
                }
            }

        }

        // send sms
        $sms_settings = setting('sms');

        if ($sms_settings[$type]['active'] == true) {
            if (! empty($patient['phone'])) {
                $message = str_replace(
                    ['{patient_code}', '{patient_name}'],
                    [$patient['code'], $patient['name']],
                    $sms_settings[$type]['message']
                );

                send_sms($patient['phone'], $message);
            }
        }

    }
}

// get json setting as array
if (! function_exists('setting')) {
    function setting($key)
    {
        $setting = Setting::where('key', $key)->first();
        if ($setting) {
            $setting = json_decode($setting['value'], true);
        }

        return $setting;
    }
}

if (! function_exists('menu_settings')) {
    function menu_settings()
    {
        $defaults = [
            'main_menu' => [
                ['label' => 'Home', 'url' => '/', 'new_tab' => false, 'children' => []],
                ['label' => 'Services', 'url' => '/services', 'new_tab' => false, 'children' => [
                    ['label' => 'Diagnostics & Lab', 'url' => '/lab-test', 'new_tab' => false],
                    ['label' => 'Health Checks', 'url' => '/health-check', 'new_tab' => false],
                    ['label' => 'Membership Plan', 'url' => '/membership', 'new_tab' => false],
                    ['label' => 'Video Consultation', 'url' => '/video-consultation', 'new_tab' => false],
                ]],
                ['label' => 'Our Doctors', 'url' => '/doctor', 'new_tab' => false, 'children' => []],
                ['label' => 'Community', 'url' => '/blog', 'new_tab' => false, 'children' => [
                    ['label' => 'Blog', 'url' => '/blog', 'new_tab' => false],
                    ['label' => 'Gallery', 'url' => '/gallery', 'new_tab' => false],
                ]],
                ['label' => 'About', 'url' => '/about', 'new_tab' => false, 'children' => [
                    ['label' => 'Mission & Vision', 'url' => '/mission-vision-value', 'new_tab' => false],
                    ['label' => 'Management', 'url' => '/management', 'new_tab' => false],
                    ['label' => 'Contact Us', 'url' => '/contact', 'new_tab' => false],
                ]],
                ['label' => 'Contact', 'url' => '/contact', 'new_tab' => false, 'children' => []],
            ],
            'footer_menu' => [
                ['label' => 'Privacy', 'url' => '/privacy-notice', 'new_tab' => false],
                ['label' => 'Ethics', 'url' => '/code-of-ethics', 'new_tab' => false],
                ['label' => 'Rights', 'url' => '/bill-of-right', 'new_tab' => false],
            ],
        ];

        $saved = setting('menus');
        if (! is_array($saved)) {
            return $defaults;
        }

        return [
            'main_menu' => isset($saved['main_menu']) ? $saved['main_menu'] : $defaults['main_menu'],
            'footer_menu' => isset($saved['footer_menu']) ? $saved['footer_menu'] : $defaults['footer_menu'],
        ];
    }
}

if (! function_exists('home_page_settings')) {
    function home_page_settings()
    {
        $defaults = [
            'hero' => [
                'slides' => [
                    [
                        'badge' => 'Precision & Care',
                        'title_html' => 'Healthcare <br>Anytime, <span class="text-indigo-400 italic">Anywhere</span>',
                        'description' => 'Experience the future of healthcare with our world-class medical facilities and home diagnostics.',
                        'button_text' => 'Explore Services',
                        'button_url' => '/services',
                        'image' => 'assets/front/images/index/slide-1.jpg',
                    ],
                    [
                        'badge' => 'Wellness Packages',
                        'title_html' => 'Affordable <br>Health <span class="text-indigo-400 italic">Checks</span>',
                        'description' => 'Tailored packages designed for every age and gender, fitting perfectly within your family budget.',
                        'button_text' => 'View Packages',
                        'button_url' => '/health-check',
                        'image' => 'assets/front/images/index/slide-2.jpg',
                    ],
                    [
                        'badge' => 'Lab at Doorstep',
                        'title_html' => 'Hassle-Free <br>Diagnostic <span class="text-indigo-400 italic">Tests</span>',
                        'description' => 'Avoid the traffic and wait. Our experts come to you for sample collection in the comfort of your home.',
                        'button_text' => 'Book Home Test',
                        'button_url' => '/lab-test',
                        'image' => 'assets/front/images/index/slide-3.jpg',
                    ],
                ],
            ],
            'about' => [
                'badge' => 'About Imperial',
                'title_html' => 'Redefining the <span class="text-indigo-600">Patient Experience</span>',
                'description' => 'Imperial exists to provide a better patient experience. We are a one-stop-shop for your health, offering caring doctors, world-class diagnostics, and accessible healthcare for everyone.',
            ],
            'stats' => [
                'specialities_count' => '27',
                'specialities_label' => 'Specialities',
                'doctors_count' => '84',
                'doctors_label' => 'Expert Doctors',
                'patients_count' => '914K',
                'patients_label' => 'Patients Served',
            ],
            'our_approach' => [
                'badge' => 'Our Approach',
                'title_html' => 'Doctors Who <span class="text-indigo-600">Actually</span> Listen',
                'description_1' => 'Our specialists dedicate time to truly understand your health history. We believe in respect, empathy, and personalized advice based on international clinical protocols.',
                'description_2' => 'With years of local and international experience, our team provides healthcare you can trust blindly.',
                'button_text' => 'Find a Specialist',
                'button_url' => '/doctor',
                'image' => 'assets/front/images/index/why-imperial.jpg',
            ],
            'lab_excellence' => [
                'badge' => 'Lab Excellence',
                'title_html' => 'Diagnostics You Can <span class="text-emerald-600">Trust</span>',
                'description' => 'Accuracy is our top priority. Our laboratories follow ISO 15189-2012 international standards to ensure you get precise results every single time.',
                'feature_1' => 'ISO Certified',
                'feature_2' => 'Accredited Lab',
                'button_text' => 'Explore Our Services',
                'button_url' => '/lab-test',
                'image' => 'assets/front/images/index/diagnosis.jpg',
            ],
            'experience_imperial' => [
                'badge' => 'Experience Imperial',
                'title_html' => 'Take a Virtual Tour of Our Facility',
                'description' => 'Step inside our world-class medical center. From our luxury waiting areas to state-of-the-art diagnostic labs, experience the Imperial difference.',
                'button_text' => 'Start The Tour',
                'button_url' => '#',
                'image' => 'assets/front/images/index/tour.jpg',
            ],
            'continuous_care' => [
                'title_html' => 'Continuous Care for <br><span class="text-indigo-600">Your Family</span>',
                'description' => 'Our membership plans are designed to provide proactive health management with unlimited family doctor consultations, health checks, and exclusive discounts.',
                'button_text' => 'Explore Membership',
                'button_url' => '/membership',
            ],
            'expert_advice' => [
                'title_html' => 'Expert Advice from <br><span class="text-indigo-400">Comfort of Home</span>',
                'description' => "Can't visit the hub? Connect with our world-class specialists via high-definition, secure video consultations. Reliable care, anywhere you are.",
                'button_text' => 'Book Video Consult',
                'button_url' => '/video-consultation',
            ],
            'ceo_message' => [
                'enabled' => true,
                'badge' => "CEO's Message",
                'title_html' => 'A Message from Our <span class="text-indigo-600">CEO</span>',
                'message' => 'At Imperial Health, we believe that every patient deserves world-class healthcare delivered with compassion and excellence. Our mission is to redefine the healthcare experience in Bangladesh by combining cutting-edge medical technology with a patient-first approach. We are committed to providing accessible, affordable, and high-quality care to every individual who walks through our doors.',
                'name' => 'Mohammad Abdul Matin Emon',
                'designation' => 'Chief Executive Officer',
                'image' => 'assets/front/images/management/2.jpg',
            ],
        ];

        $saved = setting('home_page');
        if (! is_array($saved)) {
            return $defaults;
        }

        $merged = array_replace_recursive($defaults, $saved);

        if (isset($saved['hero']['slides']) && is_array($saved['hero']['slides'])) {
            $merged['hero']['slides'] = $saved['hero']['slides'];
        }

        return $merged;
    }
}

if (! function_exists('diagonostic_page_settings')) {
    function diagonostic_page_settings()
    {
        $defaults = [
            'page_name' => 'Diagnostics & Lab Tests',
            'hero_title_html' => 'Precision <span class="text-indigo-400">Diagnostics</span> for Better Health',
            'hero_description' => 'Experience world-class laboratory services with international quality standards and 99.9% accuracy in results.',
            'hero_image' => 'assets/front/images/index/diagnosis.jpg',
            'feature_1_title' => 'Quality Assured',
            'feature_1_desc' => 'International standards & ISO protocols.',
            'feature_2_title' => 'Rapid Turnaround',
            'feature_2_desc' => 'Fast & reliable test result delivery.',
            'feature_3_title' => 'Home Collection',
            'feature_3_desc' => 'Sample collection from your doorstep.',
            'search_placeholder' => 'Search for tests or procedures...',
            'all_tests_label' => 'All Tests',
            'laboratory_label' => 'Laboratory',
            'imaging_label' => 'Imaging',
            'procedures_label' => 'Procedures',
            'catalog_footer_prefix' => 'End of Test Catalog',
            'catalog_footer_suffix' => 'Investigations',
        ];

        $saved = setting('diagonostic_page');
        if (! is_array($saved)) {
            return $defaults;
        }

        return array_replace_recursive($defaults, $saved);
    }
}

if (! function_exists('health_check_page_settings')) {
    function health_check_page_settings()
    {
        $defaults = [
            'page_name' => 'Health Check',
            'hero_title_html' => 'Invest in Your <span class="text-indigo-400">Future Health</span> Today',
            'hero_description' => 'Comprehensive health screenings designed to detect risks early and provide you with a roadmap to long-term wellness.',
            'hero_image' => 'assets/front/images/healthcheck/1.jpg',
            'feature_1_title' => 'Expert Analysis',
            'feature_1_desc' => 'Consultations with top clinical specialists.',
            'feature_2_title' => 'Affordable Care',
            'feature_2_desc' => 'Best-in-class tests at transparent prices.',
            'feature_3_title' => 'Instant Digital Reports',
            'feature_3_desc' => 'Access your data anytime via our portal.',
            'faq_title' => 'Common Questions',
            'faq_subtitle' => 'Everything you need to know about our health checks.',
            'faq_1_question' => 'What is a Health Check?',
            'faq_1_answer' => 'A health check is a comprehensive examination of your current physical condition. It involves a series of tests and screenings to detect potential health issues before they become symptoms.',
            'faq_2_question' => 'How does a health check help me?',
            'faq_2_answer' => 'Regular health checks help in early detection of diseases, increase the chances for effective treatment, and allow you to track your health progress over time.',
            'faq_3_question' => 'How will I receive my reports?',
            'faq_3_answer' => 'Reports are typically delivered digitally via email or through a secure patient portal within 24-48 hours of the tests being completed.',
        ];

        $saved = setting('health_check_page');
        if (! is_array($saved)) {
            return $defaults;
        }

        return array_replace_recursive($defaults, $saved);
    }
}

if (! function_exists('inner_page_settings')) {
    function inner_page_settings($key, array $defaults)
    {
        $saved = setting($key);
        if (! is_array($saved)) {
            return $defaults;
        }

        return array_replace_recursive($defaults, $saved);
    }
}

if (! function_exists('membership_page_settings')) {
    function membership_page_settings()
    {
        return inner_page_settings('membership_page', [
            'page_name' => 'Membership',
            'hero_title_html' => 'Membership <span class="text-indigo-400">Plans</span>',
            'hero_description' => 'Comprehensive healthcare solutions for you and your family.',
            'hero_image' => 'assets/front/images/services/con5.jpg',
        ]);
    }
}

if (! function_exists('video_consultation_page_settings')) {
    function video_consultation_page_settings()
    {
        return inner_page_settings('video_consultation_page', [
            'page_name' => 'Video Consultation',
            'hero_title_html' => 'Video <span class="text-indigo-400">Consultation</span>',
            'hero_description' => 'Consult our doctors from the comfort of your home.',
            'hero_image' => 'assets/front/images/services/consult.jpg',
            'plans_section_title' => 'Affordable Video Consultation Packages',
            'plans_section_description' => 'Choose a flexible plan for regular online doctor consultations for you and your family.',
            'plans_empty_text' => 'No video consultation packages available now.',
            'why_title' => 'Why choose Amar Jotno Plan?',
            'why_image' => 'assets/front/images/services/con4.jpg',
            'why_item_1' => 'Access to experienced, internationally trained doctors',
            'why_item_2' => 'Secure access through our own consultation platform',
            'why_item_3' => 'Confidentiality for patient and doctor communications',
            'why_item_4' => 'Minimum 15 minutes quality consultation per session',
            'why_item_5' => 'Electronic Health Records to track your health journey',
            'faq_title' => 'Frequently Asked Questions',
            'faq_subtitle' => 'Take a look at the most commonly asked questions. We are here to help.',
            'faq_1_question' => 'How do I book a video consultation?',
            'faq_1_answer' => 'You can book through our website by selecting a plan and following the booking process.',
            'faq_2_question' => 'How long does a consultation last?',
            'faq_2_answer' => 'Each consultation is typically around 15 minutes, depending on your needs.',
            'faq_3_question' => 'How do I receive prescriptions?',
            'faq_3_answer' => 'Doctors provide digital prescriptions in your profile after the consultation.',
        ]);
    }
}

if (! function_exists('about_page_settings')) {
    function about_page_settings()
    {
        return inner_page_settings('about_page', [
            'page_name' => 'About Us',
            'hero_title_html' => 'Welcome to <span class="text-indigo-400">Imperial Private Health Care</span>',
            'hero_description' => 'Welcome to Imperial private health care ltd, where precision meets care, and health mysteries find solutions. We are a state-of-the-art diagnostic facility committed to providing unparalleled insights into your well-being.',
            'hero_image' => 'assets/front/images/about/1.jpg',
            'intro_title' => 'Our Vision',
            'intro_description' => 'Empowering individuals to take control of their health through accurate and timely diagnostics, Imperial private health care ltd envisions a future where every person has access to the information they need to make informed decisions about their well-being.',
            'intro_image' => 'assets/front/images/about/1.jpg',
            'feature_1_title' => 'Digitalisation of Services',
            'feature_1_desc' => 'Accompanied by innovative service strategies to enhance customer experience.',
            'feature_2_title' => 'Value-Added Services',
            'feature_2_desc' => 'Offering house call phlebotomy services where blood samples are collected at the patient home or workplace, including better accessibility and visibility of pathologists.',
            'feature_3_title' => 'Community Wellness Engagement',
            'feature_3_desc' => 'Organizing health camps at residential apartment blocks, promoting wellness, and providing exposure to consulting doctors and pathologists.',
            'leadership_title' => 'Our Management Team',
            'leadership_description' => 'We are proud to have a team of compassionate, dedicated, and highly skilled professionals committed to delivering exceptional care.',
            'partners_title' => 'Our Happy Clients',
            'partners_subtitle' => 'Patient and Partner Testimonials',
        ]);
    }
}

if (! function_exists('services_page_settings')) {
    function services_page_settings()
    {
        return inner_page_settings('services_page', [
            'page_name' => 'Our Services',
            'hero_title_html' => 'Comprehensive <span class="text-indigo-400">Healthcare</span> Solutions',
            'hero_description' => 'From primary consultations to advanced diagnostics, we provide all your outpatient needs under one professional roof.',
            'hero_image' => 'assets/front/images/services/services.jpg',
            'section_badge' => 'Patient-Centered Care',
            'section_title' => 'Integrated Services for Everyday Health Needs',
            'section_description' => 'We combine consultation, diagnostics, preventive screening, and digital follow-up to ensure every patient receives complete and coordinated care.',
            'block_1_badge' => 'Expert Guidance',
            'block_1_title' => 'Personalized Consultations',
            'block_1_description' => 'Our doctors spend meaningful time understanding each patient. Consult in person or virtually and receive practical care plans tailored to your condition and goals.',
            'block_1_button_text' => 'Explore Specialities',
            'block_1_button_url' => '/service-details',
            'block_1_image' => 'assets/front/images/services/con4.jpg',
            'block_2_badge' => 'Advanced Diagnostics',
            'block_2_title' => 'Reliable Testing with Modern Technology',
            'block_2_description' => 'Our laboratories and diagnostics workflow are designed for consistency, speed, and clinical accuracy, helping doctors and patients make timely decisions with confidence.',
            'block_2_button_text' => 'View Lab Tests',
            'block_2_button_url' => '/lab-test',
            'block_2_image' => 'assets/front/images/services/con3.jpeg',
            'catalog_title' => 'Available Services',
            'catalog_description' => 'Browse our active services below. Each test or procedure includes essential details to help you choose the right care path.',
            'empty_state_text' => 'No services are available right now. Please check again shortly.',
        ]);
    }
}

if (! function_exists('doctors_page_settings')) {
    function doctors_page_settings()
    {
        return inner_page_settings('doctors_page', [
            'page_name' => 'Our Doctors',
            'hero_title_html' => 'Expert Care from <span class="text-indigo-400">World-Class</span> Specialists',
            'hero_description' => 'Connect with experienced specialists dedicated to personalized care.',
            'hero_image' => 'assets/front/images/doctor/1.jpg',
        ]);
    }
}

if (! function_exists('gallery_page_settings')) {
    function gallery_page_settings()
    {
        return inner_page_settings('gallery_page', [
            'page_name' => 'Gallery',
            'hero_title_html' => 'Our <span class="text-indigo-400">Gallery</span>',
            'hero_description' => 'Explore moments from our hospital, events, and healthcare services.',
            'hero_image' => 'assets/front/images/index/tour.jpg',
        ]);
    }
}

if (! function_exists('mission_vision_page_settings')) {
    function mission_vision_page_settings()
    {
        return inner_page_settings('mission_vision_page', [
            'page_name' => 'Mission & Vision',
            'hero_title_html' => 'Our <span class="text-indigo-400">Mission, Vision</span> & Values',
            'hero_description' => 'Imperial exists to provide a better patient experience.',
            'hero_image' => 'assets/front/images/about/1.jpg',
        ]);
    }
}

if (! function_exists('management_page_settings')) {
    function management_page_settings()
    {
        return inner_page_settings('management_page', [
            'page_name' => 'Management',
            'hero_title_html' => 'Our <span class="text-indigo-400">Management</span> Team',
            'hero_description' => 'Meet the leadership driving patient-centered innovation.',
            'hero_image' => 'assets/front/images/management/1.jpg',
        ]);
    }
}

if (! function_exists('contact_page_settings')) {
    function contact_page_settings()
    {
        return inner_page_settings('contact_page', [
            'page_name' => 'Contact',
            'hero_title_html' => "We're Here to <span class=\"text-indigo-400\">Help</span> You",
            'hero_description' => 'Reach out for services, booking support, or feedback.',
            'hero_image' => 'assets/front/images/about/2.jpg',
        ]);
    }
}

if (! function_exists('blog_page_settings')) {
    function blog_page_settings()
    {
        return inner_page_settings('blog_page', [
            'page_name' => 'Blog',
            'hero_title_html' => 'Health <span class="text-indigo-400">Insights</span> & Stories',
            'hero_description' => 'Read expert perspectives, wellness tips, and updates from Imperial Health.',
            'hero_image' => 'assets/front/images/services/services.jpg',
            'founder_badge' => 'Our Story',
            'founder_title' => 'Meet Our Founder & Chair of the Board',
            'founder_description' => 'Six years ago, my mother was hospitalized at one of Bangladesh\'s top hospitals for a basic operation. We expected that the routine procedure would go smoothly, yet she suffered dramatic complications. That experience taught us that empathy, transparency, and quality must come first in healthcare.',
            'founder_button_text' => 'See Details',
            'founder_button_url' => '#',
            'founder_image' => 'assets/front/images/management/1.jpg',
            'blog_list_title' => 'Blog list',
            'blogs_per_page' => 8,
        ]);
    }
}

// generate  pdf
if (! function_exists('generate_pdf')) {
    // type (1) => tests report
    // type (2) => receipt
    // type (3) => accounting report
    // type (4) => accounting doctor report

    function generate_pdf($data = '', $type = 1)
    {
        // reports settings
        $reports_settings = setting('reports');

        // info setting
        $info_settings = setting('info');

        $pdf_name = time().'.pdf';

        // get header , body , footer
        $report_header = '';
        $report_background = '';
        $report_footer = '';
        if (file_exists('img/report_header.jpg')) {
            $report_header = base64_encode(file_get_contents('img/report_header.jpg'));
            $report_header = 'data:'.mime_content_type('img/report_header.jpg').';base64,'.$report_header;
        }
        if (file_exists('img/report_background.png')) {
            $report_background = base64_encode(file_get_contents('img/report_background.png'));
            $report_background = 'data:'.mime_content_type('img/report_background.png').';base64,'.$report_background;
        }
        if (file_exists('img/report_footer.jpg')) {
            $report_footer = base64_encode(file_get_contents('img/report_footer.jpg'));
            $report_footer = 'data:'.mime_content_type('img/report_footer.jpg').';base64,'.$report_footer;
        }

        if ($type == 1) {
            $group = $data;
            $pdf = PDF::loadView('pdf.report', compact('group', 'reports_settings', 'info_settings', 'type', 'report_header', 'report_background', 'report_footer'));
        } elseif ($type == 2) {
            $group = $data;
            $pdf = PDF::loadView('pdf.receipt', compact('group', 'reports_settings', 'info_settings', 'type', 'report_header', 'report_background', 'report_footer'));
        } elseif ($type == 3) {
            $pdf = PDF::loadView('pdf.accounting', compact('data', 'reports_settings', 'info_settings', 'type'));
        } elseif ($type == 4) {
            $pdf = PDF::loadView('pdf.doctor_report', compact('data', 'reports_settings', 'info_settings', 'type'));
        }

        $pdf->save('uploads/pdf/'.$pdf_name); // save pdf file

        return url('uploads/pdf/'.$pdf_name); // return pdf url
    }
}

if (! function_exists('print_barcode')) {
    function print_barcode($group, $number, $barcode_image)
    {
        $pdf_name = time().'.pdf';

        $pdf = PDF::loadView('pdf.barcode', compact('group', 'number', 'barcode_image'));

        $pdf->save('uploads/pdf/'.$pdf_name); // save pdf file

        return url('uploads/pdf/'.$pdf_name);
    }
}

// check if report all subtests are done
if (! function_exists('check_group_done')) {
    function check_group_done($group_id)
    {
        $group = \App\Models\Group::with(['tests'])->where('id', $group_id)->first();

        $done = true;

        if (isset($group)) {
            // check tests
            foreach ($group['tests'] as $test) {
                if (! $test['done']) {
                    $done = false;
                }
            }
        }

        $group->update(['done' => $done]);

        return $done;
    }
}

// group test calculations
if (! function_exists('group_test_calculations')) {
    function group_test_calculations($id)
    {
        $group = Group::with('tests', 'contract')->where('id', $id)->first();

        $subtotal = 0;
        $discount = 0;
        $paid = $group['paid'];
        $doctor_commission = 0;

        if (isset($group['tests'])) {
            foreach ($group['tests'] as $test) {
                $subtotal += $test['price'];
            }
        }

        if (isset($group['contract'])) {
            $discount = ($group['contract']['discount'] * $subtotal) / 100;
        }

        $total = $subtotal - $discount;
        $due = $total - $paid;

        if (isset($group['doctor'])) {
            $doctor_commission = $total * $group['doctor']['commission'] / 100;
        }

        $group->update([
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $subtotal - $discount,
            'paid' => $paid,
            'due' => $due,
            'doctor_commission' => $doctor_commission,
        ]);

    }
}

if (! function_exists('patient_code')) {
    function patient_code()
    {
        $code = time().mt_rand(1, 1000);

        $patient = Patient::where('code', $code)->first();

        if (isset($patient)) {
            patient_code();
        }

        return $code;
    }
}

if (! function_exists('doctor_code')) {
    function doctor_code()
    {
        $code = time().mt_rand(1, 1000);

        $doctor = Doctor::where('code',$code)->first();

        if (isset($doctor)) {
            doctor_code();
        }

        return $code;
    }
}
