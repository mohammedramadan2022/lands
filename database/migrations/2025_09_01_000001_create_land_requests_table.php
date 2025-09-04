<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('land_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('applicant_name');
            $table->string('national_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_alt')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Ensure duplicates are prevented at DB level when both fields are present
            $table->unique(['applicant_name', 'national_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('land_requests');
    }
};
