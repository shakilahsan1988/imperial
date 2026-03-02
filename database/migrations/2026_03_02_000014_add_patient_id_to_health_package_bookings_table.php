<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('health_package_bookings', function (Blueprint $table) {
            $table->foreignId('patient_id')->nullable()->after('health_package_id')->constrained('patients')->nullOnDelete();
            $table->string('dob')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('health_package_bookings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('patient_id');
            $table->dropColumn('dob');
        });
    }
};
