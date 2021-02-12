<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdConstraint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::table('user_measurements', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->comment('ユーザーID');
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
        });

        Schema::table('user_healthcares', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->comment('ユーザーID');
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('user_measurements', function (Blueprint $table) {
            $table->dropForeign('user_measurements_user_id_foreign');
        });

        Schema::table('user_healthcares', function (Blueprint $table) {
            $table->dropForeign('user_healthcares_user_id_foreign');
        });
    }
}
