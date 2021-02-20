<?php

namespace App\Http\Middleware;

use Illuminate\Support\Str;
use Closure;

class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param mixed $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authorization = $request->header()['authorization'][0] ?? '';
        $user_authentication = \App\Models\UserAuthentication::where('user_id', $request->user_id)->where('device_identifier', $request->device_identifier)->first();
        if($user_authentication != null && $authorization != ''){
            if($user_authentication->access_token == $authorization && $user_authentication->access_token_expires_at > now()){
                //API認証成功
                return $next($request);
            }else{
                // 認証失敗
                return [
                    'result' => false,
                    'message' => '認証情報がセットされていません'
                ];
            }
        }else{
            // 認証失敗
            return [
                'result' => false,
                'message' => '認証情報がセットされていません'
            ];
        }
    }
}
