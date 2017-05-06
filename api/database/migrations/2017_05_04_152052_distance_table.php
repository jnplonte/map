<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DistanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('distance', function (Blueprint $table) {
             $table->increments('id');
             $table->string('token')->default('some-random-token');
             $table->integer('start_id')->default(1);
             $table->string('end_ids')->default('[]');
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
         Schema::drop('distance');
     }
}
