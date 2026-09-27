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
            $table->enum('payment_method', ['cash', 'sslcommerz', 'pay_later'])->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        DB::table('doctor_consultation_bookings')->where('payment_method', 'pay_later')->update(['payment_method' => null]);

        Schema::table('doctor_consultation_bookings', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'sslcommerz'])->nullable()->default(null)->change();
        });
    }
};
