<?php

namespace App\Http\Controllers\api;

use App\Helper\Util;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrderList()
    {
        $orders = Order::all();

        return Util::getorderListResponse($orders);
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
