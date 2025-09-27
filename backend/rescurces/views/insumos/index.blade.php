@extends('layouts.app')

@section('title', 'Gestión de Compras / Insumos')

@section('content')
    <div class="bg-white p-6 rounded-2xl shadow-xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Insumos y Materiales</h1>
            <a href="{{ route('insumos.create') }}" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-xl shadow-md hover:bg-blue-700 transition-colors">
                + Registrar Nuevo Insumo
            </a>
        </div>

        <div class="overflow-x-auto relative rounded-xl shadow-md">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="py-3 px-6">Código / Tipo</th>
                        <th scope="col" class="py-3 px-6">Descripción</th>
                        <th scope="col" class="py-3 px-6">Stock Actual</th>
                        <th scope="col" class="py-3 px-6">Stock Mínimo</th>
                        <th scope="col" class="py-3 px-6">Ubicación</th>
                        <th scope="col" class="py-3 px-6">Proveedor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($insumos as $insumo)
                        <tr class="bg-white border-b hover:bg-gray-50 text-gray-700">
                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                {{ $insumo->codigo }}
                                <span class="block text-xs text-gray-500">{{ ucfirst($insumo->tipo->value) }}</span>
                            </th>
                            <td class="py-4 px-6">{{ $insumo->descripcion }}</td>
                            <td class="py-4 px-6 font-bold @if($insumo->stock_actual < $insumo->stock_minimo) text-red-500 @else text-green-700 @endif">
                                {{ $insumo->stock_actual }}
                            </td>
                            <td class="py-4 px-6">{{ $insumo->stock_minimo }}</td>
                            <td class="py-4 px-6">{{ $insumo->ubicacion ?? 'N/A' }}</td>
                            <td class="py-4 px-6">{{ $insumo->proveedor ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b">
                            <td colspan="6" class="py-4 px-6 text-center text-gray-500">No hay insumos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
