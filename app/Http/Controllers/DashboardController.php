<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Retorna el estado del stock de insumos para la gráfica.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInsumosStock(): JsonResponse
    {
        // En un entorno real, aquí se obtendrían los datos de la base de datos
        // usando un modelo, por ejemplo:
        // $insumos = Insumo::select('nombre', 'stock_actual')->get();

        // Datos de ejemplo
        $data = [
            ['nombre' => 'Hilo de Poliéster', 'stock' => 1500],
            ['nombre' => 'Colorante Azul', 'stock' => 850],
            ['nombre' => 'Botones', 'stock' => 2500],
            ['nombre' => 'Cierres', 'stock' => 1200],
            ['nombre' => 'Etiquetas', 'stock' => 3000],
        ];

        return response()->json(['data' => $data]);
    }

    /**
     * Retorna el estado de las órdenes de compra para la gráfica.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrdenesEstado(): JsonResponse
    {
        // En un entorno real, se usaría una consulta agrupada, por ejemplo:
        // $ordenes = OrdenCompra::groupBy('estado')->selectRaw('estado, count(*) as cantidad')->get();

        // Datos de ejemplo
        $data = [
            ['estado' => 'Pendiente', 'cantidad' => 7],
            ['estado' => 'Realizable', 'cantidad' => 12],
            ['estado' => 'No Realizable', 'cantidad' => 3],
            ['estado' => 'Completada', 'cantidad' => 45],
        ];

        return response()->json(['data' => $data]);
    }

    /**
     * Retorna alertas de inventario (stock bajo, etc.).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInventarioAlertas(): JsonResponse
    {
        // En un entorno real, se haría una consulta de los insumos donde el stock_actual
        // sea menor o igual al stock_minimo.
        // $alertas = Insumo::where('stock_actual', '<=', 'stock_minimo')->get();

        // Datos de ejemplo
        $data = [
            ['insumo' => 'Hilo de Algodón', 'mensaje' => 'Stock bajo. ¡Pedido urgente!', 'stock' => 10, 'tipo' => 'danger'],
            ['insumo' => 'Cajas de Cartón', 'mensaje' => 'Stock próximo a agotarse.', 'stock' => 50, 'tipo' => 'warning'],
        ];

        return response()->json(['data' => $data]);
    }

    /**
     * Retorna una lista de órdenes de compra con sobrantes para autorización.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAutorizacionesPendientes(): JsonResponse
    {
        // En un entorno real, se obtendrían órdenes de compra con estado 'pendiente_autorizacion'.
        // $ordenes = OrdenCompra::where('estado', 'pendiente_autorizacion')->with('cliente')->get();

        // Datos de ejemplo
        $data = [
            ['numero' => 'OC-2023-001', 'cliente' => 'VANIPLACE MADO', 'sobrante' => '15 unidades'],
            ['numero' => 'OC-2023-005', 'cliente' => 'Cliente A', 'sobrante' => '5 rollos'],
        ];

        return response()->json(['data' => $data]);
    }
}
