<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('land_requests', function (Blueprint $table) {
            // Status column representing previous land status (0 or 1)
            $table->unsignedTinyInteger('previous_land_status')->default(0)->after('last_participation_date');
            // Long text notes for previous lane notes (as requested)
            $table->longText('previous_lane_notes')->nullable()->after('previous_land_status');
            $table->index('previous_land_status');
        });
    }

    public function down(): void
    {
        Schema::table('land_requests', function (Blueprint $table) {
            $table->dropIndex(['previous_land_status']);
            $table->dropColumn(['previous_land_status', 'previous_lane_notes']);
        });
    }
};
