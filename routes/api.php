<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SchedullingController;
use Illuminate\Support\Facades\Route;

Route::apiResource('client', ClientController::class)->middleware('auth:api');

Route::get('barber/search', [BarberController::class, 'search'])->middleware('auth:api'); // Se colocar em baixo da rota abaixo da erro
Route::get('/barber/active', [BarberController::class, 'getActiveBarbers'])->middleware('auth:api');
Route::get('/barber/inactive', [BarberController::class, 'getInactiveBarbers'])->middleware('auth:api');
Route::apiResource('barber', BarberController::class)->middleware('auth:api');

Route::get('category/search', [CategoryController::class, 'search'])->middleware('auth:api'); // Se colocar em baixo da rota abaixo da erro
Route::apiResource('category', CategoryController::class)->middleware('auth:api');

Route::apiResource('schedulling', SchedullingController::class)->middleware('auth:api');;
Route::get('schedulling/search/{data}', [SchedullingController::class, 'searchForDay']);
Route::get('schedulling/search/barber/{barberName}', [SchedullingController::class, 'indexByBarberName']);
Route::patch('schedulling/{id}', [SchedullingController::class, 'concludeScheduling']);

Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('user', [AuthController::class, 'user'])->middleware('auth:api');
