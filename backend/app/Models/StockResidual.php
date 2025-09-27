<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenCompra;
use App\Http\Requests\OrdenCompraRequest;
use App\Services\OrdenCompraService;

class OrdenCompraController extends Controller
{
    protected $ordenCompraService;

    public function __construct(OrdenCompraService $ordenCompraService)
    {
        $this->ordenCompraService = $ordenCompraService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $ordenes = $this->ordenCompraService->getOrdenesCompra();
        return response()->json($ordenes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OrdenCompraRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OrdenCompraRequest $request)
    {
        try {
            $ordenCompra = $this->ordenCompraService->createOrdenCompra($request->validated());
            return response()->json($ordenCompra, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
