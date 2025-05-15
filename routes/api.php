<?php

use App\Http\Controllers\ActividadesController;
use App\Http\Controllers\AsociadosController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\ParticipacionesController;
use App\Http\Controllers\PrestamosController;
use Illuminate\Support\Facades\Route;

Route::middleware('jwt.auth', 'auth.role:admin')->group(function () {
    Route::apiResource('asociados', AsociadosController::class);
    Route::apiResource('pagos', PagosController::class);
    Route::apiResource('participaciones', ParticipacionesController::class);
    Route::apiResource('prestamos', PrestamosController::class);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('user', [AuthController::class, 'user']);
});

//auth.role:user
Route::apiResource('actividades', ActividadesController::class);


// Rutas públicas
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout']);

