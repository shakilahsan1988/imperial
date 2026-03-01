<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add fields to services table
        Schema::table('services', function (Blueprint $table) {
            $table->string('unit')->nullable()->after('description');
            $table->text('reference_range')->nullable()->after('unit');
        });

        // Add service_id to group_tests to link directly to services
        Schema::table('group_tests', function (Blueprint $table) {
            $table->foreignId('service_id')->nullable()->after('test_id')->constrained('services')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('group_tests', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['unit', 'reference_range']);
        });
    }
};
