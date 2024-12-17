<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    public function run()
    {
        // Crear áreas de ejemplo utilizando firstOrCreate para evitar duplicados
        Area::firstOrCreate(['name' => 'Seguridad']);
        Area::firstOrCreate(['name' => 'Higiene']);
        Area::firstOrCreate(['name' => 'Salud']);
        Area::firstOrCreate(['name' => 'Capacitación']);
        Area::firstOrCreate(['name' => 'Medio Ambiente']);
        Area::firstOrCreate(['name' => 'Innovación']);
    }
}
