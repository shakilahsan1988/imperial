<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('group_tests', function (Blueprint $table) {
            $table->string('result')->nullable()->after('price');
            $table->string('status')->nullable()->after('result');
        });
    }

    public function down()
    {
        Schema::table('group_tests', function (Blueprint $table) {
            $table->dropColumn(['result', 'status']);
        });
    }
};
