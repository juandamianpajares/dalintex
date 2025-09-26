/**
 * Nombre del archivo: _app.jsx
 * Ruta sugerida: /pages/_app.jsx
 * Este archivo es el punto de entrada de la aplicación, esencial para Next.js.
 */
import 'tailwindcss/tailwind.css'; // Asegúrate de tener Tailwind CSS configurado

function MyApp({ Component, pageProps }) {
    return <Component {...pageProps} />;
}

export default MyApp;
