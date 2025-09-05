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
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="User Login",
     *     description="Authenticate user by contact number and password. Returns user details and access token.",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"number","password"},
     *             @OA\Property(property="number", type="string", example="9876543210"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="contact", type="string", example="9876543210"),
     *             @OA\Property(property="type", type="string", example="Customer"),
     *             @OA\Property(property="token", type="string", example="1|vJ6qJdF..")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid password"),
     *     @OA\Response(response=404, description="User not found"),
     *     @OA\Response(response=500, description="An error occurred during login")
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'password' => 'required',
        ]);

        try {
            $user = User::where('contact', $request->number)
                ->where('status', 'Active')
                ->first();

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

    /**
     * @OA\Post(
     *     path="/api/change-password",
     *     summary="Change Password",
     *     description="Allows authenticated user to change their password.",
     *     tags={"Authentication"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"old_password","new_password"},
     *             @OA\Property(property="old_password", type="string", format="password", example="oldPass123"),
     *             @OA\Property(property="new_password", type="string", format="password", example="newPass456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password changed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Password changed successfully")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid old password"),
     *     @OA\Response(response=404, description="User not found"),
     *     @OA\Response(response=500, description="An error occurred during password change")
     * )
     */

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        try {
            $userId = Auth::user()->id;

            $user = User::where('id', $userId)->first();

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
