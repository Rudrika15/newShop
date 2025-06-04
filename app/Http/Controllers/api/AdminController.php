<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Product_stock;
use App\Models\Sku;
use App\Models\Slider;
use App\Models\Stock_Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function userCreate(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            // 'email' => 'email|unique:users',
            'contact' => 'required',
            'password' => 'required',
        ], [
            'name.required' => 'Name is required',
            // 'email.required' => 'Email is required',
            'contact.required' => 'Contact is required',
            'password.required' => 'Password is required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $user = new User();
            $user->name = $req->name;
            $user->email = $req->email;
            $user->contact = $req->contact;
            $user->password = Hash::make($req->password);
            $user->save();
            $token = $user->createToken('my-app-token')->plainTextToken;

            return response()->json([
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'contact' => $user->contact,
                    'status' => $user->status

                ],

                'status' => true,
                'token' => $token,
                'message' => 'User created successfully!'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the user. Please try again.'], 500);
        }
    }
    public function getAllUsers(Request $req)
    {
        try {
            $users = User::where('status', 'Active')->paginate(10);
            if (count($users) == 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'No data found',
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'User List',
                'data' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while getting the user. Please try again.'], 500);
        }
    }
    public function getTrashUsers()
    {

        try {
            $users = User::where('status', 'Deleted')->paginate(10);
            if (count($users) == 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'No data found',
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'User List',
                'data' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while getting the user. Please try again.'], 500);
        }
    }
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = 'Deleted';
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'User deleted successfully!',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the user. Please try again.'], 500);
        }
    }
    public function restoreUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = 'Active';
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'User restored successfully!',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            Log::error('User creation error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while restoring the user. Please try again.'], 500);
        }
    }
    public function hardDeleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'User deleted permanently successfully!',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            Log::error('User creation error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while permanently deleting the user. Please try again.'], 500);
        }
    }
    public function showUser($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'User details',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while getting the user. Please try again.'], 500);
        }
    }
    public function updateUser(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'contact' => 'required',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'contact.required' => 'Contact is required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        try {
            $user = User::findOrFail($id);
            $user->name = $req->input('name');
            $user->email = $req->input('email');
            $user->contact = $req->input('contact');
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'User updated successfully!',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the user. Please try again.'], 500);
        }
    }

    public function resetPassword($id)
    {
        try {


            $user = User::find($id);
            $user->password = Hash::make('123456');
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'Password reset successfully!',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while getting the reset password. Please try again.'], 500);
        }
    }
    public function getAllSkus()
    {
        try {
            $skus = Sku::all();

            return response()->json([
                'status' => true,
                'message' => 'Sku List',
                'data' => $skus
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while getting the sku. Please try again.'], 500);
        }
    }
    public function storeSku(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'prefix' => 'required',
            'colorname' => 'required'
        ], [
            'prefix.required' => 'Prefix is required',
            'colorname.required' => 'Colorname is required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        try {

            $sku = new Sku();
            $sku->prefix = $req->prefix;
            $sku->colorname = $req->colorname;
            $sku->save();
            return response()->json([
                'status' => true,
                'message' => 'Sku created successfully!',
                'data' => $sku
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the sku. Please try again.'], 500);
        }
    }
    public function showSku($id)
    {
        try {
            $sku = Sku::findOrFail($id);
            return response()->json([
                'status' => true,
                'message' => 'Sku details',
                'data' => $sku
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while getting the sku. Please try again.'], 500);
        }
    }
    public function updateSku(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'prefix' => 'required',
            'colorname' => 'required'
        ], [
            'prefix.required' => 'Prefix is required',
            'colorname.required' => 'Colorname is required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        try {
            $sku = Sku::findOrFail($id);
            $sku->prefix = $req->prefix;
            $sku->colorname = $req->colorname;
            $sku->save();
            return response()->json([
                'status' => true,
                'message' => 'Sku updated successfully!',
                'data' => $sku
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the sku. Please try again.'], 500);
        }
    }
    public function deleteSku($id)
    {
        try {
            $sku = Sku::findOrFail($id);
            $sku->delete();
            return response()->json([
                'status' => true,
                'message' => 'Sku deleted successfully!',
                'data' => $sku
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the sku. Please try again.'], 500);
        }
    }
    public function getAllCategories()
    {
        try {
            $categories = Category::with('parent')->paginate(10);

            return response()->json([
                'status' => true,
                'message' => 'Category List',
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while getting the category. Please try again.'], 500);
        }
    }
    public function storeCategory(Request $req)
    {
        $validator = Validator::make(
            $req->all(),
            [
                'categoryname' => 'required',
                'is_parent' => 'required|boolean',
                'parent' => 'nullable|exists:categories,id',
            ],
            [
                'categoryname.required' => 'Category name is required',
                'is_parent.required' => 'Is parent is required',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        try {

            $newCategory = new Category();
            $newCategory->categoryname = $req->categoryname;
            $newCategory->is_parent = $req->is_parent;

            if ($req->parent) {
                $newCategory->parent = $req->parent;
            }
            $newCategory->save();
            return response()->json([
                'status' => true,
                'message' => 'Category created successfully!',
                'data' => $newCategory
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the category. Please try again.'], 500);
        }
    }
    public function showCategory($id)
    {
        try {
            $category = Category::findOrFail($id);
            return response()->json([
                'status' => true,
                'message' => 'Category details',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while getting the category. Please try again.'], 500);
        }
    }
    public function deleteCategory($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json([
                'status' => true,
                'message' => 'Category deleted successfully!',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the category. Please try again.'], 500);
        }
    }
    public function updateCategory(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'categoryname' => 'required',
            'is_parent' => 'required|boolean',
            'parent' => 'nullable|exists:categories,id',
        ], [
            'categoryname.required' => 'Category name is required',
            'is_parent.required' => 'Is parent is required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        try {
            $category = Category::findOrFail($id);
            $category->categoryname = $req->categoryname;
            $category->is_parent = $req->has('is_parent');
            if ($req->parent) {
                $category->parent = $req->parent;
                $category->is_parent = 0;
            } else {
                $category->parent = null;
                $category->is_parent = 1;
            }
            $category->save();
            return response()->json([
                'status' => true,
                'message' => 'Category updated successfully!',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the category. Please try again.'], 500);
        }
    }
    public function getTrashCategories()
    {
        try {
            $categories = Category::onlyTrashed()->paginate(10);
            return response()->json([
                'status' => true,
                'message' => 'Category List',
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while getting the category. Please try again.'], 500);
        }
    }
    public  function restoreCategory($id)
    {
        try {
            $category = Category::onlyTrashed()->findOrFail($id);
            $category->restore();
            return response()->json([
                'status' => true,
                'message' => 'Category restored successfully!',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while restoring the category. Please try again.'], 500);
        }
    }
    public function hardDeleteCategory($id)

    {
        try {
            $category = Category::onlyTrashed()->findOrFail($id);
            $category->forceDelete();
            return response()->json([
                'status' => true,
                'message' => 'Category deleted successfully!',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the category. Please try again.'], 500);
        }
    }
    public function getAllSliders()
    {
        try {
            $sliders = Slider::where('status', 'Active')->paginate(10);
            return response()->json([
                'status' => true,
                'message' => 'Slider List',
                'data' => $sliders
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while getting the slider. Please try again.'], 500);
        }
    }

    public function getTrashSlider()
    {
        try {
            $sliders = Slider::where('status', 'Deleted')->paginate(10);
            return response()->json([
                'status' => true,
                'message' => 'Slider List',
                'data' => $sliders
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while getting the slider. Please try again.'], 500);
        }
    }
    public function restoreSlider($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            $slider->status = "Active";
            $slider->save();
            return response()->json([
                'status' => true,
                'message' => 'Slider restored successfully!',
                'data' => $slider
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while restoring the slider. Please try again.'], 500);
        }
    }
    public function hardDeleteSlider($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            $slider->delete();

            return response()->json([
                'status' => true,
                'message' => 'Slider deleted successfully!',
                'data' => $slider
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while permanently deleting the slider. Please try again.'], 500);
        }
    }
    public function softDeleteSlider($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            $slider->status = "Deleted";
            $slider->save();
            return response()->json([
                'status' => true,
                'message' => 'Slider deleted successfully!',
                'data' => $slider
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while soft deleting the slider. Please try again.'], 500);
        }
    }
    public function updateSlider($id, Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',

            ],
            [
                'title.required' => 'Title is required',


            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        try {
            $slider = Slider::findOrFail($id);
            $slider->title = $request->title;
            $slider->save();
            return response()->json([
                'status' => true,
                'message' => 'Slider updated successfully!',
                'data' => $slider
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the slider. Please try again.'], 500);
        }
    }
    public function showSlider($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            return response()->json([
                'status' => true,
                'message' => 'Slider retrieved successfully!',
                'data' => $slider
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while retrieving the slider. Please try again.'], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'image' => 'required',
                ],
                [
                    'title.required' => 'Title is required',
                    'image.required' => 'Image is required',
                ]
            );
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ]);
            }
            $slider = new Slider();
            $slider->title = $request->title;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->extension();
                $image->move(public_path('slider'), $imageName);
                $slider->image = $imageName;
            }
            $slider->status = "Active";
            $slider->save();
            return response()->json([
                'status' => true,
                'message' => 'Slider created successfully!',
                'data' => $slider
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the slider. Please try again.'], 500);
        }
    }
    public function stickerPrint(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'from' => 'required',
                'to' => 'required',
            ],
            [
                'from.required' => 'From date is required',
                'to.required' => 'To date is required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $from = $request->from;
            $to = $request->to;

            $stickers = OrderDetail::whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)
                ->with('order.user') // eager load user through order
                ->get()
                ->map(function ($item) {
                    return [
                        'address' => $item->customer_address,
                        'mobile' => $item->order?->user?->contact // safely access mobile
                    ];
                });

            return response()->json([
                'status' => true,
                'message' => 'Stickers retrieved successfully!',
                'data' => $stickers
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while retrieving the stickers. Please try again.'], 500);
        }
    }

    public function getAllOrders(Request $request)

    {
        try {
            $query = OrderDetail::with('product', 'order');


            //find payment id from order 



            if ($request->has('orderStatus')) {
                $query->where('orderStatus', $request->orderStatus);
            }

            // Find by userId from the order table
            if ($request->has('userId')) {
                $query->whereHas('order', function ($q) use ($request) {
                    $q->where('user_id', $request->userId);
                });
            }

            if ($request->has('productName')) {
                $query->whereHas('product', function ($q) use ($request) {
                    $q->where('slug', 'like', '%' . $request->productName . '%');
                });
            }

            if ($request->has('userName')) {
                $query->whereHas('order.users', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->userName . '%');
                });
            }

            if ($request->has('date')) {
                $query->whereHas('order', function ($q) use ($request) {
                    $q->whereDate('created_at', $request->date);
                });
            }


            // Filter by startDate and endDate
            if ($request->has('startDate') && $request->has('endDate')) {
                // Convert startDate and endDate to Carbon instances
                $startDate = \Carbon\Carbon::parse($request->startDate)->format('Y-m-d');
                $endDate = \Carbon\Carbon::parse($request->endDate)->addDay()->format('Y-m-d');

                // Apply whereBetween filter
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $orders = $query->orderBy('created_at', 'desc')->paginate(10);

            foreach ($orders as $order) {
                $orderId = $order->order->payment_id;
                $url = "https://api.cashfree.com/pg/orders/{$orderId}/settlements";

                try {
                    $response = Http::withHeaders([
                        'Content-Type'     => 'application/json',
                        'x-client-id'      => env('CASHFREE_CLIENT_ID'),
                        'x-client-secret'  => env('CASHFREE_CLIENT_SECRET'),
                        'x-api-version'    => '2023-08-01',
                    ])->timeout(30)->withoutVerifying()->get($url);

                    if ($response->successful()) {
                        $data = $response->json();

                        if (!empty($data['transfer_id'])) {
                            $updatestatus = Order::find($order->order_id);
                            $updatestatus->status = 'Setteled';
                            $updatestatus->save();
                        }

                        // return response()->json($data, 200);
                    }
                } catch (\Exception $e) {
                    \Log::error("Cashfree API Error: " . $e->getMessage());
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Orders retrieved successfully!',
                'data' => $orders
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while retrieving the orders. Please try again.'], 500);
        }
    }

    public function getCatalog(Request $request, $id = null)
    {
        try {

            if ($id != null) {
                $catalog = Catalog::find($id);
                return response()->json([
                    'status' => true,
                    'data' => $catalog
                ]);
            } else {
                $catalogs = Catalog::all();
                return response()->json([
                    'status' => true,
                    'data' => $catalogs
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the catalog. Please try again.'], 500);
        }
    }
    public function addCatalog(Request $request)
    {
        // Validate the input
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string|max:255',
                'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Ensure the file is an image
                'description' => 'nullable|string|max:500', // Optional description
            ],
            [
                'title.required' => 'Title is required.',

                'main_image.required' => 'Main image is required.',
                'main_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
                'main_image.max' => 'The image size must not exceed 2MB.',

            ]
        );

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        try {
            $catalog = new Catalog();
            $catalog->title = $request->title;

            $imageName = uniqid('catalog_', true) . '.' . $request->main_image->extension();
            $request->main_image->move(public_path('images/catalog'), $imageName);
            $catalog->main_image = $imageName;


            $catalog->save();

            return response()->json([
                'status' => true,
                'message' => 'Catalog created successfully!',
                'imagePath' => '/images/catalog/' . $catalog->main_image,
                'data' => $catalog
            ]);
        } catch (\Exception $e) {
            // Log the error (optional, for debugging purposes)
            \Log::error('Error creating catalog: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while creating the catalog. Please try again.'
            ], 500);
        }
    }


    public function updateCatalog(Request $request)
    {
        // Validate the input
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:500', // Optional description
            ],
            [
                'title.required' => 'Title is required.',


            ]
        );

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        try {
            $catalog = Catalog::findOrfail($request->id);
            $catalog->title = $request->title;


            if ($request->hasFile('main_image')) {
                $imageName = uniqid('catalog_', true) . '.' . $request->main_image->extension();
                $request->main_image->move(public_path('images/catalog'), $imageName);
                $catalog->main_image = $imageName;
            }


            $catalog->save();

            return response()->json([
                'status' => true,
                'message' => 'Catalog created successfully!',
                'imagePath' => '/images/catalog/' . $catalog->main_image,
                'data' => $catalog
            ]);
        } catch (\Exception $e) {
            // Log the error (optional, for debugging purposes)
            \Log::error('Error creating catalog: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while creating the catalog. Please try again.'
            ], 500);
        }
    }


    public function catalogProducts1()
    {

        $catalogs = Catalog::with('products.getStoke')->with('products.category')->get();
        return response()->json([
            'status' => true,
            'data' => $catalogs
        ]);
    }
    public function catalogs()
    {

        $catalogs = Catalog::with('products.getStoke')->with('products.category')->get();
        return response()->json([
            'status' => true,
            'data' => $catalogs
        ]);
    }

    // product
    public function getProducts($id = null)
    {
        try {
            if ($id == null) {


                $products = Product::all();
            } else {
                $products = Product::where('catalogid', $id)->get();
            }
            return response()->json([
                'status' => true,
                'data' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while retrieving the products. Please try again.'], 500);
        }
    }

    public function addProduct(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'catalogid' => 'required',
                'sku' => 'required',
                'categoryid' => 'required',
                'color' => 'required',
                'size' => 'required',
                'image' => 'required',
                'description' => 'required',
                'base_price' => 'required',
                'tax_price' => 'required',
                // 'discount_amt' => 'required',
                'mrp' => 'required',
                'quantity' => 'required',
            ],
            [
                'catalogid.required' => 'catalogid is required',
                'sku.required' => 'sku is required',
                'categoryid.required' => 'categoryid is required',
                'color.required' => 'color is required',
                'size.required' => 'size is required',
                'image.required' => 'image is required',
                'description.required' => 'description is required',
                'base_price.required' => 'base_price is required',
                'tax_price.required' => 'tax_price is required',
                // 'discount_amt.required' => 'discount_amt is required',
                'mrp.required' => 'mrp is required',
                'quantity.required' => 'quantity is required',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        try {
            $product = new Product();
            $product->catalogid = $request->catalogid;
            $product->slug = $request->slug;
            $product->sku = $request->sku;
            $product->categoryid = $request->categoryid;
            $product->color = $request->color;
            $product->size = $request->size;
            $product->description = $request->description;
            $product->base_price = $request->base_price;
            $product->tax_price = $request->tax_price;
            $product->discount_amt = $request->discount_amt;
            $product->discount_type = $request->discount_type;
            $product->mrp = $request->mrp;
            $product->image = time() . "." . $request->image->extension();
            $request->image->move(public_path('images/product'), $product->image);
            $product->save();

            $stock = new Stock_Transaction();
            $stock->product_id = $product->id;
            $stock->quantity = $request->quantity;
            $stock->type = 'in';
            $stock->remarks = 'Initial Stock';
            $stock->save();

            // find sum for pproduct
            $qty =  Stock_Transaction::where('product_id', $product->id)->sum('quantity');

            $finalStock = new Product_stock();
            $finalStock->product_id = $product->id;
            $finalStock->quantity = $qty;
            $finalStock->save();

            return response()->json([
                'status' => true,
                'message' => 'Product created successfully!',
                'imagePath' => '/images/product/' . $product->image,
                'data' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => 'An error occurred while creating the product. Please try again.',
                    'message' => $e->getMessage()
                ],
                500
            );
        }
    }



    public function updateProduct(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'catalogid' => 'required',
                'sku' => 'required',
                'categoryid' => 'required',
                'color' => 'required',
                'size' => 'required',
                'description' => 'required',
                'base_price' => 'required',
                'tax_price' => 'required',
                'discount_amt' => 'required',
                'mrp' => 'required',

            ],
            [
                'catalogid.required' => 'catalogid is required',
                'sku.required' => 'sku is required',
                'categoryid.required' => 'categoryid is required',
                'color.required' => 'color is required',
                'size.required' => 'size is required',
                'description.required' => 'description is required',
                'base_price.required' => 'base_price is required',
                'tax_price.required' => 'tax_price is required',
                'discount_amt.required' => 'discount_amt is required',
                'mrp.required' => 'mrp is required',

            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        try {
            $product = Product::findOrFail($request->id);
            $product->catalogid = $request->catalogid;
            $product->slug = $request->slug;
            $product->sku = $request->sku;
            $product->categoryid = $request->categoryid;
            $product->color = $request->color;
            $product->size = $request->size;
            $product->description = $request->description;
            $product->base_price = $request->base_price;
            $product->tax_price = $request->tax_price;
            $product->discount_amt = $request->discount_amt;
            $product->mrp = $request->mrp;
            $product->discount_type = $request->discount_type;


            if ($request->hasFile('image')) {
                $product->image = time() . "." . $request->image->extension();
                $request->image->move(public_path('images/product'), $product->image);
            }

            $product->save();

            return response()->json([
                'status' => true,
                'message' => 'Product updated successfully!',
                'imagePath' => '/images/product/' . $product->image,
                'data' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => 'An error occurred while updating the product. Please try again.',
                    'message' => $e->getMessage()
                ],
                500
            );
        }
    }

    public function getProductDetail($productId)
    {
        $product = Product::where('id', $productId)
            ->with('productStocks')
            ->with('catalog')
            ->with('sku')
            ->with('category')
            ->first();
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }
        return response()->json([
            'status' => true,
            'data' => $product
        ]);
    }
    public function catalogDelete(string $id)
    {
        $catalog = Catalog::findOrFail($id);

        foreach ($catalog->products as $product) {
            $product->delete();
        }
        $catalog->delete();
        return response()->json([
            'status' => true,
            'message' => 'Catalog and its products deleted successfully'
        ]);
    }
    public function catalog_trash()
    {

        try {
            $catalogs = Catalog::onlyTrashed()->get();
            return response()->json([
                'status' => true,
                'data' => $catalogs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred: ' . $e->getMessage(), // Add exception message here
                'trace' => $e->getTrace() // Optional: include trace for debugging
            ]);
        }
    }

    public function catalogHardDelete($id)
    {
        // Retrieve the soft-deleted catalog by ID
        $catalog = Catalog::onlyTrashed()->find($id);

        // Check if the catalog exists
        if (!$catalog) {
            return response()->json([
                'status' => false,
                'message' => 'Catalog not found or is not deleted.'
            ]);
        }

        // Check if the catalog has associated products
        if ($catalog->products()->count() > 0) {
            return response()->json([
                'status' => false,
                'message' => 'Cannot delete, there are products associated with this catalog.'
            ]);
        }

        // Permanently delete the catalog and associated products
        $catalog->forceDelete();
        $catalog->products()->forceDelete();

        return response()->json([
            'status' => true,
            'message' => 'Catalog permanently deleted.'
        ]);
    }

    public function catalogRestore($id)
    {
        $catalog = Catalog::withTrashed()->findOrFail($id);
        $catalog->restore();

        // Restore products
        $catalog->products()->withTrashed()->restore();

        return response()->json([
            'status' => true,
            'message' => 'Catalog Restored Successfully.'
        ]);
    }
    public function productDelete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product Deleted Successfully'
        ]);
    }
    public function trashProduct()
    {
        try {
            // Retrieve soft-deleted products
            $products = Product::onlyTrashed()->get();

            // Return successful response with data
            return response()->json([
                'status' => true,
                'data' => $products
            ]);
        } catch (\Throwable $th) {
            // Log the error for debugging
            \Log::error('Error retrieving trashed products: ' . $th->getMessage());

            // Return a user-friendly error message
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching trashed products. Please try again later.'
            ], 500);
        }
    }
    public function deletedProduct()
    {
        $products = Product::onlyTrashed()->get();
        return response()->json([
            'status' => true,
            'data' => $products
        ]);
    }

    public function productHardDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();
        return response()->json([
            'status' => true,
            'message' => 'Product Permanently Deleted'
        ]);
    }
    public function productRestore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return response()->json([
            'status' => true,
            'message' => 'Product Restored Successfully'
        ]);
    }
    public function getStock($id)
    {
        try {
            $stock = Product_stock::where('product_id', $id)->get();
            return response()->json([
                'status' => true,
                'message' => 'Stock fetched successfully',
                'data' => $stock
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateOrderStatus(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'status' => 'required',
            ],
            [
                'id.required' => 'Order Detail ID is required',
                'status.required' => 'status is required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $orderDetail = OrderDetail::findOrFail($request->id);
            $orderDetail->orderStatus = $request->status;
            $orderDetail->save();
            return response()->json([
                'status' => true,
                'message' => 'Order status updated successfully',
                'data' => $orderDetail
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateProductStock(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'product_id' => 'required',
                'quantity' => 'required|integer|min:1',
            ],
            [
                'product_id.required' => 'Product ID is required',
                'quantity.required' => 'Quantity is required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $stockTranjection = Stock_Transaction::create([
                'product_id' => $request->product_id,
                'type' => $request->type,
                'quantity' => $request->quantity,
                'remarks' => $request->remarks,
            ]);
            $getStock = Stock_Transaction::where('id', $stockTranjection->id)->sum('quantity');
            $stock = Product_stock::where('product_id', $request->product_id)->first();
            $stock->quantity = $stock->quantity + $getStock;
            $stock->save();
            return response()->json([
                'status' => true,
                'message' => 'Stock updated successfully',
                'data' => $getStock
            ]);
        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('Stock update failed: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating stock. Please try again later.',
            ]);
        }
    }
}
