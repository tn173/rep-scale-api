<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
  public function delete($id)
  {
    $user = \App\Models\User::find($id)->delete();
    return [
      'result' => true
    ];
  }

}
