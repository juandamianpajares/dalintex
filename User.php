<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'role'];
    
    protected $hidden = ['password', 'remember_token'];
    
    public function ordenesCompra()
    {
        return $this->hasMany(OrdenCompra::class);
    }
    
    public function movimientosStock()
    {
        return $this->hasMany(MovimientoStock::class);
    }
    
    public function planesProduccion()
    {
        return $this->hasMany(PlanProduccion::class);
    }
}