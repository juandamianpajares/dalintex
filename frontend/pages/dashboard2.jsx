import React from 'react';

const Dashboard = () => {
  return (
<div className="bg-white p-6 rounded-lg shadow-md">
    <h1 className="text-2xl font-semibold text-gray-800 mb-4">Bienvenido al Sistema de Gestión de Stock</h1>
    <p className="text-gray-600">
        Aquí podrás ver un resumen de los indicadores clave de tu stock y pedidos.
    </p>
    {/* TODO: Agregar componentes de gráficos y métricas */}
</div>
  );
};

export default Dashboard;