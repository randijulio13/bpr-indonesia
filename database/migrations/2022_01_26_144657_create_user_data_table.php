<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('nik');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('pob');
            $table->date('dob');
            $table->boolean('gender');
            $table->string('mobile');
            $table->longText('address');
            $table->string('zip_code');
            $table->integer('state_id')->references('state_id')->on('states');
            $table->integer('district_id')->references('district_id')->on('districts');
            $table->integer('sub_district_id')->references('sub_district_id')->on('sub_districts');
            $table->text('ktp_photo');
            $table->text('selfie_photo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_data');
    }
}
