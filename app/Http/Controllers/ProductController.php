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
        // Validate the data
        $validatedData = $request->validate([
            'title' => 'required',
            'main_image' => 'nullable|image|max:2048',
            'categoryid' => 'required|exists:categories,id',
            'description' => 'required',
            'base_price' => 'required|numeric',
            'tax_price' => 'required|numeric',
            'discount_amt' => 'required|numeric',
            'mrp' => 'required|numeric',
            // 'sku.sku.*' => 'required|exists:skus,prefix',
            // 'sku.slug.*' => 'required',
            // 'sku.color.*' => 'required',
            // 'sku.image.*' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            // 'sku.quantity.*' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
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
                    $uniqueNumber = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);
                    $sku = $prefix . '-' . $uniqueNumber;
                } while (DB::table('products')->where('sku', $sku)->exists());

                return $sku;
            }

            // Loop through and save each product
            foreach ($request->sku['slug'] as $i => $slug) {
                $product = new Product();
                $product->catalogid = $catalog->id;
                $product->categoryid = $request->categoryid;
                $product->description = $request->description;
                $product->base_price = $request->base_price;
                $product->tax_price = $request->tax_price;
                $product->discount_amt = $request->discount_amt;
                $product->mrp = $request->mrp;
                $product->sku = generateUniqueNumber($request->sku['sku'][$i]);
                $product->slug = $slug;
                $product->color = $request->sku['color'][$i];
                $product->size = $request->sku['size'][$i] ?? null;

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
                $stock->save();

                // save product transaction

                $transaction = new Stock_Transaction();
                $transaction->product_id = $product->id;
                $transaction->quantity = $request->sku['quantity'][$i];
                $transaction->remarks = 'Initial Stock';
                $transaction->save();
            }

            DB::commit();

            return redirect()->route('product.index')->with('success', 'Products created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to create products: ' . $e->getMessage()]);
        }
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
                $catalogImage = time() . "." . $image->extension();
                $image->move($destinationPath, $catalogImage);
                $input['main_image'] = $catalogImage;
            } else {
                // unset($input['image']);
            }
        }
        $catalog->update($input);
        return redirect()->route('product.index')->with('success', 'Catalog Updated Successfully');
    }

    public function edit ($id)
    {
        // $product = Product::with('productStocks')->findOrFail($id);
        // $categories = Category::all();
        // $skus = Sku::all();
        // return view('product.editproduct', compact('product', 'categories', 'skus'));
        $product = Product::findOrFail($id);
        $stock = Product_Stock::where('product_id', $product->id)->first();
        $catalog = Catalog::find($product->catalogid);
        return view('product.editproduct', compact('product', 'catalog', 'stock'));

       

    }




    // product 
    public function update(Request $request, Product $product)
    {
        // return $request;
        $request->validate([
      
            'base_price' => 'required',
            'tax_price' => 'required',
            'discount_amt' => 'required',
            'mrp' => 'required',
        ]);

    
        $product = Product::find($product->id);
        

        $product->base_price = $request->base_price;
        $product->tax_price = $request->tax_price;
        $product->discount_amt = $request->discount_amt;
        $product->mrp = $request->mrp;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/product'), $imageName);
            $product->image = $imageName;
        }
        $product->save();
        if(isset($request->newStock) && $request->newStock > 0)
        {
        $stock = new Stock_Transaction();
        $stock->product_id = $product->id;
        $stock->quantity = $request->newStock;
        $stock->type = 'in';
        $stock->remarks = 'Stock Update';
        $stock->save();

        $productStock = Product_stock::where('product_id', $product->id)->first();
        $productStock->quantity = $productStock->quantity + $request->newStock;
        $productStock->save();
        }
       
        return redirect()->route('product.index')->with('success', 'Product Updated Successfully');
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

        return redirect()->route('product.index')->with('success', 'Catalog and Products Restored Successfully.');
    }

    //force-delete
    public function destory($id)
    {
        $catalog = Catalog::onlyTrashed()->findOrFail($id);
        $catalog->forceDelete();

        $catalog->products()->forceDelete();

        return redirect()->back()->with('success', 'Catalog and Products Permanently Deleted.');
    }

    //single product show
    public function view($id)
    {
        $product = Product::onlyTrashed()
            ->with(['catalog' => function ($query) {
                $query->withTrashed();
            }])
            ->findOrFail($id);

        return view('product.productview', compact('product'));
    }
    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $product->is_active = 'No';
        $product->save();
        return redirect()->back()->with('success', 'Product Deleted Successfully');
    }
    public function restoreProduct($id)
    {
        $product = Product::find($id);
        $product->is_active = 'Yes';
        $product->save();
        return redirect()->back()->with('success', 'Product Deleted Successfully');
    }
}
