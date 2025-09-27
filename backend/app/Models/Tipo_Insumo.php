<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoInsumo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    /**
     * Get the insumos for the tipo de insumo.
     */
    public function insumos(): HasMany
    {
        return $this->hasMany(Insumo::class);
    }
}