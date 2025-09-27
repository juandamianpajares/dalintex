<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\MovimientoStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    /**
     * Muestra la interfaz de ingreso de stock (simulación de Balanza/Scanner).
     */
    public function ingresoIndex()
    {
        $insumos = Insumo::all(['id', 'codigo', 'descripcion']);
        return view('stock.ingreso_index', compact('insumos'));
    }

    /**
     * Procesa el ingreso de stock y genera un MovimientoStock.
     */
    public function ingresarStock(Request $request)
    {
        $request->validate([
            'insumo_id' => 'required|exists:insumos,id',
            'cantidad' => 'required|numeric|min:0.01',
            'lote' => 'required|string|max:100',
            'fecha_vencimiento' => 'nullable|date',
        ]);

        $insumo = Insumo::find($request->insumo_id);
        
        // 1. Crear el registro de movimiento
        MovimientoStock::create([
            'insumo_id' => $insumo->id,
            'user_id' => 1, // **IMPORTANTE**: CAMBIAR A Auth::id()
            'tipo_movimiento' => 'ingreso',
            'cantidad' => $request->cantidad,
            'lote' => $request->lote,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'ubicacion_origen' => 'Proveedor',
            'ubicacion_destino' => $insumo->ubicacion ?? 'Almacén Principal'
        ]);

        // 2. Actualizar el stock actual del insumo
        $insumo->increment('stock_actual', $request->cantidad);

        return redirect()->route('stock.ingreso.index')
                         ->with('success', "Stock de '{$insumo->descripcion}' ingresado exitosamente. Cantidad: {$request->cantidad}.");
    }
}
