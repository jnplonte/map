<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GeocodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('geocode', function (Blueprint $table) {
             $table->increments('id');
             $table->string('lat')->nullable();
             $table->string('lng')->nullable();
             $table->string('address')->nullable();
             $table->string('placeid')->nullable();
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
         Schema::drop('geocode');
     }
}
