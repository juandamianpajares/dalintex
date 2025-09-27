<?php

namespace App\Services;

use App\Models\StockResidual;
use App\Models\MovimientoStock;
use App\Models\Insumo;
use Exception;
use Illuminate\Support\Facades\DB;

class StockResidualService
{
    /**
     * Registra un nuevo stock residual.
     *
     * @param array $data
     * @return StockResidual
     * @throws Exception
     */
    public function registrarSobrante(array $data): StockResidual
    {
        DB::beginTransaction();
        try {
            $insumo = Insumo::findOrFail($data['insumo_id']);
            
            $stockResidual = StockResidual::create([
                'insumo_id' => $insumo->id,
                'cantidad' => $data['cantidad'],
                'origen' => $data['origen'],
                'etiqueta' => $data['etiqueta'] ?? null,
                'autorizado_por' => $data['autorizado_por'] ?? null,
            ]);

            // Se registra como un movimiento de entrada
            MovimientoStock::create([
                'insumo_id' => $insumo->id,
                'cantidad' => $data['cantidad'],
                'tipo' => 'entrada_residual',
                'user_id' => $data['user_id']
            ]);

            // Actualizar stock del insumo
            $insumo->increment('stock_actual', $data['cantidad']);

            DB::commit();
            return $stockResidual;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error al registrar el stock residual: " . $e->getMessage());
        }
    }

    /**
     * Permite el uso de stock residual, si está autorizado.
     *
     * @param int $stockResidualId
     * @param int $cantidad
     * @return void
     * @throws Exception
     */
    public function utilizarResidual(int $stockResidualId, int $cantidad): void
    {
        DB::beginTransaction();
        try {
            $stockResidual = StockResidual::findOrFail($stockResidualId);

            if ($stockResidual->autorizado_por === null) {
                throw new Exception("El uso de este stock residual no está autorizado.");
            }
            if ($stockResidual->cantidad < $cantidad) {
                throw new Exception("Cantidad insuficiente de stock residual.");
            }

            // Decrementar stock residual
            $stockResidual->decrement('cantidad', $cantidad);

            // Registrar movimiento de salida
            MovimientoStock::create([
                'insumo_id' => $stockResidual->insumo_id,
                'cantidad' => $cantidad,
                'tipo' => 'salida_residual',
                'user_id' => auth()->id() // Usar el ID del usuario autenticado
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error al utilizar el stock residual: " . $e->getMessage());
        }
    }
}