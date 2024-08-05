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

            $productStock = Product_stock::find($productId);
            if ($productStock) {
                $productStock->quantity -= $request->quantity[$key];
                $productStock->save();
            }
        }

        return Util::getCreateResponse($order, 'Order created successfully');
    } catch (Exception $err) {
        return response()->json(['error' => $err->getMessage()], 500);
    }
}




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
}
