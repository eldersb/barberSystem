<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SchedullingController;
use Illuminate\Support\Facades\Route;


Route::apiResource('barber', BarberController::class)->middleware('auth:api');
Route::apiResource('client', ClientController::class)->middleware('auth:api');
Route::apiResource('category', CategoryController::class)->middleware('auth:api');
Route::get('schedulling/barber/{barberName}', [SchedullingController::class, 'indexByBarberName'])->middleware('auth:api');
Route::apiResource('schedulling', SchedullingController::class)->middleware('auth:api');

Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('user', [AuthController::class, 'user'])->middleware('auth:api');


// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

// require __DIR__. '/auth.php';