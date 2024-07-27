<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Pincode;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProductList()
    {
        try {
            $catalogs = Catalog::all();
            $result = [];
            $imgPath = asset('images/catalog/');

            foreach ($catalogs as $catalog) {
                $products = Product::where('catalogid', '=', $catalog->id)->get();
                $colors = [];

                foreach ($products as $product) {
                    $colors[] = $product->color;
                }

                $result[] = [
                    'catalog' => $catalog,
                    'colors' => $colors,
                    'imgPath' => $imgPath
                ];
            }

            return response()->json(['status' => true, 'message' => 'Product List', 'data' => $result]);
        } catch (Exception $err) {
            return response()->json(['error' => $err->getMessage()]);
        }
    }
    public function getProductDetail($id)
    {
        try {
            $imgPath = asset('images/product/');
            $product = Product::where('catalogid', '=', $id)->get();
            return response()->json(['status' => true, 'message' => 'Product Detail', 'data' => $product, 'imgPath' => $imgPath]);
        } catch (Exception $err) {
            return response()->json(['error' => $err->getMessage()]);
        }
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
