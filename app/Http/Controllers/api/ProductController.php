<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Pincode;
use App\Models\Product;
use App\Models\Product_stock;
use App\Models\Slider;
use App\Models\Stock_Transaction;
use App\Models\Version;
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
                $products = Product::where('catalogid', '=', $catalog->id)->where('is_active', 'Yes')->get();
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
            $products = Product::where('catalogid', '=', $id)->where('is_active', 'Yes')->get();
            
            foreach ($products as $product) {
                // Get stock information for each product
                $stock = Product_stock::where('product_id', '=', $product->id)->first();
                
                // Check if stock data exists and structure it as an object
                if ($stock) {
                    $product->stock = [
                        'quantity' => $stock->quantity
                    ];
                } else {
                    $product->stock = null; // or you can set it to an empty object: (object)[]
                }
            }
            
            $response = [
                'status' => true,
                'message' => 'Product Detail',
                'imgPath' => $imgPath,
                'data' => $products
            ];
            
            return response()->json($response);
            
        } catch (Exception $err) {
            return response()->json(['error' => $err->getMessage()]);
        }
    }
    public function  getSlider()
    {
        $imgPath = asset('slider/');
        $sliders = Slider::where('status', 'Active')->get();
        $response = [
            'status' => true,
            'message' => 'Slider List',
            'imgPath' => $imgPath,
            'data' => $sliders
        ];
        return response()->json($response);
    }

    public function getVersion()
    {
        $version  = Version::orderBy('id', 'desc')->first();
        $response = [
            'status' => true,
            'message' => 'Version',
            'data' => $version
        ];
        return response()->json($response);
    }
}
