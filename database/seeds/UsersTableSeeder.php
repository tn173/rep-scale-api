<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserAuthentication;
use App\Models\UserMeasurement;
use App\Models\UserStep;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 一旦全てクリア
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('user_authentications')->truncate();
        DB::table('user_mail_verifications')->truncate();
        DB::table('user_measurements')->truncate();
        DB::table('user_steps')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::create([
            'gender' => 'MALE',
            'birthday' => date("2000/02/01"),
            'height' => 175,
            'mail' => 'tomoaki.nishioka@upswell.jp',
            'password' => Hash::make('upsw2020'),
        ]);

        User::create([
            'gender' => 'MALE',
            'birthday' => date("1990/01/01"),
            'height' => 175,
            'mail' => '',
            'password' => '',
        ]);

        UserAuthentication::create([
            'user_id' => 1,
            'device_identifier' => 'abc',
            'access_token' => '3be06fae-9ba0-4d6d-bd4a-39084a97212c',
            'access_token_expires_at' => now()->addDays(config('const.ACCESS_TOKEN_EXPIRATION')),
            'refresh_token' => 'f8940923-4435-44f7-808f-fe9c46f6cd84',
            'refresh_token_expires_at' => now()->addDays(config('const.ACCESS_TOKEN_EXPIRATION')),
        ]);

        UserAuthentication::create([
            'user_id' => 2,
            'device_identifier' => 'def',
            'access_token' => 'b396d6d7-a7e4-4068-84ad-4f6900e0ca61',
            'access_token_expires_at' => now()->addDays(config('const.ACCESS_TOKEN_EXPIRATION')),
            'refresh_token' => 'd36267df-5c9f-484b-ae0d-46d8d2f84325',
            'refresh_token_expires_at' => now()->addDays(config('const.ACCESS_TOKEN_EXPIRATION')),
        ]);

        for ($i = 1; $i < 31; $i++){
            $date = mt_rand(Carbon::now()->subMonths(1)->timestamp,Carbon::now()->timestamp);
            $weight = mt_rand(60,70);
            $steps = mt_rand(2000,5000);
            UserMeasurement::create([
                'user_id' => 1,
                'date' => date("Y/m/d H:i:s",$date),
                'weight' => $weight,
            ]);
            UserStep::create([
                'user_id' => 1,
                'date' => date("Y/m/d",$date),
                'steps' => $steps,
            ]);
        }
    
    }
}
