<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctor_consultation_bookings', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'sslcommerz'])->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('doctor_consultation_bookings', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'sslcommerz'])->default('cash')->change();
        });
    }
};
