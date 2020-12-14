<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
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
        $user = \App\Models\User::find($request->user_id);
        if($authorization != '' && $user->api_token == $authorization){
            return $next($request);
        }else{
            abort(403, '認証情報がセットされていません');
        }
    }
}
