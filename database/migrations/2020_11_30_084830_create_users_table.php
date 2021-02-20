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
            $table->enum('gender', ['MALE', 'FEMALE', 'OTHER'])->nullable()->comment('性別')->default('OTHER');
            $table->date('birthday')->nullable()->comment('生年月日')->default(date('1990-01-01'));
            $table->double('height',4,1)->nullable()->comment('身長')->default(160);
            $table->string('mail')->nullable()->comment('mail'); // メールアドレスのバリデーションはデータ登録時に行う
            $table->string('password')->nullable()->comment('password'); // BCryptでHash化した60桁の文字列
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement('ALTER TABLE users MODIFY mail varchar(50) BINARY');
        DB::statement('ALTER TABLE users MODIFY password char(60) BINARY');

        Schema::create('user_authentications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('device_identifier')->comment('デバイス識別子')->nullable();
            $table->string('access_token',36)->unique()->nullable();
            $table->dateTime('access_token_expires_at')->nullable();
            $table->string('refresh_token',36)->unique()->nullable();
            $table->dateTime('refresh_token_expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_mail_verifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tfa_token')->nullable();
            $table->dateTime('tfa_expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_measurements', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->dateTime('date')->comment('測定日時')->default(date('2021-01-01'));
            $table->double('weight')->default(0);
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
            $table->softDeletes();
        });

        Schema::create('user_steps', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->dateTime('date')->comment('日時');
            $table->double('steps')->comment('歩数');
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('user_authentications');
        Schema::dropIfExists('user_mail_verifications');
        Schema::dropIfExists('user_measurements');
        Schema::dropIfExists('user_steps');
    }
}
