<?php

namespace App\Http\Controllers\api;

use App\Helper\Util;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

    /**
 * @OA\Get(
 *     path="/api/getOrderList",
 *     tags={"Orders"},
 *     summary="Get order list",
 *     description="Fetches a list of all orders",
 *     security={{"sanctum":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Successful Order List Response",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Order List"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="user_id", type="integer", example=5),
 *                     @OA\Property(property="total_amount", type="number", format="float", example=1999.99),
 *                     @OA\Property(property="status", type="string", example="Pending"),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-05T12:30:00Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-05T13:00:00Z")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server Error"
 *     )
 * )
 */
    public function getOrderList()
    {
        $orders = Order::all();

        return Util::getOrderListResponse($orders);
    }
    public function orderSave(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1', // Adjust validation rules as needed
            'price' => 'required|numeric|min:0',   // Adjust validation rules as needed
        ]);

        // Create new Order instance
        $order = new Order();
        $order->user_id = $request->user_id;
        $order->product_id = $request->product_id;
        $order->quantity = $request->quantity;
        $order->price = $request->price;

        // Save the order
        $order->save();

        return Util::getCreateResponse($order, 'Order created successfully');
        // return response()->json([
        //     'message' => 'Order created successfully',
        //     'status' => 'success',
        //     'order' => $order
        // ]);
    }
}
