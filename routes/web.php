<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;


Route::get('/', [ProductController::class, 'homepage'])->name('homepage');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/admin/login', function () {
    return view('admin_login');
})->name('admin_login');

Route::get('/admin/profile', function () {
    return view('admin_profile');
})->name('admin_profile');

Route::get('/products', function () {
    return view('products');
})->name('products');

Route::get('/confirmation', function () {
    return view('confirmation');
})->name('confirmation');

Route::get('/favorites', function () {
    return view('favorites');
})->name('favorites');


// LOGIN LOGOUT REGISTER PROFILE
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth')->name('profile');

// PRODUKTY
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{category}', [ProductController::class, 'byCategory'])->name('products.byCategory');
Route::get('/products/{category}/{subcategory}', [ProductController::class, 'bySubcategory'])->name('products.bySubcategory');

// FAVORITES
Route::middleware(['auth'])->group(function () {
    Route::post('/favorites/add/{product}', [FavoriteController::class, 'add'])->name('favorites.add');
    Route::delete('/favorites/remove/{product}', [FavoriteController::class, 'remove'])->name('favorites.remove');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});

// DETAIL PRODUKTU
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product_detail');


// CART step1
Route::get('/cart_step1', [CartController::class, 'step1'])->name('shopping_cart1');
Route::delete('/remove-from-cart/{id}', [CartController::class, 'removeFromCart'])->name('removeFromCart');
Route::post('add-to-cart/{id}', [CartController::class, 'addToCart'])->name('addToCart');
Route::put('/cart/update/{id}', [CartController::class, 'updateCartItem'])->name('updateCartItem');

// CART step2
Route::get('/cart_step2', [CartController::class, 'step2'])->name('shopping_cart2');
Route::post('/save-order-session', [OrderController::class, 'saveOrderToSession']);

// CART step3
Route::get('/cart_step3', [CartController::class, 'step3'])->name('shopping_cart3');
Route::post('/process-order-session', [OrderController::class, 'processOrderSession']);

// ULOZENIE ORDER
Route::post('/order', [OrderController::class, 'process'])->name('order.process');
Route::post('/ordersession', [OrderController::class, 'processFromSession'])->name('order.processFromSession');
Route::get('/confirmation', [OrderController::class, 'confirmation'])->name('confirmation');




//  ---------------- ADMIN -----------------------
Route::view('/login/admin', 'admin_login')->name('admin_login');
Route::post('/login/admin', [AdminController::class, 'login'])->name('admin_login_udaje');
Route::get('/profile/admin', [AdminController::class, 'profile'])->middleware('auth')->name('admin_profile');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin_logout');
// manipulacia s produktami
Route::post('/profile/admin', [AdminController::class, 'add'])->name('add_product');
Route::delete('/admin/products/{product}', [AdminController::class, 'delete'])->name('delete_product');
Route::put('/admin/products/{product}', [AdminController::class, 'edit'])->name('edit_product');
