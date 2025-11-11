<?php

  use App\Http\Controllers\Api\AuthController;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Route;

  // Public routes (sem autenticação)
  Route::post('/register', [AuthController::class, 'register']);
  Route::post('/login', [AuthController::class, 'login']);

  // Protected routes (requer autenticação)
  Route::middleware('auth:sanctum')->group(function () {
      Route::post('/logout', [AuthController::class, 'logout']);
      Route::get('/me', [AuthController::class, 'me']);
  });