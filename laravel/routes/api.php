<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Category Routes
Route::get('/categories', 'App\\Http\\Controllers\\CategoryController@index'); // Get all categories
Route::post('/categories', 'App\\Http\\Controllers\\CategoryController@store'); // Create 1 category
Route::get('/categories/{categoryId}', 'App\\Http\\Controllers\\CategoryController@show'); // Get 1 category by categoryId
Route::patch('/categories/{categoryId}', 'App\\Http\\Controllers\\CategoryController@update'); // Update 1 category
Route::delete('/categories/{categoryId}', 'App\\Http\\Controllers\\CategoryController@destroy'); // Delete 1 category

// Product Routes
Route::get('/products', 'App\\Http\\Controllers\\ProductController@index'); // Get all products
Route::post('/products', 'App\\Http\\Controllers\\ProductController@store'); // Create 1 product
Route::get('/products/{productId}', 'App\\Http\\Controllers\\ProductController@show'); // Get 1 product
Route::patch('/products/{productId}', 'App\\Http\\Controllers\\ProductController@update'); // Update 1 product
Route::delete('/products/{productId}', 'App\\Http\\Controllers\\ProductController@destroy'); // Delete 1 product

// Get all products belong to categoryId
Route::get('/categories/{categoryId}/products', 'App\\Http\\Controllers\\CategoryController@products');
