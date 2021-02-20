<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
  
  public function create(Request $request)
  {
    $user = new \App\Models\User;
    $user->gender = $request->gender;
    $user->birthday = $request->birthday;
    $user->height = $request->height;
    $user->mail = '';
    $user->password = '';
    $user->save();

    $user_authentication = new \App\Models\UserAuthentication;
    $user_authentication->user_id = $user->id;
    $user_authentication->device_identifier = $request->device_identifier;
    $user_authentication->access_token = Str::uuid();
    $user_authentication->access_token_expires_at = now()->addDays(config('const.ACCESS_TOKEN_EXPIRATION'));
    $user_authentication->refresh_token = Str::uuid();
    $user_authentication->refresh_token_expires_at = now()->addDays(config('const.REFRESH_TOKEN_EXPIRATION'));
    $user_authentication->save();

    return [
      'result' => true, 
      'user_id' => $user->id, 
      'access_token' => $user_authentication->access_token, 
      'refresh_token' => $user_authentication->refresh_token
    ]; 

  }

  public function update(Request $request)
  {
    $user = \App\Models\User::where('id', $request->user_id)->first();
    $user->gender = $request->gender;
    $user->birthday = $request->birthday;
    $user->height = $request->height;
    $user->save();
    
    return [
      'result' => true
    ];

  }

  public function delete(Request $request)
  {
    $user = \App\Models\User::find($request->user_id)->delete();

    return [
      'result' => true
    ];

  }

}
