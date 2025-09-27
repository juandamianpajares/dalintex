<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = ['codigo', 'descripcion', 'unidad_medida', 'cliente_id'];
    
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    
    public function insumos()
    {
        return $this->belongsToMany(Insumo::class, 'producto_insumo')
                   ->withPivot('cantidad');
    }
    
    public function ordenCompraDetalles()
    {
        return $this->hasMany(OrdenCompraDetalle::class);
    }
}