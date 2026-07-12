<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $existing = DB::table('settings')->where('key', 'sslcommerz')->first();

        if (!$existing) {
            DB::table('settings')->insert([
                'key' => 'sslcommerz',
                'value' => json_encode([
                    'store_id' => '',
                    'store_password' => '',
                    'sandbox_mode' => true,
                    'enabled' => false,
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('settings')->where('key', 'sslcommerz')->delete();
    }
};
