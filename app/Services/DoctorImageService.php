<?php

namespace App\Services;

use App\Models\Doctor;
use App\Support\DoctorImagePresenter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Owns the lifecycle of a doctor's personal photo.
 *
 * Two hard rules govern everything here:
 *
 *  1. A file is deletable only if ownership can be PROVEN. assertOwned() fails
 *     closed - if any check is inconclusive the file is left alone. This is
 *     what keeps the shared avatars, other doctors' photos, and anything
 *     outside uploads/doctors/{id}/ permanently out of reach.
 *
 *  2. A database transaction cannot roll back a filesystem change, so the two
 *     are sequenced rather than nested: write the new file, commit the row,
 *     and only then remove the superseded file. Every failure mode leaves the
 *     doctor with a working image.
 */
class DoctorImageService
{
    /**
     * Attach an uploaded photo to a doctor, replacing any previous one.
     *
     * Compensation ordering:
     *   1. validate the upload
     *   2. write the new file
     *   3. verify what was written
     *   4. commit the new path              -> on failure, remove the new file
     *   5. delete the superseded file       -> on failure, log an orphan
     *
     * The previous file survives every database failure; the new file is
     * cleaned up on every database failure; a failed cleanup degrades to a
     * logged orphan rather than a missing image.
     *
     * @return string the stored public-relative path
     */
    public function store(Doctor $doctor, UploadedFile $file): string
    {
        if (! $doctor->exists) {
            throw new RuntimeException('Cannot attach an image to an unsaved doctor.');
        }

        $extension = $this->resolveExtension($file);

        $directory = $this->doctorDirectory($doctor);
        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $filename = Str::uuid()->toString().'.'.$extension;
        $relativePath = $this->baseDirectory().'/'.$doctor->getKey().'/'.$filename;

        $file->move($directory, $filename);

        $absolutePath = $directory.DIRECTORY_SEPARATOR.$filename;
        $this->assertWrittenFileIsUsable($absolutePath);

        $previousPath = $doctor->image;

        try {
            DB::transaction(function () use ($doctor, $relativePath) {
                $doctor->forceFill(['image' => $relativePath])->save();
            });
        } catch (\Throwable $e) {
            // The row was not changed, so the previous image is still correct.
            // Remove the file we just wrote so it does not become an orphan.
            $this->deleteFileQuietly($absolutePath, 'rollback of failed image update');

            throw $e;
        }

        DoctorImagePresenter::flushCache();

        $this->deleteSupersededFile($doctor, $previousPath);

        return $relativePath;
    }

    /**
     * Detach a doctor's personal photo so the shared avatar takes over.
     *
     * The row is cleared first; only then is the file considered for deletion,
     * which means an interrupted removal leaves an orphan file rather than a
     * doctor pointing at a file that no longer exists.
     */
    public function remove(Doctor $doctor): void
    {
        $previousPath = $doctor->image;

        if ($previousPath === null || $previousPath === '') {
            return;
        }

        DB::transaction(function () use ($doctor) {
            $doctor->forceFill(['image' => null])->save();
        });

        DoctorImagePresenter::flushCache();

        $this->deleteSupersededFile($doctor, $previousPath);
    }

