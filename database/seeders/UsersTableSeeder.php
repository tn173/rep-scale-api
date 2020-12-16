<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserMeasurement;
use App\Models\UserHealthcare;
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
        DB::table('user_infos')->truncate();
        DB::table('user_measurements')->truncate();
        DB::table('user_healthcares')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 仮データ
        for ($num = 1; $num < 11; $num++){
            $gender = ['MALE', 'FEMALE', 'OTHER'];
            $birthday = mt_rand(0,1262055681);
            $height = mt_rand(150,190);

            if($num == 1){
                // てすとよう
                User::create([
                    'mail' => 'tomoaki.nishioka@upswell.jp',
                    'password' => Hash::make('upsw2020'),
                ]);
            }else{
                User::create([
                    'mail' => Str::random(10).'@gmail.com',
                    'password' => Hash::make(Str::random(10)),
                ]);
            }

            UserInfo::create([
                'user_id' => $num,
                'gender' => Arr::random($gender),
                'birthday' => date("Y/m/d",$birthday),
                'height' => $height,
            ]);

            for ($i = 1; $i < 31; $i++){
                $date = mt_rand(Carbon::now()->subMonths(1)->timestamp,Carbon::now()->timestamp);
                $weight = mt_rand(40,90);
                $steps = mt_rand(2000,5000);
                UserMeasurement::create([
                    'user_id' => $num,
                    'date' => date("Y/m/d H:i:s",$date),
                    'weight' => $weight,
                ]);
                UserHealthcare::create([
                    'user_id' => $num,
                    'date' => date("Y/m/d",$date),
                    'steps' => $steps,
                ]);
            }

        }
    }
}
