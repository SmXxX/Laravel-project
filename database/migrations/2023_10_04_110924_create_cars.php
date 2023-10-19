<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->string('image')->nullable();
            $table->string('plate');
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->string('color')->nullable();
            $table->string('engine');
            $table->integer('hp');
            $table->integer('kw');
            $table->string('fuel');
            $table->string('vin_num');
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
        Schema::dropIfExists('cars');
    }
}
