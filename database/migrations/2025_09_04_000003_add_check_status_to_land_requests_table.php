<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('land_requests', function (Blueprint $table) {
            $table->string('check_status')->nullable()->after('last_participation_date');
            $table->index('check_status');
        });
    }

    public function down(): void
    {
        Schema::table('land_requests', function (Blueprint $table) {
            $table->dropIndex(['check_status']);
            $table->dropColumn('check_status');
        });
    }
};
