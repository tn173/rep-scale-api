<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Controllers\Controller;
use App\Mail\TwoFactorAuthPassword;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserForgotPasswordController extends Controller
{

    public function first_auth(Request $request) {  // １段階目の認証

        if(!\App\Models\User::where('mail', $request->mail)->get()->isEmpty()) {

            $random_password = '';

            for($i = 0 ; $i < 4 ; $i++) {

                $random_password .= strval(rand(0, 9));

            }

            $user = \App\Models\User::where('mail', $request->mail)->first();
            $user->pw_tfa_token = $random_password;            // 4桁のランダムな数字
            $user->pw_tfa_expiration = now()->addMinutes(10);  // 10分間だけ有効
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

        if($request->filled('pw_tfa_token', 'mail')) {

            $user = \App\Models\User::where('mail','=',$request->mail)->first();
            $expiration = new Carbon($user->pw_tfa_expiration);

            if($user->pw_tfa_token === $request->pw_tfa_token && $expiration > now()) {
                
                $user->pw_tfa_token = null;
                $user->pw_tfa_expiration = null;
                $user->save();

                $result = true;

            }

        }

        return [
            'result' => $result,
        ];

    }

    public function update(ForgotPasswordRequest $request) {  // パスワードのリセット
        $user = \App\Models\User::where('mail','=',$request->mail)->first();
        $user->password = $request->password;
        $user->save();

        return [
            'result' => true
        ];
    }
}
