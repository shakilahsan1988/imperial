<?php

namespace App\Support;

use App\Models\Blog;
use App\Models\Branch;
use App\Models\Doctor;

/**
 * Builds schema.org JSON-LD payloads as plain arrays.
 *
 * These arrays must be built here, in a real .php file, rather than inline in
 * a .blade.php template: Blade's directive compiler scans raw template text
 * for @word sequences before it understands PHP string quoting, so a literal
 * '@context' key written inside a Blade file collides with Blade's own
 * @context/@endcontext directive and gets silently stripped out.
 */
final class SchemaBuilder
{
    public static function organization(array $info): array
    {
        $generic = ['https://facebook.com', 'https://twitter.com', 'https://instagram.com', 'https://youtube.com'];

        $sameAs = collect($info['socials'] ?? [])
            ->filter(fn ($url) => filled($url) && ! in_array(rtrim($url, '/'), $generic, true))
            ->values()
            ->all();

        $logo = ! empty($info['logo']) ? asset('img/'.$info['logo']) : asset('assets/front/images/logo.png');

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'MedicalOrganization',
            'name' => $info['name'] ?? 'Imperial Health',
            'url' => url('/'),
            'logo' => $logo,
            'sameAs' => $sameAs ?: null,
        ]);
    }

    public static function medicalClinic(Branch $branch): array
    {
        $images = collect([$branch->feature_image])
            ->merge($branch->galleries->pluck('image'))
            ->filter()
            ->map(fn ($path) => asset($path))
            ->values()
            ->all();

        $geo = ($branch->lat && $branch->lng) ? array_filter([
            '@type' => 'GeoCoordinates',
            'latitude' => $branch->lat,
            'longitude' => $branch->lng,
        ]) : null;

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'MedicalClinic',
            'name' => $branch->title ?: $branch->name,
            'description' => $branch->description,
            'image' => $images ?: null,
            'telephone' => $branch->phone,
            'address' => $branch->address,
            'geo' => $geo,
            'url' => route('branch-details', $branch->slug),
        ]);
    }

    public static function faqPage(array $pairs): ?array
    {
        $items = collect($pairs)
            ->filter(fn ($pair) => filled($pair['question'] ?? null) && filled($pair['answer'] ?? null))
            ->map(fn ($pair) => [
                '@type' => 'Question',
                'name' => html_entity_decode(strip_tags($pair['question']), ENT_QUOTES),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => html_entity_decode(strip_tags($pair['answer']), ENT_QUOTES),
                ],
            ])
            ->values()
            ->all();

        if (empty($items)) {
            return null;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $items,
        ];
    }

    public static function physician(Doctor $doctor): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Physician',
            'name' => $doctor->name,
            'image' => $doctor->effective_image_url ?? null,
            'jobTitle' => $doctor->designation,
            'medicalSpecialty' => $doctor->specialty->name ?? null,
            'description' => $doctor->bio,
            'url' => route('book-doctor', $doctor->slug),
        ]);
    }

    public static function blogPosting(Blog $blog): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $blog->title,
            'image' => $blog->featured_image ? asset($blog->featured_image) : null,
            'datePublished' => optional($blog->published_at)->toIso8601String(),
            'author' => $blog->author_name ? [
                '@type' => 'Person',
                'name' => $blog->author_name,
            ] : null,
            'description' => $blog->excerpt,
            'url' => route('blog-details', $blog->slug),
        ]);
    }

    public static function script(?array $data): string
    {
        if (empty($data)) {
            return '';
        }

        $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return '<script type="application/ld+json">'.$json.'</script>';
    }
}
