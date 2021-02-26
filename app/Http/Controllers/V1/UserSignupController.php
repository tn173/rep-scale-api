<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use App\Http\Requests\MailVerificationRequest;
use App\Mail\TwoFactorAuthPassword;

class UserSignupController extends Controller
{

    public function first_auth(MailVerificationRequest $request) {  // １段階目の認証

        $validated = $request->validated();
        $credentials = $request->only('mail', 'password');

        // そのメールアドレスが使用されている場合エラー
        if(\App\Models\User::where('mail', '=', $request->mail)->exists()){

            return [
                'result' => false,
                'message' => 'そのメールアドレスは既に使用されています',
            ];

        }else{

            $random_password = '';

            for($i = 0 ; $i < 4 ; $i++) {
                $random_password .= strval(rand(0, 9));
            }

            // すでにそのユーザーのメール認証がある場合は削除しておく
            if(\App\Models\UserMailVerification::where('user_id','=', $request->user_id)->exists()){
                \App\Models\UserMailVerification::where('user_id','=', $request->user_id)->delete();
            }

            $mail_verification = new \App\Models\UserMailVerification;
            $mail_verification->user_id = $request->user_id;
            $mail_verification->tfa_token = $random_password;            
            $mail_verification->tfa_expires_at = now()->addMinutes(10);  
            $mail_verification->save();

            // メール送信
            \Mail::to($request->mail)->send(new TwoFactorAuthPassword($random_password));

            return [
                'result' => true
            ];


        }

    }

    public function second_auth(Request $request) {  // ２段階目の認証

        $result = false;

        if($request->filled('tfa_token', 'mail')){

            $mail_verification = \App\Models\UserMailVerification::where('user_id','=', $request->user_id)->first();
            $expiration = new Carbon($mail_verification->tfa_expires_at);

            if($mail_verification->tfa_token === $request->tfa_token && $expiration->gt(Carbon::now())) {

                // サインアップ
                $user = \App\Models\User::find($request->user_id);
                $user->mail = $request->mail;
                $user->password = Hash::make($request->password);
                $user->save();

                $result = true;
                $mail_verification->delete();

                return [
                    'result' => $result,
                ];

            }

        }

        return [
            'result' => $result,
        ];

    }
}
