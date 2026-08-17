<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * @var array<int, array{name: string, image: string}>
     */
    private array $packages = [
        1 => [
            'name' => 'Imperial Women’s Wellness Check – Under 40',
            'image' => 'uploads/health_packages/imperial-womens-wellness-under-40.png',
        ],
        2 => [
            'name' => 'Imperial Women’s Wellness Check – 40 to 65',
            'image' => 'uploads/health_packages/imperial-womens-wellness-40-to-65.png',
        ],
        3 => [
            'name' => 'Imperial Men’s Wellness Check – Under 40',
            'image' => 'uploads/health_packages/imperial-mens-wellness-under-40.png',
        ],
        4 => [
            'name' => 'Imperial Men’s Wellness Check – 40 to 65',
            'image' => 'uploads/health_packages/imperial-mens-wellness-40-to-65.png',
        ],
        5 => [
            'name' => 'Imperial Women’s Senior Wellness Check – 65+',
            'image' => 'uploads/health_packages/imperial-womens-senior-wellness-65-plus.png',
        ],
        6 => [
            'name' => 'Imperial Women’s Heart Health Check',
            'image' => 'uploads/health_packages/imperial-womens-heart-health.png',
        ],
        7 => [
            'name' => 'Imperial Men’s Senior Wellness Check – 65+',
            'image' => 'uploads/health_packages/imperial-mens-senior-wellness-65-plus.png',
        ],
        8 => [
            'name' => 'Imperial Men’s Executive Health Check',
            'image' => 'uploads/health_packages/imperial-mens-executive-health.png',
        ],
    ];

    public function up(): void
    {
        DB::transaction(function () {
            foreach ($this->packages as $expectedId => $package) {
                $targetId = $this->verifiedPackageId($expectedId, $package['name']);

                if ($targetId === null) {
                    continue;
                }

                DB::table('health_packages')
                    ->where('id', $targetId)
                    ->where('name', $package['name'])
                    ->where('image', '<>', $package['image'])
                    ->update([
                        'image' => $package['image'],
                        'updated_at' => now(),
                    ]);
            }
        });
    }

    public function down(): void
    {
        DB::transaction(function () {
            foreach ($this->packages as $expectedId => $package) {
                DB::table('health_packages')
                    ->where('id', $expectedId)
                    ->where('name', $package['name'])
                    ->where('image', $package['image'])
                    ->update([
                        'image' => 'assets/front/images/services/services-facility.jpg',
                        'updated_at' => now(),
                    ]);
            }
        });
    }

    private function verifiedPackageId(int $expectedId, string $name): ?int
    {
        $expectedPackage = DB::table('health_packages')
            ->where('id', $expectedId)
            ->where('name', $name)
            ->first(['id']);

        if ($expectedPackage) {
            return (int) $expectedPackage->id;
        }

        $matches = DB::table('health_packages')
            ->where('name', $name)
            ->get(['id']);

        if ($matches->count() > 1) {
            throw new RuntimeException("Multiple health packages match the verified name: {$name}");
        }

        return $matches->isEmpty() ? null : (int) $matches->first()->id;
    }
};
