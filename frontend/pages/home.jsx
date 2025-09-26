import Head from 'next/head';
import Navbar from '../components/Navbar';
import Dashboard from '../components/Dashboard';

export default function Home() {
  return (
    <>
<Head>
    <title>DALINTEX - Gestión de Stock</title>
    <meta name="description" content="Sistema de Gestión de Stock DALINTEX" />
    <link rel="icon" href="/favicon.ico" />
</Head>

<Navbar />
<main className="container mx-auto p-4 mt-8">
    <Dashboard />
</main>
    </>
  );
}