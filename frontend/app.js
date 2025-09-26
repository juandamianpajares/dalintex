// Lógica para ingreso manual
document.getElementById('form-ingreso-manual').addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
        title: '¡Artículo registrado!',
        text: 'El stock se ha actualizado correctamente',
        icon: 'success'
    });
    this.reset();
});

// Lógica para gestión de pedidos
document.getElementById('btn-add-producto').addEventListener('click', function() {
    const container = document.getElementById('productos-container');
    const newProduct = `
        <div class="row g-3 mb-3 producto-item">
            <div class="col-md-5">
                <select class="form-select" required>
                    <option value="">Seleccionar producto...</option>
                    <option>GEL TERMOREDUCTOR 300ML</option>
                    <option>CREMA REDUCTORA 245ML</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" placeholder="Cantidad" min="1" required>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Lote" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm remove-product">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newProduct);
});

// Delegación de eventos para eliminar productos
document.getElementById('productos-container').addEventListener('click', function(e) {
    if (e.target.closest('.remove-product')) {
        e.target.closest('.producto-item').remove();
    }
});