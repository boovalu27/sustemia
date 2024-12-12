<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Insertar roles solo si no existen
        if (DB::table('roles')->count() === 0) {
            // Crear el rol "admin" con id = 1, si no existe
            DB::table('roles')->insertOrIgnore([
                ['id' => 1, 'name' => 'admin', 'guard_name' => 'web'],
                ['id' => 2,'name' => 'editor', 'guard_name' => 'web'],
                ['id' => 3, 'name' => 'viewer', 'guard_name' => 'web'],
            ]);
        }
    }
}
