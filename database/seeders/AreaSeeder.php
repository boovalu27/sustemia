<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    public function run()
    {
        // Crear áreas de ejemplo
        Area::create(['name' => 'Seguridad']);
        Area::create(['name' => 'Higiene']);
        Area::create(['name' => 'Salud']);
        Area::create(['name' => 'Capacitación']);
        Area::create(['name' => 'Medio Ambiente']);
        Area::create(['name' => 'Innovación']);
    }
}
