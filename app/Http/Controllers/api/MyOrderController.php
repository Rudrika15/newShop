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

    //     public function updateCustomerAddress(Request $request)
    // {
    //     try {
    //         // Validate the incoming request
    //         $request->validate([
    //             'order_id' => 'required|integer|exists:order_details,order_id',
    //             'customer_address' => 'required|string|max:255',
    //         ]);

    //         // Retrieve the order by ID
    //         $order = OrderDetail::findOrFail($request->order_id);

    //         // Update the customer's address
    //         $order->customer_address = $request->customer_address;
    //         $order->save();

    //         // Return a success response
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Customer address updated successfully',
    //             'order_id' => $request->order_id,
    //             'customer_address' => $order->customer_address,
    //         ]);
    //     } catch (Exception $err) {
    //         // Return an error response
    //         return response()->json(['error' => $err->getMessage()], 500);
    //     }
    // }

    public function updateCustomerAddress(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required|integer|exists:order_details,order_id',
                'customer_address' => 'required|string|max:255',
            ]);

            $orderDetail = OrderDetail::findOrFail($request->order_id);

            $orderDetail->customer_address = $request->customer_address;
            $orderDetail->save();

            $order = $orderDetail->order;

            $user_id = $order->user_id;
            $user_details = $order->users;

            return response()->json([
                'success' => true,
                'message' => 'Customer address updated successfully',
                'order_id' => $request->order_id,
                'customer_address' => $orderDetail->customer_address,
                'user_id' => $user_id,
                'user_details' => [
                    'name' => $user_details->name,
                    'email' => $user_details->email,
                    'contact' => $user_details->contact,
                ],
            ]);
        } catch (Exception $err) {
            return response()->json(['error' => $err->getMessage()], 500);
        }
    }

}
