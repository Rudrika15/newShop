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
