<?php

namespace App\Services;

use App\Models\Insumo;
use App\Models\Producto;
use App\Models\TipoInsumo;
use Illuminate\Database\Eloquent\Collection;

class InsumoService
{
    /**
     * Obtener todos los insumos con sus relaciones.
     *
     * @return Collection
     */
    public function getAllInsumos(): Collection
    {
        // Carga las relaciones de producto y tipo de insumo para evitar N+1 queries
        return Insumo::with(['producto', 'tipoInsumo'])->get();
    }

    /**
     * Crear un nuevo insumo.
     *
     * @param array $data
     * @return Insumo
     */
    public function createInsumo(array $data): Insumo
    {
        return Insumo::create($data);
    }

    /**
     * Obtener un insumo por su ID.
     *
     * @param int $id
     * @return Insumo|null
     */
    public function getInsumoById(int $id): ?Insumo
    {
        return Insumo::find($id);
    }
}
