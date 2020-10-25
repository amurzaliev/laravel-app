<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SecurityController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ProductController::class, 'index'])->name('product_index');
Route::get('/cart', [CartController::class, 'index'])->name('cart_index');
Route::post('/cart/add/{product}', [CartController::class, 'addProduct'])->name('cart_add_product');
Route::delete('/cart/remove/{product}', [CartController::class, 'removeProduct'])->name('cart_remove_product');
Route::get('/login', [SecurityController::class, 'showLogin'])->name('security_show_login');
Route::post('/login', [SecurityController::class, 'doLogin'])->name('security_do_login');
Route::get('/logout', [SecurityController::class, 'doLogout'])->name('security_do_logout');
