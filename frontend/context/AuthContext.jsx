/**
 * Nombre del archivo: AuthContext.jsx
 * Ruta sugerida: /context/AuthContext.jsx
 */
import { createContext, useContext, useState } from 'react';

const AuthContext = createContext(null);

export const AuthProvider = ({ children }) => {
    // Estado inicial del usuario: sin rol definido
    const [user, setUser] = useState({ role: null });

    return (
        <AuthContext.Provider value={{ user, setUser }}>
            {children}
        </AuthContext.Provider>
    );
};

// Hook personalizado para usar el contexto
export const useAuth = () => {
    return useContext(AuthContext);
};
