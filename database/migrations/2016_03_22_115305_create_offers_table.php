<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id_from')->length(11);
            $table->integer('user_id_to')->length(11);
            $table->integer('job_id')->length(11);
            $table->integer('vehicle_id')->length(11);
            $table->integer('task_id')->length(11);
            $table->integer('status')->length(1)->default(0);
            $table->integer('price')->nullable();
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
        Schema::drop('offers');
    }
}
