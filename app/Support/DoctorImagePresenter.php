<?php

namespace App\Support;

use App\Models\Doctor;

/**
 * Resolves the effective image URL for a doctor.
 *
 * This is the single place in the application where "which picture does this
 * doctor show?" is decided. Every surface - admin, public, JSON - must call it
 * rather than reading doctors.image directly, otherwise the fallback rules
 * drift apart again.
 *
 * Two security properties this class is responsible for:
 *
 *  1. A stored path is never handed to file_exists() or asset() until it has
 *     passed the read allowlist. A malformed, traversing, absolute, or remote
 *     path resolves to an avatar instead of touching the filesystem.
 *
 *  2. It never deletes anything. Deletion ownership is a separate, stricter
 *     question answered by DoctorImageService::assertOwned().
 */
final class DoctorImagePresenter
{
    /**
     * Per-request memo of public_path() existence checks.
     *
     * A doctor listing renders the same avatar dozens of times; without this
     * we would issue one stat() syscall per card.
     *
     * @var array<string, bool>
     */
    private static array $existsCache = [];

    /**
     * The effective, browser-ready image URL for a doctor.
     *
     * Order: valid personal photo that exists on disk, else the avatar for the
     * doctor's gender, else the neutral avatar.
     */
    public static function url(Doctor $doctor): string
    {
        $path = self::safeRelativePath($doctor->image);

        if ($path !== null && self::publicFileExists($path)) {
            return asset($path).self::cacheBuster($doctor);
        }

        return self::avatarFor(self::genderOf($doctor));
    }

    /**
     * Whether this doctor has a usable personal photo.
     *
     * False means the doctor is currently showing a shared avatar - either
     * because image is null, or because the stored path is unsafe or broken.
     */
    public static function hasPersonalImage(Doctor $doctor): bool
    {
        $path = self::safeRelativePath($doctor->image);

        return $path !== null && self::publicFileExists($path);
    }

    /**
     * Validate a stored image path against the read allowlist.
     *
     * Returns the cleaned public-relative path, or null if the value must not
     * be trusted. Null is a normal outcome, not an error - the caller falls
     * back to an avatar.
     *
     * Deliberately permissive about legacy flat filenames
     * (uploads/doctors/dr-name.jpg) because 14 existing doctors still use
     * them. Those paths are readable but, by design, are NOT deletable - see
     * DoctorImageService::assertOwned().
     *
     * Remote URLs are rejected outright: no doctor image in this application
     * is an external URL, so accepting one would only add attack surface.
     */
    public static function safeRelativePath(?string $path): ?string
    {
        if ($path === null) {
            return null;
        }

        $path = trim($path);

        if ($path === '') {
            return null;
        }

        // Reject before any filesystem or URL helper sees the value.
        if (str_contains($path, "\0")
            || str_contains($path, '..')
            || str_contains($path, '\\')
            || str_contains($path, '://')
            || str_starts_with($path, '/')
            || preg_match('/^[A-Za-z]:/', $path) === 1
        ) {
            return null;
        }

        $base = trim((string) config('doctor_sync.uploads.base_directory', 'uploads/doctors'), '/');
        $extensions = implode('|', array_keys((array) config('doctor_sync.uploads.allowed_types', [])));

        if ($base === '' || $extensions === '') {
            return null;
        }

        // uploads/doctors/<id>/<file>.<ext>  (current layout)
        // uploads/doctors/<file>.<ext>       (legacy flat layout)
        $pattern = '#^'.preg_quote($base, '#').'/(?:\d+/)?[A-Za-z0-9._-]{1,120}\.(?:'.$extensions.')$#i';

        return preg_match($pattern, $path) === 1 ? $path : null;
    }

    /**
     * The shared avatar URL for a gender value.
     *
     * Unknown, null, or unrecognised gender resolves to the neutral avatar.
     * Gender is never inferred from a name, a title, a photo, or a specialty.
     */
    public static function avatarFor(?string $gender): string
    {
        $avatars = (array) config('doctor_sync.avatars', []);

        $key = match (strtolower(trim((string) $gender))) {
            'male' => 'male',
            'female' => 'female',
            default => 'unknown',
        };

        $path = $avatars[$key] ?? null;

        // If the configured avatar is missing from disk - for instance because
        // a deployment did not ship the asset - degrade to the neutral avatar
        // and then to the last-resort image rather than emitting a broken img.
        foreach ([$path, $avatars['unknown'] ?? null, $avatars['fallback'] ?? null] as $candidate) {
            if (is_string($candidate) && $candidate !== '' && self::publicFileExists($candidate)) {
                return asset($candidate);
            }
        }

        return asset($path ?? ($avatars['fallback'] ?? 'img/no-image.png'));
    }

    /**
     * Clear the memoised existence checks.
     *
     * Needed in tests, and after an upload replaces a file within the same
     * request.
     */
    public static function flushCache(): void
    {
        self::$existsCache = [];
    }

    /**
     * Read the gender attribute defensively.
     *
     * doctors.gender does not exist until the Gate B migration runs, so this
     * must not assume the attribute is present.
     */
    private static function genderOf(Doctor $doctor): ?string
    {
        $gender = $doctor->getAttribute('gender');

        return is_string($gender) ? $gender : null;
    }

    /**
     * Version marker so a replaced photo is not served from browser cache.
     */
    private static function cacheBuster(Doctor $doctor): string
    {
        $updatedAt = $doctor->updated_at;

        return $updatedAt ? '?v='.$updatedAt->getTimestamp() : '';
    }

    /**
     * Existence check for an already-validated public-relative path.
     */
    private static function publicFileExists(string $relativePath): bool
    {
        if (! array_key_exists($relativePath, self::$existsCache)) {
            self::$existsCache[$relativePath] = is_file(public_path($relativePath));
        }

        return self::$existsCache[$relativePath];
    }
}
