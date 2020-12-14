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
            $table->increments('id')->comment('ユーザーID');
            $table->string('mail', 100)->unique()->comment('mail')->unique();;
            $table->string('password', 100)->comment('password');
            $table->timestamps();
            $table->string('api_token',60)->unique()->nullable();
        });

        Schema::create('mail_verifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mail', 100)->unique()->comment('mail')->unique();;
            $table->string('password', 100)->comment('password');
            $table->string('tfa_token')->nullable();
            $table->dateTime('tfa_expiration')->nullable();
            $table->timestamps();
        });

        Schema::create('user_infos', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->integer('user_id')->comment('ユーザーID');
            $table->enum('gender', ['MALE', 'FEMALE', 'OTHER'])->nullable()->comment('性別');
            $table->date('birthday')->nullable()->comment('生年月日');
            $table->double('height')->nullable()->comment('身長');
            $table->timestamps();
        });

        Schema::create('user_measurements', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->integer('user_id')->comment('ユーザーID');
            $table->dateTime('date')->comment('測定日時');
            $table->double('weight');
            $table->double('BMI')->nullable();
            $table->double('body_fat_rate')->nullable();
            $table->double('subcutaneous_fat')->nullable();
            $table->integer('visceral_fat')->nullable();
            $table->double('body_water_rate')->nullable();
            $table->double('muscle_rate')->nullable();
            $table->double('bone_mass')->nullable();
            $table->integer('BMR')->nullable();
            $table->integer('body_type')->nullable();
            $table->double('protein')->nullable();
            $table->double('lean_body_weight')->nullable();
            $table->double('muscle_mass')->nullable();
            $table->integer('metabolic_age')->nullable();
            $table->double('health_score')->nullable();
            $table->integer('heart_rate')->nullable();
            $table->double('heart_index')->nullable();
            $table->double('fat_mass')->nullable();
            $table->double('obesity_degree')->nullable();
            $table->double('water_content')->nullable();
            $table->double('protein_mass')->nullable();
            $table->integer('mineral_salt')->nullable();
            $table->double('best_visual_weight')->nullable();
            $table->double('stand_weight')->nullable();
            $table->double('weight_control')->nullable();
            $table->double('fat_control')->nullable();
            $table->double('muscle_control')->nullable();
            $table->double('muscle_mass_rate')->nullable();
            $table->timestamps();
        });

        Schema::create('user_healthcares', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->integer('user_id')->comment('ユーザーID');
            $table->dateTime('date')->comment('日時');
            $table->double('steps')->comment('歩数');
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
        Schema::dropIfExists('mail_verifications');
        Schema::dropIfExists('user_infos');
        Schema::dropIfExists('user_measurements');
        Schema::dropIfExists('user_healthcares');
    }
}
