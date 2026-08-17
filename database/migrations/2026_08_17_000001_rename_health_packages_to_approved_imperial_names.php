<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * @var array<int, array{old: string, new: string}>
     */
    private array $packages = [
        1 => [
            'old' => 'Her Health (Under 40)',
            'new' => 'Imperial Women’s Wellness Check – Under 40',
        ],
        2 => [
            'old' => 'Her Health (40 - 65)',
            'new' => 'Imperial Women’s Wellness Check – 40 to 65',
        ],
        3 => [
            'old' => 'His Health (Under 40)',
            'new' => 'Imperial Men’s Wellness Check – Under 40',
        ],
        4 => [
            'old' => 'His Health (40 - 65)',
            'new' => 'Imperial Men’s Wellness Check – 40 to 65',
        ],
        5 => [
            'old' => 'Her Health (Above 65)',
            'new' => 'Imperial Women’s Senior Wellness Check – 65+',
        ],
        6 => [
            'old' => "Women's Cardiac Check",
            'new' => 'Imperial Women’s Heart Health Check',
        ],
        7 => [
            'old' => 'His Health (Above 65)',
            'new' => 'Imperial Men’s Senior Wellness Check – 65+',
        ],
        8 => [
            'old' => "Men's Executive Check",
            'new' => 'Imperial Men’s Executive Health Check',
        ],
    ];

    public function up(): void
    {
        $this->renamePackages('old', 'new');
    }

    public function down(): void
    {
        $this->renamePackages('new', 'old');
    }

    /**
     * Rename only a verified master record, preserving its ID, slug and every
     * clinical, pricing and relationship field. Re-running is a no-op.
     */
    private function renamePackages(string $from, string $to): void
    {
        DB::transaction(function () use ($from, $to) {
            foreach ($this->packages as $expectedId => $names) {
                $target = DB::table('health_packages')
                    ->where('id', $expectedId)
                    ->where('name', $names[$from])
                    ->first(['id']);

                if (! $target) {
                    $matches = DB::table('health_packages')
                        ->where('name', $names[$from])
                        ->get(['id']);

                    if ($matches->count() > 1) {
                        throw new RuntimeException(
                            "Multiple health packages match the verified name: {$names[$from]}"
                        );
                    }

                    $target = $matches->first();
                }

                if (! $target) {
                    continue;
                }

                $approvedNameAlreadyUsed = DB::table('health_packages')
                    ->where('name', $names[$to])
                    ->where('id', '<>', $target->id)
                    ->exists();

                if ($approvedNameAlreadyUsed) {
                    throw new RuntimeException(
                        "Another health package already uses the approved name: {$names[$to]}"
                    );
                }

                DB::table('health_packages')
                    ->where('id', $target->id)
                    ->where('name', $names[$from])
                    ->update([
                        'name' => $names[$to],
                        'updated_at' => now(),
                    ]);
            }
        });
    }
};
