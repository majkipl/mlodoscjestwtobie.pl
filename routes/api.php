<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\ApplicationController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/contest/verified', [ApplicationController::class, 'verified'])->name('api.contests.veryfied');
Route::get('/product', [ProductController::class, 'index'])->name('api.products');
Route::get('/product/category/{category}', [ProductController::class, 'category'])->name('api.products.category');

Route::middleware(['myauth:api'])->group(function () {
    Route::get('/category', [CategoryController::class, 'index'])->name('api.category');
    Route::post('/category', [CategoryController::class, 'add'])->name('api.category.add');
    Route::put('/category', [CategoryController::class, 'update'])->name('api.category.update');
    Route::delete('/category/{category}', [CategoryController::class, 'delete'])->name('api.category.delete');

    Route::get('/product', [ProductController::class, 'index'])->name('api.product');
    Route::post('/product', [ProductController::class, 'add'])->name('api.product.add');
    Route::put('/product', [ProductController::class, 'update'])->name('api.product.update');
    Route::delete('/product/{product}', [ProductController::class, 'delete'])->name('api.product.delete');

    Route::get('/shop', [ShopController::class, 'index'])->name('api.shop');
    Route::post('/shop', [ShopController::class, 'add'])->name('api.shop.add');
    Route::put('/shop', [ShopController::class, 'update'])->name('api.shop.update');
    Route::delete('/shop/{shop}', [ShopController::class, 'delete'])->name('api.shop.delete');

    Route::get('/application', [ApplicationController::class, 'index'])->name('api.application');
});
