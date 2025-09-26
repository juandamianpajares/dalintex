import React from 'react';

const Dashboard = () => {
  return (
<div className="bg-white p-6 rounded-lg shadow-md">
    <h1 className="text-2xl font-semibold text-gray-800 mb-4">Bienvenido al Sistema de Gesti�n de Stock</h1>
    <p className="text-gray-600">
        Aqu� podr�s ver un resumen de los indicadores clave de tu stock y pedidos.
    </p>
    {/* TODO: Agregar componentes de gr�ficos y m�tricas */}
</div>
  );
};

export default Dashboard;