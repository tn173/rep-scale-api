<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserMeasurement;
use Illuminate\Support\Arr;

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
        DB::table('users')->truncate();
        DB::table('user_infos')->truncate();
        DB::table('user_measurements')->truncate();

        // 仮データ
        for ($num = 1; $num < 11; $num++){
            $gender = ['MALE', 'FEMALE', 'OTHER'];
            $birthday = mt_rand(0,1262055681);
            $height = mt_rand(150,190);

            User::create([
                'name' => Str::random(10),
                'mail' => Str::random(10).'@gmail.com',
                'password' => Str::random(10),
            ]);

            UserInfo::create([
                'user_id' => $num,
                'gender' => Arr::random($gender),
                'birthday' => date("Y/m/d",$birthday),
                'height' => $height,
            ]);

            for ($i = 1; $i < 31; $i++){
                $date = mt_rand(1596752413,1607293213);
                $weight = mt_rand(40,90);
                UserMeasurement::create([
                    'user_id' => $num,
                    'date' => date("Y/m/d",$date),
                    'weight' => $weight,
                ]);
            }

          }
    }
}
