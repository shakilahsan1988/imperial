<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('membership_plan_booking_payments');

        Schema::create('membership_plan_booking_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('membership_plan_booking_id');
            $table->decimal('amount', 12, 2);
            $table->string('payment_type')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamps();

            $table->foreign('membership_plan_booking_id', 'mpbp_mpb_id_fk')
                ->references('id')
                ->on('membership_plan_bookings')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_plan_booking_payments');
    }
};
