<?php

namespace App\Http\Controllers;

use App\Models\Product_stock;
use Illuminate\Http\Request;

class Product_stockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function edit($id)
    {
        $productStock = Product_stock::findOrFail($id);
        return view('product-stock.edit', compact('productStock'));
    }

    // Update the specified product
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'newstock' => 'required|integer'
            // Add other validation rules as needed
        ]);

        $productStock = Product_stock::findOrFail($id);

        $newQuantity = $productStock->quantity + $request->newstock;

        $productStock->update([
            'quantity' => $newQuantity,
        ]);

        return redirect()->route('admin.home')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
