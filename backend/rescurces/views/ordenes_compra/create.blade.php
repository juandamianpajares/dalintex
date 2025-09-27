@extends('layouts.app')

@section('title', 'Crear Nueva Orden de Compra')

@section('content')
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Crear Orden de Compra</h1>

        <form action="{{ route('ordenes-compra.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Número y Fecha -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="numero" class="block text-sm font-medium text-gray-700">Número de Orden</label>
                    <input type="text" name="numero" id="numero" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-colors" value="{{ old('numero') }}">
                </div>
                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha de Emisión</label>
                    <input type="date" name="fecha" id="fecha" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-colors" value="{{ old('fecha', date('Y-m-d')) }}">
                </div>
            </div>

            <!-- Cliente y Estado -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="cliente_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                    <select name="cliente_id" id="cliente_id" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-colors">
                        <option value="">Seleccione un Cliente</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700">Estado Inicial</label>
                    <select name="estado" id="estado" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-colors">
                        @foreach ($estados as $estado)
                            <option value="{{ $estado }}" {{ old('estado', 'pendiente') == $estado ? 'selected' : '' }}>
                                {{ ucfirst($estado) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Condiciones de Pago y Vencimiento -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="condiciones_pago" class="block text-sm font-medium text-gray-700">Condiciones de Pago</label>
                    <input type="text" name="condiciones_pago" id="condiciones_pago" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-colors" value="{{ old('condiciones_pago') }}">
                </div>
                <div>
                    <label for="vencimiento_requerido" class="block text-sm font-medium text-gray-700">Días Vencimiento Requerido</label>
                    <input type="number" name="vencimiento_requerido" id="vencimiento_requerido" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-colors" value="{{ old('vencimiento_requerido') }}">
                </div>
            </div>

            <!-- Observaciones -->
            <div>
                <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones</label>
                <textarea name="observaciones" id="observaciones" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-colors">{{ old('observaciones') }}</textarea>
            </div>

            <!-- Productos (Nota: Esto requiere un CRUD secundario, lo omitimos para el MVP simple) -->
            <div class="bg-gray-50 p-4 rounded-lg border border-dashed text-gray-600">
                <p class="font-semibold">Detalle de Productos (Simplificado)</p>
                <p class="text-sm">Para el MVP, asume que los detalles se añadirán después o que esta orden solo registra la cabecera.</p>
            </div>


            <div class="flex justify-end space-x-4 pt-4 border-t">
                <a href="{{ route('ordenes-compra.index') }}" class="py-2 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-xl shadow-lg hover:bg-blue-700 transition-colors">
                    Guardar Orden
                </button>
            </div>
        </form>
    </div>
@endsection
