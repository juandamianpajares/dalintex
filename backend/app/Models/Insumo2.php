<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * title="Insumo",
 * description="Modelo de datos para Insumos",
 * @OA\Xml(name="Insumo"),
 * )
 */
class Insumo extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     * title="ID",
     * description="ID del insumo",
     * format="int64",
     * example=1
     * )
     * @OA\Property(
     * title="C�digo",
     * description="C�digo �nico del insumo",
     * example="INS-001"
     * )
     * @OA\Property(
     * title="Descripci�n",
     * description="Descripci�n del insumo",
     * example="Tapas de pl�stico blancas"
     * )
     * @OA\Property(
     * title="Stock",
     * description="Cantidad actual en stock",
     * format="int32",
     * example=150
     * )
     */
    protected $fillable = [
        'codigo',
        'descripcion',
        'tipo',
        'proveedor',
        'stock_minimo',
        'stock_actual',
        'ubicacion'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'insumos';
}
