<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * @var array<int, array{old: string, new: string}>
     */
    private array $plans = [
        1 => ['old' => 'Imperial Gold Annual Plan', 'new' => 'Imperial Care Advantage Annual Membership'],
        2 => ['old' => 'Imperial Silver Annual Plan', 'new' => 'Imperial Care Essential Annual Membership'],
        3 => ['old' => 'Imperial Platinum Annual Plan', 'new' => 'Imperial Care Premier Annual Membership'],
        4 => ['old' => 'Prediabetes Plan', 'new' => 'Imperial Prediabetes Prevention Plan'],
        5 => ['old' => 'Diabetes Plan', 'new' => 'Imperial Diabetes Care Plan'],
        6 => ['old' => 'Imperial Anywhere 12 Months Plan', 'new' => 'Imperial CareConnect 12-Month Plan'],
        7 => ['old' => 'Imperial Anywhere 6 Months Plan', 'new' => 'Imperial CareConnect 6-Month Plan'],
        8 => ['old' => 'Imperial Anywhere 3 Months Plan', 'new' => 'Imperial CareConnect 3-Month Plan'],
        9 => ['old' => 'Imperial Anywhere Family Plus Plan', 'new' => 'Imperial CareConnect Family Plus Plan'],
        10 => ['old' => 'Imperial Anywhere Senior Care Plan', 'new' => 'Imperial CareConnect Senior Support Plan'],
    ];

    private array $videoCategory = [
        'old' => 'Imperial Anywhere Plan (Video Consultation)',
        'new' => 'Imperial CareConnect Plans (Video Consultation)',
    ];

    public function up(): void
    {
        DB::transaction(function () {
            $this->renamePlans('old', 'new');
            $this->renameVideoCategory('old', 'new');
            $this->renameSeniorBadge('Senior Care', 'Senior Support', $this->plans[10]['new']);
        });
    }

    public function down(): void
    {
        DB::transaction(function () {
            $this->renameSeniorBadge('Senior Support', 'Senior Care', $this->plans[10]['new']);
            $this->renameVideoCategory('new', 'old');
            $this->renamePlans('new', 'old');
        });
    }

    private function renamePlans(string $from, string $to): void
    {
        foreach ($this->plans as $expectedId => $names) {
            $targetId = $this->verifiedRecordId('membership_plans', $expectedId, $names[$from]);

            if ($targetId === null) {
                continue;
            }

            $approvedNameAlreadyUsed = DB::table('membership_plans')
                ->where('name', $names[$to])
                ->where('id', '<>', $targetId)
                ->exists();

            if ($approvedNameAlreadyUsed) {
                throw new RuntimeException("Another membership plan already uses the approved name: {$names[$to]}");
            }

            DB::table('membership_plans')
                ->where('id', $targetId)
                ->where('name', $names[$from])
                ->update([
                    'name' => $names[$to],
                    'updated_at' => now(),
                ]);
        }
    }

    private function renameVideoCategory(string $from, string $to): void
    {
        $targetId = $this->verifiedRecordId('membership_categories', 3, $this->videoCategory[$from]);

        if ($targetId === null) {
            return;
        }

        $duplicate = DB::table('membership_categories')
            ->where('name', $this->videoCategory[$to])
            ->where('id', '<>', $targetId)
            ->exists();

        if ($duplicate) {
            throw new RuntimeException("Another membership category already uses the approved label: {$this->videoCategory[$to]}");
        }

        $category = DB::table('membership_categories')->where('id', $targetId)->first(['description']);
        $updates = [
            'name' => $this->videoCategory[$to],
            'updated_at' => now(),
        ];

        if ($category?->description === $this->videoCategory[$from]) {
            $updates['description'] = $this->videoCategory[$to];
        }

        DB::table('membership_categories')
            ->where('id', $targetId)
            ->where('name', $this->videoCategory[$from])
            ->update($updates);
    }

    private function renameSeniorBadge(string $from, string $to, string $planName): void
    {
        DB::table('membership_plans')
            ->where('id', 10)
            ->where('name', $planName)
            ->where('badge_text', $from)
            ->update([
                'badge_text' => $to,
                'updated_at' => now(),
            ]);
    }

    private function verifiedRecordId(string $table, int $expectedId, string $name): ?int
    {
        $expectedRecord = DB::table($table)
            ->where('id', $expectedId)
            ->where('name', $name)
            ->first(['id']);

        if ($expectedRecord) {
            return (int) $expectedRecord->id;
        }

        $matches = DB::table($table)->where('name', $name)->get(['id']);

        if ($matches->count() > 1) {
            throw new RuntimeException("Multiple records in {$table} match the verified name: {$name}");
        }

        return $matches->isEmpty() ? null : (int) $matches->first()->id;
    }
};
