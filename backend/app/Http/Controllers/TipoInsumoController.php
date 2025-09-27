<?php

namespace App\Http\Controllers;

use App\Models\TipoInsumo;
use Illuminate\Http\JsonResponse;

class TipoInsumoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tiposInsumo = TipoInsumo::all();
        return response()->json($tiposInsumo);
    }
}
