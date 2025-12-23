<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

Route::post('/api/categories', [CategoryController::class, 'store']);
Route::get('/api/categories', [CategoryController::class, 'index']);
Route::get('/api/categories/{category}', [CategoryController::class, 'show']);
Route::put('/api/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/api/categories/{category}', [CategoryController::class, 'destroy']);

Route::get('/api/categories-with-posts', [CategoryController::class, 'withPosts']);

Route::post('/api/posts', [PostController::class, 'store']);
Route::get('/api/posts', [PostController::class, 'index']);
Route::get('/api/posts/{post}', [PostController::class, 'show']);
Route::put('/api/posts/{post}', [PostController::class, 'update']);
Route::delete('/api/posts/{post}', [PostController::class, 'destroy']);
