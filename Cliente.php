<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['nombre', 'contacto', 'email', 'telefono', 'direccion'];
    
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
    
    public function ordenesCompra()
    {
        return $this->hasMany(OrdenCompra::class);
    }
}