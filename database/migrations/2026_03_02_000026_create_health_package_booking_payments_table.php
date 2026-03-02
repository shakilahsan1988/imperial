<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('health_package_booking_payments');

        Schema::create('health_package_booking_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('health_package_booking_id');
            $table->decimal('amount', 12, 2);
            $table->string('payment_type')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamps();

            $table->foreign('health_package_booking_id', 'hpbp_hpb_id_fk')
                ->references('id')
                ->on('health_package_bookings')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_package_booking_payments');
    }
};
