@extends('layouts.app')

@section('title', 'Detalle OC #' . $ordenCompra->numero)

@section('content')
    <div class="bg-white p-8 rounded-2xl shadow-xl">
        <div class="flex justify-between items-start mb-8 border-b pb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Orden de Compra #{{ $ordenCompra->numero }}</h1>
                <p class="text-lg text-gray-600 mt-1">Cliente: <span class="font-semibold">{{ $ordenCompra->cliente->nombre ?? 'N/A' }}</span></p>
            </div>
            <div>
                @php
                    $color = match($ordenCompra->estado->value) {
                        'pendiente' => 'bg-yellow-500',
                        'realizable' => 'bg-blue-500',
                        'ejecutable' => 'bg-green-500',
                        'completada' => 'bg-gray-500',
                        default => 'bg-red-500',
                    };
                @endphp
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-white {{ $color }} shadow-md">
                    Estado: {{ strtoupper($ordenCompra->estado->value) }}
                </span>
            </div>
        </div>

        <!-- Información General -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-sm font-medium text-gray-500">Fecha de Emisión</p>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $ordenCompra->fecha->format('d/m/Y') }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-sm font-medium text-gray-500">Creada por</p>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $ordenCompra->usuario->name ?? 'Sistema' }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-sm font-medium text-gray-500">Vencimiento Requerido</p>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $ordenCompra->vencimiento_requerido ?? 'No especificado' }} días</p>
            </div>
        </div>

        <!-- Auditoría y Flujo de Trabajo (Validado/Confirmado) -->
        <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Control de Flujo</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="p-4 bg-yellow-50 rounded-xl border border-yellow-300">
                <p class="text-sm font-medium text-gray-700">Validación de Stock (Encargado)</p>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $ordenCompra->validadorStock->name ?? 'PENDIENTE DE VALIDACIÓN' }}</p>

                @if (!$ordenCompra->validado_por)
                    <!-- Formulario de simulación de validación -->
                    <form action="{{ route('ordenes-compra.validarStock', $ordenCompra->id) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="flex space-x-2">
                            <select name="validado_por" required class="block w-full text-sm rounded-xl border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-500 focus:ring-opacity-50">
                                <option value="">Asignar Validador</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-yellow-600 text-white py-2 px-4 text-sm rounded-xl hover:bg-yellow-700 transition-colors">
                                Validar
                            </button>
                        </div>
                    </form>
                @endif
            </div>

            <div class="p-4 bg-blue-50 rounded-xl border border-blue-300">
                <p class="text-sm font-medium text-gray-700">Confirmación de Gerencia</p>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $ordenCompra->confirmador->name ?? 'PENDIENTE DE CONFIRMACIÓN' }}</p>
                <!-- Omitimos el formulario de confirmación por ahora para simplificar el MVP -->
                @if ($ordenCompra->validado_por && !$ordenCompra->confirmado_por)
                    <p class="mt-3 text-xs text-blue-600">Listo para confirmación.</p>
                @endif
            </div>
        </div>

        <!-- Observaciones y Pago -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-700 mb-2 border-b pb-2">Otros Detalles</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-medium text-gray-500">Condiciones de Pago</p>
                    <p class="mt-1 text-gray-800">{{ $ordenCompra->condiciones_pago ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Observaciones</p>
                    <p class="mt-1 text-gray-800">{{ $ordenCompra->observaciones ?? 'No hay observaciones.' }}</p>
                </div>
            </div>
        </div>

        <!-- Detalle de Productos -->
        <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Detalles de Productos (Simulado)</h2>
        @if ($ordenCompra->detalles->isEmpty())
             <div class="p-4 bg-red-50 text-red-700 rounded-xl border border-red-300">
                <p>No hay productos registrados para esta orden. (Se requiere implementar el CRUD para los detalles).</p>
            </div>
        @else
            <!-- Si tienes el modelo OrdenCompraDetalle, muestra la tabla -->
            <div class="overflow-x-auto relative rounded-xl shadow-md">
                <table class="w-full text-sm text-left text-gray-500">
                    <!-- ... tabla de detalles ... -->
                </table>
            </div>
        @endif


        <div class="mt-8 pt-4 border-t flex justify-start">
            <a href="{{ route('ordenes-compra.index') }}" class="py-2 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                ← Volver al Listado
            </a>
        </div>
    </div>
@endsection
