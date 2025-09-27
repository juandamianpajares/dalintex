<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoInsumoProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insertar datos de ejemplo para la tabla tipo_insumos
        DB::table('tipo_insumos')->insert([
            ['nombre' => 'Envases'],
            ['nombre' => 'Tapas'],
            ['nombre' => 'Etiquetas'],
            ['nombre' => 'Otros'],
        ]);

        // Insertar datos de ejemplo para la tabla productos
        DB::table('productos')->insert([
            ['nombre' => 'Shampoo Vital'],
            ['nombre' => 'Acondicionador Brillo'],
            ['nombre' => 'Crema Corporal'],
            ['nombre' => 'Jabón Líquido'],
        ]);
    }
}
