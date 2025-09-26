/**
 * Nombre del archivo: ordenes-compra.jsx
 * Ruta sugerida: /pages/ordenes-compra.jsx
 */
import { useState, useEffect } from 'react';
import axios from 'axios';
import Navbar from '../components/Navbar';
import OrdenesCompra from '../components/OrdenesCompra';
import Swal from 'sweetalert2';

export default function OrdenesCompraPage() {
    const [ordenes, setOrdenes] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchOrdenes();
    }, []);

    const fetchOrdenes = async () => {
        try {
            setLoading(true);
            const response = await axios.get('/api/ordenes-compra');
            setOrdenes(response.data);
        } catch (error) {
            console.error("Error al cargar las órdenes de compra:", error);
            Swal.fire('Error', 'No se pudieron cargar las órdenes de compra.', 'error');
        } finally {
            setLoading(false);
        }
    };

    return (
        <div>
            <Navbar />
            <main className="container mx-auto p-4">
                <h1 className="text-2xl font-bold mb-4">Gestión de Órdenes de Compra</h1>

                {loading ? (
                    <p className="text-center text-gray-500">Cargando órdenes...</p>
                ) : (
                    <div className="space-y-4">
                        {ordenes.length > 0 ? (
                            ordenes.map(orden => (
                                <OrdenesCompra key={orden.id} orden={orden} />
                            ))
                        ) : (
                            <p className="text-center text-gray-500">No hay órdenes de compra para mostrar.</p>
                        )}
                    </div>
                )}
            </main>
        </div>
    );
}
