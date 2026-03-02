<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('membership_plan_bookings', function (Blueprint $table) {
            $table->decimal('total_amount', 12, 2)->default(0)->after('notes');
            $table->decimal('paid_amount', 12, 2)->default(0)->after('total_amount');
            $table->decimal('due_amount', 12, 2)->default(0)->after('paid_amount');
            $table->string('payment_status')->default('pending')->after('due_amount');
            $table->string('payment_type')->nullable()->after('payment_status');
            $table->timestamp('paid_at')->nullable()->after('payment_type');
            $table->text('payment_notes')->nullable()->after('paid_at');
        });

        DB::statement("
            UPDATE membership_plan_bookings mpb
            JOIN membership_plans mp ON mp.id = mpb.membership_plan_id
            SET mpb.total_amount = mp.price,
                mpb.paid_amount = 0,
                mpb.due_amount = mp.price,
                mpb.payment_status = 'pending'
        ");
    }

    public function down(): void
    {
        Schema::table('membership_plan_bookings', function (Blueprint $table) {
            $table->dropColumn([
                'total_amount',
                'paid_amount',
                'due_amount',
                'payment_status',
                'payment_type',
                'paid_at',
                'payment_notes',
            ]);
        });
    }
};
