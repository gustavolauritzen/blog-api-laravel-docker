<?php

  use App\Http\Controllers\Api\AuthController;
  use App\Http\Controllers\Api\CategoryController;
  use App\Http\Controllers\Api\PostController;
  use App\Http\Controllers\Api\TagController;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Route;

  // Public routes (authentication)
  Route::post('/register', [AuthController::class, 'register']);
  Route::post('/login', [AuthController::class, 'login']);

  // Public routes (read-only)
  Route::get('/posts', [PostController::class, 'index']);
  Route::get('/posts/{post}', [PostController::class, 'show']);
  Route::get('/categories', [CategoryController::class, 'index']);
  Route::get('/categories/{category}', [CategoryController::class, 'show']);
  Route::get('/tags', [TagController::class, 'index']);
  Route::get('/tags/{tag}', [TagController::class, 'show']);

  // Protected routes (require authentication)
  Route::middleware('auth:sanctum')->group(function () {
      // Auth routes
      Route::post('/logout', [AuthController::class, 'logout']);
      Route::get('/me', [AuthController::class, 'me']);

      // Post routes (authenticated users only)
      Route::post('/posts', [PostController::class, 'store']);
      Route::put('/posts/{post}', [PostController::class, 'update']);
      Route::delete('/posts/{post}', [PostController::class, 'destroy']);

      // Category routes (authenticated users only)
      Route::post('/categories', [CategoryController::class, 'store']);
      Route::put('/categories/{category}', [CategoryController::class, 'update']);
      Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

      // Tag routes (authenticated users only)
      Route::post('/tags', [TagController::class, 'store']);
      Route::put('/tags/{tag}', [TagController::class, 'update']);
      Route::delete('/tags/{tag}', [TagController::class, 'destroy']);
  });