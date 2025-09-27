<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenCompraDetalle extends Model
{
   
// Nombre de la tabla explícitamente definido para consistencia
    protected $table = 'orden_compra_detalles';

    protected $fillable = [
        'orden_compra_id',
        'producto_id',
        'cantidad_solicitada',
        'cantidad_sobrante',
        'lote',
    ];

    /**
     * Relación con la Orden de Compra.
     */
    public function ordenCompra()
    {
        return $this->belongsTo(OrdenCompra::class);
    }

    /**
     * Relación con el Producto solicitado.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
