<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            if (! Schema::hasColumn('branches', 'title')) {
                $table->string('title')->nullable()->after('name');
            }
            if (! Schema::hasColumn('branches', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
            if (! Schema::hasColumn('branches', 'contact_information')) {
                $table->text('contact_information')->nullable()->after('address');
            }
            if (! Schema::hasColumn('branches', 'feature_image')) {
                $table->string('feature_image')->nullable()->after('contact_information');
            }
            if (! Schema::hasColumn('branches', 'google_map_location')) {
                $table->text('google_map_location')->nullable()->after('feature_image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $columns = [
                'title',
                'description',
                'contact_information',
                'feature_image',
                'google_map_location',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('branches', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
