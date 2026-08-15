<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Branch;
use App\Models\Doctor;
use App\Models\HealthPackage;
use App\Models\MembershipPlan;
use App\Models\Page;
use App\Models\TeamMember;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function robots(): Response
    {
        $sitemapUrl = url('/sitemap.xml');

        $disallow = [
            '/admin',
            '/patient',
            '/cart',
            '/checkout',
            '/my-bookings',
            '/run-otp-migration',
            '/clear-cache',
            '/booking/',
            '/payment/',
            '/doctor-booking/',
        ];

        $lines = ['User-agent: *'];
        foreach ($disallow as $path) {
            $lines[] = "Disallow: {$path}";
        }
        $lines[] = '';
        $lines[] = "Sitemap: {$sitemapUrl}";

        return response(implode("\n", $lines), 200)
            ->header('Content-Type', 'text/plain');
    }

    public function sitemap(): Response
    {
        $staticRoutes = [
            ['route' => 'fhome', 'priority' => '1.0'],
            ['route' => 'about', 'priority' => '0.8'],
            ['route' => 'mission-vision-value', 'priority' => '0.6'],
            ['route' => 'management', 'priority' => '0.6'],
            ['route' => 'services', 'priority' => '0.8'],
            ['route' => 'health-check', 'priority' => '0.8'],
            ['route' => 'membership', 'priority' => '0.8'],
            ['route' => 'video-consultation', 'priority' => '0.8'],
            ['route' => 'lab-test', 'priority' => '0.7'],
            ['route' => 'beauty', 'priority' => '0.6'],
            ['route' => 'contact', 'priority' => '0.6'],
            ['route' => 'career', 'priority' => '0.5'],
            ['route' => 'doctor', 'priority' => '0.8'],
            ['route' => 'blog', 'priority' => '0.7'],
            ['route' => 'gallery', 'priority' => '0.5'],
            ['route' => 'branches', 'priority' => '0.8'],
            ['route' => 'privacy-notice', 'priority' => '0.3'],
            ['route' => 'code-of-ethics', 'priority' => '0.3'],
            ['route' => 'bill-of-right', 'priority' => '0.3'],
            ['route' => 'client', 'priority' => '0.4'],
        ];

        $urls = [];

        foreach ($staticRoutes as $item) {
            $urls[] = [
                'loc' => route($item['route']),
                'priority' => $item['priority'],
                'images' => [],
            ];
        }

        foreach (Branch::query()->whereNotNull('slug')->get() as $branch) {
            $urls[] = [
                'loc' => route('branch-details', $branch->slug),
                'priority' => '0.8',
                'images' => $this->imageUrls(array_merge(
                    [$branch->feature_image],
                    $branch->galleries->pluck('image')->all()
                )),
            ];
        }

        foreach (Doctor::query()->where('status', true)->whereNotNull('slug')->get() as $doctor) {
            $urls[] = [
                'loc' => route('book-doctor', $doctor->slug),
                'priority' => '0.6',
                'images' => $this->imageUrls([$doctor->image]),
            ];
        }

        foreach (HealthPackage::query()->where('status', true)->whereNotNull('slug')->get() as $package) {
            $urls[] = [
                'loc' => route('package-details', $package->slug),
                'priority' => '0.6',
                'images' => $this->imageUrls([$package->image]),
            ];
        }

        foreach (MembershipPlan::query()->where('status', true)->whereNotNull('slug')->get() as $plan) {
            $urls[] = [
                'loc' => route('membership-details', $plan->slug),
                'priority' => '0.6',
                'images' => $this->imageUrls([$plan->image]),
            ];
        }

        foreach (Blog::query()->where('status', true)->whereNotNull('slug')->get() as $blog) {
            $urls[] = [
                'loc' => route('blog-details', $blog->slug),
                'priority' => '0.5',
                'images' => $this->imageUrls([$blog->featured_image ?? null]),
            ];
        }

        foreach (TeamMember::query()->where('status', true)->whereNotNull('slug')->get() as $member) {
            $urls[] = [
                'loc' => route('management-details', $member->slug),
                'priority' => '0.4',
                'images' => $this->imageUrls([$member->image]),
            ];
        }

        foreach (Page::query()->where('status', true)->whereNotNull('slug')->get() as $page) {
            $urls[] = [
                'loc' => route('dynamic-page.show', $page->slug),
                'priority' => '0.4',
                'images' => [],
            ];
        }

        $xml = view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    private function imageUrls(array $paths): array
    {
        return collect($paths)
            ->filter(fn ($path) => filled($path))
            ->map(fn ($path) => str_replace(' ', '%20', asset($path)))
            ->values()
            ->all();
    }
}
