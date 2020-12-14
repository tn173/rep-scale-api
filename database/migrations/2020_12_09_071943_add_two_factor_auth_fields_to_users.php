<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTwoFactorAuthFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('tfa_token')
                ->nullable()
                ->after('password');
            $table->dateTime('tfa_expiration')
                ->nullable()
                ->after('tfa_token');
            $table->string('pw_tfa_token')
                ->nullable()
                ->after('tfa_expiration');
            $table->dateTime('pw_tfa_expiration')
                ->nullable()
                ->after('pw_tfa_token');
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
            $table->dropColumn('tfa_token');
            $table->dropColumn('tfa_expiration');
            $table->dropColumn('pw_tfa_token');
            $table->dropColumn('pw_tfa_expiration');
        });
    }
}