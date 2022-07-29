<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CommentController;
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


//Wishlist
Route::prefix('wishlist')->group(function () {
    Route::get('/add/{id}', [WishlistController::class, 'AddWishlist']);
    Route::get('/delete/{id}', [WishlistController::class, 'DeleteWishlist']);

    Route::get('/order', [WishlistController::class, 'OrderWishlist']);
});
//Comment
Route::post('/comment/{id}', [CommentController::class, 'AddComment']);

// ----------------------- TRANG ADMIN --------------------
Route::get('/admin', [ProductController::class, 'getIndexAdmin'])->name('admin');
Route::get('/admin-add-form', [ProductController::class, 'getAdminAdd'])->name('add-product');
Route::post('/admin-add-form', [ProductController::class, 'postAdminAdd']);
Route::get('/admin-edit-form/{id}', [ProductController::class, 'getAdminEdit']);
Route::post('/admin-edit', [ProductController::class, 'postAdminEdit'])->name('editProduct');
Route::post('/admin-delete/{id}', [ProductController::class, 'postAdminDelete']);
Route::get('/billsManage', [ProductController::class, 'getBillsManage']);


Route::get('/userBills', [ProductController::class, 'getUserBill']);
Route::post('/newBills/{{id}}', [ProductController::class, 'updateStatusBill']);