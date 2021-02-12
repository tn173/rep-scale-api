<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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
    $user->api_token = Str::uuid();
    $user->save();

    return ['result' => true, 'api_token' => $user->api_token, 'user_id' => $user->id]; 
  }

  public function delete($id)
  {
    $user = \App\Models\User::find($id)->delete();
    return [
      'result' => true
    ];
  }

  public function update(Request $request,$id)
  {
    $user = \App\Models\User::where('id',$id)->first();
    $user->gender = $request->gender;
    $user->birthday = $request->birthday;
    $user->height = $request->height;
    $user->save();
    
    return [
      'result' => true
    ];
  }

}
