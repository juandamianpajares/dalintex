<?php

namespace App\Models;

use App\Enums\TipoInsumo;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $fillable = [
        'tipo', 'codigo', 'descripcion', 'proveedor', 
        'stock_actual', 'stock_minimo', 'ubicacion', 'cliente_sumistrador'
    ];
    
    protected $casts = [
        'tipo' => TipoInsumo::class,
    ];
    
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_insumo')
                   ->withPivot('cantidad');
    }
    
    public function movimientos()
    {
        return $this->hasMany(MovimientoStock::class);
    }
}