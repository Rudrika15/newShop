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
     *     path="/api/getProductList",
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
 *     path="/api/getProductDetail/{id}",
 *     tags={"Products"},
 *     summary="Get product detail by catalog ID",
 *     description="Retrieve product details by providing the catalog ID.",
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
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Product Detail"),
 *             @OA\Property(property="imgPath", type="string", example="http://localhost/images/product/"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
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
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
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

    /**
 * @OA\Get(
 *     path="/api/getSlider",
 *     tags={"Sliders"},
 *     summary="Get active sliders",
 *     description="Retrieve all active sliders with image path",
 *     @OA\Response(
 *         response=200,
 *         description="List of active sliders",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Slider List"),
 *             @OA\Property(property="imgPath", type="string", example="https://example.com/slider/"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="title", type="string", example="Summer Sale"),
 *                     @OA\Property(property="image", type="string", example="slider1.jpg"),
 *                     @OA\Property(property="status", type="string", example="Active"),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-06T10:00:00Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-06T10:10:00Z")
 *                 )
 *             )
 *         )
 *     )
 * )
 */
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

    /**
 * @OA\Get(
 *     path="/api/getVersion",
 *     tags={"Version"},
 *     summary="Get latest version",
 *     description="Retrieve the latest app version",
 *     @OA\Response(
 *         response=200,
 *         description="Latest version",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Version"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=5),
 *                 @OA\Property(property="version", type="string", example="2.3.1"),
 *                 @OA\Property(property="description", type="string", example="Latest stable release"),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-06T09:00:00Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-06T09:15:00Z")
 *             )
 *         )
 *     )
 * )
 */
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
