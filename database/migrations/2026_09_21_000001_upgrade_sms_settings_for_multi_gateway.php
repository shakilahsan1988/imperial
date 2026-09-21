<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $existing = DB::table('settings')->where('key', 'sms')->first();

        $defaults = [
            'active_gateway' => 'twilio',
            'gateways' => [
                'twilio' => ['sid' => '', 'token' => '', 'from' => ''],
                'bulksmsbd' => ['api_key' => '', 'sender_id' => ''],
            ],
            'patient_code' => [
                'active' => false,
                'message' => 'welcome {patient_name} , your patient code is {patient_code}',
            ],
            'tests_notification' => [
                'active' => false,
                'message' => 'welcome {patient_name} , your tests are ready now .. you can check tests by using your patient code : {patient_code}',
            ],
        ];

        if (! $existing) {
            DB::table('settings')->insert([
                'key' => 'sms',
                'value' => json_encode($defaults),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return;
        }

        $old = json_decode($existing->value, true) ?: [];

        if (! isset($old['gateways'])) {
            $migrated = [
                'active_gateway' => 'twilio',
                'gateways' => [
                    'twilio' => [
                        'sid' => $old['sid'] ?? '',
                        'token' => $old['token'] ?? '',
                        'from' => $old['from'] ?? '',
                    ],
                    'bulksmsbd' => ['api_key' => '', 'sender_id' => ''],
                ],
                'patient_code' => $old['patient_code'] ?? $defaults['patient_code'],
                'tests_notification' => $old['tests_notification'] ?? $defaults['tests_notification'],
            ];

            DB::table('settings')->where('key', 'sms')->update([
                'value' => json_encode($migrated),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Intentionally a no-op: reverting to the flat sid/token/from shape
        // would silently drop bulksmsbd credentials. Restore from a DB
        // backup instead if the old shape is genuinely needed.
    }
};
