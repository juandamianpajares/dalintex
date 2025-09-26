@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Filtros Superiores -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form id="filtros-pedidos">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Cliente</label>
                        <select class="form-select" name="cliente">
                            <option value="">Todos</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        @include('pedidos.partials._estados')
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fecha Desde</label>
                        <input type="date" class="form-control" name="fecha_desde">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel"></i> Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Listado + Acciones -->
    <div class="card shadow">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-clipboard-check"></i> Órdenes de Compra</h4>
            <a href="{{ route('pedidos.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Nueva OC
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>N° OC</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Productos</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                        <tr class="{{ $pedido->estado === 'urgente' ? 'table-warning' : '' }}">
                            <td>{{ $pedido->numero }}</td>
                            <td>{{ $pedido->cliente->nombre }}</td>
                            <td>{{ $pedido->fecha->format('d/m/Y') }}</td>
                            <td>
                                @foreach($pedido->items as $item)
                                <span class="badge bg-info">{{ $item->producto->codigo }}</span>
                                @endforeach
                            </td>
                            <td>
                                @include('pedidos.partials._estado_badge')
                            </td>
                            <td>
                                <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($pedido->estado === 'pendiente')
                                <button class="btn btn-sm btn-outline-success btn-priorizar" data-id="{{ $pedido->id }}">
                                    <i class="bi bi-arrow-up-circle"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $pedidos->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/pedidos.js') }}"></script>
@endpush