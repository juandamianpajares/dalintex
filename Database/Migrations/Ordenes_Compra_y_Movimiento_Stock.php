<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\EstadoOrdenCompra;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orden_compras', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->date('fecha');
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');
            $table->enum('estado', EstadoOrdenCompra::getValues())->default(EstadoOrdenCompra::PENDIENTE);
            $table->date('vencimiento_requerido')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('condiciones_pago')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('orden_compra_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_compra_id')->constrained()->onDelete('cascade');
            $table->foreignId('producto_id')->constrained()->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('movimientos_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insumo_id')->constrained()->onDelete('cascade');
            $table->foreignId('orden_compra_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('cantidad');
            $table->string('tipo'); // Entrada o Salida
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_stock');
        Schema::dropIfExists('orden_compra_detalles');
        Schema::dropIfExists('orden_compras');
    }
};
