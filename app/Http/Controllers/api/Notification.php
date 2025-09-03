<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class Notification extends Controller
{
    //

    public function updateFcmToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
        ]);
        $userId = Auth::user()->id;

        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ]);
        }
        $user->fcm_token = $request->fcm_token;
        $user->save();
        return response()->json([
            'status' => true,
            'message' => 'FCM token updated successfully',
        ]);
    }
}
