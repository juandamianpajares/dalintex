<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoStock extends Model
{
    use HasFactory;

    protected $fillable = ['insumo_id', 'orden_compra_id', 'user_id', 'cantidad', 'tipo'];

    /**
     * Get the insumo that the movement belongs to.
     */
    public function insumo(): BelongsTo
    {
        return $this->belongsTo(Insumo::class);
    }

    /**
     * Get the order that the movement belongs to.
     */
    public function ordenCompra(): BelongsTo
    {
        return $this->belongsTo(OrdenCompra::class);
    }

    /**
     * Get the user that made the movement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
