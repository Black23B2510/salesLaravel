<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('pages.index');
// });
Route::get('/', [ProductController::class , 'getProducts'])->name('homepage');
Route::get('/detail/{id}', [ProductController::class , 'getProductDetail']);
Route::get('/product_type/{id}', [ProductController::class , 'getProductType']);
Route::get('/addtocart/{id}', [ProductController::class, 'AddtoCart'])->name('themgiohang');
Route::get('/deleteItem/{id}', [ProductController::class, 'getDelItemCart'])->name('xoasp');
Route::get('/signup', [UserController::class, 'getSignUp'])->name('dangki');
Route::post('/signup_successfully', [UserController::class, 'postSignUp'])->name('dangkithanhcong');
Route::get('/getLogin', [UserController::class, 'Login'])->name('dangnhap');
Route::post('/login', [UserController::class, 'postLogin'])->name('login_sc');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/checkout', [ProductController::class, 'getCheckout'])->name('checkout');
Route::post('/pcheckout', [ProductController::class, 'postCheckout'])->name('checkout_sc');
Route::get('/vnpay-index',function(){
    return view('vnpay.vnpay-index');
});
Route::post('/vnpay/create_payment',[ProductController::class,'createPayment'])->name('postCreatePayment');
Route::get('/vnpay_return',[ProductController::class,'vnpayReturn'])->name('vnpayReturn');

Route::get('/getInput-email',[UserController::class,'getInputEmail'])->name('getInputEmail');
Route::post('/input-email',[UserController::class,'postInputEmail'])->name('postInputEmail');