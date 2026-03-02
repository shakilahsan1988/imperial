<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_category_id')->constrained('membership_categories')->cascadeOnDelete();
            $table->string('page_name')->default('Membership Details');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->string('badge_text')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('old_price', 12, 2)->nullable();
            $table->string('discount_text')->nullable();
            $table->string('duration')->nullable();
            $table->string('doctor_visits')->nullable();
            $table->string('service_discount')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->text('key_features')->nullable();
            $table->text('inclusions')->nullable();
            $table->text('exclusions')->nullable();
            $table->text('important_notes')->nullable();
            $table->string('faq_1_question')->nullable();
            $table->text('faq_1_answer')->nullable();
            $table->string('faq_2_question')->nullable();
            $table->text('faq_2_answer')->nullable();
            $table->string('faq_3_question')->nullable();
            $table->text('faq_3_answer')->nullable();
            $table->boolean('show_on_frontend')->default(true);
            $table->boolean('status')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_plans');
    }
};
