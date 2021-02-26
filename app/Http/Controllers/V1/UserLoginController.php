<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use App\Mail\TwoFactorAuthPassword;

class UserLoginController extends Controller
{

    public function first_auth(Request $request) {  // １段階目の認証

        // そのメールアドレスが使用されていない場合エラー
        if(\App\Models\User::where('mail', '=', $request->mail)->exists()){

            $user = \App\Models\User::where('mail','=',$request->mail)->first();

            // パスワードチェック
            if(Hash::check($request->password, $user->password)){

                $random_password = '';

                for($i = 0 ; $i < 4 ; $i++) {
                    $random_password .= strval(rand(0, 9));
                }

                // すでにそのユーザーのメール認証がある場合は削除しておく
                if(\App\Models\UserMailVerification::where('user_id','=', $user->id)->exists()){
                    \App\Models\UserMailVerification::where('user_id','=', $user->id)->delete();
                }

                $mail_verification = new \App\Models\UserMailVerification;
                $mail_verification->user_id = $user->id;
                $mail_verification->tfa_token = $random_password;            
                $mail_verification->tfa_expires_at = now()->addMinutes(10);  
                $mail_verification->save();

                // メール送信
                \Mail::to($request->mail)->send(new TwoFactorAuthPassword($random_password));

                return [
                    'result' => true,
                ];

            }else{

                return [
                    'result' => false,
                ];

            }

        }else{

            return [
                'result' => false,
            ];

        }

    }

    public function second_auth(Request $request) {  // ２段階目の認証

        $result = false;

        if($request->filled('tfa_token', 'mail')) {

            $user = \App\Models\User::where('mail','=',$request->mail)->first();
            $mail_verification = \App\Models\UserMailVerification::where('user_id','=', $user->id)->first();
            $expiration = new Carbon($mail_verification->tfa_expires_at);

            if($mail_verification->tfa_token === $request->tfa_token && $expiration->gt(Carbon::now())) {

                // ログイン
                if(\App\Models\UserAuthentication::where('user_id', $user->id)->where('device_identifier', $request->device_identifier)->exists()){
                    // 再ログイン
                    $user_authentication = \App\Models\UserAuthentication::where('user_id', $user->id)->where('device_identifier', $request->device_identifier)->first(); 
                    $user_authentication->access_token = Str::uuid();
                    $user_authentication->access_token_expires_at = now()->addDays(config('const.ACCESS_TOKEN_EXPIRATION'));
                    $user_authentication->refresh_token = Str::uuid();
                    $user_authentication->refresh_token_expires_at = now()->addDays(config('const.REFRESH_TOKEN_EXPIRATION'));
                    $user_authentication->save();
                }else{
                    //別デバイスからのログイン
                    $user_authentication = new \App\Models\UserAuthentication;
                    $user_authentication->user_id = $user->id;
                    $user_authentication->device_identifier = $request->device_identifier;
                    $user_authentication->access_token = Str::uuid();
                    $user_authentication->access_token_expires_at = now()->addDays(config('const.ACCESS_TOKEN_EXPIRATION'));
                    $user_authentication->refresh_token = Str::uuid();
                    $user_authentication->refresh_token_expires_at = now()->addDays(config('const.REFRESH_TOKEN_EXPIRATION'));
                    $user_authentication->save();
                }

                $result = true;
                $mail_verification->delete();

                return [
                    'result' => $result,
                    'user_id' => $user->id,
                    "access_token" => $user_authentication->access_token,
                    "refresh_token" => $user_authentication->refresh_token,
                    'gender' => $user->gender,
                    'birthday' => $user->birthday,
                    'height' => $user->height,
                ];

            }

        }

        return [
            'result' => $result,
        ];

    }
}
