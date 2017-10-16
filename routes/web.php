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
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ThxController;

Auth::routes();

//Route::get('/', function () {
//    return view('welcome');
//});

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