    /**
     * Prove that a path is a deletable file belonging to this doctor.
     *
     * Fails closed: every check must pass. Ownership is never inferred from a
     * filename prefix alone.
     *
     * Legacy flat paths (uploads/doctors/dr-name.jpg) intentionally fail at
     * step 2. They remain readable and displayable, but this service will
     * never delete them - migrating them into the id-scoped layout is a
     * separate, explicitly approved operation.
     */
    public function assertOwned(Doctor $doctor, ?string $path): bool
    {
        // 1. Structural rejection, before any filesystem call.
        if (! is_string($path) || trim($path) === '') {
            return false;
        }

        $path = trim($path);

        if (str_contains($path, "\0")
            || str_contains($path, '..')
            || str_contains($path, '\\')
            || str_contains($path, '://')
            || str_starts_with($path, '/')
            || preg_match('/^[A-Za-z]:/', $path) === 1
        ) {
            return false;
        }

        // 2. Must match the id-scoped UUID layout exactly.
        $base = $this->baseDirectory();
        $extensions = implode('|', array_keys($this->allowedTypes()));

        if ($extensions === '') {
            return false;
        }

        $pattern = '#^'.preg_quote($base, '#')
            .'/(\d+)/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\.('.$extensions.')$#i';

        if (preg_match($pattern, $path, $matches) !== 1) {
            return false;
        }

        // 3. The id embedded in the path must be this doctor.
        if ((string) $matches[1] !== (string) $doctor->getKey()) {
            return false;
        }

        // 4. The file must resolve on disk.
        $real = realpath(public_path($path));
        if ($real === false) {
            return false;
        }

        // 5. It must resolve INSIDE this doctor's directory. Comparing resolved
        //    paths is what defeats a symlink pointing out of the tree.
        $directoryReal = realpath($this->doctorDirectory($doctor));
        if ($directoryReal === false || ! str_starts_with($real, $directoryReal.DIRECTORY_SEPARATOR)) {
            return false;
        }

        // 6. It must be a regular file, not a link.
        if (! is_file($real) || is_link($real)) {
            return false;
        }

        // 7. It must no longer be referenced by any doctor row, including
        //    soft-deleted ones. This is what makes the check safe for both the
        //    replace flow (old path already superseded) and the remove flow
        //    (image already nulled), while refusing to delete a file that is
        //    still in use anywhere.
        $stillReferenced = Doctor::withTrashed()->where('image', $path)->exists();

        return ! $stillReferenced;
    }

    /**
     * Public-relative base directory for doctor uploads.
     */
    public function baseDirectory(): string
    {
        return trim((string) config('doctor_sync.uploads.base_directory', 'uploads/doctors'), '/');
    }

    /**
     * Absolute path of a doctor's own upload directory.
     */
    public function doctorDirectory(Doctor $doctor): string
    {
        return public_path($this->baseDirectory().'/'.$doctor->getKey());
    }

    /**
     * Delete a superseded file, but only if ownership can be proven.
     */
    private function deleteSupersededFile(Doctor $doctor, ?string $previousPath): void
    {
        if ($previousPath === null || $previousPath === '') {
            return;
        }

        if (! $this->assertOwned($doctor, $previousPath)) {
            // Not provably ours: a legacy flat path, a shared avatar, a file
            // another doctor still references, or something malformed. Leaving
            // it in place is always the safe outcome.
            Log::info('[doctor-image] SKIPPED_DELETE_NOT_OWNED', [
                'doctor_id' => $doctor->getKey(),
                'path' => $previousPath,
            ]);

            return;
        }

        $this->deleteFileQuietly(public_path($previousPath), 'superseded doctor image', [
            'doctor_id' => $doctor->getKey(),
            'path' => $previousPath,
        ]);
    }

    /**
     * Remove a file without ever letting the failure surface to the user.
     *
     * A photo that could not be cleaned up is an orphan, which the
     * reconciliation report can pick up later. It is never a reason to fail a
     * request that has already been committed.
     */
    private function deleteFileQuietly(string $absolutePath, string $reason, array $context = []): void
    {
        try {
            if (is_file($absolutePath) && ! @unlink($absolutePath)) {
                throw new RuntimeException('unlink() returned false');
            }
        } catch (\Throwable $e) {
            Log::warning('[doctor-image] ORPHANED_FILE', $context + [
                'absolute_path' => $absolutePath,
                'reason' => $reason,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Derive the stored extension from the file's actual content type.
     *
     * The client-supplied extension is never trusted.
     */
    private function resolveExtension(UploadedFile $file): string
    {
        $mime = (string) $file->getMimeType();
        $extension = array_search($mime, $this->allowedTypes(), true);

        if ($extension === false) {
            throw new RuntimeException("Unsupported doctor image type: {$mime}");
        }

        return (string) $extension;
    }

    /**
     * Confirm the file we just wrote is a real, readable image of a sane size.
     */
    private function assertWrittenFileIsUsable(string $absolutePath): void
    {
        if (! is_file($absolutePath) || filesize($absolutePath) === 0) {
            $this->deleteFileQuietly($absolutePath, 'unusable upload');

            throw new RuntimeException('The uploaded doctor image could not be stored.');
        }

        $dimensions = @getimagesize($absolutePath);

        if ($dimensions === false) {
            $this->deleteFileQuietly($absolutePath, 'not a decodable image');

            throw new RuntimeException('The uploaded doctor image is not a valid image file.');
        }
    }

    /**
     * @return array<string, string> extension => mime type
     */
    private function allowedTypes(): array
    {
        return (array) config('doctor_sync.uploads.allowed_types', []);
    }
}
