<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Table to define the SETUP of components for a service
        Schema::create('service_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->string('name');
            $table->string('unit')->nullable();
            $table->text('reference_range')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 2. Table to store the PATIENT'S ACTUAL RESULTS for each component
        Schema::create('group_test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_test_id')->constrained('group_tests')->onDelete('cascade');
            $table->foreignId('service_component_id')->constrained('service_components')->onDelete('cascade');
            $table->string('result')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('group_test_results');
        Schema::dropIfExists('service_components');
    }
};
