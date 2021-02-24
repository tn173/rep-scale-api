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
            $table->string('device_identifier',36)->default('default')->comment('デバイス識別子');
            $table->string('access_token',36)->unique()->nullable();
            $table->dateTime('access_token_expires_at')->nullable();
            $table->string('refresh_token',36)->unique()->nullable();
            $table->dateTime('refresh_token_expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_mail_verifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tfa_token')->length(4)->nullable();
            $table->dateTime('tfa_expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_measurements', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->dateTime('date')->comment('測定日時')->default(date('2021-01-01'));
            $table->integer('impedance')->length(8)->default(0);
            $table->double('weight',4,1)->default(0);
            $table->double('BMI',3,1)->nullable();
            $table->double('body_fat_percentage',3,1)->nullable();
            $table->double('muscle_kg',4,1)->nullable();
            $table->double('water_percentage',3,1)->nullable();
            $table->integer('VFAL')->length(2)->nullable();
            $table->double('bone_kg',2,1)->nullable();
            $table->integer('BMR')->length(5)->nullable();
            $table->double('protein_percentage',3,1)->nullable();
            $table->double('VF_percentage',3,1)->nullable();
            $table->double('lose_fat_weight_kg',4,1)->nullable();
            $table->double('body_standard',4,1)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_steps', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->dateTime('date')->comment('日時');
            $table->integer('steps')->comment('歩数');
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
