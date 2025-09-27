@extends('layouts.app')

@section('title', 'Ingreso de Stock (Simulación Balanza)')

@section('content')
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Ingreso de Stock por Balanza/Escáner</h1>
        <p class="text-gray-600 mb-6">Esta interfaz simula la recepción y pesaje de insumos (compras). Selecciona el insumo y registra la cantidad/lote.</p>

        <form action="{{ route('stock.ingreso.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Búsqueda de Insumo (Simulación Escáner) -->
            <div class="bg-blue-50 p-6 rounded-xl border border-blue-200">
                <h2 class="text-lg font-semibold text-blue-800 mb-3">1. Escaneo / Selección de Insumo</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label for="insumo_id" class="block text-sm font-medium text-gray-700">Buscar / Seleccionar Insumo</label>
                        <select name="insumo_id" id="insumo_id" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-colors">
                            <option value="">-- Seleccionar Insumo --</option>
                            @foreach ($insumos as $insumo)
                                <option value="{{ $insumo->id }}" {{ old('insumo_id') == $insumo->id ? 'selected' : '' }}>
                                    [{{ $insumo->codigo }}] - {{ $insumo->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                         <button type="button" onclick="alert('Simulando escaneo QR... El sistema identificaría el insumo automáticamente.')" class="bg-gray-500 text-white w-full py-2 px-4 rounded-xl shadow-md hover:bg-gray-600 transition-colors mt-5 md:mt-0">
                            Simular Escaneo QR
                        </button>
                    </div>
                </div>
            </div>

            <!-- Datos de Ingreso (Simulación Balanza) -->
            <div class="bg-green-50 p-6 rounded-xl border border-green-200">
                <h2 class="text-lg font-semibold text-green-800 mb-3">2. Datos de Pesaje / Lote</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad / Peso (kg, unidades)</label>
                        <input type="number" step="any" name="cantidad" id="cantidad" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50 transition-colors" value="{{ old('cantidad') }}" placeholder="Ej: 45.50">
                    </div>
                    <div>
                        <label for="lote" class="block text-sm font-medium text-gray-700">Número de Lote</label>
                        <input type="text" name="lote" id="lote" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50 transition-colors" value="{{ old('lote') }}" placeholder="Ej: LOTE-001-2025">
                    </div>
                    <div>
                        <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-700">Fecha de Vencimiento (Opcional)</label>
                        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50 transition-colors" value="{{ old('fecha_vencimiento') }}">
                    </div>
                </div>
            </div>


            <div class="flex justify-end space-x-4 pt-4 border-t">
                <button type="submit" class="bg-green-600 text-white font-semibold py-3 px-8 rounded-xl shadow-lg hover:bg-green-700 transition-colors text-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Confirmar Ingreso de Stock
                </button>
            </div>
        </form>
    </div>
@endsection
