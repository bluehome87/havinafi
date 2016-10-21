<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->boolean('passenger_delivery')->default(0);
            $table->boolean('package_delivery')->default(0);
            $table->boolean('one_stop_task')->default(0);
            $table->string('from_city');
            $table->string('from_address');
            $table->time('from_time_start')->nullable();
            $table->time('from_time_end')->nullable();
            $table->double('from_lon', 20, 16);
            $table->double('from_lat', 20, 16);
            $table->string('to_city');
            $table->string('to_address');
            $table->time('to_time_start')->nullable();
            $table->time('to_time_end')->nullable();
            $table->double('to_lon', 20, 16);
            $table->double('to_lat', 20, 16);
            $table->integer('loading_time');
            $table->integer('passengers')->default(0);
            $table->integer('invalids')->default(0);
            $table->integer('total_packages')->default(0);
            $table->double('total_volume', 10, 2)->default(0);
            $table->integer('weight')->default(0);
            $table->boolean('fragile')->default(0);
            $table->boolean('weather_protection')->default(0);
            $table->boolean('food')->default(0);
            $table->boolean('temp_control')->default(0);
            $table->integer('temp_min')->default(0);
            $table->integer('temp_max')->default(0);
            $table->boolean('crane')->default(0);
            $table->boolean('rear_lift')->default(0);
            $table->string('notes', 1000)->nullable();
            $table->boolean('is_deleted')->default(0);
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
        Schema::drop('tasks');
    }
}
