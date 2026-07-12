<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctor_consultation_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('doctor_consultation_bookings', 'payment_method')) {
                $table->enum('payment_method', ['cash', 'sslcommerz'])->default('cash')->after('status');
            }
            if (!Schema::hasColumn('doctor_consultation_bookings', 'payment_status')) {
                $table->enum('payment_status', ['unpaid', 'paid', 'failed', 'cancelled'])->default('unpaid')->after('payment_method');
            }
            if (!Schema::hasColumn('doctor_consultation_bookings', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('doctor_consultation_bookings', 'bank_transaction_id')) {
                $table->string('bank_transaction_id')->nullable()->after('transaction_id');
            }
            if (!Schema::hasColumn('doctor_consultation_bookings', 'currency')) {
                $table->string('currency', 10)->default('BDT')->after('bank_transaction_id');
            }
            if (!Schema::hasColumn('doctor_consultation_bookings', 'validation_id')) {
                $table->string('validation_id')->nullable()->after('currency');
            }
            if (!Schema::hasColumn('doctor_consultation_bookings', 'paid_amount')) {
                $table->decimal('paid_amount', 12, 2)->default(0)->after('validation_id');
            }
            if (!Schema::hasColumn('doctor_consultation_bookings', 'payment_date')) {
                $table->timestamp('payment_date')->nullable()->after('paid_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('doctor_consultation_bookings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'payment_status',
                'transaction_id',
                'bank_transaction_id',
                'currency',
                'validation_id',
                'paid_amount',
                'payment_date',
            ]);
        });
    }
};
