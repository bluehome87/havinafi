<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->integer('type');
            $table->integer('max_speed');
            $table->boolean('passenger_delivery')->default(0);
            $table->boolean('package_delivery')->default(0);
            $table->string('from_city');
            $table->string('from_address');
            $table->time('from_time');
            $table->double('from_lon', 20, 16);
            $table->double('from_lat', 20, 16);
            $table->string('to_city');
            $table->string('to_address');
            $table->time('to_time');
            $table->double('to_lon', 20, 16);
            $table->double('to_lat', 20, 16);
            $table->integer('max_passengers')->nullable();
            $table->integer('invalid_seats')->nullable();
            $table->double('trunk_length', 8, 2);
            $table->double('trunk_width', 8, 2);
            $table->double('trunk_height', 8, 2);
            $table->double('trunk_volume', 10, 2);
            $table->integer('max_weight');
            $table->boolean('weather_protection')->default(0);
            $table->boolean('food_accepted')->default(0);
            $table->boolean('temp_control')->default(0);
            $table->integer('temp_min')->default(0);
            $table->integer('temp_max')->default(0);
            $table->boolean('crane')->default(0);
            $table->boolean('rear_lift')->default(0);
            $table->double('cost_eur_task', 8, 2);
            $table->double('cost_eur_km', 8, 2);
            $table->double('cost_eur_h', 8, 2);
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
        Schema::drop('vehicles');
    }
}
