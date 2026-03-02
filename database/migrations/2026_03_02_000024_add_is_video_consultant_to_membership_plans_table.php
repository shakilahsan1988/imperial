<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('membership_plans', function (Blueprint $table) {
            $table->boolean('is_video_consultant')->default(false)->after('show_on_frontend');
        });
    }

    public function down(): void
    {
        Schema::table('membership_plans', function (Blueprint $table) {
            $table->dropColumn('is_video_consultant');
        });
    }
};
