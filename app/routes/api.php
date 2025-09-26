<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\OrdenCompraController;
use App\Http\Controllers\StockResidualController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas de la API para tu aplicación.
| Estas rutas son cargadas por el RouteServiceProvider dentro de un grupo
| que se asigna al middleware "api". Disfruta construyendo tu API!
|
*/

// Ruta de prueba para verificar la conexión
Route::get('/saludo', function () {
    return response()->json(['mensaje' => '¡API funcional!']);
});

// Rutas para Insumos
Route::apiResource('insumos', InsumoController::class);

// Rutas para Ordenes de Compra
Route::apiResource('ordenes-compra', OrdenCompraController::class);
Route::put('ordenes-compra/{orden}/validar-stock', [OrdenCompraController::class, 'validarStock']);
Route::put('ordenes-compra/{orden}/confirmar', [OrdenCompraController::class, 'confirmar']);

// Rutas para Stock Residual
Route::apiResource('stock-residual', StockResidualController::class);


Route::get('/insumos/stock', [DashboardController::class, 'getInsumosStock']);
Route::get('/ordenes/estado', [DashboardController::class, 'getOrdenesEstado']);
Route::get('/inventario/alertas', [DashboardController::class, 'getInventarioAlertas']);
Route::get('/ordenes/autorizaciones', [DashboardController::class, 'getAutorizacionesPendientes']);

Route::get('/stock/insumos', [StockController::class, 'getInsumosStock']);
Route::get('/stock/movimientos', [StockController::class, 'getUltimosMovimientos']);
Route::get('/stock/alertas', [StockController::class, 'getAlertasStock']);
Route::get('/stock/entradas', [StockController::class, 'getResumenEntradas']);