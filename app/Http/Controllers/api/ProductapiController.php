<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Pincode;
use Exception;
use Illuminate\Http\Request;

class ProductapiController extends Controller
{
    public function getProductList()
    {
        $catalogs = Catalog::with('products')->get();
        return response()->json($catalogs);
    }

    public function getPincode(Request $req)
    {
        try {
            $code = $req->pincode;
            $pincode = Pincode::where('pincode', '=', $code)->first();
            if ($pincode) {
                return response()->json($pincode);
            } else {
                return response()->json(["message" => "not found"]);
            }
        } catch (Exception $err) {
            return response()->json($err);
        }
    }
}
