<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\MyorderController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\PincodeController;
use App\Http\Controllers\api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/getProductList', [ProductController::class, 'getProductList']);
    Route::get('/getOrderList', [OrderController::class, 'getOrderList']);
    Route::get('/getPincode', [PincodeController::class, 'getPincode']);
    Route::get('/getMyorderList', [MyOrderController::class, 'getMyorderList']);
    Route::get('/getCategoryList', [CategoryController::class, 'getCategoryfilter']);
    Route::post('/orderSave', [OrderController::class, 'orderSave']);
});

Route::post('/login', [LoginController::class, 'login']);
