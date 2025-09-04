<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('abbreviation')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });


        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `languages` comment 'اللغات خاصة بالاضافة كاعداد'");
       \Illuminate\Support\Facades\DB::statement("INSERT INTO `languages` (`id`, `title`, `abbreviation`,`status`, `created_at`, `updated_at`) VALUES
          (1, 'arabic','ar', '1', '2022-03-27 13:57:36', '2022-03-27 13:57:36'),
          (2, 'english','en', '0', '2022-03-27 13:57:36', '2022-03-27 13:57:36');
         ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
