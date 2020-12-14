<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Models\UserInfo;
use App\Http\Controllers\Controller;

class UserInfoController extends Controller
{
  
  public function index($id)
  {
    $info = UserInfo::where('user_id',$id)->first();
    return [
      'gender' => $info->gender,
      'birthday' => $info->birthday,
      'height' => $info->height
    ];
  }

  public function store(Request $request,$id)
  {
      $info = new UserInfo;
      $info->user_id = $id;
      $info->gender = $request->gender;
      $info->birthday = $request->birthday;
      $info->height = $request->height;
      $info->save();
      return [
        'result' => true
      ];
  }

  public function update(Request $request,$id)
  {
    $info = UserInfo::where('user_id',$id)->first();
    $info->gender = $request->gender;
    $info->birthday = $request->birthday;
    $info->height = $request->height;
    $info->save();
    return [
      'result' => true
    ];
  }

}
