<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nombre_categoria' => 'LUCES', 'fecha' => '2025-10-10'],
            ['nombre_categoria' => 'CABINA', 'fecha' => '2025-10-10'],
            ['nombre_categoria' => 'LLANTAS', 'fecha' => '2025-10-10'],
            ['nombre_categoria' => 'ESTADO MECÁNICO', 'fecha' => '2025-10-10']
        ];

        foreach ($categorias as $categoria) {
            DB::table('categorias')->insert([
                'nombre' => $categoria['nombre_categoria'],
                'fecha' => $categoria['fecha']
            ]);
        }
        $this->command->info('Categorias creadas correctamente');
    }

}
