/**
 * Nombre del archivo: productos.jsx
 * Ruta sugerida: /pages/productos.jsx
 *
 * Esta página gestiona la creación, visualización y actualización de productos finales.
 * Permite vincular los productos a los insumos necesarios para su fabricación.
 */
import { useState, useEffect } from 'react';
import axios from 'axios';
import Navbar from '../components/Navbar';
import Swal from 'sweetalert2';

export default function Productos() {
    const [productos, setProductos] = useState([]);
    const [insumos, setInsumos] = useState([]);
    const [form, setForm] = useState({
        codigo: '',
        descripcion: '',
        unidad_medida: '',
        insumos_necesarios: []
    });

    // useEffect para cargar los productos e insumos al iniciar la página
    useEffect(() => {
        fetchProductos();
        fetchInsumos();
    }, []);

    const fetchProductos = async () => {
        try {
            const response = await axios.get('/api/productos');
            setProductos(response.data);
        } catch (error) {
            console.error("Error al cargar los productos:", error);
            Swal.fire('Error', 'No se pudieron cargar los productos.', 'error');
        }
    };

    const fetchInsumos = async () => {
        try {
            const response = await axios.get('/api/insumos');
            setInsumos(response.data);
        } catch (error) {
            console.error("Error al cargar los insumos:", error);
            Swal.fire('Error', 'No se pudieron cargar los insumos.', 'error');
        }
    };

    const handleChange = (e) => {
        const { name, value } = e.target;
        setForm({
            ...form,
            [name]: value
        });
    };

    const handleAddInsumo = () => {
        setForm({
            ...form,
            insumos_necesarios: [...form.insumos_necesarios, { insumo_id: '', cantidad: 0 }]
        });
    };

    const handleInsumoChange = (index, e) => {
        const { name, value } = e.target;
        const list = [...form.insumos_necesarios];
        list[index][name] = value;
        setForm({ ...form, insumos_necesarios: list });
    };

    const handleRemoveInsumo = (index) => {
        const list = [...form.insumos_necesarios];
        list.splice(index, 1);
        setForm({ ...form, insumos_necesarios: list });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await axios.post('/api/productos', form);
            Swal.fire('¡Éxito!', 'Producto registrado correctamente.', 'success');
            setForm({
                codigo: '',
                descripcion: '',
                unidad_medida: '',
                insumos_necesarios: []
            });
            fetchProductos();
        } catch (error) {
            console.error("Error al registrar el producto:", error);
            Swal.fire('Error', 'No se pudo registrar el producto.', 'error');
        }
    };

    const handleDelete = async (id) => {
        try {
            await axios.delete(`/api/productos/${id}`);
            Swal.fire('¡Eliminado!', 'Producto eliminado correctamente.', 'success');
            fetchProductos();
        } catch (error) {
            console.error("Error al eliminar el producto:", error);
            Swal.fire('Error', 'No se pudo eliminar el producto.', 'error');
        }
    };

    return (
        <div>
            <Navbar />
            <main className="container mx-auto p-4">
                <h1 className="text-2xl font-bold mb-4">Gestión de Productos</h1>

                {/* Formulario de Registro de Productos */}
                <div className="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h2 className="text-xl font-semibold mb-4">Registrar Nuevo Producto</h2>
                    <form onSubmit={handleSubmit}>
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="codigo" value={form.codigo} onChange={handleChange} placeholder="Código del Producto" className="p-2 border rounded" required />
                            <input type="text" name="descripcion" value={form.descripcion} onChange={handleChange} placeholder="Descripción" className="p-2 border rounded" required />
                            <input type="text" name="unidad_medida" value={form.unidad_medida} onChange={handleChange} placeholder="Unidad de Medida (ej. Kg, Lt)" className="p-2 border rounded" required />
                        </div>

                        <div className="mt-4">
                            <h3 className="font-semibold mb-2">Insumos Necesarios</h3>
                            {form.insumos_necesarios.map((insumo, index) => (
                                <div key={index} className="flex items-center gap-4 mb-2">
                                    <select
                                        name="insumo_id"
                                        value={insumo.insumo_id}
                                        onChange={(e) => handleInsumoChange(index, e)}
                                        className="p-2 border rounded w-1/2"
                                        required
                                    >
                                        <option value="">Seleccionar Insumo...</option>
                                        {insumos.map((i) => (
                                            <option key={i.id} value={i.id}>{i.descripcion} ({i.codigo})</option>
                                        ))}
                                    </select>
                                    <input
                                        type="number"
                                        name="cantidad"
                                        value={insumo.cantidad}
                                        onChange={(e) => handleInsumoChange(index, e)}
                                        placeholder="Cantidad"
                                        className="p-2 border rounded w-1/4"
                                        required
                                    />
                                    <button type="button" onClick={() => handleRemoveInsumo(index)} className="bg-red-500 text-white p-2 rounded hover:bg-red-600 transition-colors">
                                        Eliminar
                                    </button>
                                </div>
                            ))}
                            <button
                                type="button"
                                onClick={handleAddInsumo}
                                className="bg-gray-200 text-gray-800 p-2 rounded mt-2 hover:bg-gray-300 transition-colors"
                            >
                                Agregar Insumo
                            </button>
                        </div>

                        <div className="mt-4">
                            <button type="submit" className="bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition-colors">
                                Registrar Producto
                            </button>
                        </div>
                    </form>
                </div>

                {/* Tabla de Productos Existentes */}
                <div className="bg-white p-6 rounded-lg shadow-md">
                    <h2 className="text-xl font-semibold mb-4">Listado de Productos</h2>
                    <div className="overflow-x-auto">
                        <table className="min-w-full bg-white">
                            <thead>
                                <tr className="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th className="py-3 px-6 text-left">Código</th>
                                    <th className="py-3 px-6 text-left">Descripción</th>
                                    <th className="py-3 px-6 text-left">Unidad</th>
                                    <th className="py-3 px-6 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="text-gray-600 text-sm font-light">
                                {productos.map((producto) => (
                                    <tr key={producto.id} className="border-b border-gray-200 hover:bg-gray-100">
                                        <td className="py-3 px-6 text-left whitespace-nowrap">{producto.codigo}</td>
                                        <td className="py-3 px-6 text-left">{producto.descripcion}</td>
                                        <td className="py-3 px-6 text-left">{producto.unidad_medida}</td>
                                        <td className="py-3 px-6 text-left">
                                            <button
                                                onClick={() => handleDelete(producto.id)}
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
