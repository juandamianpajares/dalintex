<?php

namespace App\Services;

use App\Models\OrdenCompra;
use App\Models\Insumo;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Enums\EstadoOrdenCompra;

class OrdenCompraService
{
    /**
     * Obtiene todas las órdenes de compra con sus relaciones.
     *
     * @return Collection
     */
    public function getOrdenesCompra(): Collection
    {
        return OrdenCompra::with(['cliente', 'detalles.producto', 'usuario'])->get();
    }

    /**
     * Crea una nueva orden de compra y valida la disponibilidad de insumos.
     *
     * @param array $data
     * @return OrdenCompra
     * @throws \Exception
     */
    public function createOrdenCompra(array $data): OrdenCompra
    {
        DB::beginTransaction();

        try {
            $ordenCompra = OrdenCompra::create([
                'numero' => $data['numero'],
                'fecha' => $data['fecha'],
                'cliente_id' => $data['cliente_id'],
                'vencimiento_requerido' => $data['vencimiento_requerido'],
                'observaciones' => $data['observaciones'],
                'condiciones_pago' => $data['condiciones_pago'],
                'estado' => EstadoOrdenCompra::PENDIENTE, // Estado inicial
                'user_id' => $data['user_id']
            ]);

            // Crear detalles y validar stock
            foreach ($data['detalles'] as $detalle) {
                // Validación de disponibilidad de insumos (RF006)
                $producto = Producto::with('insumos')->find($detalle['producto_id']);
                if (!$producto) {
                    throw new \Exception("Producto con ID {$detalle['producto_id']} no encontrado.");
                }

                foreach ($producto->insumos as $insumoRequerido) {
                    $cantidadNecesaria = $insumoRequerido->pivot->cantidad * $detalle['cantidad'];
                    if ($insumoRequerido->stock_actual < $cantidadNecesaria) {
                        $estado = EstadoOrdenCompra::NO_REALIZABLE;
                        $ordenCompra->update(['estado' => $estado]);
                        throw new \Exception("Stock insuficiente para el insumo '{$insumoRequerido->descripcion}'. Faltan " . ($cantidadNecesaria - $insumoRequerido->stock_actual) . " unidades.");
                    }
                }

                $ordenCompra->detalles()->create($detalle);
            }

            // Si se cumple el stock para todos los insumos, actualizar el estado
            $ordenCompra->update(['estado' => EstadoOrdenCompra::REALIZABLE]);

            DB::commit();

            return $ordenCompra->load(['detalles']);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
