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

/**
 * @OA\Tag(
 *     name="Products",
 *     description="API Endpoints for Products"
 * )
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Get product list with catalogs and colors",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Product List",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Product List"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="catalog", type="object"),
     *                     @OA\Property(property="colors", type="array", @OA\Items(type="string")),
     *                     @OA\Property(property="imgPath", type="string", example="http://localhost/images/catalog/")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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
    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     summary="Get product detail by catalog ID",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Catalog ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product Detail",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Product Detail"),
     *             @OA\Property(property="imgPath", type="string", example="http://localhost/images/product/"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Product 1"),
     *                     @OA\Property(property="color", type="string", example="Red"),
     *                     @OA\Property(
     *                         property="stock",
     *                         type="object",
     *                         nullable=true,
     *                         @OA\Property(property="quantity", type="integer", example=50)
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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
