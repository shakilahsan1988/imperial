<?php

use App\Models\Doctor;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

require dirname(__DIR__).'/vendor/autoload.php';

$app = require dirname(__DIR__).'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$sourceDirectory = isset($argv[1]) ? rtrim($argv[1], '\\/') : '';

if ($sourceDirectory === '' || ! is_dir($sourceDirectory)) {
    fwrite(STDERR, "Usage: php scripts/update-doctor-shared-contacts-and-images.php <image-directory>\n");
    exit(1);
}

$email = (string) config('doctor_sync.shared_contacts.email');
$phone = (string) config('doctor_sync.shared_contacts.phone');
$doctors = Doctor::query()->orderBy('id')->get();
$doctorsByName = $doctors->keyBy(fn (Doctor $doctor) => Str::lower(trim($doctor->name)));
$createdFiles = [];
$imageUpdates = [];
$matchedDoctorIds = [];
$unusedImages = [];

try {
    foreach (glob($sourceDirectory.DIRECTORY_SEPARATOR.'*') ?: [] as $sourcePath) {
        if (! is_file($sourcePath)) {
            continue;
        }

        $dimensions = @getimagesize($sourcePath);
        if ($dimensions === false) {
            $unusedImages[] = basename($sourcePath).' (not a valid image)';
            continue;
        }

        $doctorName = Str::lower(trim(pathinfo($sourcePath, PATHINFO_FILENAME)));
        /** @var Doctor|null $doctor */
        $doctor = $doctorsByName->get($doctorName);

        if (! $doctor) {
            $unusedImages[] = basename($sourcePath).' (no exact doctor-name match)';
            continue;
        }

        $sourceHash = hash_file('sha256', $sourcePath);
        $currentPath = $doctor->image ? public_path($doctor->image) : null;

        if ($currentPath && is_file($currentPath) && hash_file('sha256', $currentPath) === $sourceHash) {
            $matchedDoctorIds[$doctor->id] = true;
            continue;
        }

        $extension = image_type_to_extension($dimensions[2], false);
        if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            $unusedImages[] = basename($sourcePath).' (unsupported image type)';
            continue;
        }

        $relativeDirectory = 'uploads/doctors/'.$doctor->id;
        $absoluteDirectory = public_path($relativeDirectory);

        if (! is_dir($absoluteDirectory) && ! mkdir($absoluteDirectory, 0755, true) && ! is_dir($absoluteDirectory)) {
            throw new RuntimeException("Unable to create {$absoluteDirectory}");
        }

        $relativePath = $relativeDirectory.'/'.Str::uuid().'.'.$extension;
        $absolutePath = public_path($relativePath);

        if (! copy($sourcePath, $absolutePath)) {
            throw new RuntimeException('Unable to copy '.basename($sourcePath));
        }

        $createdFiles[] = $absolutePath;

        if (! is_file($absolutePath) || hash_file('sha256', $absolutePath) !== $sourceHash) {
            throw new RuntimeException('Copied image verification failed for '.basename($sourcePath));
        }

        $imageUpdates[$doctor->id] = $relativePath;
        $matchedDoctorIds[$doctor->id] = true;
    }

    DB::transaction(function () use ($doctors, $email, $phone, $imageUpdates) {
        $now = now();

        DB::table('doctors')
            ->whereNull('deleted_at')
            ->update([
                'email' => $email,
                'phone' => $phone,
                'updated_at' => $now,
            ]);

        foreach ($imageUpdates as $doctorId => $relativePath) {
            DB::table('doctors')
                ->where('id', $doctorId)
                ->whereNull('deleted_at')
                ->update([
                    'image' => $relativePath,
                    'updated_at' => $now,
                ]);
        }
    });
} catch (Throwable $exception) {
    foreach ($createdFiles as $createdFile) {
        if (is_file($createdFile)) {
            @unlink($createdFile);
        }
    }

    throw $exception;
}

$unmatchedDoctors = $doctors
    ->reject(fn (Doctor $doctor) => isset($matchedDoctorIds[$doctor->id]))
    ->pluck('name')
    ->values()
    ->all();

echo json_encode([
    'contacts_updated' => $doctors->count(),
    'images_updated' => count($imageUpdates),
    'images_already_current' => count($matchedDoctorIds) - count($imageUpdates),
    'doctors_without_source_image' => $unmatchedDoctors,
    'unused_source_images' => $unusedImages,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL;
