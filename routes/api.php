<?php

use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\OrderapiController;
use App\Http\Controllers\api\PincodeapiController;
use App\Http\Controllers\api\ProductapiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/getProductList', [ProductapiController::class, 'getProductList']);
    Route::get('/getOrderList', [OrderapiController::class, 'getOrderList']);
    Route::get('/getPincode', [PincodeapiController::class, 'getPincode']);
    Route::post('/orderSave', [OrderapiController::class, 'orderSave']);
});

Route::post('/login', [LoginController::class, 'login']);
