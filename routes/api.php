<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('listing-categories/tree', 'App\Http\Controllers\Api\V1\CategoryController@tree');
Route::get('products', 'App\Http\Controllers\Api\V1\ProductController@index');

Route::controller('App\Http\Controllers\Api\V1\RegisterController')->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('category', 'App\Http\Controllers\Api\V1\CategoryController@store');
    Route::get('cart', 'App\Http\Controllers\Api\V1\CartController@cartList');
    Route::post('cart', 'App\Http\Controllers\Api\V1\CartController@addToCart');
    Route::patch('cart', 'App\Http\Controllers\Api\V1\CartController@updateCart');
    Route::delete('cart/{item}', 'App\Http\Controllers\Api\V1\CartController@removeProduct');
    Route::post('orders', 'App\Http\Controllers\Api\V1\OrderController@store');
    Route::get('orders', 'App\Http\Controllers\Api\V1\OrderController@index');
    Route::get('orders/{order}', 'App\Http\Controllers\Api\V1\OrderController@show');
    Route::delete('orders/{order}', 'App\Http\Controllers\Api\V1\OrderController@delete');
});
