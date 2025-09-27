<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Enums\TipoInsumo;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    /**
     * Muestra una lista de todos los insumos (Compras).
     */
    public function index()
    {
        $insumos = Insumo::orderBy('descripcion', 'asc')->get();
        return view('insumos.index', compact('insumos'));
    }

    /**
     * Muestra el formulario para crear un nuevo insumo.
     */
    public function create()
    {
        $tipos = TipoInsumo::getValues();
        return view('insumos.create', compact('tipos'));
    }

    /**
     * Almacena un nuevo insumo.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:' . implode(',', TipoInsumo::getValues()),
            'codigo' => 'required|unique:insumos,codigo',
            'descripcion' => 'required|string|max:255',
            'stock_minimo' => 'nullable|integer|min:0',
        ]);

        Insumo::create([
            'tipo' => $request->tipo,
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'proveedor' => $request->proveedor,
            'stock_actual' => 0, // Se inicia en 0, el stock se ingresa por Balanza
            'stock_minimo' => $request->stock_minimo ?? 0,
            'ubicacion' => $request->ubicacion
        ]);

        return redirect()->route('insumos.index')
                         ->with('success', 'Insumo registrado exitosamente. Stock inicial 0.');
    }
}
