/**
 * Nombre del archivo: dashboard.jsx
 * Ruta sugerida: /pages/dashboard.jsx
 *
 * Esta página es el panel de control central de la aplicación.
 * Proporciona una visión general del estado del stock de insumos y
 * la viabilidad de las órdenes de compra.
 */
import { useState, useEffect } from 'react';
import axios from 'axios';
import Navbar from '../components/Navbar';
import Swal from 'sweetalert2';

export default function Dashboard() {
    const [insumos, setInsumos] = useState([]);
    const [ordenes, setOrdenes] = useState([]);
    const [productos, setProductos] = useState([]);
    const [isDataLoaded, setIsDataLoaded] = useState(false);

    useEffect(() => {
        fetchData();
    }, []);

    const fetchData = async () => {
        try {
            const insumosResponse = await axios.get('/api/insumos');
            const ordenesResponse = await axios.get('/api/ordenes-compra');
            const productosResponse = await axios.get('/api/productos');
            setInsumos(insumosResponse.data);
            setOrdenes(ordenesResponse.data);
            setProductos(productosResponse.data);
            setIsDataLoaded(true);
        } catch (error) {
            console.error("Error al cargar datos del dashboard:", error);
            Swal.fire('Error', 'No se pudieron cargar los datos del dashboard.', 'error');
        }
    };

    // Función para determinar si una orden es realizable
    const esOrdenRealizable = (orden) => {
        if (!orden.productos || orden.productos.length === 0) {
            return { status: 'realizable', faltantes: [] };
        }

        const insumosFaltantes = [];

        for (const productoOrden of orden.productos) {
            const producto = productos.find(p => p.id === productoOrden.producto_id);
            if (producto && producto.insumos_necesarios) {
                for (const insumoNecesario of producto.insumos_necesarios) {
                    const insumoEnStock = insumos.find(i => i.id === insumoNecesario.insumo_id);
                    const cantidadRequerida = insumoNecesario.cantidad * productoOrden.cantidad;
                    if (!insumoEnStock || insumoEnStock.stock_actual < cantidadRequerida) {
                        insumosFaltantes.push({
                            insumo: insumoEnStock?.descripcion || 'Insumo desconocido',
                            cantidad_faltante: cantidadRequerida - (insumoEnStock?.stock_actual || 0)
                        });
                    }
                }
            }
        }

        return {
            status: insumosFaltantes.length === 0 ? 'realizable' : 'no_realizable',
            faltantes: insumosFaltantes
        };
    };

    const insumosBajoMinimo = insumos.filter(insumo => insumo.stock_actual < insumo.stock_minimo);
    const ordenesNoRealizables = ordenes.filter(orden => esOrdenRealizable(orden).status === 'no_realizable');

    return (
        <div>
            <Navbar />
            <main className="container mx-auto p-4">
                <h1 className="text-3xl font-bold mb-6">Dashboard de Producción</h1>

                {/* Tarjetas de Resumen */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div className="bg-blue-100 p-6 rounded-lg shadow-md text-blue-700">
                        <h2 className="text-xl font-semibold mb-2">Total de Insumos</h2>
                        <p className="text-4xl font-bold">{insumos.length}</p>
                    </div>
                    <div className="bg-yellow-100 p-6 rounded-lg shadow-md text-yellow-700">
                        <h2 className="text-xl font-semibold mb-2">Órdenes de Compra</h2>
                        <p className="text-4xl font-bold">{ordenes.length}</p>
                    </div>
                    <div className="bg-red-100 p-6 rounded-lg shadow-md text-red-700">
                        <h2 className="text-xl font-semibold mb-2">Órdenes No Realizables</h2>
                        <p className="text-4xl font-bold">{ordenesNoRealizables.length}</p>
                    </div>
                </div>

                {/* Sección de Alertas */}
                <div className="bg-white p-6 rounded-lg shadow-md mb-6">
                    <div className="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                        <p className="font-bold">Alertas de Stock Crítico</p>
                        {insumosBajoMinimo.length > 0 ? (
                            <ul className="list-disc ml-5 mt-2">
                                {insumosBajoMinimo.map((insumo) => (
                                    <li key={insumo.id}>
                                        El insumo **{insumo.descripcion}** está por debajo del stock mínimo. Stock actual: {insumo.stock_actual}.
                                    </li>
                                ))}
                            </ul>
                        ) : (
                            <p className="mt-2">No hay insumos con stock por debajo del mínimo.</p>
                        )}
                    </div>
                </div>

                {/* Sección de Órdenes de Compra */}
                <div className="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h2 className="text-xl font-semibold mb-4">Estado de Órdenes de Compra</h2>
                    <div className="overflow-x-auto">
                        <table className="min-w-full bg-white">
                            <thead>
                                <tr className="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th className="py-3 px-6 text-left">Nro. Orden</th>
                                    <th className="py-3 px-6 text-left">Estado</th>
                                    <th className="py-3 px-6 text-left">Insumos Faltantes</th>
                                </tr>
                            </thead>
                            <tbody className="text-gray-600 text-sm font-light">
                                {isDataLoaded && ordenes.map((orden) => {
                                    const estado = esOrdenRealizable(orden);
                                    return (
                                        <tr key={orden.id} className="border-b border-gray-200 hover:bg-gray-100">
                                            <td className="py-3 px-6 text-left whitespace-nowrap">{orden.numero}</td>
                                            <td className="py-3 px-6 text-left">
                                                <span className={`px-2 py-1 font-semibold rounded-full ${estado.status === 'realizable' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'}`}>
                                                    {estado.status === 'realizable' ? 'Realizable' : 'No Realizable'}
                                                </span>
                                            </td>
                                            <td className="py-3 px-6 text-left">
                                                {estado.faltantes.length > 0 ? (
                                                    <ul className="list-disc ml-5">
                                                        {estado.faltantes.map((item, index) => (
                                                            <li key={index}>{item.insumo}: {item.cantidad_faltante} unidades</li>
                                                        ))}
                                                    </ul>
                                                ) : (
                                                    '--'
                                                )}
                                            </td>
                                        </tr>
                                    );
                                })}
                                {!isDataLoaded && (
                                    <tr>
                                        <td colSpan="3" className="py-3 px-6 text-center">Cargando datos...</td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    );
}
