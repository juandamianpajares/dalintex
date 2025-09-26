
<?php
// Este archivo simula la estructura de múltiples migraciones necesarias para el sistema.
// En un entorno de Laravel real, cada bloque 'Schema::create' estaría en su propio archivo.

use App\Enums\EstadoOrdenCompra;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migración para la tabla de Usuarios (users)
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('role')->default('encargado_stock'); // Roles: gerente, encargado_stock
    $table->timestamps();
});

// Migración para la tabla de Clientes (clientes)
Schema::create('clientes', function (Blueprint $table) {
    $table->id();
    $table->string('nombre')->unique();
    $table->string('contacto')->nullable();
    $table->string('email')->nullable();
    $table->string('telefono')->nullable();
    $table->string('direccion')->nullable();
    $table->timestamps();
});

// Migración para la tabla de Insumos (insumos)
Schema::create('insumos', function (Blueprint $table) {
    $table->id();
    $table->string('tipo'); // Tipo de insumo, ej: 'tela', 'quimico', 'envase'
    $table->string('codigo')->unique();
    $table->string('descripcion');
    $table->string('proveedor')->nullable();
    $table->unsignedBigInteger('stock_actual')->default(0);
    $table->unsignedBigInteger('stock_minimo')->default(0);
    $table->string('ubicacion')->nullable();
    $table->foreignId('cliente_sumistrador')->nullable()->constrained('clientes'); // Para insumos que vienen del cliente
    $table->timestamps();
});

// Migración para la tabla de Productos (productos)
Schema::create('productos', function (Blueprint $table) {
    $table->id();
    $table->string('codigo')->unique();
    $table->string('descripcion');
    $table->string('unidad_medida')->default('unidades');
    $table->foreignId('cliente_id')->constrained('clientes'); // Producto asociado a un cliente específico
    $table->timestamps();
});

// Migración para la tabla Pivote Producto-Insumo (producto_insumo)
// Define la "receta" o materiales necesarios por producto.
Schema::create('producto_insumo', function (Blueprint $table) {
    $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
    $table->foreignId('insumo_id')->constrained('insumos')->onDelete('cascade');
    $table->decimal('cantidad_requerida', 8, 2); // Cantidad de insumo requerida por unidad de producto
    $table->primary(['producto_id', 'insumo_id']);
});

// Migración para la tabla de Movimientos de Stock (movimientos_stock)
Schema::create('movimientos_stock', function (Blueprint $table) {
    $table->id();
    $table->foreignId('insumo_id')->constrained('insumos');
    $table->foreignId('user_id')->constrained('users');
    $table->enum('tipo', ['entrada', 'salida', 'ajuste']);
    $table->integer('cantidad');
    $table->string('referencia')->nullable(); // Número de OC, Lote, etc.
    $table->text('observaciones')->nullable();
    $table->timestamps();
});

// Migración para la tabla de Órdenes de Compra (ordenes_compra)
// (Usando la estructura de tu archivo adjunto)
Schema::create('ordenes_compra', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->date('fecha');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->enum('estado', EstadoOrdenCompra::getValues());
            $table->integer('vencimiento_requerido')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('condiciones_pago')->nullable();
            $table->foreignId('user_id')->constrained('users');
            
            // Nuevos campos de auditoría
            $table->foreignId('validado_por')->nullable()->constrained('users');
            $table->foreignId('confirmado_por')->nullable()->constrained('users');

            $table->timestamps();
});

// Migración para la tabla de Detalles de Órdenes de Compra (orden_compra_detalles)
Schema::create('orden_compra_detalles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('orden_compra_id')->constrained('ordenes_compra')->onDelete('cascade');
    $table->foreignId('producto_id')->constrained('productos');
    $table->integer('cantidad_solicitada');
    $table->integer('cantidad_sobrante')->default(0); // Para control de sobrantes
    $table->string('lote')->nullable();
    $table->timestamps();
});
