<?php

namespace App\Http\Controllers;

use App\Services\StockResidualService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\StockResidual;

class StockResidualController extends Controller
{
    protected $service;

    public function __construct(StockResidualService $service)
    {
        $this->service = $service;
    }

    /**
     * Registra un nuevo sobrante de producción (RF009).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'insumo_id' => 'required|exists:insumos,id',
            'cantidad' => 'required|integer|min:1',
            'origen' => 'required|string',
            'etiqueta' => 'nullable|string',
            'autorizado_por' => 'nullable|exists:users,id',
        ]);
        
        $data = $request->all();
        $data['user_id'] = auth()->id(); // Asignar el usuario actual
        
        try {
            $stockResidual = $this->service->registrarSobrante($data);
            return response()->json($stockResidual, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Utiliza una cantidad de stock residual (RF010).
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function utilizar(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        try {
            $this->service->utilizarResidual($id, $request->cantidad);
            return response()->json(['message' => 'Stock residual utilizado correctamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Muestra el stock residual (RF011).
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $stockResidual = StockResidual::with('insumo')->get();
        return response()->json($stockResidual);
    }
}
