<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sslcommerz_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_booking_id')->nullable()->constrained('doctor_consultation_bookings')->nullOnDelete();
            $table->string('transaction_id')->index();
            $table->string('bank_transaction_id')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('BDT');
            $table->enum('status', ['init', 'success', 'failed', 'cancelled', 'validated'])->default('init');
            $table->string('validation_id')->nullable();
            $table->json('ipn_response')->nullable();
            $table->string('card_type')->nullable();
            $table->string('card_no')->nullable();
            $table->string('bank_gateway')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sslcommerz_transactions');
    }
};
