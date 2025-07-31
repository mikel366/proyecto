<?php

use App\Http\Controllers\Authent\AuthController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CanalVentasController;
use App\Http\Controllers\EstadoCajaController;
use App\Http\Controllers\EstadoPedidosController;
use App\Http\Controllers\ImagenProductoController;
use App\Http\Controllers\LocacionController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/users', UserController::class)->middleware('auth:sanctum');

Route::apiResource('roles', RoleController::class);
Route::apiResource('estado-cajas', EstadoCajaController::class);
Route::apiResource('metodo-pagos', MetodoPagoController::class);
Route::apiResource('canal-ventas', CanalVentasController::class);
Route::apiResource('estado-pedidos', EstadoPedidosController::class);
Route::apiResource('locaciones', LocacionController::class);
Route::apiResource('cajas', CajaController::class);
Route::apiResource('productos', ProductoController::class);
Route::apiResource('imagen-productos', ImagenProductoController::class);
Route::apiResource('pedidos', PedidoController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Rutas protegidas que requieren autenticación
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
});