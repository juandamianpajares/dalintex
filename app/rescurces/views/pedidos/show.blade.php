<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">OC-{{ $pedido->numero }} - {{ $pedido->cliente->nombre }}</h4>
                <span class="badge bg-{{ $pedido->estado === 'urgente' ? 'warning' : 'primary' }}">
                    {{ ucfirst($pedido->estado) }}
                </span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Lote</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedido->items as $item)
                            <tr>
                                <td>{{ $item->producto->nombre }} <small class="text-muted">{{ $item->producto->codigo }}</small></td>
                                <td>{{ $item->cantidad }}</td>
                                <td>{{ $item->lote ?? 'N/A' }}</td>
                                <td>
                                    @if($item->completado)
                                        <span class="badge bg-success">Listo</span>
                                    @else
                                        <span class="badge bg-secondary">Pendiente</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-gear"></i> Acciones</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($pedido->estado !== 'urgente')
                    <button class="btn btn-warning btn-sm btn-block btn-priorizar" data-id="{{ $pedido->id }}">
                        <i class="bi bi-exclamation-triangle"></i> Marcar como Urgente
                    </button>
                    @endif
                    
                    <a href="#" class="btn btn-primary btn-sm btn-block">
                        <i class="bi bi-printer"></i> Generar Remito
                    </a>
                    
                    @if($pedido->estado === 'pendiente')
                    <button class="btn btn-success btn-sm btn-block btn-completar" data-id="{{ $pedido->id }}">
                        <i class="bi bi-check-circle"></i> Completar Pedido
                    </button>
                    @endif
                </div>
                
                <hr>
                
                <h6>Historial</h6>
                <ul class="list-group list-group-flush">
                    @foreach($pedido->historial as $evento)
                    <li class="list-group-item small">
                        <strong>{{ $evento->created_at->format('d/m H:i') }}:</strong>
                        {{ $evento->descripcion }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>