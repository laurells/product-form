<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Show the form and list of products
Route::get('/', [ProductController::class, 'index']);

// Store a new product
Route::post('/products', [ProductController::class, 'store']);

// Update an existing product
Route::put('/products/{id}', [ProductController::class, 'update']);

// Get product data
Route::get('/products/{id}', [ProductController::class, 'show']); 