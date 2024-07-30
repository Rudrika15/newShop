<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Sku;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get today's date
        $today = now()->startOfDay();

        // Fetch orders created today
        $skus = Sku::all();
        $orders = Order::whereDate('created_at', $today)->paginate(5);

        return view('order.index', compact('orders', 'skus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function print()
    {
        // Get today's date
        $today = now()->startOfDay();

        // Fetch orders created today
        $skus = Sku::all();
        $orders = Order::whereDate('created_at', $today)->get();
        return view('order.printReport', compact('orders', 'skus'));
    }


    public function allOrders()
    {
        $orders = OrderDetail::with('product')
        ->with('orders')
        ->paginate(10);
        return view('order.orders', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
