        <?php

        use App\Enums\TipoInsumo; // Asegúrate de que este Enum exista o usa un array
        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        return new class extends Migration
        {
            public function up()
            {
                Schema::create('insumos', function (Blueprint $table) {
                    $table->id();
                    $table->enum('tipo', ['empaque', 'materia_prima', 'otro']); // Usar los valores del Enum TipoInsumo
                    $table->string('codigo')->unique();
                    $table->string('descripcion');
                    $table->string('proveedor')->nullable();
                    $table->unsignedBigInteger('stock_actual')->default(0);
                    $table->unsignedBigInteger('stock_minimo')->default(0);
                    $table->string('ubicacion')->nullable();
                    $table->string('cliente_sumistrador')->nullable();
                    $table->timestamps();
                });
            }

            public function down()
            {
                Schema::dropIfExists('insumos');
            }
        };