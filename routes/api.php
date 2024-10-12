<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\MyOrderController;
use App\Http\Controllers\api\PincodeController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ChangePinController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/change-password', [LoginController::class, 'changePassword']);


    Route::get('/getProductList', [ProductController::class, 'getProductList']);
    Route::get('/getProductDetail/{id}', [ProductController::class, 'getProductDetail']);
    Route::get('/getOrderList', [OrderController::class, 'getOrderList']);
    Route::get('/getMyOrderList', [MyOrderController::class, 'getMyOrderList']);
    Route::get('/getCategoryList', [CategoryController::class, 'getCategoryfilter']);
    Route::post('/order-save', [MyOrderController::class, 'orderSave']);

    //pincode
    Route::get('/pincodes', [PincodeController::class, 'getAllPincodes']);
    Route::post('/checkPincode', [PincodeController::class, 'checkPincode']);
    Route::get('/pincode-details', [PincodeController::class, 'getPincodeDetails']);

    //changePin
    Route::post('/updatePin', [ChangePinController::class, 'updatePin'])->name('user.updatepin');

    //updateAddress
    // Route::post('/updateCustomerAddress', [MyOrderController::class, 'updateCustomerAddress'])->name('order.updateCustomerAddress');
    Route::post('/update-customer-address', [MyOrderController::class, 'updateCustomerAddress']);
    Route::get('/cancel-order/{id}', [MyOrderController::class, 'cancelOrder']);
    Route::post('/addAddress', [MyOrderController::class, 'addAddress']);
    //get slider
});

Route::get('/getSlider', [ProductController::class, 'getSlider']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/getVersion',[ProductController::class, 'getVersion']);