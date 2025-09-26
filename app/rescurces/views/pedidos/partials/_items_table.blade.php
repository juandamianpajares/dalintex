@switch($pedido->estado)
    @case('pendiente')
        <span class="badge bg-secondary">Pendiente</span>
        @break
    @case('urgente')
        <span class="badge bg-warning">Urgente</span>
        @break
    @case('completado')
        <span class="badge bg-success">Completado</span>
        @break
    @default
        <span class="badge bg-primary">{{ ucfirst($pedido->estado) }}</span>
@endswitch