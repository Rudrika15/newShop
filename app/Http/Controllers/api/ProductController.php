<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Pincode;
use App\Models\Product;
use App\Models\Product_stock;
use App\Models\Slider;
use App\Models\Stock_Transaction;
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
            $products = Product::where('catalogid', '=', $id)->get();
    
            foreach ($products as $product) {
                // Get stock information for each product
                $stock = Product_stock::where('product_id', '=', $product->id)->pluck('quantity');
                // Append stock information to each product
                $product->stock = $stock;
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
}
