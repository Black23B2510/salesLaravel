<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
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
Route::get('/', [ProductController::class , 'getProducts']);
Route::get('/detail/{id}', [ProductController::class , 'getProductDetail']);
Route::get('/product_type/{id}', [ProductController::class , 'getProductType']);
Route::get('addtocart/{id}', [ProductController::class, 'AddtoCart'])->name('themgiohang');