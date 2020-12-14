<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Requests\MailVerificationRequest;
use App\Http\Controllers\Controller;
use App\Mail\TwoFactorAuthPassword;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserRegisterController extends Controller
{

    public function first_auth(MailVerificationRequest $request) {  // １段階目の認証
        // ユーザーがいない場合のみ作成
        if(\App\Models\User::where('mail', $request->mail)->get()->isEmpty()){
            $random_password = '';

            for($i = 0 ; $i < 4 ; $i++) {

                $random_password .= strval(rand(0, 9));

            }

            // すでにある場合はアップデート
            if(\App\Models\MailVerification::where('mail','=',$request->mail)->exists()){
                $new_user = \App\Models\MailVerification::where('mail','=',$request->mail)->first();
                $new_user->tfa_token = $random_password;            
                $new_user->tfa_expiration = now()->addMinutes(10);  
                $new_user->save();
            }else{
                $new_user = new \App\Models\MailVerification;
                $new_user->mail = $request->mail;
                $new_user->password = Hash::make($request->password);
                $new_user->tfa_token = $random_password;            
                $new_user->tfa_expiration = now()->addMinutes(10);  
                $new_user->save();
            }

            // メール送信
            \Mail::to($new_user->mail)->send(new TwoFactorAuthPassword($random_password));

            return [
                'result' => true,
                'mail' => $new_user->mail
            ];
        }

        return ['result' => false];

    }

    public function second_auth(Request $request) {  // ２段階目の認証

        $result = false;

        if($request->filled('tfa_token', 'mail')) {

            $new_user = \App\Models\MailVerification::where('mail','=',$request->mail)->first();
            $expiration = new Carbon($new_user->tfa_expiration);

            if($new_user->tfa_token === $request->tfa_token && $expiration > now()) {

                $user = new \App\Models\User;
                $user->mail = $new_user->mail;
                $user->password = $new_user->password;
                $user->tfa_token = null;
                $user->tfa_expiration = null;
                $user->api_token = Str::random(60);
                $user->save();

                $result = true;

            }

        }

        return $result ? ['result' => $result,'api_token' => $user->api_token] : ['result' => $result];

    }
}
