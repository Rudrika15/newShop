<?php

namespace App\Http\Controllers\api;

use App\Helper\Util;
use App\Http\Controllers\Controller;
use App\Models\Pincode;
use Exception;
use Illuminate\Http\Request;

class PincodeapiController extends Controller
{
    public function getPincode(Request $req)
    {
        try {
            $code = $req->pincode;
            $pincode = Pincode::where('pincode', '=', $code)->first();
            if ($pincode) {
                return Util::getPincodeResponse($pincode);
            } else {
                return response()->json(["message" => "not found"]);
            }
        } catch (Exception $err) {
            return response()->json($err);
        }
    }
}
