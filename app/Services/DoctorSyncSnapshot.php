<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

/**
 * Records a before-image of every row a write operation is about to touch, so
 * `doctor:audit:rollback` can restore exactly what was there - including rows
 * that didn't exist yet, which are rolled back by deletion rather than update.
 *
 * One snapshot file typically covers one `--execute` invocation. Kept as JSON
 * (never hand-built SQL) so restoring is a parameterized Eloquent/query-builder
 * operation, not string interpolation.
 */
class DoctorSyncSnapshot
{
    /** @var array<int, array<string, mixed>> */
    protected array $operations = [];

    protected string $label;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    /**
     * Record the pre-change state of an existing row.
     */
    public function recordUpdate(string $table, int|string $id, array $before): void
    {
        $this->operations[] = [
            'table' => $table,
            'action' => 'update',
            'id' => $id,
            'before' => $before,
        ];
    }

    /**
     * Record that a row was newly created. Rollback deletes it.
     */
    public function recordCreate(string $table, int|string $id): void
    {
        $this->operations[] = [
            'table' => $table,
            'action' => 'create',
            'id' => $id,
        ];
    }

    public function isEmpty(): bool
    {
        return $this->operations === [];
    }

    /**
     * Persist the snapshot and return its absolute path.
     */
    public function save(): string
    {
        $directory = storage_path('app/'.config('doctor_sync.audit.output_directory', 'doctor-audit'));
        File::ensureDirectoryExists($directory);

        $timestamp = Carbon::now(config('app.timezone'))->format('Ymd-His');
        $path = $directory.'/rollback-'.$this->label.'-'.$timestamp.'.json';

        File::put($path, json_encode([
            'label' => $this->label,
            'created_at' => Carbon::now(config('app.timezone'))->toIso8601String(),
            'app_env' => config('app.env'),
            'database' => config('database.connections.'.config('database.default').'.database'),
            'operation_count' => count($this->operations),
            'operations' => $this->operations,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return $path;
    }
}
