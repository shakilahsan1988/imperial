<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->decimal('video_consultation_fee', 12, 2)->nullable()->after('consultation_fee');
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('video_consultation_fee');
        });
    }
};
