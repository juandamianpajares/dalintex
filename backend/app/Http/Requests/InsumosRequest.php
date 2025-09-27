<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsumoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Se puede añadir lógica de autorización aquí, como verificar si el usuario tiene un rol específico
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
            'codigo' => 'required|string|unique:insumos,codigo',
            'descripcion' => 'required|string',
            'tipo_insumo_id' => 'required|exists:tipo_insumos,id',
            'proveedor' => 'required|string',
            'stock_minimo' => 'required|integer|min:0',
            'stock_actual' => 'required|integer|min:0',
            'ubicacion' => 'required|string',
            'cliente_sumistrador' => 'nullable|string',
            'producto_id' => 'nullable|exists:productos,id'
        ];
    }
}
