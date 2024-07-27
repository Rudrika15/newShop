<?php

namespace App\Http\Controllers\api;

use App\Helper\Util;
use App\Http\Controllers\Controller;
use App\Models\Myorder;
use App\Models\Order;
use App\Models\OrderDetail;
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
            ]);
            $id = Auth::user()->id;

            $order = new Order();

            $order->user_id = $id;
            $order->amount = $request->amount;
            $order->payment_id = $request->payment_id;
            $order->save();

            $order_id = $order->id;

            foreach ($request->product_id as $key => $value) {
                $order_detail = new OrderDetail();
                $order_detail->order_id = $order_id;
                $order_detail->product_id = $value;
                $order_detail->quantity = $request->quantity[$key];
                $order_detail->price = $request->price[$key];
                $order_detail->save();
            }

            return Util::getCreateResponse($order, 'Order created successfully');
        } catch (Exception $err) {
            return response()->json(['error' => $err->getMessage()]);
        }
    }
}
