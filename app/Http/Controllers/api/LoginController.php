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
        $request->validate([
            'number' => 'required',
            'password' => 'required',
        ]);



        try {
            $user = User::where('contact', $request->number)->first();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json(['error' => 'Invalid password'], 401);
            }

            $token = $user->createToken('my-app-token')->plainTextToken;
            $user = [
                'name' => $user->name,
                'email' => $user->email,
                'contact' => $user->contact,
            ];

            return Util::getSuccessResponse($user, $token, "User login successfully");
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database query exceptions
            return response()->json(['error' => 'Database query error'], 500);
        } catch (\Exception $e) {
            // Handle general exceptions
            return response()->json(['error' => 'An error occurred during login. Please try again.'], 500);
        }
    }
}
