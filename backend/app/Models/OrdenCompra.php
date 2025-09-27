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
     * Relaci�n con el Cliente asociado a la Orden.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    
    /**
     * Relaci�n para obtener los productos/detalles de la orden de compra.
     */
    public function detalles()
    {
        return $this->hasMany(OrdenCompraDetalle::class);
    }
    
    /**
     * Relaci�n con los movimientos de stock generados por esta orden.
     */
    public function movimientosStock()
    {
        return $this->hasMany(MovimientoStock::class);
    }
    
    /**
     * Relaci�n con el usuario que cre� la orden.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relaci�n para saber qui�n valid� el stock de la orden (Encargado de Stock).
     */
    public function validadorStock()
    {
        return $this->belongsTo(User::class, 'validado_por');
    }

    /**
     * Relaci�n para saber qui�n confirm� la orden (Gerente/Administraci�n).
     */
    public function confirmador()
    {
        return $this->belongsTo(User::class, 'confirmado_por');
    }
    
    // Asumiendo que existe una relaci�n a planes de producci�n, mantenemos la coherencia
    public function planesProduccion()
    {
        return $this->hasManyThrough(
            PlanProduccionDetalle::class,
            OrdenCompraDetalle::class
        );
    }
}