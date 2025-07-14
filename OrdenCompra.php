<?php

namespace App\Models;

use App\Enums\EstadoOrdenCompra;
use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    protected $fillable = [
        'numero', 'fecha', 'cliente_id', 'estado', 
        'vencimiento_requerido', 'observaciones', 'condiciones_pago', 'user_id'
    ];
    
    protected $casts = [
        'estado' => EstadoOrdenCompra::class,
        'fecha' => 'date',
    ];
    
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    
    public function detalles()
    {
        return $this->hasMany(OrdenCompraDetalle::class);
    }
    
    public function movimientosStock()
    {
        return $this->hasMany(MovimientoStock::class);
    }
    
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function planesProduccion()
    {
        return $this->hasManyThrough(
            PlanProduccionDetalle::class,
            OrdenCompraDetalle::class
        );
    }
}