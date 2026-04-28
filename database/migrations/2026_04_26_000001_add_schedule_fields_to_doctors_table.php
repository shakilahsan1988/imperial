<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->string('schedule_branch')->nullable()->after('image');
            $table->string('schedule_consultant')->nullable()->after('schedule_branch');
            $table->string('schedule_days')->nullable()->after('schedule_consultant');
            $table->string('schedule_time')->nullable()->after('schedule_days');
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn([
                'schedule_branch',
                'schedule_consultant',
                'schedule_days',
                'schedule_time',
            ]);
        });
    }
};
