/**
 * Nombre del archivo: ordenes-compra.jsx
 * Ruta sugerida: /pages/ordenes-compra.jsx
 */
import React from 'react';
import Navbar from '../components/Navbar';

const OrdenesCompra = () => {
    return (
        <>
            <Navbar />
            <main className="container mx-auto p-4 mt-8">
                <h1 className="text-3xl font-bold mb-6 text-gray-800">Gestión de Órdenes de Compra</h1>
                <div className="bg-white p-6 rounded-lg shadow-md">
                    <p className="text-gray-600">
                        Aquí se gestionarán las órdenes de compra. Próximamente se implementará la tabla y el formulario para crear nuevas órdenes.
                    </p>
                </div>
            </main>
        </>
    );
};

export default OrdenesCompra;
