<div class="card shadow">
    <div class="card-header bg-white">
        <h4><i class="bi bi-file-earmark-plus"></i> Nueva Orden de Compra</h4>
    </div>
    <div class="card-body">
        <form id="form-nuevo-pedido" action="{{ route('pedidos.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Cliente *</label>
                    <select class="form-select" name="cliente_id" required>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fecha Entrega *</label>
                    <input type="date" class="form-control" name="fecha_entrega" required>
                </div>
                <div class="col-12">
                    <hr>
                    <h5>Productos</h5>
                    <div id="items-container">
                        <!-- Items dinámicos -->
                    </div>
                    <button type="button" id="btn-add-item" class="btn btn-sm btn-outline-primary mt-2">
                        <i class="bi bi-plus-circle"></i> Agregar Producto
                    </button>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Guardar Pedido
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Dinámica de agregar productos
document.getElementById('btn-add-item').addEventListener('click', function() {
    const container = document.getElementById('items-container');
    const newItem = `
        <div class="row g-3 mb-3 item-pedido">
            <div class="col-md-5">
                <select class="form-select" name="producto_id[]" required>
                    <option value="">Seleccionar producto...</option>
                    @foreach($productos as $prod)
                        <option value="{{ $prod->id }}">{{ $prod->nombre }} ({{ $prod->codigo }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="cantidad[]" min="1" placeholder="Cantidad" required>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="lote[]" placeholder="Lote/Referencia">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm remove-item">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newItem);
});

// Eliminar items
document.getElementById('items-container').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-item')) {
        e.target.closest('.item-pedido').remove();
    }
});
</script>
@endpush