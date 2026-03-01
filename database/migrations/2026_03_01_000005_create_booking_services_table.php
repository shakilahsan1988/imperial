<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('booking_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        // Migrate existing data from bookings.service_id to booking_services pivot table
        $bookings = DB::table('bookings')->get();
        foreach ($bookings as $booking) {
            if ($booking->service_id) {
                DB::table('booking_services')->insert([
                    'booking_id' => $booking->id,
                    'service_id' => $booking->service_id,
                    'price' => DB::table('services')->where('id', $booking->service_id)->value('price') ?? 0,
                    'created_at' => $booking->created_at,
                    'updated_at' => $booking->updated_at,
                ]);
            }
        }

        // Make service_id nullable in bookings table since we use pivot table now
        Schema::table('bookings', function (Blueprint $blueprint) {
            $blueprint->foreignId('service_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $blueprint) {
            $blueprint->foreignId('service_id')->nullable(false)->change();
        });
        Schema::dropIfExists('booking_services');
    }
};
