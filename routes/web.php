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

use App\Http\Controllers\HomeController;

Auth::routes();

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [HomeController::class, 'index'])->name('front.home');
Route::get('/nagrody', [HomeController::class, 'index'])->name('front.home');
Route::get('/zgloszenia', [HomeController::class, 'index'])->name('front.home');
Route::get('/zgloszenia-tygodnia', [HomeController::class, 'index'])->name('front.home');
Route::get('/nasze-produkty', [HomeController::class, 'index'])->name('front.home');
Route::get('/kontakt', [HomeController::class, 'index'])->name('front.home');
