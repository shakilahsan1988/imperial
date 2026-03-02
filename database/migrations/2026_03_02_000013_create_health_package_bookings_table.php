<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_package_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('health_package_id')->constrained('health_packages')->cascadeOnDelete();
            $table->string('patient_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->date('preferred_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_package_bookings');
    }
};
