<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->after('patient_id')->constrained('branches')->nullOnDelete();
            $table->decimal('discount', 10, 2)->default(0)->after('paid_amount');
            $table->decimal('due_amount', 10, 2)->default(0)->after('discount');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn(['branch_id', 'discount', 'due_amount']);
        });
    }
};
