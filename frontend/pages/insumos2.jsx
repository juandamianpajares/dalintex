/**
 * Nombre del archivo: insumos.jsx
 * Ruta sugerida: /pages/insumos.jsx
 */
import React, { useState, useEffect } from 'react';
import Navbar from '../components/Navbar';
import axios from 'axios'; // Se asume que axios está instalado (npm install axios)
import Swal from 'sweetalert2';

const Insumos = () => {
    const [insumos, setInsumos] = useState([]);
    const [tiposInsumo, setTiposInsumo] = useState([]);
    const [productos, setProductos] = useState([]);
    const [formData, setFormData] = useState({
        codigo: '',
        descripcion: '',
        tipo_insumo_id: '',
        ubicacion: '',
        cliente_sumistrador: '',
        stock_actual: 0,
        stock_minimo: 0,
        producto_id: ''
    });

    useEffect(() => {
        // Cargar datos de la API al montar el componente
        const fetchData = async () => {
            try {
                const [insumosRes, tiposRes, productosRes] = await Promise.all([
                    axios.get('/api/insumos'),
                    axios.get('/api/tipo-insumos'),
                    axios.get('/api/productos')
                ]);
                setInsumos(insumosRes.data);
                setTiposInsumo(tiposRes.data);
                setProductos(productosRes.data);
            } catch (error) {
                Swal.fire('Error', 'No se pudieron cargar los datos.', 'error');
            }
        };
        fetchData();
    }, []);

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await axios.post('/api/insumos', formData);
            Swal.fire('Éxito', 'Insumo registrado correctamente.', 'success');
            setFormData({
                codigo: '',
                descripcion: '',
                tipo_insumo_id: '',
                ubicacion: '',
                cliente_sumistrador: '',
                stock_actual: 0,
                stock_minimo: 0,
                producto_id: ''
            });
            // Recargar la lista de insumos
            const insumosRes = await axios.get('/api/insumos');
            setInsumos(insumosRes.data);
        } catch (error) {
            Swal.fire('Error', 'No se pudo registrar el insumo.', 'error');
        }
    };

    return (
        <>
            <Navbar />
            <main className="container mx-auto p-4 mt-8">
                <h1 className="text-3xl font-bold mb-6 text-gray-800">Gestión de Insumos</h1>

                <div className="bg-white p-6 rounded-lg shadow-md mb-8">
                    <h2 className="text-xl font-semibold mb-4">Registrar Nuevo Insumo</h2>
                    <form onSubmit={handleSubmit} className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label className="block text-sm font-medium text-gray-700">Código</label>
                            <input type="text" name="codigo" value={formData.codigo} onChange={handleChange} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required />
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-gray-700">Descripción</label>
                            <input type="text" name="descripcion" value={formData.descripcion} onChange={handleChange} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required />
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-gray-700">Tipo de Insumo</label>
                            <select name="tipo_insumo_id" value={formData.tipo_insumo_id} onChange={handleChange} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">Seleccionar Tipo</option>
                                {tiposInsumo.map(tipo => (
                                    <option key={tipo.id} value={tipo.id}>{tipo.nombre}</option>
                                ))}
                            </select>
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-gray-700">Ubicación</label>
                            <input type="text" name="ubicacion" value={formData.ubicacion} onChange={handleChange} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required />
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-gray-700">Cliente/Suministrador</label>
                            <input type="text" name="cliente_sumistrador" value={formData.cliente_sumistrador} onChange={handleChange} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required />
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-gray-700">Stock Actual</label>
                            <input type="number" name="stock_actual" value={formData.stock_actual} onChange={handleChange} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required />
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-gray-700">Stock Mínimo</label>
                            <input type="number" name="stock_minimo" value={formData.stock_minimo} onChange={handleChange} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required />
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-gray-700">Asociar a Producto</label>
                            <select name="producto_id" value={formData.producto_id} onChange={handleChange} className="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Ninguno</option>
                                {productos.map(producto => (
                                    <option key={producto.id} value={producto.id}>{producto.descripcion}</option>
                                ))}
                            </select>
                        </div>
                        <div className="md:col-span-2 lg:col-span-3">
                            <button type="submit" className="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700">
                                Registrar Insumo
                            </button>
                        </div>
                    </form>
                </div>

                <div className="bg-white p-6 rounded-lg shadow-md">
                    <h2 className="text-xl font-semibold mb-4">Listado de Insumos</h2>
                    <div className="overflow-x-auto">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mínimo</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto Asociado</th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {insumos.map(insumo => (
                                    <tr key={insumo.id}>
                                        <td className="px-6 py-4 whitespace-nowrap">{insumo.codigo}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">{insumo.descripcion}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">{tiposInsumo.find(t => t.id === insumo.tipo_insumo_id)?.nombre || 'N/A'}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">{insumo.ubicacion}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">{insumo.cliente_sumistrador}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">{insumo.stock_actual}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">{insumo.stock_minimo}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">{productos.find(p => p.id === insumo.producto_id)?.descripcion || 'Ninguno'}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </>
    );
};

export default Insumos;
