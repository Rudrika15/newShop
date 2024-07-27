<?php

namespace App\Http\Controllers\api;



use App\Helper\Util;
use App\Http\Controllers\Controller;
use App\Models\Pincode;
use Exception;
use Illuminate\Http\Request;

class PincodeController extends Controller
{
    public function getAllPincodes(Request $request)
    {
        try {
            // Fetch all pincodes
            $pincodes = Pincode::all();

            // Return response in JSON format
            return response()->json([
                'data' => Util::getPincodesListResponse($pincodes)
            ]);
        } catch (\Exception $e) {
            // Return a 500 error with the exception message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPincodeDetails(Request $request)
    {
        try {
            // Fetch pincode from request body
            $code = $request->input('pincode');

            if (!$code) {
                return response()->json(['message' => 'Pincode parameter is required'], 400);
            }

            // Fetch all records matching the pincode
            $pincodes = Pincode::where('pincode', $code)->get();

            if ($pincodes->isNotEmpty()) {
                return response()->json(Util::getPincodeResponse($pincodes));
            } else {
                return response()->json(['message' => 'Pincode not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
