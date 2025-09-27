<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_residual', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insumo_id')->constrained()->onDelete('cascade');
            $table->integer('cantidad');
            $table->string('origen'); // e.g., 'Sobrante de Producción', 'Devolución de cliente'
            $table->string('etiqueta')->nullable(); // Para cumplir con RF012
            $table->foreignId('autorizado_por')->nullable()->constrained('users')->onDelete('set null'); // Para cumplir con RF010
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_residual');
    }
};
