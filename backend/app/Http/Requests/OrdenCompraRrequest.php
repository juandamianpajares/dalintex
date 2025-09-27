<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrdenCompraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'numero' => 'required|string|unique:orden_compras,numero',
            'fecha' => 'required|date',
            'cliente_id' => 'required|exists:clientes,id',
            'vencimiento_requerido' => 'nullable|date',
            'observaciones' => 'nullable|string',
            'condiciones_pago' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'detalles' => 'required|array',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio' => 'nullable|numeric|min:0',
        ];
    }
}
