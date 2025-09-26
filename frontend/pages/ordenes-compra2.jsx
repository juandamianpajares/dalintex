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
                <h1 className="text-3xl font-bold mb-6 text-gray-800">Gesti�n de �rdenes de Compra</h1>
                <div className="bg-white p-6 rounded-lg shadow-md">
                    <p className="text-gray-600">
                        Aqu� se gestionar�n las �rdenes de compra. Pr�ximamente se implementar� la tabla y el formulario para crear nuevas �rdenes.
                    </p>
                </div>
            </main>
        </>
    );
};

export default OrdenesCompra;
