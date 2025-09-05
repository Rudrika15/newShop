<?php

namespace App\Http\Controllers\api;

use App\Helper\Util;
use App\Http\Controllers\Controller;
use App\Models\Myorder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product_stock;
use App\Models\Stock_Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{
    public function getMyorderList()
    {
        $imgPath = asset('images/product/');
        $id = Auth::user()->id;
        $orders = Order::where('user_id', '=', $id)
            ->with('order_details.product')

            ->get();
        $response = [
            'status' => true,
            'message' => 'Order List',
            'imgPath' => $imgPath,
            'data' => $orders
        ];

        return Util::getMyOrderListResponse($response);
    }

    /**
 * @OA\Post(
 *     path="/api/order-save",
 *     tags={"Orders"},
 *     summary="Create a new order",
 *     security={{"sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="product_id", type="array", @OA\Items(type="integer"), example={1,2}),
 *             @OA\Property(property="quantity", type="array", @OA\Items(type="integer"), example={2,1}),
 *             @OA\Property(property="price", type="array", @OA\Items(type="number", format="float"), example={500,1200}),
 *             @OA\Property(property="amount", type="number", format="float", example=1700),
 *             @OA\Property(property="payment_id", type="string", example="pay_12345"),
 *             @OA\Property(property="customer_address", type="string", example="123 Main St, NY")
 *         )
 *     ),
 *     @OA\Response(response=201, description="Order created successfully"),
 *     @OA\Response(response=400, description="Validation error"),
 *     @OA\Response(response=401, description="Unauthenticated")
 * )
 */

    public function orderSave(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required',
                'quantity' => 'required',
                'price' => 'required',
                'amount' => 'required',
                'payment_id' => 'required',
                'customer_address' => 'required',
            ]);

            $userId = Auth::user()->id;

            $order = new Order();
            $order->user_id = $userId;
            $order->amount = $request->amount;
            $order->payment_id = $request->payment_id;
            $order->save();

            $orderId = $order->id;

            foreach ($request->product_id as $key => $productId) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $orderId;
                $orderDetail->customer_address = $request->customer_address;
                $orderDetail->product_id = $productId;
                $orderDetail->quantity = $request->quantity[$key];
                $orderDetail->price = $request->price[$key];
                $orderDetail->save();

                $stock = new Stock_Transaction();
                $stock->product_id = $productId;
                $stock->quantity = $request->quantity[$key] * -1;
                $stock->type = 'out';
                $stock->remarks = 'sold ' . $orderId;
                $stock->save();

                $productStock = Product_stock::where('product_id', $productId)->first();
                if ($productStock) {
                    $productStock->quantity   = $productStock->quantity -   $request->quantity[$key];
                    $productStock->save();
                }
            }

            return Util::getCreateResponse($order, 'Order created successfully');
        } catch (Exception $err) {
            return response()->json(['error' => $err->getMessage()], 500);
        }
    }

/**
 * @OA\Post(
 *     path="/api/update-customer-address",
 *     tags={"Orders"},
 *     summary="Update customer address for a single order detail",
 *     security={{"sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=5),
 *             @OA\Property(property="customer_address", type="string", example="New Street 456, LA")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Customer address updated successfully"),
 *     @OA\Response(response=400, description="Validation error"),
 *     @OA\Response(response=404, description="Order detail not found")
 * )
 */



    public function updateCustomerAddress(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'customer_address' => 'required|string|max:255',
            ]);

            $orderDetail = OrderDetail::findOrFail($request->id);

            $orderDetail->customer_address = $request->customer_address;
            $orderDetail->save();


            return response()->json([
                'success' => true,
                'message' => 'Customer address updated successfully',
                'data' => $orderDetail
            ]);
        } catch (Exception $err) {
            return response()->json(['error' => $err->getMessage()], 500);
        }
    }

    /**
 * @OA\get(
 *     path="/api/cancel-order/{id}",
 *     tags={"Orders"},
 *     summary="Cancel an order",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="OrderDetail ID",
 *         @OA\Schema(type="integer", example=10)
 *     ),
 *     @OA\Response(response=200, description="Order cancelled successfully"),
 *     @OA\Response(response=404, description="Order not found")
 * )
 */

    public function cancelOrder(Request $request, $id)
    {
        try {


            $orderDetail = OrderDetail::findOrFail($id);

            $orderDetail->orderStatus = 'cancelled';
            $orderDetail->save();

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully',
                'data' => $orderDetail
            ]);
        } catch (Exception $err) {
            return response()->json(['error' => $err->getMessage()], 500);
        }
    }

    /**
 * @OA\Post(
 *     path="/api/addAddress",
 *     tags={"Orders"},
 *     summary="Update customer address for all order details in an order",
 *     security={{"sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=3, description="Order ID"),
 *             @OA\Property(property="customer_address", type="string", example="45 Downtown Street, Chicago")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Customer address updated successfully for all order items"),
 *     @OA\Response(response=400, description="Validation error"),
 *     @OA\Response(response=404, description="Order not found")
 * )
 */

    public function addAddress(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:order_details,order_id',
                'customer_address' => 'required|string|max:255',
            ]);

            // Retrieve all OrderDetail records associated with the given order_id
            $orderDetails = OrderDetail::where('order_id', $request->id)->get();

            // Iterate over each OrderDetail record and update the customer_address
            foreach ($orderDetails as $orderDetail) {
                $orderDetail->customer_address = $request->customer_address;
                $orderDetail->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Customer address updated successfully',
                'data' => $orderDetails
            ]);
        } catch (Exception $err) {
            return response()->json(['error' => $err->getMessage()], 500);
        }
    }
}
