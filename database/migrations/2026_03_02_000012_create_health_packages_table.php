<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('health_package_category_id')->constrained('health_package_categories')->cascadeOnDelete();
            $table->string('page_name')->default('Package Details');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->string('badge_text')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('old_price', 12, 2)->nullable();
            $table->string('discount_text')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('duration')->nullable();
            $table->string('turnaround')->nullable();
            $table->string('fasting')->nullable();
            $table->longText('inclusions')->nullable();
            $table->longText('preparation_steps')->nullable();
            $table->string('faq_1_question')->nullable();
            $table->text('faq_1_answer')->nullable();
            $table->string('faq_2_question')->nullable();
            $table->text('faq_2_answer')->nullable();
            $table->boolean('recommended')->default(false);
            $table->boolean('immediate_availability')->default(true);
            $table->boolean('show_on_frontend')->default(true);
            $table->boolean('status')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_packages');
    }
};
