<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SchedulingController;
use Illuminate\Support\Facades\Route;


Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::get('user/auth', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::apiResource('user', RegisteredUserController::class);

    Route::get('client/search', [ClientController::class, 'search']); 
    Route::apiResource('client', ClientController::class);

    Route::get('barber/search', [BarberController::class, 'search']); // Se colocar em baixo da rota abaixo da erro
    Route::get('/barber/active', [BarberController::class, 'getActiveBarbers']);
    Route::get('/barber/inactive', [BarberController::class, 'getInactiveBarbers']);
    Route::apiResource('barber', BarberController::class);

    Route::get('category/search', [CategoryController::class, 'search'])->middleware('auth:api'); // Se colocar em baixo da rota abaixo da erro
    Route::apiResource('category', CategoryController::class)->middleware('auth:api');

    Route::apiResource('schedulling', SchedulingController::class)->middleware('auth:api');;
    Route::get('schedulling/search/{data}', [SchedulingController::class, 'searchForDay']);
    Route::get('schedulling/search/barber/{barberName}', [SchedulingController::class, 'indexByBarberName']);
    Route::patch('scheduling/{id}', [SchedulingController::class, 'concludeScheduling']);
});







