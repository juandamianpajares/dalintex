/**
 * Nombre del archivo: index.jsx
 * Ruta sugerida: /pages/index.jsx
 */
import { useState } from 'react';
import { useRouter } from 'next/router';
import { useAuth } from '../context/AuthContext';

export default function Home() {
  const [selectedRole, setSelectedRole] = useState('');
  const { setUser } = useAuth();
  const router = useRouter();

  const handleLogin = () => {
    if (selectedRole) {
      setUser({ role: selectedRole });
      router.push('/insumos');
    } else {
      alert('Por favor, selecciona un rol para continuar.');
    }
  };

  return (
    <div className="min-h-screen bg-gray-100 flex flex-col justify-center items-center">
      <div className="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
        <h1 className="text-3xl font-bold text-center text-gray-800 mb-6">
          Bienvenido a DALINTEX
        </h1>
        <div className="space-y-4">
          <div>
            <label htmlFor="role-select" className="block text-gray-700 font-semibold mb-2">
              Selecciona tu rol
            </label>
            <select
              id="role-select"
              value={selectedRole}
              onChange={(e) => setSelectedRole(e.target.value)}
              className="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="">-- Seleccionar --</option>
              <option value="encargado_stock">Encargado de Stock</option>
              <option value="gerente">Gerente</option>
            </select>
          </div>
          <button
            onClick={handleLogin}
            className="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-700 transition-colors duration-200"
          >
            Ingresar
          </button>
        </div>
      </div>
    </div>
  );
}
