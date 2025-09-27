<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\JsonResponse;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $productos = Producto::all();
        return response()->json($productos);
    }
}
