<?php

namespace App\Http\Controllers\api;

use App\Helper\Util;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePinController extends Controller
{
    /**
 * @OA\Post(
 *     path="/api/updatePin",
 *     tags={"User"},
 *     summary="Change user PIN",
 *     description="Allows an authenticated user to change their PIN/password",
 *     security={{"sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"currentPin","newPin","newPin_confirmation"},
 *             @OA\Property(property="currentPin", type="string", example="123456", description="Current PIN"),
 *             @OA\Property(property="newPin", type="string", example="654321", description="New PIN (at least 6 digits)"),
 *             @OA\Property(property="newPin_confirmation", type="string", example="654321", description="Confirm new PIN")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="PIN changed successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="PIN changed successfully"),
 *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOi...")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error or current PIN mismatch",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Current PIN does not match our records.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error"
 *     )
 * )
 */

    public function updatePin(Request $request)
    {
        try {
            // Get the authenticated user
            $user = $request->user('sanctum');

            // Define validation rules
            $rules = [
                'currentPin' => ['required', 'regex:/^[0-9]*$/'],
                'newPin' => ['required', 'min:6', 'regex:/^[0-9]*$/'],
                'newPin_confirmation' => ['required', 'min:6', 'regex:/^[0-9]*$/'],
            ];

            // Validate the request
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Util::getErrorResponse($validator->errors(), 'Validation failed');
            }

            // Check if the current pin matches the user's pin
            if (!Hash::check($request->currentPin, $user->password)) {
                return Util::getErrorResponse([], 'Current PIN does not match our records.');
            }

            // Check if the new pin and current pin are not same
            if (Hash::check($request->newPin, $user->password)) {
                return Util::getErrorResponse([], 'New PIN cannot be same as current PIN.');
            }

            // Update the user's pin
            $user->password = Hash::make($request->newPin);
            $user->save();

            return Util::getSuccessResponseForPinChange([], $request->bearerToken());
        } catch (\Exception $e) {
            return Util::getErrorResponse([], $e->getMessage());
        }
    }
}
