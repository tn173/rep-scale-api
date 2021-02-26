<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\UserInfo;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Controllers\Controller;
use App\Mail\TwoFactorAuthPassword;

class UserPasswordController extends Controller
{

    public function first_auth(UpdatePasswordRequest $request) {  // １段階目の認証

        $validated = $request->validated();
        $user = \App\Models\User::find($request->user_id);

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
        }

    

        return ['result' => false];

    }

    public function second_auth(Request $request) {  // ２段階目の認証

        $result = false;

        if($request->filled('tfa_token', 'mail')) {

            $user = \App\Models\User::where('mail','=', $request->mail)->first();
            $mail_verification = \App\Models\UserMailVerification::where('user_id','=', $user->id)->first();
            $expiration = new Carbon($mail_verification->tfa_expires_at);

            if($mail_verification->tfa_token === $request->tfa_token && $expiration->gt(Carbon::now())) {

                // パスワードの変更
                $user->password = Hash::make($request->new_password);
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

