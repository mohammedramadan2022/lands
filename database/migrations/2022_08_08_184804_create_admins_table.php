<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('password')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('admins');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        $sql=[
            ['id'=>1,'name'=>'Mohamed Ramadan','email'=>'admin@admin.com','password'=>bcrypt(123456),'phone'=>'01010871488','created_at'=>'2022-03-27 13:57:36','updated_at'=>'2022-03-27 13:57:36']
        ];
        \Illuminate\Support\Facades\DB::table('admins')->insert($sql);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
