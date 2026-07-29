<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Restores doctor data from a snapshot written by DoctorSyncSnapshot.
 *
 * Dry-run by default, same convention as `doctor:audit`. Restoration is
 * parameterized query-builder calls keyed by primary key - never hand-built
 * SQL - and runs inside one transaction so a partial failure leaves the
 * database exactly as it was before the rollback attempt, not half-restored.
 */
class DoctorAuditRollbackCommand extends Command
{
    protected $signature = 'doctor:audit:rollback
        {snapshot : Path to a rollback-*.json file written by a previous --execute run}
        {--execute : Actually apply the rollback. Without this, only a preview is printed}';

    protected $description = 'Restore doctor data from a before-state snapshot (dry-run by default)';

    public function handle(): int
    {
        $path = $this->argument('snapshot');

        if (! is_file($path)) {
            $this->error("Snapshot not found: {$path}");

            return self::FAILURE;
        }

        $snapshot = json_decode(file_get_contents($path), true);

        if (! is_array($snapshot) || ! isset($snapshot['operations'])) {
            $this->error('Snapshot file is not a recognised doctor-sync snapshot.');

            return self::FAILURE;
        }

        $this->info('Rollback source: '.$path);
        $this->line('Label: '.($snapshot['label'] ?? 'unknown'));
        $this->line('Recorded at: '.($snapshot['created_at'] ?? 'unknown'));
        $this->line('Operations: '.count($snapshot['operations']));
        $this->newLine();

        $rows = [];
        foreach ($snapshot['operations'] as $op) {
            $rows[] = [
                $op['table'],
                $op['action'],
                $op['id'],
                $op['action'] === 'update' ? 'restore '.count($op['before'] ?? []).' column(s)' : 'delete this row',
            ];
        }
        $this->table(['Table', 'Action', 'ID', 'Effect'], $rows);

        if (! $this->option('execute')) {
            $this->newLine();
            $this->comment('Dry run only. Re-run with --execute to apply.');

            return self::SUCCESS;
        }

        DB::transaction(function () use ($snapshot) {
            foreach ($snapshot['operations'] as $op) {
                if ($op['action'] === 'update') {
                    $attributes = $op['before'];
                    unset($attributes['id']);
                    DB::table($op['table'])->where('id', $op['id'])->update($attributes);
                } elseif ($op['action'] === 'create') {
                    DB::table($op['table'])->where('id', $op['id'])->delete();
                }
            }
        });

        $this->info('Rollback applied.');

        return self::SUCCESS;
    }
}
