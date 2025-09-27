<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DALINTEX Stock')</title>
    <!-- Carga de Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex">
                    <a href="{{ route('ordenes-compra.index') }}" class="flex-shrink-0 flex items-center text-white text-xl font-bold">
                        DALINTEX OC
                    </a>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('ordenes-compra.index') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Órdenes de Compra</a>
                        <a href="#" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium opacity-70 cursor-not-allowed">Insumos (WIP)</a>
                    </div>
                </div>
                <!-- Simulación de Usuario -->
                <div class="text-white text-sm">
                    Hola, Usuario Demo (ID: 1)
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
                    <p class="font-bold">¡Hubo un error!</p>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>
</html>
