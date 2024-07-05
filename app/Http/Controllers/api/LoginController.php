<?php

namespace App\Http\Controllers\api;

use App\Helper\Util;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $rules = array(
            'email' => 'required',
            'password' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $user = User::where('email', $request->email)->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {
                
                $token = $user->createToken('my-app-token')->plainTextToken;
                // $role = $user->getRoleNames();
                return Util::getSuccessResponse($user, "User login successfully" ,$token);
            }
        }
    }
}
