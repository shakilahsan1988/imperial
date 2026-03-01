<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->enum('category', ['laboratory', 'imaging', 'procedure']);
            $table->string('sub_category')->nullable();
            $table->text('description')->nullable();
            $table->text('preparation')->nullable();
            $table->string('specimen_type')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('home_visit_price', 10, 2)->nullable();
            $table->boolean('home_visit_available')->default(false);
            $table->integer('duration_minutes')->default(30);
            $table->string('image')->nullable();
            $table->boolean('show_on_frontend')->default(true);
            $table->boolean('status')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
};
