<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('land_requests', function (Blueprint $table) {
            $table->string('nationality')->nullable()->after('national_id'); // الجنسية
            $table->date('birth_date')->nullable()->after('nationality'); // تاريخ الميلاد
            $table->unsignedInteger('race_participation_count')->default(0)->after('phone_alt'); // عدد مرات المشاركة بالسباقات
            $table->unsignedInteger('camels_count')->default(0)->after('race_participation_count'); // عدد المطايا
            $table->string('subscriber_number')->nullable()->after('camels_count'); // رقم المشترك
            $table->string('subscriber_status')->nullable()->after('subscriber_number'); // حالة المشترك
            $table->date('last_participation_date')->nullable()->after('subscriber_status'); // تاريخ اخر مشاركه

            $table->index('subscriber_number');
            $table->index('subscriber_status');
        });
    }

    public function down(): void
    {
        Schema::table('land_requests', function (Blueprint $table) {
            $table->dropIndex(['subscriber_number']);
            $table->dropIndex(['subscriber_status']);

            $table->dropColumn([
                'nationality',
                'birth_date',
                'race_participation_count',
                'camels_count',
                'subscriber_number',
                'subscriber_status',
                'last_participation_date',
            ]);
        });
    }
};
