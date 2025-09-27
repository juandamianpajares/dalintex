        <?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        return new class extends Migration
        {
            public function up()
            {
                Schema::create('movimiento_stocks', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('insumo_id')->constrained('insumos');
                    $table->foreignId('user_id')->constrained('users'); // Usuario que realiza el movimiento
                    $table->enum('tipo_movimiento', ['ingreso', 'egreso']);
                    $table->decimal('cantidad', 10, 2);
                    $table->string('lote');
                    $table->date('fecha_vencimiento')->nullable();
                    $table->string('ubicacion_origen')->nullable();
                    $table->string('ubicacion_destino')->nullable();
                    $table->timestamps();
                });
            }

            public function down()
            {
                Schema::dropIfExists('movimiento_stocks');
            }
        };
        
