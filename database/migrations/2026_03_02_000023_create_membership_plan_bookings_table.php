<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_plan_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_plan_id')->constrained('membership_plans')->cascadeOnDelete();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
            $table->string('patient_name');
            $table->string('phone');
            $table->string('email');
            $table->date('dob')->nullable();
            $table->date('preferred_start_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_plan_bookings');
    }
};
