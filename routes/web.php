<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ConfirmController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\PanelController;
use App\Http\Controllers\Panel\ProductController;
use App\Http\Controllers\Panel\ShopController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ThxController;

Auth::routes();

//Route::get('/', function () {
//    return view('welcome');
//});

// FRONTEND

Route::get('/', [HomeController::class, 'index'])->name('front.home');
Route::get('/nagrody', [HomeController::class, 'index'])->name('front.home');
Route::get('/wez-udzial', [HomeController::class, 'index'])->name('front.home');
Route::get('/zgloszenia', [HomeController::class, 'index'])->name('front.home');
Route::get('/zgloszenia-tygodnia', [HomeController::class, 'index'])->name('front.home');
Route::get('/nasze-produkty', [HomeController::class, 'index'])->name('front.home');
Route::get('/kontakt', [HomeController::class, 'index'])->name('front.home');
Route::get('/polityka-prywatnosci', [PolicyController::class, 'index'])->name('front.policy');

Route::get('/formularz', [ApplicationController::class, 'form'])->name('front.form');
Route::post('/formularz/zapisz', [ApplicationController::class, 'store'])->name('front.form.save');

Route::get('/potwierdzam/{application}/{token}', [ConfirmController::class, 'application'])->name('front.confirm.application');

Route::get('/podziekowania/rejestracja', [ThxController::class, 'form'])->name('front.thx.form');
Route::get('/podziekowania/konkurs', [ThxController::class, 'contest'])->name('front.thx.contest');
Route::get('/podziekowania/promocja', [ThxController::class, 'promotion'])->name('front.thx.promotion');

Route::get('/zgloszenia/{application}', [ApplicationController::class, 'show'])->name('front.application.id');
Route::post('/kontakt/wyslij', [ContactController::class, 'send'])->name('front.contact.send');

//BACKEND

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/panel', [PanelController::class, 'index'])->name('back.home');

    Route::middleware(['can:isAdmin'])->group(function () {
        Route::get('/panel/zgloszenie', [\App\Http\Controllers\Panel\ApplicationController::class, 'index'])->name('back.application');
        Route::get('/panel/zgloszenie/{promotion}', [\App\Http\Controllers\Panel\ApplicationController::class, 'show'])->name('back.application.show');

        Route::get('/panel/kategoria', [CategoryController::class, 'index'])->name('back.category');
        Route::get('/panel/kategoria/dodaj', [CategoryController::class, 'create'])->name('back.category.create');
        Route::get('/panel/kategoria/zmien/{category}', [CategoryController::class, 'edit'])->name('back.category.edit');
        Route::get('/panel/kategoria/{category}', [CategoryController::class, 'show'])->name('back.category.show');

        Route::get('/panel/produkt', [ProductController::class, 'index'])->name('back.product');
        Route::get('/panel/produkt/dodaj', [ProductController::class, 'create'])->name('back.product.create');
        Route::get('/panel/produkt/zmien/{product}', [ProductController::class, 'edit'])->name('back.product.edit');
        Route::get('/panel/produkt/{product}', [ProductController::class, 'show'])->name('back.product.show');


        Route::get('/panel/sklep', [ShopController::class, 'index'])->name('back.shop');
        Route::get('/panel/sklep/dodaj', [ShopController::class, 'create'])->name('back.shop.create');
        Route::get('/panel/sklep/zmien/{shop}', [ShopController::class, 'edit'])->name('back.shop.edit');
        Route::get('/panel/sklep/{shop}', [ShopController::class, 'show'])->name('back.shop.show');
    });
});
