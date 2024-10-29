<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\Sku;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function userCreate(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'contact' => 'required',
            'password' => 'required',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
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
                ],
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
            $skus = Sku::paginate(5);

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
            if (!$category->is_parent && $req->parent) {
                $category->parent = $req->parent;
            } else {
                $category->parent = null;
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
                ->pluck('customer_address');
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

            if ($request->has('orderStatus') && $request->orderStatus != 'select order status') {
                $query->where('orderStatus', $request->orderStatus);
            }
            //find by userId form order table
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
                $query->whereHas('order',  function ($q) use ($request) {
                    $q->where('created_at', 'like', '%' . $request->date . '%');
                });
            }
            $orders = $query->orderBy('created_at', 'desc')->paginate(10);
            return response()->json([
                'status' => true,
                'message' => 'Orders retrieved successfully!',
                'data' => $orders
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while retrieving the orders. Please try again.'], 500);
        }
    }

    public function getCatalog(Request $request)
    {
        try {
            $catalogs = Catalog::all();
            return response()->json([
                'status' => true,
                'data' => $catalogs
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the catalog. Please try again.'], 500);
        }
    }
    public function addCatalog(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'main_image' => 'required',
            ],
            [
                'title.required' => 'Title is required',
                'main_image.required' => 'Description is required',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        try {
            $catalog = new Catalog();
            $catalog->title = $request->title;
            $catalog->main_image = time() . "." . $request->main_image->extension();
            $request->main_image->move(public_path('images/catalog'), $catalog->main_image);
            $catalog->save();
            return response()->json([
                'status' => true,
                'message' => 'Catalog created successfully!',
                'imagePath' => '/images/catalog/' . $catalog->main_image,
                'data' => $catalog
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the catalog. Please try again.'], 500);
        }
    }

    public function catalogProducts()
    {

        $catalogs = Catalog::with('products.getStoke')->with('products.category')->get();
        return response()->json([
            'status' => true,
            'data' => $catalogs
        ]);
    }
}
