<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\MailVerificationRequest;
use App\Http\Controllers\Controller;
use App\Mail\TwoFactorAuthPassword;

class UserSignupController extends Controller
{

    public function first_auth(MailVerificationRequest $request, $id) {  // １段階目の認証

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

            // すでにある場合はアップデート
            if(\App\Models\MailVerification::where('mail','=',$request->mail)->exists()){
                $mail_verification = \App\Models\MailVerification::where('mail','=',$request->mail)->first();
                $mail_verification->tfa_token = $random_password;            
                $mail_verification->tfa_expiration = now()->addMinutes(10);  
                $mail_verification->save();
            }else{
                $mail_verification = new \App\Models\MailVerification;
                $mail_verification->mail = $request->mail;
                $mail_verification->password = Hash::make($request->password);
                $mail_verification->tfa_token = $random_password;            
                $mail_verification->tfa_expiration = now()->addMinutes(10);  
                $mail_verification->save();
            }

            // メール送信
            \Mail::to($mail_verification->mail)->send(new TwoFactorAuthPassword($random_password));

            return [
                'result' => true,
                'mail' => $mail_verification->mail
            ];


        }

    }

    public function second_auth(Request $request, $id) {  // ２段階目の認証

        $result = false;

        if($request->filled('tfa_token', 'mail')){

            $mail_verification = \App\Models\MailVerification::where('mail','=',$request->mail)->first();
            $expiration = new Carbon($mail_verification->tfa_expiration);

            if($mail_verification->tfa_token === $request->tfa_token && $expiration > now()) {

                // サインアップ
                $user = \App\Models\User::find($id);
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
