<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutPageSettingRequest;
use App\Http\Requests\Admin\DiagonosticPageSettingRequest;
use App\Http\Requests\Admin\BlogPageSettingRequest;
use App\Http\Requests\Admin\HealthCheckPageSettingRequest;
use App\Http\Requests\Admin\HomePageSettingRequest;
use App\Http\Requests\Admin\InnerPageSettingRequest;
use App\Http\Requests\Admin\ServicesPageSettingRequest;
use App\Http\Requests\Admin\VideoConsultationPageSettingRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class PageSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $u = auth()->guard('admin')->user();
            $isSuper = ($u && $u->id == 1);

            if ($isSuper) {
                return $next($request);
            }

            if (!$u || !$u->hasPermission('view_setting')) {
                abort(403, 'You do not have permission to manage page settings.');
            }

            return $next($request);
        });
    }

    public function homeSettings()
    {
        $homeSettings = home_page_settings();

        return view('admin.pages.home_settings', compact('homeSettings'));
    }

    public function updateHomeSettings(HomePageSettingRequest $request)
    {
        try {
            $validated = $request->validated();

            $heroSlides = [];
            $badges = $request->input('hero_badge', []);
            $titles = $request->input('hero_title_html', []);
            $descriptions = $request->input('hero_description', []);
            $buttonTexts = $request->input('hero_button_text', []);
            $buttonUrls = $request->input('hero_button_url', []);
            $existingImages = $request->input('hero_existing_image', []);
            $uploadedImages = $request->file('hero_image', []);

            $max = max(
                count($badges),
                count($titles),
                count($descriptions),
                count($buttonTexts),
                count($buttonUrls),
                count($existingImages),
                count($uploadedImages)
            );

            if (!File::isDirectory('uploads/home/hero')) {
                File::makeDirectory('uploads/home/hero', 0755, true);
            }
            if (!File::isDirectory('uploads/home/sections')) {
                File::makeDirectory('uploads/home/sections', 0755, true);
            }

            for ($i = 0; $i < $max; $i++) {
                $badge = trim((string) ($badges[$i] ?? ''));
                $title = trim((string) ($titles[$i] ?? ''));
                $description = trim((string) ($descriptions[$i] ?? ''));
                $buttonText = trim((string) ($buttonTexts[$i] ?? ''));
                $buttonUrl = trim((string) ($buttonUrls[$i] ?? ''));
                $imagePath = (string) ($existingImages[$i] ?? '');

                if (isset($uploadedImages[$i]) && $uploadedImages[$i]) {
                    $image = $uploadedImages[$i];
                    $imageName = 'hero_' . time() . '_' . $i . '.' . $image->getClientOriginalExtension();
                    $image->move('uploads/home/hero', $imageName);
                    $imagePath = 'uploads/home/hero/' . $imageName;
                }

                if (
                    $badge === '' &&
                    $title === '' &&
                    $description === '' &&
                    $buttonText === '' &&
                    $buttonUrl === '' &&
                    $imagePath === ''
                ) {
                    continue;
                }

                $heroSlides[] = [
                    'badge' => $badge,
                    'title_html' => $title,
                    'description' => $description,
                    'button_text' => $buttonText,
                    'button_url' => $buttonUrl,
                    'image' => $imagePath,
                ];
            }

            $payload = [
                'hero' => [
                    'slides' => $heroSlides,
                ],
                'about' => $validated['about'],
                'stats' => $validated['stats'],
                'our_approach' => $validated['our_approach'],
                'lab_excellence' => $validated['lab_excellence'],
                'experience_imperial' => $validated['experience_imperial'],
                'continuous_care' => $validated['continuous_care'],
                'expert_advice' => $validated['expert_advice'],
            ];

            if ($request->hasFile('our_approach_image')) {
                $image = $request->file('our_approach_image');
                $imageName = 'our_approach_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move('uploads/home/sections', $imageName);
                $payload['our_approach']['image'] = 'uploads/home/sections/' . $imageName;
            }

            if ($request->hasFile('lab_excellence_image')) {
                $image = $request->file('lab_excellence_image');
                $imageName = 'lab_excellence_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move('uploads/home/sections', $imageName);
                $payload['lab_excellence']['image'] = 'uploads/home/sections/' . $imageName;
            }

            if ($request->hasFile('experience_imperial_image')) {
                $image = $request->file('experience_imperial_image');
                $imageName = 'experience_imperial_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move('uploads/home/sections', $imageName);
                $payload['experience_imperial']['image'] = 'uploads/home/sections/' . $imageName;
            }

            Setting::updateOrCreate(
                ['key' => 'home_page'],
                ['value' => json_encode($payload)]
            );

            return redirect()
                ->route('admin.pages.home_settings')
                ->with('success', 'Home page settings updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update home page settings: ' . $e->getMessage());
        }
    }

    public function diagonosticSettings()
    {
        $settings = diagonostic_page_settings();

        return view('admin.pages.diagonostic_settings', compact('settings'));
    }

    public function updateDiagonosticSettings(DiagonosticPageSettingRequest $request)
    {
        try {
            $payload = $request->validated();

            if (!File::isDirectory('uploads/pages/diagonostic')) {
                File::makeDirectory('uploads/pages/diagonostic', 0755, true);
            }

            if ($request->hasFile('hero_image_file')) {
                $image = $request->file('hero_image_file');
                $imageName = 'hero_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move('uploads/pages/diagonostic', $imageName);
                $payload['hero_image'] = 'uploads/pages/diagonostic/' . $imageName;
            }

            Setting::updateOrCreate(
                ['key' => 'diagonostic_page'],
                ['value' => json_encode($payload)]
            );

            return redirect()
                ->route('admin.pages.diagonostic_settings')
                ->with('success', 'Diagonostic page settings updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update Diagonostic page settings: ' . $e->getMessage());
        }
    }

    public function healthCheckSettings()
    {
        $settings = health_check_page_settings();

        return view('admin.pages.health_check_settings', compact('settings'));
    }

    public function updateHealthCheckSettings(HealthCheckPageSettingRequest $request)
    {
        try {
            $payload = $request->validated();

            if (!File::isDirectory('uploads/pages/health-check')) {
                File::makeDirectory('uploads/pages/health-check', 0755, true);
            }

            if ($request->hasFile('hero_image_file')) {
                $image = $request->file('hero_image_file');
                $imageName = 'hero_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move('uploads/pages/health-check', $imageName);
                $payload['hero_image'] = 'uploads/pages/health-check/' . $imageName;
            }

            Setting::updateOrCreate(
                ['key' => 'health_check_page'],
                ['value' => json_encode($payload)]
            );

            return redirect()
                ->route('admin.pages.health_check_settings')
                ->with('success', 'Health Check page settings updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update Health Check page settings: ' . $e->getMessage());
        }
    }

    public function membershipSettings()
    {
        return $this->renderInnerPageSettings(
            'Membership Settings',
            '/membership Page Settings',
            'admin.pages.membership_settings_submit',
            membership_page_settings(),
            'pages_membership'
        );
    }

    public function updateMembershipSettings(InnerPageSettingRequest $request)
    {
        return $this->updateInnerPageSettings($request, 'membership_page', 'membership', 'admin.pages.membership_settings');
    }

    public function videoConsultationSettings()
    {
        $settings = video_consultation_page_settings();

        return view('admin.pages.video_consultation_settings', compact('settings'));
    }

    public function updateVideoConsultationSettings(VideoConsultationPageSettingRequest $request)
    {
        try {
            $payload = $request->validated();

            $targetDir = 'uploads/pages/video-consultation';
            if (!File::isDirectory($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            if ($request->hasFile('hero_image_file')) {
                $image = $request->file('hero_image_file');
                $imageName = 'hero_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($targetDir, $imageName);
                $payload['hero_image'] = $targetDir . '/' . $imageName;
            }

            if ($request->hasFile('why_image_file')) {
                $image = $request->file('why_image_file');
                $imageName = 'why_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($targetDir, $imageName);
                $payload['why_image'] = $targetDir . '/' . $imageName;
            }

            Setting::updateOrCreate(
                ['key' => 'video_consultation_page'],
                ['value' => json_encode($payload)]
            );

            return redirect()->route('admin.pages.video_consultation_settings')->with('success', 'Video Consultation settings updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update Video Consultation settings: ' . $e->getMessage());
        }
    }

    public function aboutSettings()
    {
        $settings = about_page_settings();

        return view('admin.pages.about_settings', compact('settings'));
    }

    public function updateAboutSettings(AboutPageSettingRequest $request)
    {
        try {
            $payload = $request->validated();

            $targetDir = 'uploads/pages/about';
            if (!File::isDirectory($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            if ($request->hasFile('hero_image_file')) {
                $image = $request->file('hero_image_file');
                $imageName = 'hero_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($targetDir, $imageName);
                $payload['hero_image'] = $targetDir . '/' . $imageName;
            }

            if ($request->hasFile('intro_image_file')) {
                $image = $request->file('intro_image_file');
                $imageName = 'intro_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($targetDir, $imageName);
                $payload['intro_image'] = $targetDir . '/' . $imageName;
            }

            Setting::updateOrCreate(
                ['key' => 'about_page'],
                ['value' => json_encode($payload)]
            );

            return redirect()->route('admin.pages.about_settings')->with('success', 'About page settings updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update About page settings: ' . $e->getMessage());
        }
    }

    public function servicesSettings()
    {
        $settings = services_page_settings();

        return view('admin.pages.services_settings', compact('settings'));
    }

    public function updateServicesSettings(ServicesPageSettingRequest $request)
    {
        try {
            $payload = $request->validated();

            $targetDir = 'uploads/pages/services';
            if (!File::isDirectory($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            if ($request->hasFile('hero_image_file')) {
                $image = $request->file('hero_image_file');
                $imageName = 'hero_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($targetDir, $imageName);
                $payload['hero_image'] = $targetDir . '/' . $imageName;
            }

            if ($request->hasFile('block_1_image_file')) {
                $image = $request->file('block_1_image_file');
                $imageName = 'block1_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($targetDir, $imageName);
                $payload['block_1_image'] = $targetDir . '/' . $imageName;
            }

            if ($request->hasFile('block_2_image_file')) {
                $image = $request->file('block_2_image_file');
                $imageName = 'block2_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($targetDir, $imageName);
                $payload['block_2_image'] = $targetDir . '/' . $imageName;
            }

            Setting::updateOrCreate(
                ['key' => 'services_page'],
                ['value' => json_encode($payload)]
            );

            return redirect()->route('admin.pages.services_settings')->with('success', 'Services page settings updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update Services page settings: ' . $e->getMessage());
        }
    }

    public function doctorsSettings()
    {
        return $this->renderInnerPageSettings(
            'Our Doctors Settings',
            '/doctor Page Settings',
            'admin.pages.doctors_settings_submit',
            doctors_page_settings(),
            'pages_our_doctors'
        );
    }

    public function updateDoctorsSettings(InnerPageSettingRequest $request)
    {
        return $this->updateInnerPageSettings($request, 'doctors_page', 'doctor', 'admin.pages.doctors_settings');
    }

    public function gallerySettings()
    {
        return $this->renderInnerPageSettings(
            'Gallery Settings',
            '/gallery Page Settings',
            'admin.pages.gallery_settings_submit',
            gallery_page_settings(),
            'pages_gallery'
        );
    }

    public function updateGallerySettings(InnerPageSettingRequest $request)
    {
        return $this->updateInnerPageSettings($request, 'gallery_page', 'gallery', 'admin.pages.gallery_settings');
    }

    public function missionVisionSettings()
    {
        return $this->renderInnerPageSettings(
            'Mission & Vision Settings',
            '/mission-vision-value Page Settings',
            'admin.pages.mission_vision_settings_submit',
            mission_vision_page_settings(),
            'pages_mission_vision'
        );
    }

    public function updateMissionVisionSettings(InnerPageSettingRequest $request)
    {
        return $this->updateInnerPageSettings($request, 'mission_vision_page', 'mission-vision', 'admin.pages.mission_vision_settings');
    }

    public function managementSettings()
    {
        return $this->renderInnerPageSettings(
            'Management Settings',
            '/management Page Settings',
            'admin.pages.management_settings_submit',
            management_page_settings(),
            'pages_management'
        );
    }

    public function updateManagementSettings(InnerPageSettingRequest $request)
    {
        return $this->updateInnerPageSettings($request, 'management_page', 'management', 'admin.pages.management_settings');
    }

    public function contactSettings()
    {
        return $this->renderInnerPageSettings(
            'Contact Settings',
            '/contact Page Settings',
            'admin.pages.contact_settings_submit',
            contact_page_settings(),
            'pages_contact'
        );
    }

    public function updateContactSettings(InnerPageSettingRequest $request)
    {
        return $this->updateInnerPageSettings($request, 'contact_page', 'contact', 'admin.pages.contact_settings');
    }

    public function blogSettings()
    {
        $settings = blog_page_settings();

        return view('admin.pages.blog_settings', compact('settings'));
    }

    public function updateBlogSettings(BlogPageSettingRequest $request)
    {
        try {
            $payload = $request->validated();

            $targetDir = 'uploads/pages/blog';
            if (!File::isDirectory($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            if ($request->hasFile('hero_image_file')) {
                $image = $request->file('hero_image_file');
                $imageName = 'hero_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($targetDir, $imageName);
                $payload['hero_image'] = $targetDir . '/' . $imageName;
            }

            if ($request->hasFile('founder_image_file')) {
                $image = $request->file('founder_image_file');
                $imageName = 'founder_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($targetDir, $imageName);
                $payload['founder_image'] = $targetDir . '/' . $imageName;
            }

            Setting::updateOrCreate(
                ['key' => 'blog_page'],
                ['value' => json_encode($payload)]
            );

            return redirect()->route('admin.pages.blog_settings')->with('success', 'Blog page settings updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update Blog page settings: ' . $e->getMessage());
        }
    }

    private function renderInnerPageSettings(
        string $title,
        string $subtitle,
        string $submitRoute,
        array $settings,
        string $activeMenuId
    ) {
        return view('admin.pages.inner_page_settings', compact('title', 'subtitle', 'submitRoute', 'settings', 'activeMenuId'));
    }

    private function updateInnerPageSettings(
        InnerPageSettingRequest $request,
        string $settingKey,
        string $uploadFolder,
        string $redirectRoute
    ) {
        try {
            $payload = $request->validated();

            $targetDir = 'uploads/pages/' . $uploadFolder;
            if (!File::isDirectory($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            if ($request->hasFile('hero_image_file')) {
                $image = $request->file('hero_image_file');
                $imageName = 'hero_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($targetDir, $imageName);
                $payload['hero_image'] = $targetDir . '/' . $imageName;
            }
            
            Setting::updateOrCreate(
                ['key' => $settingKey],
                ['value' => json_encode($payload)]
            );

            return redirect()->route($redirectRoute)->with('success', 'Page settings updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update page settings: ' . $e->getMessage());
        }
    }
}
