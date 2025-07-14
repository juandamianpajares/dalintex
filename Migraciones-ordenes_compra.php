<?php

use App\Enums\EstadoOrdenCompra;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
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
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordenes_compra');
    }
};