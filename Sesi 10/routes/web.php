<?php

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\MockObject\Stub\ReturnCallback;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', function () {
    echo "Products Page";
});

Route::get('/cart', function () {
    echo "Cart Page";
});

Route::get('/checkout', function () {
    echo "Checkout Page";
});

Route::get('/about', function () {
    return "About Page";
});

Route::get('/hello', function () {
    return "Hello, World!";
});

Route::get('/greeting/{name}/age/{age}', function ($name, $age) {
    return "Hello, $name! You are $age years old.";
});
