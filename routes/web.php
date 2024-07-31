<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PincodeController;
use App\Http\Controllers\ProductStockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SkuController;
use App\Http\Controllers\SliderController;
// use App\Http\Controllers\UserController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/demo', function () {
// return view('home');
// });

// . 
//All Normal Users Routes List
Auth::routes();

Route::get('view', function () {
    Artisan::call('view:clear');
    return redirect()->back();
});

Route::get('cache', function () {
    Artisan::call('cache:clear');
    return redirect()->back();
});

Route::get('route', function () {
    Artisan::call('route:clear');
    return redirect()->back();
});

//All Admin Routes List

Route::middleware(['auth', 'user-access:admin'])->group(function () {

    Route::get('view', function () {
        Artisan::call('view:clear');
        return redirect()->back();
    });

    Route::get('cache', function () {
        Artisan::call('cache:clear');
        return redirect()->back();
    });

    Route::get('route', function () {
        Artisan::call('route:clear');
        return redirect()->back();
    });




    Route::get('/admin/home/dashboard', [UserController::class, 'adminHome'])->name('admin.home');
    Route::get('/user/index', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/admin/trash-user', [UserController::class, 'trashUser'])->name('user.trash');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update/{user}', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/change-password/{id}', [UserController::class, 'password'])->name('user.password');
    Route::post('/user/update-password/{user}', [UserController::class, 'updatepassword'])->name('user.updatepassword');
    Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::get('/user/restore/{id}', [UserController::class, 'restore'])->name('user.restore');
    Route::get('/user/force-delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('logout', [UserController::class, 'logout'])->name('logout');

    //changepin
    Route::post('/user/updatePin/{id}', [UserController::class, 'updatePin'])->name('user.updatePin');

    // SKU 
    Route::get('/sku/index', [SkuController::class, 'index'])->name('sku.index');
    Route::get('/sku/trash/', [SkuController::class, 'trash'])->name('sku.trash');
    Route::get('/sku/create', [SkuController::class, 'create'])->name('sku.create');
    Route::post('/sku/store', [SkuController::class, 'store'])->name('sku.store');
    Route::get('/sku/edit/{id}', [SkuController::class, 'edit'])->name('sku.edit');
    Route::post('/sku/update/{sku}', [SkuController::class, 'update'])->name('sku.update');
    Route::get('/sku/delete/{id}', [SkuController::class, 'delete'])->name('sku.delete');
    Route::get('/sku/restore/{id}', [SkuController::class, 'restore'])->name('sku.restore');
    Route::get('/sku/force-delete/{id}', [SkuController::class, 'destroy'])->name('sku.destroy');

    // Slider
    Route::get('/slider/index', [SliderController::class, 'index'])->name('slider.index');
    Route::get('/slider/trash/', [SliderController::class, 'trash'])->name('slider.trash');
    Route::get('/slider/create', [SliderController::class, 'create'])->name('slider.create');
    Route::post('/slider/store', [SliderController::class, 'store'])->name('slider.store');
    Route::get('/slider/edit/{id}', [SliderController::class, 'edit'])->name('slider.edit');
    Route::post('/slider/update/{slider}', [SliderController::class, 'update'])->name('slider.update');
    Route::get('/slider/delete/{id}', [SliderController::class, 'delete'])->name('slider.delete');
    Route::get('/slider/restore/{id}', [SliderController::class, 'restore'])->name('slider.restore');
    Route::get('/slider/force-delete/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');

    //Category
    Route::get('/category/index', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/trash', [CategoryController::class, 'trash'])->name('category.trash');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
    Route::get('/category/restore/{id}', [CategoryController::class, 'restore'])->name('category.restore');
    Route::get('/category/force-delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    //stock update 
    Route::get('/admin/product-stock/{id}/edit', [ProductStockController::class, 'edit'])->name('product-stock.edit');
    Route::put('/admin/product-stock/{id}', [ProductStockController::class, 'update'])->name('product-stock.update');
    // Route::get('catalog/create', [CatalogController::class, 'index'])->name('catalog.index');
    // Route::get('catalog/post', [CatalogController::class, 'index'])->name('catalog.index');

    //products
    Route::get('product/index', [ProductController::class, 'index'])->name('product.index');
    Route::get('product/trash-product', [ProductController::class, 'trashProduct'])->name('product.trash');
    Route::get('product/trash-product/{id}', [ProductController::class, 'view'])->name('product.view');
    Route::get('product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('catalog/edit/{catalog}', [ProductController::class, 'editcatalog'])->name('catalog.edit');
    Route::put('catalog/update/{catalog}', [ProductController::class, 'catalogupdate'])->name('catalog.update');
    Route::get('product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('product/update/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::get('catalog/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    Route::get('catalog/restore/{id}', [ProductController::class, 'restore'])->name('product.restore');
    Route::get('catalog/force-delete/{id}', [ProductController::class, 'destory'])->name('product.destory');

    // Report
    Route::get('report/index', [OrderController::class, 'index'])->name('report.index');
    Route::get('report/printData', [OrderController::class, 'print'])->name('report.print');

    Route::get('orders/index', [OrderController::class, 'allOrders'])->name('orders.index');

    // Pincodes

    Route::get('pincode/index', [PincodeController::class, 'index'])->name('pincode.index');
    Route::get('pincodes/fetch', [PincodeController::class, 'fetchPincodes'])->name('pincodes.fetch');
    Route::post('pincodes/update', [PincodeController::class, 'updatePincode'])->name('pincodes.update');

    //orders
    // Route::post('/update-order-status', [OrderController::class, 'updateOrderStatus'])->name('updateOrderStatus');
    Route::post('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
});
