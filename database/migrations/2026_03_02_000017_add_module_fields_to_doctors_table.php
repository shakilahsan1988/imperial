<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->foreignId('doctor_specialty_id')->nullable()->after('code')->constrained('doctor_specialties')->nullOnDelete();
            $table->foreignId('doctor_department_id')->nullable()->after('doctor_specialty_id')->constrained('doctor_departments')->nullOnDelete();
            $table->string('slug')->nullable()->after('name')->unique();
            $table->string('designation')->nullable()->after('address');
            $table->string('qualification')->nullable()->after('designation');
            $table->unsignedInteger('experience_years')->nullable()->after('qualification');
            $table->text('bio')->nullable()->after('experience_years');
            $table->string('image')->nullable()->after('bio');
            $table->decimal('consultation_fee', 12, 2)->default(0)->after('commission');
            $table->boolean('video_consultation_available')->default(false)->after('consultation_fee');
            $table->boolean('status')->default(true)->after('video_consultation_available');
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropConstrainedForeignId('doctor_specialty_id');
            $table->dropConstrainedForeignId('doctor_department_id');
            $table->dropColumn([
                'slug',
                'designation',
                'qualification',
                'experience_years',
                'bio',
                'image',
                'consultation_fee',
                'video_consultation_available',
                'status',
            ]);
        });
    }
};
