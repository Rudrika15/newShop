<?php

use App\Http\Controllers\api\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\MyOrderController;
use App\Http\Controllers\api\PincodeController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ChangePinController;
use Illuminate\Support\Facades\Artisan;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/route-clear', function (Request $request) {
    Artisan::call('route:clear');
});
Route::get('/cache-clear', function (Request $request) {
    Artisan::call('cache:clear');
});



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



    /////////////////////////////admin side///////////////////////////////////////

    ///user routes
    Route::post('/user-create', [AdminController::class, 'userCreate']);
    Route::get('/user-list', [AdminController::class, 'getAllUsers']);
    Route::get('/user-trash', [AdminController::class, 'getTrashUsers']);
    Route::delete('/user-delete/{id}', [AdminController::class, 'deleteUser']);
    Route::put('/user-restore/{id}', [AdminController::class, 'restoreUser']);
    Route::delete('/user-hard-delete/{id}', [AdminController::class, 'hardDeleteUser']);
    Route::get('/user-show/{id}', [AdminController::class, 'showUser']);
    Route::patch('/user-update/{id}', [AdminController::class, 'updateUser']);
    Route::patch('/user-reset-password/{id}', [AdminController::class, 'resetPassword']);
    //user route end
    //sku route
    Route::get('/sku-list', [AdminController::class, 'getAllSkus']);
    Route::post('/sku-create', [AdminController::class, 'storeSku']);
    Route::get('/sku-show/{id}', [AdminController::class, 'showSku']);
    Route::post('/sku-update/{id}', [AdminController::class, 'updateSku']);
    Route::delete('/sku-delete/{id}', [AdminController::class, 'deleteSku']);
    //sku route end
    // category route
    Route::get('/category-list', [AdminController::class, 'getAllCategories']);
    Route::post('/category-store', [AdminController::class, 'storeCategory']);
    Route::get('/category-show/{id}', [AdminController::class, 'showCategory']);
    Route::delete('/category-delete/{id}', [AdminController::class, 'deleteCategory']);
    Route::post('/category-update/{id}', [AdminController::class, 'updateCategory']);
    Route::get('/category-trash', [AdminController::class, 'getTrashCategories']);
    Route::post('/category-restore/{id}', [AdminController::class, 'restoreCategory']);
    Route::post('/category-hard-delete/{id}', [AdminController::class, 'hardDeleteCategory']);
    // category route end

    //slider route
    Route::get('/slider-list', [AdminController::class, 'getAllSliders']);
    Route::get('/slider-trash', [AdminController::class, 'getTrashSlider']);
    Route::post('/slider-restore/{id}', [AdminController::class, 'restoreSlider']);
    Route::post('/slider-hard-delete/{id}', [AdminController::class, 'hardDeleteSlider']);
    Route::post('/slider-soft-delete/{id}', [AdminController::class, 'softDeleteSlider']);
    Route::post('/slider-update/{id}', [AdminController::class, 'updateSlider']);
    Route::get('/slider-show/{id}', [AdminController::class, 'showSlider']);
    Route::post('/slider-create', [AdminController::class, 'store']);
    //slider route end

    //stricker print
    Route::post('sticker-print', [AdminController::class, 'stickerPrint']);
    //stricker print end

    //order route
    //order route end

    // admin routes

    // catalog
    Route::get('/catalog/{id?}', [AdminController::class, 'getCatalog']);
    Route::post('/catalog', [AdminController::class, 'addCatalog']);
    Route::get('/catalog/products1', [AdminController::class, 'catalogProducts1']);
    Route::get('/catalogs', [AdminController::class, 'catalogs']);
    Route::post('/catalog/{id}', [AdminController::class, 'updateCatalog']);

    //  products
    Route::get('/products/{id?}', [AdminController::class, 'getProducts']);
    Route::post('/product', [AdminController::class, 'addProduct']);
    Route::post('/product/{id}', [AdminController::class, 'updateProduct']);


    Route::get('catalog/delete/{id}', [AdminController::class, 'catalogDelete']);
    Route::get('catalog_trash', [AdminController::class, 'catalog_trash'])->name('catalog.trash');
    Route::get('catalog/hardDelete/{id}', [AdminController::class, 'catalogHardDelete']);
    Route::get('catalog/restore/{id}', [AdminController::class, 'catalogRestore']);

    Route::get('products/delete/{id}', [AdminController::class, 'productDelete']);
    // Route::get('products/trash', [AdminController::class, 'trashProduct']);
    Route::get('deletedProduct', [AdminController::class, 'deletedProduct']);
    Route::get('products/hardDetelete/{id}', [AdminController::class, 'productHardDelete']);
    Route::get('products/restore/{id}', [AdminController::class, 'productRestore']);


    //stock
    Route::get('/stock/{id}', [AdminController::class, 'getStock']);
    Route::post('/update-stock', [AdminController::class, 'updateProductStock']);
    Route::post('/update-order-status', [AdminController::class, 'updateOrderStatus']);
});

Route::get('/getSlider', [ProductController::class, 'getSlider']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/getVersion', [ProductController::class, 'getVersion']);
Route::get('/cashfree/settlement/{orderId}', [OrderController::class, 'getSettlement']);
Route::get('/order-list', [AdminController::class, 'getAllOrders']);
