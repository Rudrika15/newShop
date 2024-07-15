<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_stock;
use App\Models\Sku;
use App\Models\Stock_Transaction;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catalogs = Catalog::with('products')->orderBy('created_at', 'desc')->paginate(5);


        return view('product.index', compact('catalogs'));
    }

    //trash user data
    public function trashProduct()
    {
        $catalogs = Catalog::with(['products' => function ($query) {
            $query->onlyTrashed();
        }])->onlyTrashed()->paginate(5);

        return view('product.trash', compact('catalogs'));
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

        // Function to generate a unique SKU suffix
        function generateUniqueNumber($prefix)
        {
            do {
                // Generate a 5-digit random number
                $uniqueNumber = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);
                $sku = $prefix . $uniqueNumber;
            } while (DB::table('products')->where('sku', $sku)->exists());

            return $sku;
        }


        // Loop through and save each product
        for ($i = 0; $i < count($request->sku['slug']); $i++) {
            $product = new Product();
            //  return $request->sku['slug'];


            $product->catalogid = $catalog->id; // Link to the catalog
            $product->categoryid = $request->categoryid;
            $product->description = $request->description;
            $product->base_price = $request->base_price;
            $product->tax_price = $request->tax_price;
            $product->discount_amt = $request->discount_amt;
            $product->mrp = $request->mrp;
            $product->is_active = $request->is_active;
            $product->sku = generateUniqueNumber($request->sku['sku'][$i]);
            $product->slug = $request->sku['slug'][$i];
            $product->color = $request->sku['color'][$i];
            $product->size = $request->sku['size'][$i] ?? null; // Handle nullable size


            if (!empty($request->file('sku')['image']) && count($request->file('sku')['image']) > 0) {
                $image = $request->file('sku')['image'][$i];
                $imageName = time() . '_' . $i . '.' . $image->extension();
                $image->move(public_path('images/product'), $imageName);
                $product->image = $imageName;
            }

            $product->save();

            // Save product stock
            $stock = new Product_Stock();
            $stock->product_id = $product->id;
            $stock->quantity = $request->sku['quantity'][$i];

            // return $stock;
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
    public function editcatalog(string $id)
    {
        $catalog = Catalog::find($id);
        return view('product.edit', compact('catalog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function catalogupdate(Request $request, Catalog $catalog)
    {
        // return $request;
        $request->validate([
            'title' => 'required',
            'main_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',

        ]);

        $input = $request->all();
        // Move old image to deleted folder
        if ($image = $request->file('main_image')) {

            // Delete old image if it exists
            if ($catalog->main_image) {
                $existingImage = public_path('images/catalog/' . $catalog->main_image);
                if (file_exists($existingImage)) {
                    // Delete the existing image
                    unlink($existingImage);
                }

                $destinationPath = 'images/catalog';
                // $oldImagePath = 'images/catalog' . $catalog->image;
                $catalogImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $catalogImage);
                $input['main_image'] = $catalogImage;
            } else {
                // unset($input['image']);
            }

            $catalog->update($input);

            return redirect()->route('product.index')->with('success', 'catalog updated successfully');
        }
    }

    public function edit(string $id)
    {
        $product = Product::with('productStocks')->findOrFail($id);
        $categories = Category::all();
        $skus = Sku::all();
        return view('product.editproduct', compact('product', 'categories', 'skus'));
    }




    // product 
    public function update(Request $request, Product $product)
    {
        // return $request;
        $request->validate([
            // 'sku' => 'required',
            // 'categoryid' => 'required',
            'slug' => 'required',
            'color' => 'required',
            'size' => '',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            // 'opening_stock' => 'required',
            'description' => 'required',
            'base_price' => 'required',
            'tax_price' => 'required',
            'discount_amt' => 'required',
            'mrp' => 'required',
            'is_active' => 'required',
        ]);

        $input = $request->all();
        // dd($input);
        // Move old image to deleted folder
        if ($image = $request->file('image')) {

            if ($product->image) {
                $existingImage = public_path('images/product/' . $product->image);
                if (file_exists($existingImage)) {
                    // Delete the existing image
                    unlink($existingImage);
                }

                $destinationPath = 'images/product';
                // $oldImagePath = 'images/product' . $product->image;
                $productImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $productImage);
                $input['image'] = $productImage;
            } else {
                // unset($input['image']);
            }
        }
        $product->update($input);

        // Update quantity if newstock is provided
        if ($request->filled('newstock')) {
            $newStock = intval($request->newstock);

            // Update product stock
            $productstock = $product->productStocks->first()->quantity += $newStock;

            //   return $productstock;

            $pstock = Product_stock::find($request->pstockid);
            //    return $pstock;
            $pstock->quantity = $productstock;

            $pstock->save();

            //Save stock transaction (assuming you have a StockTransaction model and table)
            Stock_Transaction::create([
                'product_id' => $product->id,
                'type' => $request->type, // or 'subtract' based on your needs
                'quantity' => $productstock,
                'remarks' => $request->remarks,
            ]);
        }
        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        // Find the catalog by ID
        $catalog = Catalog::findOrFail($id);

        // Delete all products with this catalog
        foreach ($catalog->products as $product) {
            // Optionally, you can delete images or other related data here
            $product->delete();
        }
        $catalog->delete();

        // Redirect back with a success message
        return redirect()->route('product.index')->with('success', 'Catalog and its products deleted successfully');
    }
    //restore
    public function restore($id)
    {
        $catalog = Catalog::withTrashed()->findOrFail($id);
        $catalog->restore();

        // Restore products
        $catalog->products()->withTrashed()->restore();

        return redirect()->route('product.index')->with('success', 'Catalog and products restored successfully.');
    }

    //force-delete
    public function destory($id)
    {
        $catalog = Catalog::onlyTrashed()->findOrFail($id);
        $catalog->forceDelete();

        $catalog->products()->forceDelete();

        return redirect()->back()->with('success', 'Catalog and products permanently deleted.');
    }

    //single product show
    public function view($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        return view('product.productview', compact('product'));
    }
}
