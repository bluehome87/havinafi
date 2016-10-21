<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company_name', 64)->nullable()->after('remember_token');
            $table->string('address', 100)->nullable()->after('company_name');
            $table->string('phone', 32)->nullable()->after('address');
            $table->string('description', 1000)->nullable()->after('phone');
            $table->integer('is_professional')->length(1)->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['company_name', 'address', 'phone', 'description', 'is_professional']);
        });
    }
}
