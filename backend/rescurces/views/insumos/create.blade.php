@extends('layouts.app')

@section('title', 'Registrar Nuevo Insumo')

@section('content')
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Registrar Nuevo Insumo</h1>

        <form action="{{ route('insumos.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Tipo y Código -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de Insumo</label>
                    <select name="tipo" id="tipo" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-colors">
                        <option value="">Seleccionar Tipo</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo }}" {{ old('tipo') == $tipo ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $tipo)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="codigo" class="block text-sm font-medium text-gray-700">Código de Insumo</label>
                    <input type="text" name="codigo" id="codigo" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-colors" value="{{ old('codigo') }}">
                </div>
            </div>

            <!-- Descripción -->
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción Detallada</label>
                <input type="text" name="descripcion" id="descripcion" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-colors" value="{{ old('descripcion') }}">
            </div>

            <!-- Proveedor, Stock Mínimo y Ubicación -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="proveedor" class="block text-sm font-medium text-gray-700">Proveedor</label>
                    <input type="text" name="proveedor" id="proveedor" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-colors" value="{{ old('proveedor') }}">
                </div>
                <div>
                    <label for="stock_minimo" class="block text-sm font-medium text-gray-700">Stock Mínimo</label>
                    <input type="number" name="stock_minimo" id="stock_minimo" min="0" value="{{ old('stock_minimo', 0) }}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-colors">
                </div>
                 <div>
                    <label for="ubicacion" class="block text-sm font-medium text-gray-700">Ubicación (Almacén)</label>
                    <input type="text" name="ubicacion" id="ubicacion" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-colors" value="{{ old('ubicacion') }}">
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-4 border-t">
                <a href="{{ route('insumos.index') }}" class="py-2 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-xl shadow-lg hover:bg-blue-700 transition-colors">
                    Guardar Insumo
                </button>
            </div>
        </form>
    </div>
@endsection
