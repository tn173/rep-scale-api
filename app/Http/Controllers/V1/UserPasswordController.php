<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Models\UserInfo;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserPasswordController extends Controller
{

    public function index($id)
    {
        $result = false;

        return [
            'result' => $result
        ];
    }

    public function update(UpdatePasswordRequest $request, $id)
    {
        $validated = $request->validated();
        
        $result = false;
        $user = \App\Models\User::find($id);

        if(Hash::check($request->password, $user->password)){
            $user->password = Hash::make($request->new_password);
            $user->save();
            $result = true;
        }
    
        return [
            'result' => $result
        ];
    }

}

