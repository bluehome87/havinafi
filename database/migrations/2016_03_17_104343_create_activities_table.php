<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('route_id')->length(11);
            $table->integer('task_id')->length(11)->nullable();
            $table->string('type')->nullable();
            $table->integer('arr_time')->nullable();
            $table->integer('distance')->nullable();
            $table->integer('end_time')->nullable();
            $table->string('location_id')->nullable();
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
        Schema::drop('activities');
    }
}
