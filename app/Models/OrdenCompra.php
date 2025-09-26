<?php

namespace App\Models;

use App\Enums\EstadoOrdenCompra;
use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    protected $fillable = [
        'numero', 'fecha', 'cliente_id', 'estado', 
        'vencimiento_requerido', 'observaciones', 'condiciones_pago', 'user_id',
        'validado_por', // ID del usuario que valida el stock/ejecutabilidad (Encargado de Stock)
        'confirmado_por' // ID del usuario que confirma la orden (Gerente)
    ];
    
    // Casteo para asegurar que 'estado' use el Enum y 'fecha' sea un objeto Date
    protected $casts = [
        'estado' => EstadoOrdenCompra::class,
        'fecha' => 'date',
    ];
    
    /**
     * Relación con el Cliente asociado a la Orden.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    
    /**
     * Relación para obtener los productos/detalles de la orden de compra.
     */
    public function detalles()
    {
        return $this->hasMany(OrdenCompraDetalle::class);
    }
    
    /**
     * Relación con los movimientos de stock generados por esta orden.
     */
    public function movimientosStock()
    {
        return $this->hasMany(MovimientoStock::class);
    }
    
    /**
     * Relación con el usuario que creó la orden.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación para saber quién validó el stock de la orden (Encargado de Stock).
     */
    public function validadorStock()
    {
        return $this->belongsTo(User::class, 'validado_por');
    }

    /**
     * Relación para saber quién confirmó la orden (Gerente/Administración).
     */
    public function confirmador()
    {
        return $this->belongsTo(User::class, 'confirmado_por');
    }
    
    // Asumiendo que existe una relación a planes de producción, mantenemos la coherencia
    public function planesProduccion()
    {
        return $this->hasManyThrough(
            PlanProduccionDetalle::class,
            OrdenCompraDetalle::class
        );
    }
}