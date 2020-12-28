<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\TwoFactorAuthPassword;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserLoginController extends Controller
{

    public function first_auth(Request $request) {  // １段階目の認証

        $credentials = $request->only('mail', 'password');

        if(\Auth::validate($credentials)) {

            $random_password = '';

            for($i = 0 ; $i < 4 ; $i++) {

                $random_password .= strval(rand(0, 9));

            }

            $user = \App\Models\User::where('mail', $request->mail)->first();
            $user->tfa_token = $random_password;            // 4桁のランダムな数字
            $user->tfa_expiration = now()->addMinutes(10);  // 10分間だけ有効
            $user->save();

            // メール送信
            \Mail::to($user->mail)->send(new TwoFactorAuthPassword($random_password));

            return [
                'result' => true,
                'mail' => $user->mail
            ];

        }

        return ['result' => false];

    }

    public function second_auth(Request $request) {  // ２段階目の認証

        $result = false;

        if($request->filled('tfa_token', 'mail')) {

            $user = \App\Models\User::where('mail','=',$request->mail)->first();
            $expiration = new Carbon($user->tfa_expiration);

            if($user->tfa_token === $request->tfa_token && $expiration > now()) {
                
                $user->tfa_token = null;
                $user->tfa_expiration = null;
                $user->api_token = Str::uuid();
                $user->save();

                $result = true;

            }

        }

        return [
            'result' => $result,
            'api_token' => $user->api_token, 
            'user_id' => $user->id
        ];

    }
}
