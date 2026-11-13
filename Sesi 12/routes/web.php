<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/home2', [HomeController::class, 'index2']);

Route::get('/home-layout', [HomeController::class, 'indexLayoutComponent']);

Route::get('/products', [CartController::class, 'index']);

Route::get('/cart', [CartController::class, 'index'])->name('cart.page');
Route::post('/cart', [CartController::class, 'update'])->name('cart.update');

Route::get('/checkout', function () {
    echo 'Checkout Page';
})->name('checkout.page');

Route::get('/about', function () {
    return 'About Page';
});

Route::get('/hello', function () {
    return 'Hello, World!';
});

Route::get('/greeting/{name}/age/{age}', function ($name, $age) {
    return "Hello, $name! You are $age years old.";
});
