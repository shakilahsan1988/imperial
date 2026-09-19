<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('health_package_bookings', function (Blueprint $table) {
            $table->unsignedSmallInteger('age')->nullable()->after('dob');
        });

        Schema::table('membership_plan_bookings', function (Blueprint $table) {
            $table->unsignedSmallInteger('age')->nullable()->after('dob');
            $table->string('email')->nullable()->change();
        });

        Schema::table('doctor_consultation_bookings', function (Blueprint $table) {
            $table->unsignedSmallInteger('age')->nullable()->after('dob');
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('membership_plan_bookings', function (Blueprint $table) {
            $table->dropColumn('age');
            $table->string('email')->nullable(false)->change();
        });

        Schema::table('doctor_consultation_bookings', function (Blueprint $table) {
            $table->dropColumn('age');
            $table->string('email')->nullable(false)->change();
        });

        Schema::table('health_package_bookings', function (Blueprint $table) {
            $table->dropColumn('age');
        });
    }
};
