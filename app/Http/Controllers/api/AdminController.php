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
    /**
 * @OA\Post(
 *     path="/api/user-create",
 *     tags={"Users"},
 *     summary="Create new user",
 *     security={{"sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","contact","password"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="contact", type="string", example="9876543210"),
 *             @OA\Property(property="password", type="string", example="123456")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="User created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="User created successfully!"),
 *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJh...")
 *         )
 *     ),
 *     @OA\Response(response=400, description="Validation failed"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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
            $user->status = "Active";
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

  /**
 * @OA\Get(
 *     path="/api/user-list",
 *     tags={"Users"},
 *     summary="Get all active users (paginated)",
 *     security={{"sanctum":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="User List",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="User List"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="current_page", type="integer", example=1),
 *                 @OA\Property(
 *                     property="data",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(property="id", type="integer", example=1),
 *                         @OA\Property(property="name", type="string", example="John Doe"),
 *                         @OA\Property(property="email", type="string", example="john@example.com"),
 *                         @OA\Property(property="contact", type="string", example="9876543210"),
 *                         @OA\Property(property="status", type="string", example="Active"),
 *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-05T10:00:00Z"),
 *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-05T10:00:00Z")
 *                     )
 *                 ),
 *                 @OA\Property(property="first_page_url", type="string", example="http://localhost/api/user-list?page=1"),
 *                 @OA\Property(property="last_page", type="integer", example=5),
 *                 @OA\Property(property="last_page_url", type="string", example="http://localhost/api/user-list?page=5"),
 *                 @OA\Property(property="per_page", type="integer", example=10),
 *                 @OA\Property(property="total", type="integer", example=50)
 *             )
 *         )
 *     ),
 *     @OA\Response(response=401, description="Unauthenticated"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */



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

    /**
 * @OA\Get(
 *     path="/api/user-trash",
 *     tags={"Users"},
 *     summary="Get all deleted users (paginated)",
 *     security={{"sanctum":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Trash User List"
 *     ),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\Delete(
 *     path="/api/user-delete/{id}",
 *     tags={"Users"},
 *     summary="Soft delete a user (mark as Deleted)",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id", in="path", required=true, description="User ID", @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully"
 *     ),
 *     @OA\Response(response=404, description="User not found"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\Put(
 *     path="/api/user-restore/{id}",
 *     tags={"Users"},
 *     summary="Restore a deleted user (mark as Active)",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id", in="path", required=true, description="User ID", @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User restored successfully"
 *     ),
 *     @OA\Response(response=404, description="User not found"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\Delete(
 *     path="/api/user-hard-delete/{id}",
 *     tags={"Users"},
 *     summary="Permanently delete a user",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id", in="path", required=true, description="User ID", @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted permanently"
 *     ),
 *     @OA\Response(response=404, description="User not found"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\Get(
 *     path="/api/user-show/{id}",
 *     tags={"Users"},
 *     summary="Get user details by ID",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id", in="path", required=true, description="User ID", @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User details"
 *     ),
 *     @OA\Response(response=404, description="User not found"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\patch(
 *     path="/api/user-update/{id}",
 *     tags={"Users"},
 *     summary="Update user details",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id", in="path", required=true, description="User ID", @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","email","contact"},
 *             @OA\Property(property="name", type="string", example="Jane Doe"),
 *             @OA\Property(property="email", type="string", example="jane@example.com"),
 *             @OA\Property(property="contact", type="string", example="9998887777")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully"
 *     ),
 *     @OA\Response(response=400, description="Validation failed"),
 *     @OA\Response(response=404, description="User not found"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\patch(
 *     path="/api/user-reset-password/{id}",
 *     tags={"Users"},
 *     summary="Reset user password (default: 123456)",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id", in="path", required=true, description="User ID", @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Password reset successfully"
 *     ),
 *     @OA\Response(response=404, description="User not found"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\Get(
 *     path="/api/sku-list",
 *     tags={"Skus"},
 *     summary="Get all SKUs",
 *     security={{"sanctum":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="SKU List",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Sku List"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="prefix", type="string", example="PRFX001"),
 *                     @OA\Property(property="colorname", type="string", example="Red"),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-05T10:00:00Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-05T10:00:00Z")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\Post(
 *     path="/api/sku-create",
 *     tags={"Skus"},
 *     summary="Create a new SKU",
 *     security={{"sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"prefix", "colorname"},
 *             @OA\Property(property="prefix", type="string", example="PRFX002"),
 *             @OA\Property(property="colorname", type="string", example="Blue")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="SKU created successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Sku created successfully!"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="prefix", type="string", example="PRFX002"),
 *                 @OA\Property(property="colorname", type="string", example="Blue"),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=400, description="Validation error"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\Get(
 *     path="/api/sku-show/{id}",
 *     tags={"Skus"},
 *     summary="Get SKU details by ID",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="SKU ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="SKU details",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Sku details"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="prefix", type="string", example="PRFX001"),
 *                 @OA\Property(property="colorname", type="string", example="Red"),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=404, description="SKU not found"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

/**
 * @OA\post(
 *     path="/api/sku-update/{id}",
 *     tags={"Skus"},
 *     summary="Update an existing SKU",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="SKU ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"prefix", "colorname"},
 *             @OA\Property(property="prefix", type="string", example="PRFX003"),
 *             @OA\Property(property="colorname", type="string", example="Green")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="SKU updated successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Sku updated successfully!"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="prefix", type="string", example="PRFX003"),
 *                 @OA\Property(property="colorname", type="string", example="Green"),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=400, description="Validation error"),
 *     @OA\Response(response=404, description="SKU not found"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\Delete(
 *     path="/api/sku-delete/{id}",
 *     tags={"Skus"},
 *     summary="Delete SKU by ID",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="SKU ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="SKU deleted successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Sku deleted successfully!"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="prefix", type="string", example="PRFX001"),
 *                 @OA\Property(property="colorname", type="string", example="Red"),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=404, description="SKU not found"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\Get(
 *     path="/api/category-list",
 *     tags={"Categories"},
 *     summary="Get all categories (paginated)",
 *     security={{"sanctum":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Category List",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Category List"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 description="Pagination object containing categories",
 *                 @OA\Property(property="current_page", type="integer", example=1),
 *                 @OA\Property(
 *                     property="data",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(property="id", type="integer", example=1),
 *                         @OA\Property(property="categoryname", type="string", example="Electronics"),
 *                         @OA\Property(property="is_parent", type="boolean", example=true),
 *                         @OA\Property(property="parent", type="integer", nullable=true, example=null),
 *                         @OA\Property(property="created_at", type="string", format="date-time"),
 *                         @OA\Property(property="updated_at", type="string", format="date-time")
 *                     )
 *                 ),
 *                 @OA\Property(property="per_page", type="integer", example=10),
 *                 @OA\Property(property="total", type="integer", example=100)
 *             )
 *         )
 *     ),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\Post(
 *     path="/api/category-store",
 *     tags={"Categories"},
 *     summary="Create a new category",
 *     security={{"sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"categoryname","is_parent"},
 *             @OA\Property(property="categoryname", type="string", example="Clothing"),
 *             @OA\Property(property="is_parent", type="boolean", example=true),
 *             @OA\Property(property="parent", type="integer", nullable=true, example=null)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Category created successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Category created successfully!"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="categoryname", type="string", example="Clothing"),
 *                 @OA\Property(property="is_parent", type="boolean", example=true),
 *                 @OA\Property(property="parent", type="integer", nullable=true, example=null),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=400, description="Validation error"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\Get(
 *     path="/api/category-show/{id}",
 *     tags={"Categories"},
 *     summary="Get category details by ID",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(name="id", in="path", required=true, description="Category ID", @OA\Schema(type="integer", example=1)),
 *     @OA\Response(
 *         response=200,
 *         description="Category details",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Category details"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="categoryname", type="string", example="Electronics"),
 *                 @OA\Property(property="is_parent", type="boolean", example=true),
 *                 @OA\Property(property="parent", type="integer", nullable=true, example=null),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=404, description="Category not found"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\Delete(
 *     path="/api/category-delete/{id}",
 *     tags={"Categories"},
 *     summary="Soft delete category by ID",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(name="id", in="path", required=true, description="Category ID", @OA\Schema(type="integer", example=1)),
 *     @OA\Response(
 *         response=200,
 *         description="Category deleted successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Category deleted successfully!"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(response=404, description="Category not found"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\post(
 *     path="/api/category-update/{id}",
 *     tags={"Categories"},
 *     summary="Update an existing category",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(name="id", in="path", required=true, description="Category ID", @OA\Schema(type="integer", example=1)),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"categoryname","is_parent"},
 *             @OA\Property(property="categoryname", type="string", example="Updated Electronics"),
 *             @OA\Property(property="is_parent", type="boolean", example=false),
 *             @OA\Property(property="parent", type="integer", nullable=true, example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category updated successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Category updated successfully!"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(response=400, description="Validation error"),
 *     @OA\Response(response=404, description="Category not found"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\Get(
 *     path="/api/category-trash",
 *     tags={"Categories"},
 *     summary="Get all trashed categories",
 *     security={{"sanctum":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Trashed Category List",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Category List"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\post(
 *     path="/api/category-restore/{id}",
 *     tags={"Categories"},
 *     summary="Restore a soft-deleted category",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(name="id", in="path", required=true, description="Category ID", @OA\Schema(type="integer", example=1)),
 *     @OA\Response(
 *         response=200,
 *         description="Category restored successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Category restored successfully!"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(response=404, description="Category not found"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\post(
 *     path="/api/category-hard-delete/{id}",
 *     tags={"Categories"},
 *     summary="Permanently delete category by ID",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(name="id", in="path", required=true, description="Category ID", @OA\Schema(type="integer", example=1)),
 *     @OA\Response(
 *         response=200,
 *         description="Category permanently deleted successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Category deleted successfully!"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(response=404, description="Category not found"),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\Get(
 *     path="/api/slider-list",
 *     tags={"Sliders"},
 *     summary="Get all active sliders (paginated)",
 *     security={{"sanctum":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Slider List",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Slider List"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(response=500, description="Server error")
 * )
 */

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

    /**
 * @OA\Get(
 *     path="/api/slider-trash",
 *     tags={"Sliders"},
 *     summary="Get all deleted sliders (paginated)",
 *     security={{"sanctum":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Slider Trash List",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Slider List"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     )
 * )
 */

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

    /**
 * @OA\post(
 *     path="/api/slider-restore/{id}",
 *     tags={"Sliders"},
 *     summary="Restore a deleted slider",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Slider ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Slider restored successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Slider restored successfully!"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     )
 * )
 */

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

    /**
 * @OA\post(
 *     path="/api/slider-hard-delete/{id}",
 *     tags={"Sliders"},
 *     summary="Hard delete a slider (permanent delete)",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Slider ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Slider deleted permanently",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Slider deleted successfully!"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     )
 * )
 */

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

    /**
 * @OA\post(
 *     path="/api/slider-soft-delete/{id}",
 *     tags={"Sliders"},
 *     summary="Soft delete a slider (set status = Deleted)",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Slider ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Slider soft deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Slider deleted successfully!"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     )
 * )
 */

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

    /**
 * @OA\post(
 *     path="/api/slider-update/{id}",
 *     tags={"Sliders"},
 *     summary="Update a slider by ID",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Slider ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title"},
 *             @OA\Property(property="title", type="string", example="Updated Title")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Slider updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Slider updated successfully!"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     )
 * )
 */

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

    /**
 * @OA\Get(
 *     path="/api/slider-show/{id}",
 *     tags={"Sliders"},
 *     summary="Get a single slider by ID",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Slider ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Slider retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Slider retrieved successfully!"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     )
 * )
 */

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

    /**
 * @OA\Post(
 *     path="/api/slider-create",
 *     tags={"Sliders"},
 *     summary="Create a new slider",
 *     security={{"sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"title","image"},
 *                 @OA\Property(property="title", type="string", example="Summer Collection"),
 *                 @OA\Property(property="image", type="string", format="binary")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Slider created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Slider created successfully!"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     )
 * )
 */

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

    /**
 * @OA\Post(
 *     path="/api/sticker-print",
 *     tags={"Orders"},
 *     summary="Get stickers (customer address & mobile) by date range",
 *     description="Fetches order stickers (address and mobile) within a given date range based on order details.",
 *     security={{"sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"from","to"},
 *             @OA\Property(property="from", type="string", format="date", example="2025-09-01", description="Start date (YYYY-MM-DD)"),
 *             @OA\Property(property="to", type="string", format="date", example="2025-09-06", description="End date (YYYY-MM-DD)")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Stickers retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Stickers retrieved successfully!"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="address", type="string", example="123, Main Street, City"),
 *                     @OA\Property(property="mobile", type="string", example="+91 9876543210")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="From date is required")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="An error occurred while retrieving the stickers. Please try again.")
 *         )
 *     )
 * )
 */

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
                        'qrid' => $item->id // safely access mobile
                    ];
                });

                // $stickers = OrderDetail::whereDate('created_at', '>=', $from)
                // ->whereDate('created_at', '<=', $to)
                // ->with('order.user') // eager load user through order
                // ->get();



            return response()->json([
                'status' => true,
                'message' => 'Stickers retrieved successfully!',
                'data' => $stickers
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while retrieving the stickers. Please try again.'], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/api/order-list",
 *     tags={"Orders"},
 *     summary="Get all orders with filters",
 *     description="Retrieve paginated orders with filters such as status, user, product, and date range. Also syncs settlement status with Cashfree API.",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="orderStatus",
 *         in="query",
 *         required=false,
 *         description="Filter by order status",
 *         @OA\Schema(type="string", example="Pending")
 *     ),
 *     @OA\Parameter(
 *         name="userId",
 *         in="query",
 *         required=false,
 *         description="Filter by user ID (from orders table)",
 *         @OA\Schema(type="integer", example=12)
 *     ),
 *     @OA\Parameter(
 *         name="productName",
 *         in="query",
 *         required=false,
 *         description="Filter by product slug (partial match)",
 *         @OA\Schema(type="string", example="samsung-galaxy-s22")
 *     ),
 *     @OA\Parameter(
 *         name="userName",
 *         in="query",
 *         required=false,
 *         description="Filter by user name (partial match)",
 *         @OA\Schema(type="string", example="John Doe")
 *     ),
 *     @OA\Parameter(
 *         name="date",
 *         in="query",
 *         required=false,
 *         description="Filter by specific order date (YYYY-MM-DD)",
 *         @OA\Schema(type="string", format="date", example="2025-09-05")
 *     ),
 *     @OA\Parameter(
 *         name="startDate",
 *         in="query",
 *         required=false,
 *         description="Filter by start date (YYYY-MM-DD). Must be used with endDate.",
 *         @OA\Schema(type="string", format="date", example="2025-09-01")
 *     ),
 *     @OA\Parameter(
 *         name="endDate",
 *         in="query",
 *         required=false,
 *         description="Filter by end date (YYYY-MM-DD). Must be used with startDate.",
 *         @OA\Schema(type="string", format="date", example="2025-09-06")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Orders retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Orders retrieved successfully!"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 description="Paginated orders",
 *                 @OA\Property(property="current_page", type="integer", example=1),
 *                 @OA\Property(property="per_page", type="integer", example=10),
 *                 @OA\Property(property="total", type="integer", example=25),
 *                 @OA\Property(
 *                     property="data",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(property="id", type="integer", example=101),
 *                         @OA\Property(property="order_id", type="integer", example=55),
 *                         @OA\Property(property="orderStatus", type="string", example="Pending"),
 *                         @OA\Property(
 *                             property="product",
 *                             type="object",
 *                             @OA\Property(property="id", type="integer", example=5),
 *                             @OA\Property(property="name", type="string", example="Samsung Galaxy S22"),
 *                             @OA\Property(property="slug", type="string", example="samsung-galaxy-s22")
 *                         ),
 *                         @OA\Property(
 *                             property="order",
 *                             type="object",
 *                             @OA\Property(property="id", type="integer", example=55),
 *                             @OA\Property(property="payment_id", type="string", example="pay_123456789"),
 *                             @OA\Property(property="status", type="string", example="Settled"),
 *                             @OA\Property(
 *                                 property="user",
 *                                 type="object",
 *                                 @OA\Property(property="id", type="integer", example=12),
 *                                 @OA\Property(property="name", type="string", example="John Doe"),
 *                                 @OA\Property(property="contact", type="string", example="+91 9876543210")
 *                             )
 *                         )
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="An error occurred while retrieving the orders. Please try again.")
 *         )
 *     )
 * )
 */

    public function getAllOrders(Request $request)

    {
        try {
            $query = OrderDetail::with('product', 'order');


            // find payment id from order



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

  /**
 * @OA\Get(
 *     path="/api/catalog/{id}",
 *     tags={"Catalog"},
 *     summary="Get catalog by ID",
 *     description="Retrieve a single catalog by its ID.",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Catalog ID",
 *         @OA\Schema(type="integer", example=4)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Catalog retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=4),
 *                 @OA\Property(property="title", type="string", example="Hand work"),
 *                 @OA\Property(property="main_image", type="string", example="catalog_68b305e327de83.92394428.jpg"),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-30T19:38:35.000000Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-01T12:58:42.000000Z"),
 *                 @OA\Property(property="deleted_at", type="string", nullable=true, example=null)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */



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

    /**
 * @OA\Post(
 *     path="/api/catalog",
 *     tags={"Catalog"},
 *     summary="Add a new catalog",
 *     description="Create a new catalog with a title, image, and optional description.",
 *     security={{"sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"title", "main_image"},
 *                 @OA\Property(property="title", type="string", example="Electronics"),
 *                 @OA\Property(property="description", type="string", example="All electronic products"),
 *                 @OA\Property(property="main_image", type="string", format="binary", description="Upload an image")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Catalog created successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Catalog created successfully!"),
 *             @OA\Property(property="imagePath", type="string", example="/images/catalog/catalog_123.jpg"),
 *             @OA\Property(property="data", type="object", example={"id": 1, "title": "Electronics", "main_image": "catalog_123.jpg"})
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */

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

    /**
 * @OA\Post(
 *     path="/api/catalog/{id}",
 *     tags={"Catalog"},
 *     summary="Update an existing catalog",
 *     description="Update catalog title, description, and optionally replace its main image.",
 *     security={{"sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"id", "title"},
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="title", type="string", example="Updated Electronics"),
 *                 @OA\Property(property="description", type="string", example="Updated description"),
 *                 @OA\Property(property="main_image", type="string", format="binary", description="Upload a new image (optional)")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Catalog updated successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Catalog created successfully!"),
 *             @OA\Property(property="imagePath", type="string", example="/images/catalog/catalog_123.jpg"),
 *             @OA\Property(property="data", type="object", example={"id": 1, "title": "Updated Electronics", "main_image": "catalog_123.jpg"})
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */


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


  /**
 * @OA\Get(
 *     path="/api/catalog/products1",
 *     tags={"Catalog"},
 *     summary="Get catalogs with products (with stock and category)",
 *     description="Retrieve all catalogs along with their products, stock, and categories.",
 *     security={{"sanctum":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Catalogs retrieved successfully",
 *         @OA\JsonContent(
 *             example={
 *                 "status": true,
 *                 "data": {
 *                     {
 *                         "id": 1,
 *                         "title": "Electronics",
 *                         "main_image": "catalog_123.jpg",
 *                         "products": {
 *                             {
 *                                 "id": 101,
 *                                 "name": "Samsung Galaxy S22",
 *                                 "slug": "samsung-galaxy-s22",
 *                                 "getStoke": {"id": 55, "quantity": 20},
 *                                 "category": {"id": 3, "name": "Smartphones"}
 *                             }
 *                         }
 *                     }
 *                 }
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */


    public function catalogProducts1()
    {

        $catalogs = Catalog::with('products.getStoke')->with('products.category')->get();
        return response()->json([
            'status' => true,
            'data' => $catalogs
        ]);
    }

    /**
 * @OA\Get(
 *     path="/api/catalogs",
 *     tags={"Catalog"},
 *     summary="Get all catalogs with products",
 *     description="Retrieve all catalogs along with their products, stock, and categories.",
 *     security={{"sanctum":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Catalogs retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="title", type="string", example="Electronics"),
 *                     @OA\Property(property="main_image", type="string", example="catalog_123.jpg"),
 *                     @OA\Property(
 *                         property="products",
 *                         type="array",
 *                         @OA\Items(
 *                             type="object",
 *                             @OA\Property(property="id", type="integer", example=101),
 *                             @OA\Property(property="name", type="string", example="Samsung Galaxy S22"),
 *                             @OA\Property(property="slug", type="string", example="samsung-galaxy-s22"),
 *                             @OA\Property(
 *                                 property="getStoke",
 *                                 type="object",
 *                                 example={"id": 55, "quantity": 20}
 *                             ),
 *                             @OA\Property(
 *                                 property="category",
 *                                 type="object",
 *                                 example={"id": 3, "name": "Smartphones"}
 *                             )
 *                         )
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */

    public function catalogs()
    {

        $catalogs = Catalog::with('products.getStoke')->with('products.category')->get();
        return response()->json([
            'status' => true,
            'data' => $catalogs
        ]);
    }

    // product

/**
 * @OA\Get(
 *     path="/api/products/{id}",
 *     tags={"Products"},
 *     summary="Get products",
 *     description="Retrieve all products or products by catalog ID (optional).",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=false,
 *         description="Catalog ID (optional). If not provided, all products are returned.",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Products retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=101),
 *                     @OA\Property(property="catalogid", type="integer", example=1),
 *                     @OA\Property(property="sku", type="string", example="SKU12345"),
 *                     @OA\Property(property="categoryid", type="integer", example=5),
 *                     @OA\Property(property="color", type="string", example="Black"),
 *                     @OA\Property(property="size", type="string", example="M"),
 *                     @OA\Property(property="description", type="string", example="A sample product"),
 *                     @OA\Property(property="base_price", type="number", format="float", example=500),
 *                     @OA\Property(property="tax_price", type="number", format="float", example=50),
 *                     @OA\Property(property="discount_amt", type="number", format="float", example=20),
 *                     @OA\Property(property="discount_type", type="string", example="flat"),
 *                     @OA\Property(property="mrp", type="number", format="float", example=530),
 *                     @OA\Property(property="image", type="string", example="product_123.jpg"),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-06T10:15:30Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-06T10:15:30Z")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="An error occurred while retrieving the products. Please try again.")
 *         )
 *     )
 * )
 */



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

    /**
 * @OA\Post(
 *     path="/api/product",
 *     tags={"Products"},
 *     summary="Add a new product",
 *     description="Create a new product with details and initial stock.",
 *     security={{"sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"catalogid","sku","categoryid","color","size","image","description","base_price","tax_price","mrp","quantity"},
 *                 @OA\Property(property="catalogid", type="integer", example=1),
 *                 @OA\Property(property="slug", type="string", example="sample-product"),
 *                 @OA\Property(property="sku", type="string", example="SKU12345"),
 *                 @OA\Property(property="categoryid", type="integer", example=5),
 *                 @OA\Property(property="color", type="string", example="Black"),
 *                 @OA\Property(property="size", type="string", example="M"),
 *                 @OA\Property(property="description", type="string", example="A sample product"),
 *                 @OA\Property(property="base_price", type="number", format="float", example=500),
 *                 @OA\Property(property="tax_price", type="number", format="float", example=50),
 *                 @OA\Property(property="discount_amt", type="number", format="float", example=20),
 *                 @OA\Property(property="discount_type", type="string", example="flat"),
 *                 @OA\Property(property="mrp", type="number", format="float", example=530),
 *                 @OA\Property(property="quantity", type="integer", example=10),
 *                 @OA\Property(property="image", type="string", format="binary")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product created successfully",
 *         @OA\JsonContent(
 *             example={
 *                 "status": true,
 *                 "message": "Product created successfully!",
 *                 "imagePath": "/images/product/product_123.jpg",
 *                 "data": {"id": 101, "catalogid": 1, "sku": "SKU12345"}
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */

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


    /**
 * @OA\post(
 *     path="/api/product/{id}",
 *     tags={"Products"},
 *     summary="Update an existing product",
 *     description="Update product details and optionally update its image.",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer", example=101)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"catalogid","sku","categoryid","color","size","description","base_price","tax_price","discount_amt","mrp"},
 *                 @OA\Property(property="catalogid", type="integer", example=1),
 *                 @OA\Property(property="slug", type="string", example="sample-product"),
 *                 @OA\Property(property="sku", type="string", example="SKU12345"),
 *                 @OA\Property(property="categoryid", type="integer", example=5),
 *                 @OA\Property(property="color", type="string", example="Red"),
 *                 @OA\Property(property="size", type="string", example="L"),
 *                 @OA\Property(property="description", type="string", example="Updated product description"),
 *                 @OA\Property(property="base_price", type="number", format="float", example=550),
 *                 @OA\Property(property="tax_price", type="number", format="float", example=55),
 *                 @OA\Property(property="discount_amt", type="number", format="float", example=15),
 *                 @OA\Property(property="discount_type", type="string", example="percentage"),
 *                 @OA\Property(property="mrp", type="number", format="float", example=600),
 *                 @OA\Property(property="image", type="string", format="binary")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product updated successfully",
 *         @OA\JsonContent(
 *             example={
 *                 "status": true,
 *                 "message": "Product updated successfully!",
 *                 "imagePath": "/images/product/product_123.jpg",
 *                 "data": {"id": 101, "catalogid": 1, "sku": "SKU12345"}
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */


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

    /**
 * @OA\get(
 *     path="/api/catalog/delete/{id}",
 *     tags={"Catalogs"},
 *     summary="Delete a catalog and its products",
 *     description="Deletes a catalog and all associated products",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Catalog ID",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Catalog deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Catalog and its products deleted successfully")
 *         )
 *     ),
 *     security={{"sanctum":{}}}
 * )
 */
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

   /**
 * @OA\Get(
 *     path="/api/catalog_trash",
 *     tags={"Catalogs"},
 *     summary="Get soft-deleted catalogs",
 *     description="Retrieve all catalogs that are in the trash (soft deleted)",
 *     @OA\Response(
 *         response=200,
 *         description="List of soft-deleted catalogs",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Electronics"),
 *                     @OA\Property(property="status", type="string", example="Active"),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-06T10:00:00Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-06T10:00:00Z")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error retrieving catalogs",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="An error occurred")
 *         )
 *     ),
 *     security={{"sanctum":{}}}
 * )
 */

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

    /**
 * @OA\get(
 *     path="/api/catalog/hardDelete/{id}",
 *     tags={"Catalogs"},
 *     summary="Permanently delete a catalog",
 *     description="Permanently deletes a soft-deleted catalog if it has no associated products",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Catalog ID",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Catalog permanently deleted",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Catalog permanently deleted.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Catalog not found or not deleted",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Catalog not found or is not deleted.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Catalog has associated products",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Cannot delete, there are products associated with this catalog.")
 *         )
 *     ),
 *     security={{"sanctum":{}}}
 * )
 */

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

    /**
 * @OA\get(
 *     path="/api/catalog/restore/{id}",
 *     tags={"Catalogs"},
 *     summary="Restore a soft-deleted catalog",
 *     description="Restores a catalog and all its soft-deleted products",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Catalog ID",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Catalog restored successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Catalog Restored Successfully.")
 *         )
 *     ),
 *     security={{"sanctum":{}}}
 * )
 */
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

    /**
 * @OA\get(
 *     path="/api/products/delete/{id}",
 *     tags={"Products"},
 *     summary="Delete a product",
 *     description="Soft delete a product by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product deleted successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Product Deleted Successfully")
 *         )
 *     ),
 *     security={{"sanctum":{}}}
 * )
 */
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

    /**
 * @OA\Get(
 *     path="/api/deletedProduct",
 *     tags={"Products"},
 *     summary="Get soft-deleted products",
 *     description="Retrieve all soft-deleted products",
 *     @OA\Response(
 *         response=200,
 *         description="List of soft-deleted products",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="iPhone 15"),
 *                     @OA\Property(property="price", type="number", format="float", example=999.99),
 *                     @OA\Property(property="status", type="string", example="Active"),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-06T10:00:00Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-06T10:00:00Z"),
 *                     @OA\Property(property="deleted_at", type="string", format="date-time", example="2025-09-06T12:00:00Z")
 *                 )
 *             )
 *         )
 *     ),
 *     security={{"sanctum":{}}}
 * )
 */
    public function deletedProduct()
    {
        $products = Product::onlyTrashed()->get();
        return response()->json([
            'status' => true,
            'data' => $products
        ]);
    }

    /**
 * @OA\get(
 *     path="/api/products/hardDetelete/{id}",
 *     tags={"Products"},
 *     summary="Permanently delete a product",
 *     description="Permanently delete a soft-deleted product by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product permanently deleted",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Product Permanently Deleted")
 *         )
 *     ),
 *     security={{"sanctum":{}}}
 * )
 */
    public function productHardDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();
        return response()->json([
            'status' => true,
            'message' => 'Product Permanently Deleted'
        ]);
    }

    /**
 * @OA\get(
 *     path="/api/products/restore/{id}",
 *     tags={"Products"},
 *     summary="Restore a soft-deleted product",
 *     description="Restore a soft-deleted product by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product restored successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Product Restored Successfully")
 *         )
 *     ),
 *     security={{"sanctum":{}}}
 * )
 */
    public function productRestore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return response()->json([
            'status' => true,
            'message' => 'Product Restored Successfully'
        ]);
    }

    /**
 * @OA\Get(
 *     path="/api/stock/{id}",
 *     tags={"Stock"},
 *     summary="Get product stock",
 *     description="Retrieve stock details for a specific product",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Stock fetched successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Stock fetched successfully"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="product_id", type="integer", example=101),
 *                     @OA\Property(property="quantity", type="integer", example=50),
 *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-06T10:00:00Z"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-06T10:30:00Z")
 *                 )
 *             )
 *         )
 *     ),
 *     security={{"sanctum":{}}}
 * )
 */
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

    /**
 * @OA\Post(
 *     path="/api/update-order-status",
 *     tags={"Stock"},
 *     summary="Update order status",
 *     description="Update the status of an order detail",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=123),
 *             @OA\Property(property="status", type="string", example="shipped")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order status updated successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Order status updated successfully"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=123),
 *                 @OA\Property(property="orderStatus", type="string", example="shipped"),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-06T10:00:00Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-06T10:30:00Z")
 *             )
 *         )
 *     ),
 *     security={{"sanctum":{}}}
 * )
 */
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

    /**
 * @OA\Post(
 *     path="/api/update-stock",
 *     tags={"Stock"},
 *     summary="Update product stock",
 *     description="Update stock quantity for a product and create a stock transaction",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="product_id", type="integer", example=101),
 *             @OA\Property(property="quantity", type="integer", example=10),
 *             @OA\Property(property="type", type="string", example="addition"),
 *             @OA\Property(property="remarks", type="string", example="Stock replenishment")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Stock updated successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Stock updated successfully"),
 *             @OA\Property(property="data", type="integer", example=60)
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error updating stock",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="An error occurred while updating stock. Please try again later.")
 *         )
 *     ),
 *     security={{"sanctum":{}}}
 * )
 */
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
