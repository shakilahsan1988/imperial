<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctor_consultation_bookings', function (Blueprint $table) {
            $table->string('appointment_time', 100)->nullable()->after('appointment_date');
            $table->unsignedBigInteger('doctor_consultation_slot_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('doctor_consultation_bookings', function (Blueprint $table) {
            $table->dropColumn('appointment_time');
        });

        if (! DB::table('doctor_consultation_bookings')->whereNull('doctor_consultation_slot_id')->exists()) {
            Schema::table('doctor_consultation_bookings', function (Blueprint $table) {
                $table->unsignedBigInteger('doctor_consultation_slot_id')->nullable(false)->change();
            });
        }
    }
};
