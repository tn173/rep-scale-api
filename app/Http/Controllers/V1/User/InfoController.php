<?php

namespace App\Http\Controllers\V1\User;

use Illuminate\Http\Request;
use App\Models\UserInfo;
use App\Http\Controllers\Controller;

class InfoController extends Controller
{
  public function index()
  {
    $info = UserInfo::all();
    return $info;
  }
}
