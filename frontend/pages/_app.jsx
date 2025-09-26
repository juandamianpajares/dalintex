/**
 * Nombre del archivo: _app.jsx
 * Ruta sugerida: /pages/_app.jsx
 * Este archivo es el punto de entrada de la aplicaci�n, esencial para Next.js.
 */
import 'tailwindcss/tailwind.css'; // Aseg�rate de tener Tailwind CSS configurado

function MyApp({ Component, pageProps }) {
    return <Component {...pageProps} />;
}

export default MyApp;
