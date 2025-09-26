/**
 * Nombre del archivo: insumos.jsx
 * Ruta sugerida: /pages/insumos.jsx
 *
 * Esta página gestiona el registro, listado y eliminación de insumos.
 * Incluye la funcionalidad de la balanza para registrar la cantidad de stock.
 */
import { useState, useEffect } from 'react';
import axios from 'axios';
import Navbar from '../components/Navbar';
import Swal from 'sweetalert2';
import { leerPesoBalanza } from '../services/balanza_api';

export default function Insumos() {
    const [insumos, setInsumos] = useState([]);
    const [form, setForm] = useState({
        tipo: '',
        codigo: '',
        descripcion: '',
        proveedor: '',
        stock_actual: '',
        stock_minimo: '',
        ubicacion: '',
        cliente_sumistrador: ''
    });

    // useEffect para cargar los insumos al iniciar la página
    useEffect(() => {
        fetchInsumos();
    }, []);

    const fetchInsumos = async () => {
        try {
            const response = await axios.get('/api/insumos');
            setInsumos(response.data);
        } catch (error) {
            console.error("Error al cargar los insumos:", error);
            Swal.fire('Error', 'No se pudieron cargar los insumos.', 'error');
        }
    };

    const handleLeerPeso = async () => {
        const peso = await leerPesoBalanza();
        if (peso > 0) {
            setForm(prevForm => ({ ...prevForm, stock_actual: peso }));
            Swal.fire('¡Peso capturado!', `El peso de la balanza es: ${peso} gramos.`, 'success');
        }
    };

    const handleChange = (e) => {
        setForm({
            ...form,
            [e.target.name]: e.target.value
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await axios.post('/api/insumos', form);
            Swal.fire('¡Éxito!', 'Insumo registrado correctamente.', 'success');
            setForm({
                tipo: '',
                codigo: '',
                descripcion: '',
                proveedor: '',
                stock_actual: '',
                stock_minimo: '',
                ubicacion: '',
                cliente_sumistrador: ''
            });
            fetchInsumos(); // Recargar la lista de insumos
        } catch (error) {
            console.error("Error al registrar el insumo:", error);
            Swal.fire('Error', 'No se pudo registrar el insumo.', 'error');
        }
    };

    const handleDelete = async (id) => {
        try {
            await axios.delete(`/api/insumos/${id}`);
            Swal.fire('¡Eliminado!', 'Insumo eliminado correctamente.', 'success');
            fetchInsumos(); // Recargar la lista de insumos
        } catch (error) {
            console.error("Error al eliminar el insumo:", error);
            Swal.fire('Error', 'No se pudo eliminar el insumo.', 'error');
        }
    };

    return (
        <div>
            <Navbar />
            <main className="container mx-auto p-4">
                <h1 className="text-2xl font-bold mb-4">Gestión de Insumos</h1>

                {/* Formulario de Registro de Insumos */}
                <div className="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h2 className="text-xl font-semibold mb-4">Registrar Nuevo Insumo</h2>
                    <form onSubmit={handleSubmit}>
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <input type="text" name="tipo" value={form.tipo} onChange={handleChange} placeholder="Tipo (ej. Envase, Producto Químico)" className="p-2 border rounded" required />
                            <input type="text" name="codigo" value={form.codigo} onChange={handleChange} placeholder="Código" className="p-2 border rounded" required />
                            <input type="text" name="descripcion" value={form.descripcion} onChange={handleChange} placeholder="Descripción" className="p-2 border rounded" required />
                            <input type="text" name="proveedor" value={form.proveedor} onChange={handleChange} placeholder="Proveedor" className="p-2 border rounded" required />
                            <input type="text" name="ubicacion" value={form.ubicacion} onChange={handleChange} placeholder="Ubicación" className="p-2 border rounded" required />
                            <input type="text" name="cliente_sumistrador" value={form.cliente_sumistrador} onChange={handleChange} placeholder="Cliente Suministrador (Opcional)" className="p-2 border rounded" />
                            <input type="number" name="stock_minimo" value={form.stock_minimo} onChange={handleChange} placeholder="Stock Mínimo" className="p-2 border rounded" required />

                            {/* Sección para la balanza */}
                            <div className="md:col-span-3 lg:col-span-3 flex items-center gap-4">
                                <input
                                    type="number"
                                    name="stock_actual"
                                    value={form.stock_actual}
                                    onChange={handleChange}
                                    placeholder="Stock Actual (desde balanza)"
                                    className="p-2 border rounded w-1/3"
                                    readOnly
                                />
                                <button
                                    type="button"
                                    onClick={handleLeerPeso}
                                    className="bg-green-600 text-white p-2 rounded hover:bg-green-700 transition-colors"
                                >
                                    <i className="bi bi-smartwatch"></i> Leer de Balanza
                                </button>
                            </div>
                        </div>
                        <div className="mt-4">
                            <button type="submit" className="bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition-colors">
                                Registrar Insumo
                            </button>
                        </div>
                    </form>
                </div>

                {/* Tabla de Insumos Existentes */}
                <div className="bg-white p-6 rounded-lg shadow-md">
                    <h2 className="text-xl font-semibold mb-4">Listado de Insumos</h2>
                    <div className="overflow-x-auto">
                        <table className="min-w-full bg-white">
                            <thead>
                                <tr className="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th className="py-3 px-6 text-left">Código</th>
                                    <th className="py-3 px-6 text-left">Descripción</th>
                                    <th className="py-3 px-6 text-left">Stock Actual</th>
                                    <th className="py-3 px-6 text-left">Stock Mínimo</th>
                                    <th className="py-3 px-6 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="text-gray-600 text-sm font-light">
                                {insumos.map((insumo) => (
                                    <tr key={insumo.id} className="border-b border-gray-200 hover:bg-gray-100">
                                        <td className="py-3 px-6 text-left whitespace-nowrap">{insumo.codigo}</td>
                                        <td className="py-3 px-6 text-left">{insumo.descripcion}</td>
                                        <td className="py-3 px-6 text-left">{insumo.stock_actual}</td>
                                        <td className="py-3 px-6 text-left">{insumo.stock_minimo}</td>
                                        <td className="py-3 px-6 text-left">
                                            <button
                                                onClick={() => handleDelete(insumo.id)}
                                                className="bg-red-500 text-white p-1 rounded hover:bg-red-600 transition-colors"
                                            >
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    );
}
