<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
  public function index()
  {
    $user = User::all();
    return $user;
  }
}
