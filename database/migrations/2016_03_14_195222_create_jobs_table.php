<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->length(11);
            $table->string('name');
            $table->date('job_date');
            $table->boolean('is_own_vehicles');
            $table->boolean('is_own_tasks');
            $table->boolean('is_other_tasks');
            $table->text('raw_request')->nullable();
            $table->string('job_id')->nullable();
            $table->text('raw_solution')->nullable();
            $table->string('status');
            $table->integer('completion_time')->nullable();
            $table->integer('costs')->nullable();
            $table->integer('distance')->nullable();
            $table->integer('no_unassigned')->nullable();
            $table->integer('no_vehicles')->nullable();
            $table->integer('transport_time')->nullable();
            $table->integer('waiting_time')->nullable();
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
        Schema::drop('jobs');
    }
}
