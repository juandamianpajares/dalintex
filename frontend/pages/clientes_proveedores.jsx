/**
 * Nombre del archivo: clientes_proveedores.jsx
 * Ruta sugerida: /pages/clientes_proveedores.jsx
 *
 * Esta página permite la gestión de clientes y proveedores.
 * Utiliza un sistema de pestañas para alternar entre las vistas
 * de cada uno, simplificando la interfaz de usuario.
 */
import { useState, useEffect } from 'react';
import axios from 'axios';
import Navbar from '../components/Navbar';
import Swal from 'sweetalert2';
import Papa from 'papaparse';

export default function ClientesProveedores() {
  const [tab, setTab] = useState('clientes');
  const [clientes, setClientes] = useState([]);
  const [proveedores, setProveedores] = useState([]);
  const [isLoading, setIsLoading] = useState(false);
  const [file, setFile] = useState(null);

  // Estados para los formularios
  const [clienteForm, setClienteForm] = useState({ nombre: '', contacto: '', email: '', telefono: '', direccion: '' });
  const [proveedorForm, setProveedorForm] = useState({ nombre: '', contacto: '', email: '', telefono: '', direccion: '' });

  useEffect(() => {
    fetchData();
  }, []);

  const fetchData = async () => {
    setIsLoading(true);
    try {
      const clientesResponse = await axios.get('/api/clientes');
      const proveedoresResponse = await axios.get('/api/proveedores');
      setClientes(clientesResponse.data);
      setProveedores(proveedoresResponse.data);
    } catch (error) {
      console.error("Error al cargar datos:", error);
      Swal.fire('Error', 'No se pudieron cargar los datos de clientes y proveedores.', 'error');
    } finally {
      setIsLoading(false);
    }
  };

  const handleClienteSubmit = async (e) => {
    e.preventDefault();
    try {
      await axios.post('/api/clientes', clienteForm);
      Swal.fire('¡Éxito!', 'Cliente registrado correctamente.', 'success');
      setClienteForm({ nombre: '', contacto: '', email: '', telefono: '', direccion: '' });
      fetchData(); // Recargar datos
    } catch (error) {
      console.error("Error al registrar cliente:", error);
      Swal.fire('Error', 'No se pudo registrar el cliente.', 'error');
    }
  };

  const handleProveedorSubmit = async (e) => {
    e.preventDefault();
    try {
      await axios.post('/api/proveedores', proveedorForm);
      Swal.fire('¡Éxito!', 'Proveedor registrado correctamente.', 'success');
      setProveedorForm({ nombre: '', contacto: '', email: '', telefono: '', direccion: '' });
      fetchData(); // Recargar datos
    } catch (error) {
      console.error("Error al registrar proveedor:", error);
      Swal.fire('Error', 'No se pudo registrar el proveedor.', 'error');
    }
  };

  const handleFileChange = (e) => {
    setFile(e.target.files[0]);
  };

  const handleImport = () => {
    if (!file) {
      Swal.fire('Advertencia', 'Por favor, selecciona un archivo.', 'warning');
      return;
    }

    Papa.parse(file, {
      header: true,
      complete: async (results) => {
        setIsLoading(true);
        const dataToImport = results.data;
        const apiEndpoint = tab === 'clientes' ? '/api/clientes' : '/api/proveedores';
        
        try {
          for (const item of dataToImport) {
            await axios.post(apiEndpoint, item);
          }
          Swal.fire('¡Éxito!', `Datos importados correctamente.`, 'success');
          fetchData();
        } catch (error) {
          console.error("Error al importar datos:", error);
          Swal.fire('Error', 'Hubo un problema al importar los datos. Verifica el formato del archivo.', 'error');
        } finally {
          setIsLoading(false);
        }
      }
    });
  };

  const renderClientes = () => (
    <>
      <h2 className="text-xl font-semibold mb-4">Registrar Nuevo Cliente</h2>
      <form onSubmit={handleClienteSubmit} className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <input
          type="text"
          placeholder="Nombre"
          value={clienteForm.nombre}
          onChange={(e) => setClienteForm({ ...clienteForm, nombre: e.target.value })}
          className="p-2 border rounded-md"
          required
        />
        <input
          type="text"
          placeholder="Contacto"
          value={clienteForm.contacto}
          onChange={(e) => setClienteForm({ ...clienteForm, contacto: e.target.value })}
          className="p-2 border rounded-md"
        />
        <input
          type="email"
          placeholder="Email"
          value={clienteForm.email}
          onChange={(e) => setClienteForm({ ...clienteForm, email: e.target.value })}
          className="p-2 border rounded-md"
        />
        <input
          type="tel"
          placeholder="Teléfono"
          value={clienteForm.telefono}
          onChange={(e) => setClienteForm({ ...clienteForm, telefono: e.target.value })}
          className="p-2 border rounded-md"
        />
        <input
          type="text"
          placeholder="Dirección"
          value={clienteForm.direccion}
          onChange={(e) => setClienteForm({ ...clienteForm, direccion: e.target.value })}
          className="p-2 border rounded-md col-span-2"
        />
        <button type="submit" className="bg-blue-500 text-white p-2 rounded-md col-span-2">
          Registrar Cliente
        </button>
      </form>
      
      <div className="border-t pt-4 mt-4">
        <h2 className="text-xl font-semibold mb-2">Importar Clientes desde CSV</h2>
        <div className="flex items-center space-x-2">
          <input 
            type="file" 
            accept=".csv" 
            onChange={handleFileChange}
            className="p-2 border rounded-md"
          />
          <button 
            type="button" 
            onClick={handleImport}
            className="bg-green-500 text-white p-2 rounded-md"
          >
            Importar
          </button>
        </div>
      </div>

      <h2 className="text-xl font-semibold mb-4 mt-6">Listado de Clientes</h2>
      {isLoading ? (
        <p>Cargando clientes...</p>
      ) : (
        <div className="overflow-x-auto">
          <table className="min-w-full bg-white">
            <thead>
              <tr className="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th className="py-3 px-6 text-left">Nombre</th>
                <th className="py-3 px-6 text-left">Contacto</th>
                <th className="py-3 px-6 text-left">Email</th>
                <th className="py-3 px-6 text-left">Teléfono</th>
                <th className="py-3 px-6 text-left">Acciones</th>
              </tr>
            </thead>
            <tbody className="text-gray-600 text-sm font-light">
              {clientes.map((cliente) => (
                <tr key={cliente.id} className="border-b border-gray-200 hover:bg-gray-100">
                  <td className="py-3 px-6 text-left">{cliente.nombre}</td>
                  <td className="py-3 px-6 text-left">{cliente.contacto}</td>
                  <td className="py-3 px-6 text-left">{cliente.email}</td>
                  <td className="py-3 px-6 text-left">{cliente.telefono}</td>
                  <td className="py-3 px-6 text-left whitespace-nowrap">
                    <button className="bg-yellow-500 text-white px-2 py-1 rounded-md text-xs mr-2">Editar</button>
                    <button className="bg-red-500 text-white px-2 py-1 rounded-md text-xs">Eliminar</button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </>
  );

  const renderProveedores = () => (
    <>
      <h2 className="text-xl font-semibold mb-4">Registrar Nuevo Proveedor</h2>
      <form onSubmit={handleProveedorSubmit} className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <input
          type="text"
          placeholder="Nombre"
          value={proveedorForm.nombre}
          onChange={(e) => setProveedorForm({ ...proveedorForm, nombre: e.target.value })}
          className="p-2 border rounded-md"
          required
        />
        <input
          type="text"
          placeholder="Contacto"
          value={proveedorForm.contacto}
          onChange={(e) => setProveedorForm({ ...proveedorForm, contacto: e.target.value })}
          className="p-2 border rounded-md"
        />
        <input
          type="email"
          placeholder="Email"
          value={proveedorForm.email}
          onChange={(e) => setProveedorForm({ ...proveedorForm, email: e.target.value })}
          className="p-2 border rounded-md"
        />
        <input
          type="tel"
          placeholder="Teléfono"
          value={proveedorForm.telefono}
          onChange={(e) => setProveedorForm({ ...proveedorForm, telefono: e.target.value })}
          className="p-2 border rounded-md"
        />
        <input
          type="text"
          placeholder="Dirección"
          value={proveedorForm.direccion}
          onChange={(e) => setProveedorForm({ ...proveedorForm, direccion: e.target.value })}
          className="p-2 border rounded-md col-span-2"
        />
        <button type="submit" className="bg-blue-500 text-white p-2 rounded-md col-span-2">
          Registrar Proveedor
        </button>
      </form>
      
      <div className="border-t pt-4 mt-4">
        <h2 className="text-xl font-semibold mb-2">Importar Proveedores desde CSV</h2>
        <div className="flex items-center space-x-2">
          <input 
            type="file" 
            accept=".csv" 
            onChange={handleFileChange}
            className="p-2 border rounded-md"
          />
          <button 
            type="button" 
            onClick={handleImport}
            className="bg-green-500 text-white p-2 rounded-md"
          >
            Importar
          </button>
        </div>
      </div>

      <h2 className="text-xl font-semibold mb-4 mt-6">Listado de Proveedores</h2>
      {isLoading ? (
        <p>Cargando proveedores...</p>
      ) : (
        <div className="overflow-x-auto">
          <table className="min-w-full bg-white">
            <thead>
              <tr className="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th className="py-3 px-6 text-left">Nombre</th>
                <th className="py-3 px-6 text-left">Contacto</th>
                <th className="py-3 px-6 text-left">Email</th>
                <th className="py-3 px-6 text-left">Teléfono</th>
                <th className="py-3 px-6 text-left">Acciones</th>
              </tr>
            </thead>
            <tbody className="text-gray-600 text-sm font-light">
              {proveedores.map((proveedor) => (
                <tr key={proveedor.id} className="border-b border-gray-200 hover:bg-gray-100">
                  <td className="py-3 px-6 text-left">{proveedor.nombre}</td>
                  <td className="py-3 px-6 text-left">{proveedor.contacto}</td>
                  <td className="py-3 px-6 text-left">{proveedor.email}</td>
                  <td className="py-3 px-6 text-left">{proveedor.telefono}</td>
                  <td className="py-3 px-6 text-left whitespace-nowrap">
                    <button className="bg-yellow-500 text-white px-2 py-1 rounded-md text-xs mr-2">Editar</button>
                    <button className="bg-red-500 text-white px-2 py-1 rounded-md text-xs">Eliminar</button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </>
  );

  return (
    <div>
      <Navbar />
      <main className="container mx-auto p-4">
        <h1 className="text-3xl font-bold mb-6">Gestión de Clientes y Proveedores</h1>
        <div className="bg-white p-6 rounded-lg shadow-md">
          <div className="flex border-b border-gray-200 mb-4">
            <button
              onClick={() => setTab('clientes')}
              className={`py-2 px-4 text-sm font-medium focus:outline-none ${tab === 'clientes' ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-500 hover:text-gray-700'}`}
            >
              Clientes
            </button>
            <button
              onClick={() => setTab('proveedores')}
              className={`py-2 px-4 text-sm font-medium focus:outline-none ${tab === 'proveedores' ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-500 hover:text-gray-700'}`}
            >
              Proveedores
            </button>
          </div>
          {tab === 'clientes' ? renderClientes() : renderProveedores()}
        </div>
      </main>
    </div>
  );
}
