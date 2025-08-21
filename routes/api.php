<?php

use App\Http\Controllers\Authent\AuthController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CanalVentasController;
use App\Http\Controllers\EstadoCajaController;
use App\Http\Controllers\EstadoPedidosController;
use App\Http\Controllers\ImagenProductoController;
use App\Http\Controllers\LocacionController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\MovimientoCajaController;
use App\Http\Controllers\Pedido\PedidoPrivateController;
use App\Http\Controllers\Pedido\PedidoPublicController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::apiResource('roles', RoleController::class);
Route::apiResource('estado-cajas', EstadoCajaController::class);
Route::apiResource('metodo-pagos', MetodoPagoController::class);
Route::apiResource('canal-ventas', CanalVentasController::class);
Route::apiResource('estado-pedidos', EstadoPedidosController::class);
Route::apiResource('locaciones', LocacionController::class);
Route::apiResource('productos', ProductoController::class);
Route::apiResource('imagen-productos', ImagenProductoController::class);

//RUTAS PUBLICAS
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::get('/productos', [ProductoController::class, 'index']);
Route::get('/productos/{id}', [ProductoController::class, 'show']);
Route::get('/productos/{query}', [ProductoController::class, 'search']);

//RUTAS PARA CLIENTES
Route::middleware(['auth:sanctum'])->prefix('cliente')->group(function () {
    //perfil y cuenta
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    //Referido a la tienda
    Route::middleware(['verificar.caja.abierta'])->group(function () {
        Route::post('/crear-pedido', [PedidoPublicController::class, 'crearPedido']);
    });

    Route::get('/mis-pedidos/{id}', [PedidoPublicController::class, 'mostrarPedidoPublic']);
    Route::get('/mis-pedidos', [PedidoPublicController::class, 'listarMisPedidos']);
    Route::post('/mis-pedidos/{id}/cancelar', [PedidoPublicController::class, 'cancelarPedido']);
});

//RUTAS PARA ADMIN
Route::middleware(['auth:sanctum', 'role:Admin'])->prefix('admin')->group(function () {
    //perfil y cuenta
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    //Referido a la tienda
    Route::get('/pedidos', [PedidoPrivateController::class, 'index']);
    Route::get('/pedidos/{id}', [PedidoPrivateController::class, 'show']);
    Route::put('/pedidos/{id}', [PedidoPrivateController::class, 'actualizarEstado']);

    Route::middleware(['verificar.caja.abierta'])->group(function (){
        Route::post('/registrar-venta', [PedidoPrivateController::class, 'registrarVenta']);
    });
    
    Route::get('/cajas', [CajaController::class, 'index']);
    Route::post('/cajas/abrir', [CajaController::class, 'abrirCaja']);
    Route::post('/cajas/cerrar', [CajaController::class, 'cerrarCaja']);

    Route::post('/movimientos', [MovimientoCajaController::class, 'registrarMovimiento']);
    Route::put('/movimientos/{id}', [MovimientoCajaController::class, 'actualizarMovimiento']);
    Route::get('/movimientos', [MovimientoCajaController::class, 'listarMovimientos']);
});