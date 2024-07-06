<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_stock;
use App\Models\Sku;
use Faker\Core\File;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(5);

        return view('product.index', compact('products'));
    }

    //trash user data
    public function trashProduct()
    {
        $products = Product::onlyTrashed()->paginate(5);

        return view('product.trash', compact('products'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $skus = Sku::all();
        $categories = Category::all();
        return view('product.create', compact('skus', 'categories'));
    }

    public function store(Request $request)
    {

        //  dd($request);
        // Validate the data
        $request->validate([
            'title' => 'required',
            'main_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'categoryid' => 'required',
            'description' => 'required',
            'base_price' => 'required|numeric',
            'tax_price' => 'required|numeric',
            'discount_amt' => 'required|numeric',
            'mrp' => 'required|numeric',
            'is_active' => 'required|in:Yes,No',
           // 'sku' => 'required|array',
            // 'slug' => 'required|array',
            // 'color' => 'required|array',
            // 'size' => 'nullable|array',
            // 'image' => 'required|array',
            // 'image.*' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            // 'quantity' => 'required|array',
    
        ]);

        // Save the catalog
        $catalog = new Catalog();
        $catalog->title = $request->title;

        if ($request->hasFile('main_image')) {
            $image = $request->file('main_image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/catalog'), $imageName);
            $catalog->main_image = $imageName;
        }

        $catalog->save();

    
        // Loop through and save each product
        foreach ($request->sku as $index => $sku) {
            $product = new Product();

            $product->catalogid = $catalog->id; // Link to the catalog
            $product->categoryid = $request->categoryid;
            $product->description = $request->description;
            $product->base_price = $request->base_price;
            $product->tax_price = $request->tax_price;
            $product->discount_amt = $request->discount_amt;
            $product->mrp = $request->mrp;
            $product->is_active = $request->is_active;
            $product->sku = $sku;
            $product->slug = $request->slug[$index];
            $product->color = $request->color[$index];
            $product->size = $request->size[$index] ?? null; // Handle nullable size

            if ($request->hasFile('image.' . $index)) {
                $image = $request->file('image.' . $index);
                $imageName = time() . '_' . $index . '.' . $image->extension();
                $image->move(public_path('images/product'), $imageName);
                $product->image = $imageName;
            }

            $product->save();

            // Save product stock
            $stock = new Product_Stock();
            $stock->quantity = $request->quantity[$index];
            $stock->product_id = $product->id;
            $stock->save();

        }
        return redirect()->route('product.index')->with('success', 'Products created successfully');

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
        $product = Product::find($id);
        $categories = Category::all();
        $skus = Sku::all();
        return view('product.edit', compact('product', 'categories', 'skus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // return $request;
        $request->validate([
            'sku' => 'required',
            'categoryid' => 'required',
            'slug' => 'required',
            'color' => 'required',
            'size' => '',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'opening_stock' => 'required',
            'description' => 'required',
            'base_price' => 'required',
            'tax_price' => 'required',
            'discount_amt' => 'required',
            'mrp' => 'required',
            'is_active' => 'required',
        ]);

        $input = $request->all();
        // Move old image to deleted folder
        if ($image = $request->file('image')) {

            // Delete old image if it exists
            if ($product->image && file_exists(public_path('images/product/' . $product->image))) {
                unlink(public_path('images/product/' . $product->image));
            }

            $destinationPath = 'images/product';
            // $oldImagePath = 'images/product' . $product->image;
            $productImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $productImage);
            $input['image'] = $productImage;
        } else {
            // unset($input['image']);
        }

        $product->update($input);

        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete(); // Soft delete the user
            return redirect()->back()->with('success', 'product deleted successfully');
        }
        return redirect()->back()->with('success', 'product not found');
    }
    //restore
    public function restore($id)
    {
        $product = Product::withTrashed()->find($id);
        if ($product) {
            $product->restore(); // Soft delete the user
            return redirect()->back()->with('success', 'product restored successfully');
        }
        return redirect()->back()->with('success', 'product not found');
    }

    // permanently delete
    public function destroy($id)
    {
        $product = Product::withTrashed()->find($id);
        if ($product) {
            $product->forceDelete(); // Soft delete the user
            return redirect()->back()->with('success', 'product permanently deleted successfully');
        }
        return redirect()->back()->with('success', 'product not found');
    }
}
