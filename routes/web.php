<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SellerController;



Route::resource('sales', SaleController::class);
Route::resource('sellers', SellerController::class);
Route::resource('products', ProductController::class);
Route::resource('customers', CustomerController::class);
