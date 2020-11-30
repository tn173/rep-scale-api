<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id')->comment('ユーザーID');
            $table->string('name', 100)->comment('名前');
            $table->string('mail', 100)->unique()->comment('mail');
            $table->string('password', 100)->comment('password');
            $table->timestamps();
        });

        Schema::create('user_infos', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->integer('user_id')->comment('ユーザーID');
            $table->enum('gender', ['MALE', 'FEMALE', 'OTHER'])->nullable()->comment('性別');
            $table->dateTime('birthday')->nullable()->comment('生年月日');
            $table->double('height')->nullable()->comment('身長');
            $table->timestamps();
        });

        Schema::create('user_measurements', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->integer('user_id')->comment('ユーザーID');
            $table->dateTime('date')->comment('測定日時');
            $table->double('weight');
            $table->double('BMI');
            $table->double('body_fat_rate');
            $table->double('subcutaneous_fat');
            $table->integer('visceral_fat');
            $table->double('body_water_rate');
            $table->double('muscle_rate');
            $table->double('bone_mass');
            $table->integer('BMR');
            $table->integer('body_type');
            $table->double('protein');
            $table->double('lean_body_weight');
            $table->double('muscle_mass');
            $table->integer('metabolic_age');
            $table->double('health_score');
            $table->integer('heart_rate');
            $table->double('heart_index');
            $table->double('fat_mass');
            $table->double('obesity_degree');
            $table->double('water_content');
            $table->double('protein_mass');
            $table->integer('mineral_salt');
            $table->double('best_visual_weight');
            $table->double('stand_weight');
            $table->double('weight_control');
            $table->double('fat_control');
            $table->double('muscle_control');
            $table->double('muscle_mass_rate');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_infos');
        Schema::dropIfExists('user_measurements');
    }
}
