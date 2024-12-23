<?php

use App\Http\Controllers\BarberController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SchedullingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('barber', BarberController::class);
Route::apiResource('client', ClientController::class);
Route::apiResource('category', CategoryController::class);
Route::get('schedulling/{data}', [SchedullingController::class, 'searchForDay']);
Route::get('schedulling/barber/{barberName}', [SchedullingController::class, 'indexByBarberName']);
Route::patch('schedulling/{id}', [SchedullingController::class, 'concludeScheduling']);
Route::apiResource('schedulling', SchedullingController::class);




