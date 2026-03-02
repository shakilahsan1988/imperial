<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_consultation_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
            $table->foreignId('doctor_consultation_slot_id')->constrained('doctor_consultation_slots')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('patient_name');
            $table->string('phone');
            $table->string('email');
            $table->string('dob')->nullable();
            $table->enum('visit_type', ['in_hub', 'video']);
            $table->date('appointment_date');
            $table->text('notes')->nullable();
            $table->decimal('consultation_fee', 12, 2)->default(0);
            $table->decimal('commission_percentage', 8, 2)->default(0);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_consultation_bookings');
    }
};
