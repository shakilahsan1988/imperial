<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DiagonosticPageSettingRequest;
use App\Http\Requests\Admin\HealthCheckPageSettingRequest;
use App\Http\Requests\Admin\HomePageSettingRequest;
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
}
