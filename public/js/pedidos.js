// Priorización de pedidos
document.querySelectorAll('.btn-priorizar').forEach(btn => {
    btn.addEventListener('click', function() {
        const pedidoId = this.dataset.id;
        
        Swal.fire({
            title: '¿Marcar como urgente?',
            text: 'Este pedido saltará al inicio de la cola',
            icon: 'question',
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/pedidos/${pedidoId}/priorizar`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                });
            }
        });
    });
});

// Filtrado AJAX
document.getElementById('filtros-pedidos').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('/pedidos/filtrar', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(html => {
        document.querySelector('tbody').innerHTML = html;
    });
});