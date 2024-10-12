<?php

namespace App\Http\Controllers\api;

use App\Helper\Util;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $message = "User login successfully";
            $user = [

                'name' => $user->name,
                'email' => $user->email,
                'contact' => $user->contact,
                'type' => $user->type,
                'token' => $token

            ];

            return Util::getSuccessResponse($user, $token, $message);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'Database query error'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred during login. Please try again.'], 500);
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        try {
            $userId = Auth::user()->id;

            $user = User::find($userId)->first();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json(['error' => 'Invalid old password'], 401);
            }
            $user->password = Hash::make($request->new_password);
            $user->save();
            return response()->json(['message' => 'Password changed successfully'], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database query exceptions
            return response()->json(['error' => 'Database query error'], 500);
        } catch (\Exception $e) {
            // Handle general exceptions
            return response()->json(['error' => 'An error occurred during password change. Please try again.'], 500);
        }
    }
}
