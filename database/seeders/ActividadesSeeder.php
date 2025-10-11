<?php

namespace Database\Seeders;

use App\Models\Actividad;
use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActividadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener ID de la categoría
        $lucesId = Categoria::where('nombre', 'Luces')->value('id_categoria');

        // Obtener ID de la categoría
        $cabinaId = Categoria::where('nombre', 'CABINA')->value('id_categoria');

        // Obtener ID de la categoría
        $llantasId = Categoria::where('nombre', 'LLANTAS')->value('id_categoria');

        // Obtener ID de la categoría
        $mecanicoId = Categoria::where('nombre', 'ESTADO MECÁNICO')->value('id_categoria');

        $actividades = [
            // LUCES
            ['Frontales', $lucesId, '2025-10-10'],
            ['Traseras de trabajo (reflector', $lucesId, '2025-10-10'],
            ['Direccionales delanteras de parqueo (Giro)', $lucesId, '2025-10-10'],
            ['Direccionales traseras de parqueo (Giro)', $lucesId, '2025-10-10'],
            ['De Stop y señal trasera', $lucesId, '2025-10-10'],

            // CABINA
            ['Alarma de retroceso', $cabinaId, '2025-10-10'],
            ['Pito', $cabinaId, '2025-10-10'],
            ['Freno de servicio', $cabinaId, '2025-10-10'],
            ['Freno de emergencia', $cabinaId, '2025-10-10'],
            ['Dirección/suspensión (Terminales)', $cabinaId, '2025-10-10'],
            ['Cinturón de seguridad', $cabinaId, '2025-10-10'],
            ['Cabina antibuelco (R.O.P.S) certificada', $cabinaId, '2025-10-10'],
            ['Extintor de incendios (10 lbs)', $cabinaId, '2025-10-10'],
            ['POS Asiento en buena condición', $cabinaId, '2025-10-10'],
            ['Indicadores (hidráulico-volitmetro)', $cabinaId, '2025-10-10'],
            ['Motor-refrigerante-orometro, aire', $cabinaId, '2025-10-10'],
            ['Escaleras y pasamanos (cabina/trompo)', $cabinaId, '2025-10-10'],
            ['Batería y cables', $cabinaId, '2025-10-10'],

            // LLANTAS
            ['Sin cortaduras profundas y sin abultamientos', $llantasId, '2025-10-10'],

            // MECANICO
            ['Control de fugas hidráulicas', $mecanicoId, '2025-10-10'],
            ['Pasadores, suspensión', $mecanicoId, '2025-10-10'],
            ['Control fugas de aire', $mecanicoId, '2025-10-10'],
            ['Brazos de levante hidraulicos', $mecanicoId, '2025-10-10'],
            ['Grapas y anclaje de chasis', $mecanicoId, '2025-10-10'],
            ['Descarga (gato, pivote, pasadores)', $mecanicoId, '2025-10-10'],
            ['Eje de Toma de fuerza', $mecanicoId, '2025-10-10'],
            ['Marcara de agua y de alta presión', $mecanicoId, '2025-10-10'],

        ];

        foreach ($actividades as $actividad) {
            DB::table('actividades')->insert([
                'name' => $actividad[0],
                'id_categoria' => $actividad[1],
                'fecha' => $actividad[2]
            ]);
        }
        $this->command->info('Items de inspección creados exitosamente!');
        $this->command->info('Total: ' . count($actividades) . ' items creados');
    }
}
