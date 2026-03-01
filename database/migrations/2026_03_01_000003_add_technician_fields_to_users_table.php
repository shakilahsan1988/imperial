<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_technician')->default(false)->after('password');
            $table->string('technician_specialty')->nullable()->after('is_technician');
            $table->string('phone')->nullable()->after('technician_specialty');
            $table->string('address')->nullable()->after('phone');
            $table->string('image')->nullable()->after('address');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_technician', 'technician_specialty', 'phone', 'address', 'image']);
        });
    }
};
