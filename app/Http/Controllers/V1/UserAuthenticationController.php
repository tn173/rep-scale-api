<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class UserAuthenticationController extends Controller
{

    public function token_refresh(Request $request) { 
        $user = \App\Models\User::find($request->user_id);
        $user_authentication = \App\Models\UserAuthentication::where('user_id', $request->user_id)->where('device_identifier', $request->device_identifier)->first(); 
        if($user_authentication->refresh_token == $request->refresh_token && $user_authentication->refresh_token_expires_at > now()){
            $user_authentication->access_token = Str::uuid();
            $user_authentication->access_token_expires_at = now()->addDays(config('const.ACCESS_TOKEN_EXPIRATION'));
            $user_authentication->refresh_token = Str::uuid();
            $user_authentication->refresh_token_expires_at = $user->mail == '' ? datetime(config('const.REFRESH_TOKEN_EXPIRATION_WITHOUT_LOGIN')) : now()->addDays(config('const.REFRESH_TOKEN_EXPIRATION'));
            $user_authentication->save();

            return [
                'result' => true,
                'access_token' => $user_authentication->access_token,
                'refresh_token' => $user_authentication->refresh_token
            ];
        
        }else{
            return [
                'result' => false
            ];
        }
    }

}
