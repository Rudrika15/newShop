<?php

namespace App\Http\Controllers\api;



use App\Helper\Util;
use App\Http\Controllers\Controller;
use App\Models\Pincode;
use Exception;
use Illuminate\Http\Request;

class PincodeController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/pincodes",
 *     tags={"Pincodes"},
 *     summary="Get all pincodes (limited to 50,000)",
 *     security={{"sanctum":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of pincodes",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
 *         )
 *     ),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

    public function getAllPincodes(Request $request)
    {
        try {
            $pincodes = Pincode::take(50000)->get();

            return response()->json([
                'data' => Util::getPincodesListResponse($pincodes)
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\get(
 *     path="/api/pincode-details",
 *     tags={"Pincodes"},
 *     summary="Get details of a specific pincode",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="pincode",
 *         in="query",
 *         required=true,
 *         description="The pincode to search for",
 *         @OA\Schema(type="string", example="382350")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Pincode details found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Pincode details"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(response=400, description="Pincode parameter is required"),
 *     @OA\Response(response=404, description="Pincode not found"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

    public function getPincodeDetails(Request $request)
    {
        try {
            $code = $request->input('pincode');

            if (!$code) {
                return response()->json(['message' => 'Pincode parameter is required'], 400);
            }

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

    /**
 * @OA\post(
 *     path="/api/checkPincode",
 *     tags={"Pincodes"},
 *     summary="Check if a pincode exists",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="pincode",
 *         in="query",
 *         required=true,
 *         description="The pincode to check",
 *         @OA\Schema(type="string", example="382350")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Pincode found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Pincode found"),
 *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
 *         )
 *     ),
 *     @OA\Response(response=400, description="Pincode parameter is required"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

    public function checkPincode(Request $request)
    {
        try {
            $code = $request->input('pincode');
            if (!$code) {
                return response()->json(['message' => 'Pincode parameter is required'], 400);
            }

            $pincodes = Pincode::where('pincode', $code)->get();
            return response()->json([
                'data' => $pincodes,
                'message' => 'Pincode found',
                'status'=>true,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
