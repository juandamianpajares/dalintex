<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Insumo;
use App\Models\MovimientoStock;
use App\Models\OrdenCompra;

class StockController extends Controller
{
    /**
     * Retorna el stock de insumos principales para la gr�fica de stock.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInsumosStock(): JsonResponse
    {
        // En un entorno real, se usar�an modelos para obtener datos reales.
        // Ejemplo con Eloquent:
        // $insumos = Insumo::orderBy('stock_actual', 'asc')
        //                 ->take(5)
        //                 ->get(['descripcion as nombre', 'stock_actual as stock']);

        // Datos de ejemplo simulados
        $data = [
            ['nombre' => 'Tela de Lino', 'stock' => 1200],
            ['nombre' => 'Botones', 'stock' => 2500],
            ['nombre' => 'Cierres', 'stock' => 800],
            ['nombre' => 'Hilo de Algod�n', 'stock' => 1500],
            ['nombre' => 'Etiquetas', 'stock' => 500],
        ];

        return response()->json(['data' => $data]);
    }

    /**
     * Retorna los �ltimos movimientos de stock para la tabla.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUltimosMovimientos(): JsonResponse
    {
        // Ejemplo con Eloquent:
        // $movimientos = MovimientoStock::with('insumo')
        //                             ->orderBy('created_at', 'desc')
        //                             ->take(10)
        //                             ->get();

        // Datos de ejemplo simulados
        $data = [
            ['fecha' => '2023-10-25', 'insumo' => 'Hilo de Poli�ster', 'cantidad' => 50, 'tipo' => 'Entrada'],
            ['fecha' => '2023-10-24', 'insumo' => 'Colorante Rojo', 'cantidad' => 10, 'tipo' => 'Salida'],
            ['fecha' => '2023-10-24', 'insumo' => 'Tela de Lino', 'cantidad' => 200, 'tipo' => 'Entrada'],
            ['fecha' => '2023-10-23', 'insumo' => 'Hilo de Algod�n', 'cantidad' => 20, 'tipo' => 'Salida'],
        ];

        return response()->json(['data' => $data]);
    }

    /**
     * Retorna alertas de stock bajo o cr�tico.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAlertasStock(): JsonResponse
    {
        // Ejemplo con Eloquent:
        // $alertas = Insumo::whereColumn('stock_actual', '<=', 'stock_minimo')->get();

        // Datos de ejemplo simulados
        $data = [
            ['insumo' => 'Cierres de Metal', 'stock' => 25, 'tipo' => 'danger', 'mensaje' => 'por debajo del stock m�nimo.'],
            ['insumo' => 'Colorante Azul', 'stock' => 40, 'tipo' => 'warning', 'mensaje' => 'pr�ximo a agotarse.'],
        ];

        return response()->json(['data' => $data]);
    }

    /**
     * Retorna un resumen de las �ltimas entradas de insumos (�rdenes de compra).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResumenEntradas(): JsonResponse
    {
        // Ejemplo con Eloquent:
        // $entradas = OrdenCompra::where('estado', 'completada')
        //                         ->with('cliente')
        //                         ->orderBy('updated_at', 'desc')
        //                         ->take(5)
        //                         ->get();

        // Datos de ejemplo simulados
        $data = [
            ['numero' => '#OC-2023-010', 'proveedor' => 'Proveedur�a Textil S.A.', 'fecha' => '2023-10-25', 'productos' => ['Hilo', 'Telas']],
            ['numero' => '#OC-2023-009', 'proveedor' => 'F�brica de Insumos', 'fecha' => '2023-10-24', 'productos' => ['Cierres', 'Botones']],
        ];

        return response()->json(['data' => $data]);
    }
}
