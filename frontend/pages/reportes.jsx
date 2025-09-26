/**
 * Nombre del archivo: reportes.jsx
 * Ruta sugerida: /pages/reportes.jsx
 */
import React from 'react';
import Navbar from '../components/Navbar';

const Reportes = () => {
    return (
        <>
            <Navbar />
            <main className="container mx-auto p-4 mt-8">
                <h1 className="text-3xl font-bold mb-6 text-gray-800">Reportes y Métricas</h1>
                <div className="bg-white p-6 rounded-lg shadow-md">
                    <p className="text-gray-600">
                        En esta sección se mostrarán los reportes y análisis del sistema. Próximamente se implementarán las visualizaciones.
                    </p>
                </div>
            </main>
        </>
    );
};

export default Reportes;