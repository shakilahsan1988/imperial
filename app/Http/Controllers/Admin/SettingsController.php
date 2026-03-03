<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Currency;
use App\Http\Requests\Admin\GeneralSettingRequest;
use App\Http\Requests\Admin\EmailSettingRequest;
use App\Http\Requests\Admin\ReportSettingRequest;
use App\Http\Requests\Admin\SmsSettingRequest;
use App\Http\Requests\Admin\WhatsappSettingRequest;
use App\Http\Requests\Admin\ApiSettingRequest;
use App\Models\Service;
use App\Models\Doctor;
use App\Models\Page;

class SettingsController extends Controller
{
    /**
     * assign roles with custom permission logic
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $u = auth()->guard('admin')->user();
            $isSuper = ($u && $u->id == 1); // Md. Shakil Ahsan (Super Admin) check

            if ($isSuper) {
                return $next($request);
            }

            // সেটিংস ভিউ এবং সব ধরণের আপডেট সাবমিট করার জন্য view_setting পারমিশন চেক
            if (!$u->hasPermission('view_setting')) {
                abort(403, 'আপনার সিস্টেম সেটিংস পরিবর্তন করার অনুমতি নেই।');
            }

            return $next($request);
        });
    }

    public function index()
    {
        //general
        $settings=setting('info');
        $currencies=Currency::all();
        
        //emails
        $emails_settings=setting('emails');

        //reports
        $reports_settings=setting('reports');

        //sms
        $sms_settings=setting('sms');

        //whatsapp
        $whatsapp_settings=setting('whatsapp');

        //api keys
        $api_keys_settings=setting('api_keys');

        //menus
        $menu_settings = menu_settings();

        // Extra for menu builder
        $services = Service::select('id', 'name')->get();
        $doctors = Doctor::select('id', 'name')->get();
        $pages = Page::select('id', 'title', 'slug')->get();

        return view('admin.settings.index',compact(
            'settings',
            'currencies',
            'emails_settings',
            'reports_settings',
            'sms_settings',
            'whatsapp_settings',
            'api_keys_settings',
            'menu_settings',
            'services',
            'doctors',
            'pages'
        ));
    }


    /**
     * update settings info
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function info_submit(GeneralSettingRequest $request)
    {
        try {
            // Get old settings
            $setting_record = Setting::where('key', 'info')->first();
            $old_settings = json_decode($setting_record->value, true);
            
            // Prepare settings data
            $settings = $request->except(['logo', 'reports_logo', 'favicon', '_token']);
            
            // Social links
            $settings['socials'] = [
                'facebook'  => $request->facebook,
                'twitter'   => $request->twitter,
                'instagram' => $request->instagram,
                'youtube'   => $request->youtube,
            ];

            // Update currency cache
            cache()->put('currency', $request->currency);
        
            // Ensure img directory exists
            if (!file_exists(public_path('img'))) {
                mkdir(public_path('img'), 0777, true);
            }

            // Handle Logo
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logo_name = 'logo.' . $logo->getClientOriginalExtension();
                $logo->move(public_path('img'), $logo_name);
                $settings['logo'] = $logo_name;
            } else {
                $settings['logo'] = $old_settings['logo'] ?? 'logo.png';
            }

            // Handle Reports Logo
            if ($request->hasFile('reports_logo')) {
                $reports_logo = $request->file('reports_logo');
                $reports_logo_name = 'reports_logo.' . $reports_logo->getClientOriginalExtension();
                $reports_logo->move(public_path('img'), $reports_logo_name);
                
                // Keep base64 for reports if currently used, but also save file
                $settings['reports_logo'] = base64_encode(file_get_contents(public_path('img/' . $reports_logo_name)));
            } else {
                $settings['reports_logo'] = $old_settings['reports_logo'] ?? '';
            }

            // Handle Favicon
            if ($request->hasFile('favicon')) {
                $favicon = $request->file('favicon');
                $favicon_name = 'favicon.' . $favicon->getClientOriginalExtension();
                $favicon->move(public_path('img'), $favicon_name);
                $settings['favicon'] = $favicon_name;
            } else {
                $settings['favicon'] = $old_settings['favicon'] ?? 'favicon.png';
            }

            // Update database
            $setting_record->update([
                'value' => json_encode($settings)
            ]);
            
            return redirect()->route('admin.settings.index')->with('success', __('Settings Updated successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to update settings: ') . $e->getMessage());
        }
    }

    

    /**
     * update emails settings
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function emails_submit(EmailSettingRequest $request)
    {
       try {
           $settings=$request->except('_token');

           $settings['patient_code']['active']=($request->has('patient_code.active'))?true:false;
           $settings['reset_password']['active']=($request->has('reset_password.active'))?true:false;
           $settings['tests_notification']['active']=($request->has('tests_notification.active'))?true:false;

           //update setting record in database
           $emails=Setting::where('key','emails')->firstOrFail();
           $emails->update([
             'value'=>json_encode($settings)
           ]);
           
           return redirect()->route('admin.settings.index')->with('success', __('Settings Updated successfully'));
       } catch (\Exception $e) {
           return back()->withInput()->with('error', __('Failed to update email settings: ') . $e->getMessage());
       }
    }

    /**
     * update reports settings
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reports_submit(ReportSettingRequest $request)
    {
        try {
            $request['show_header']=($request->has('show_header'))?true:false;
            $request['show_footer']=($request->has('show_footer'))?true:false;
            $request['show_signature']=($request->has('show_signature'))?true:false;
            $request['show_header_image']=($request->has('show_header_image'))?true:false;
            $request['show_footer_image']=($request->has('show_footer_image'))?true:false;
            $request['show_background_image']=($request->has('show_background_image'))?true:false;

            $settings=json_encode($request->except('_method','_token'));
                if($request->hasFile('report_header_image'))
            {
                $report_header_image=$request->file('report_header_image');
                $report_header_image->move('img','report_header.jpg');
            }

            if($request->hasFile('report_background_image'))
            {
                $report_background_image=$request->file('report_background_image');
                $report_background_image->move('img','report_background.png');
            }

            if($request->hasFile('report_footer_image'))
            {
                $report_footer_image=$request->file('report_footer_image');
                $report_footer_image->move('img','report_footer.jpg');
            }

            $reports=Setting::where('key','reports')->firstOrFail();
            $reports->update([
                'value'=>$settings
            ]);

            return redirect()->route('admin.settings.index')->with('success', __('Settings Updated successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to update report settings: ') . $e->getMessage());
        }
    }

    /**
     * update reports settings
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sms_submit(SmsSettingRequest $request)
    {
        try {
            $settings=$request->except('_method','_token');

            $settings['patient_code']['active']=($request->has('patient_code.active'))?true:false;
            $settings['tests_notification']['active']=($request->has('tests_notification.active'))?true:false;
        
            $sms=Setting::where('key','sms')->firstOrFail();
            $sms->update([
                'value'=>$settings
            ]);

            return redirect()->route('admin.settings.index')->with('success', __('Settings Updated successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to update SMS settings: ') . $e->getMessage());
        }
    }

    /**
     * update whatsapp settings
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function whatsapp_submit(WhatsappSettingRequest $request)
    {
        try {
            $whatsapp_settings=[];

            $whatsapp_settings['receipt']['active']=(isset($request['receipt']['active']))?true:false; 
            $whatsapp_settings['report']['active']=(isset($request['report']['active']))?true:false;    
            
            $whatsapp_settings['receipt']['message']=$request['receipt']['message'];
            $whatsapp_settings['report']['message']=$request['report']['message'];


            $whatsapp=Setting::where('key','whatsapp')->firstOrFail();
            $whatsapp->update([
                'value'=>json_encode($whatsapp_settings)
            ]);

            return redirect()->route('admin.settings.index')->with('success', __('Settings Updated successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to update WhatsApp settings: ') . $e->getMessage());
        }
    }


    /**
     * update api keys settings
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function api_keys_submit(ApiSettingRequest $request)
    {
        try {
            $api_keys=[];
            $api_keys['google_map']=$request['google_map'];

            $api_keys_setting=Setting::where('key','api_keys')->firstOrFail();
            $api_keys_setting->update([
                'value'=>json_encode($api_keys)
            ]);

            return redirect()->route('admin.settings.index')->with('success', __('Settings Updated successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to update API keys: ') . $e->getMessage());
        }
    }

    public function menus_submit(Request $request)
    {
        try {
            $main = collect($request->input('main_menu', []))
                ->map(function ($item) {
                    $children = collect($item['children'] ?? [])
                        ->map(function ($child) {
                            return [
                                'label' => trim((string) ($child['label'] ?? '')),
                                'url' => trim((string) ($child['url'] ?? '')),
                                'new_tab' => !empty($child['new_tab']),
                            ];
                        })
                        ->filter(fn ($child) => $child['label'] !== '' && $child['url'] !== '')
                        ->values()
                        ->all();

                    return [
                        'label' => trim((string) ($item['label'] ?? '')),
                        'url' => trim((string) ($item['url'] ?? '')),
                        'new_tab' => !empty($item['new_tab']),
                        'children' => $children,
                    ];
                })
                ->filter(fn ($item) => $item['label'] !== '' && $item['url'] !== '')
                ->values()
                ->all();

            $footer = collect($request->input('footer_menu', []))
                ->map(function ($item) {
                    return [
                        'label' => trim((string) ($item['label'] ?? '')),
                        'url' => trim((string) ($item['url'] ?? '')),
                        'new_tab' => !empty($item['new_tab']),
                    ];
                })
                ->filter(fn ($item) => $item['label'] !== '' && $item['url'] !== '')
                ->values()
                ->all();

            Setting::updateOrCreate(
                ['key' => 'menus'],
                ['value' => json_encode([
                    'main_menu' => $main,
                    'footer_menu' => $footer,
                ])]
            );

            return redirect()->route('admin.settings.index')->with('success', __('Menu settings updated successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to update menu settings: ') . $e->getMessage());
        }
    }
}
