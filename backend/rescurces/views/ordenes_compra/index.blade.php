@extends('layouts.app')

@section('title', 'Listado de Órdenes de Compra')

@section('content')
    <div class="bg-white p-6 rounded-2xl shadow-xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Órdenes de Compra</h1>
            <a href="{{ route('ordenes-compra.create') }}" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-xl shadow-md hover:bg-blue-700 transition-colors">
                + Crear Nueva OC
            </a>
        </div>

        <div class="overflow-x-auto relative rounded-xl shadow-md">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="py-3 px-6">Número / ID</th>
                        <th scope="col" class="py-3 px-6">Cliente</th>
                        <th scope="col" class="py-3 px-6">Fecha</th>
                        <th scope="col" class="py-3 px-6">Estado</th>
                        <th scope="col" class="py-3 px-6">Creador</th>
                        <th scope="col" class="py-3 px-6">Validado por</th>
                        <th scope="col" class="py-3 px-6">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ordenes as $orden)
                        <tr class="bg-white border-b hover:bg-gray-50 text-gray-700">
                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                {{ $orden->numero }} (#{{ $orden->id }})
                            </th>
                            <td class="py-4 px-6">{{ $orden->cliente->nombre ?? 'N/A' }}</td>
                            <td class="py-4 px-6">{{ $orden->fecha->format('d/m/Y') }}</td>
                            <td class="py-4 px-6">
                                @php
                                    $color = match($orden->estado->value) {
                                        'pendiente' => 'bg-yellow-100 text-yellow-800',
                                        'realizable' => 'bg-blue-100 text-blue-800',
                                        'ejecutable' => 'bg-green-100 text-green-800',
                                        'completada' => 'bg-gray-100 text-gray-800',
                                        default => 'bg-red-100 text-red-800',
                                    };
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                    {{ $orden->estado->value }}
                                </span>
                            </td>
                            <td class="py-4 px-6">{{ $orden->usuario->name ?? 'Sistema' }}</td>
                            <td class="py-4 px-6">{{ $orden->validadorStock->name ?? 'Pendiente' }}</td>
                            <td class="py-4 px-6">
                                <a href="{{ route('ordenes-compra.show', $orden->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold">Ver Detalle</a>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b">
                            <td colspan="7" class="py-4 px-6 text-center text-gray-500">No hay órdenes de compra registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
